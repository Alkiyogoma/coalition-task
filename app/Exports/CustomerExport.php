<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomerExport implements FromCollection, WithHeadings
{
  public $data;

    public function headings(): array
    {
        $teacher_id = request()->segment(3);
        $class_id = request()->segment(2);
        $section_id = request()->segment(4);
        return $this->titles($class_id, $teacher_id = 0, $section_id=0);
    }

    public function collection()
    {
        $type = request()->segment(2);
        $partner = request()->segment(3);
        $user_id = request()->segment(4);
        if($type == 'today' && $partner > 0){
            $task = (int)$user_id > 0 ? \App\Models\Task::where('user_id', $user_id)->whereDate('created_at', date('Y-m-d'))->get(['client_id']) :  \App\Models\Task::whereDate('created_at', date('Y-m-d'))->get(['client_id']);
            $clients = \App\Models\Client::where('partner_id', $partner)->whereIn('id', $task)->orderBy('id', 'DESC')
            ->get()->map(fn ($pay) => [
                'account' => (string)$pay->account,
                'phone' => !empty($pay->codename) ? $pay->codename->code : $pay->code,
                'date' => $pay->ptpdate,
                'amount' => money($pay->ptpamount),
                'about' => $pay->placement,
            ]);
        }
        if($type == 'week' && $partner > 0){
            $task = (int)$user_id > 0 ? \App\Models\Client::where('user_id', $user_id)->whereDate('created_at', date('Y-m-d'))->get(['client_id']) :  \App\Models\Client::whereDate('created_at', date('Y-m-d'))->get(['client_id']);
            $clients = \App\Models\Client::where('partner_id', $partner)->whereIn('id', $task)->orderBy('id', 'DESC')
            ->get()->map(fn ($pay) => [
                'id' => $pay->id,
                'name' => $pay->account,
                'about' => $pay->code,
                'time' => timeAgo($pay->created_at),
                'date' => date('d M, Y', strtotime($pay->task_date)),
                'user' => !empty($pay->user) ? $pay->user->name : 'Not Defined',
                'type' => !empty($pay->tasktype) ? $pay->tasktype->name : 'Followup',
                'client' => !empty($pay->client) ? $pay->client->name : 'Not Defined',
                'phone' => !empty($pay->client) ? $pay->client->phone : 'Not Defined',
                'status' => !empty($pay->taskstatus) ? $pay->taskstatus->name : 'On progess',
                'nexttask' => !empty($pay->nexttask) ? $pay->nexttask->name : 'Followup',
            ]);
        }
        if($type == 'month' && $partner > 0){
            $task = (int)$user_id > 0 ? \App\Models\Client::where('user_id', $user_id)->whereDate('created_at', date('Y-m-d'))->get(['client_id']) :  \App\Models\Client::whereDate('created_at', date('Y-m-d'))->get(['client_id']);
            $clients = \App\Models\Client::where('partner_id', $partner)->whereIn('id', $task)->orderBy('id', 'DESC')->get();
        }
        return   $clients;
    }

    public function titles($class_id, $teacher_id = 0, $section_id=0)
    {
        if($class_id == 'today'){
            $list = 'Account Number, Action Codes, PTP Date, PTP Amount, Remarks, Future Review Date, Executor, Attorney, Summon Issue Date, Judgement Granted Date, Judgement Amount, Name of Liquidator, Date of First Meeting, Date of Second Meeting, Final L&D Date, Date of Attachment, Asset Valuation Amount, Storage Location, Date Sold, Sold Amount, Date Outsourced, Name of Insurer, Date of Claim Lodged, FSV';
        }else{
            // Equity Bank
            $list = 'S/N, Customer Names, Account Number, Customer Mobile Number, Employer Name,  OUTSTANDING LOAN BALANCE, NEXT OF KIN NAME,  Amount Received, Reason Code, Follow up/Next action';
        // Stanbick Bank
        $list = 'Collector,Customer Name,Employer,Account number,Contacts,Branch,Outstanding Balance(TZS),Amount Received,Reason Code,Follow up/Next action,Recall/Retain';

        // NMB Bank
        $list = 'COLLECTOR,BRANCH NAME,CUST NAME,ACCOUNT NUMBER,SETT ACC,PRINC BAL,PHONE NUMBER,PAYMENT,REASON CODE,STATUS,PLACEMENT';

        // CRDB Bank
        $list = 'Loan Acc. No.,Customer Name,Segment,Description,Branch,Zone,Aproved loan amount_txccy,Total Exposure,Days past due,System classification,Employer Name,Debt collector,Loan collection Officer,Status,Date';
    }

        $title = explode(',', rtrim($list, ','));
    
        if ($title) {
            return $title;
        } else {
            return redirect()->back()->with('error','Seems no customers allocated to this partner');
        } 
    
    }

}
