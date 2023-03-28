<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class CustomerExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements WithCustomValueBinder,FromCollection, WithHeadings,ShouldAutoSize,WithStyles
{
  //  class CustomerExport extends DefaultValueBinder implements WithCustomValueBinder,FromCollection, WithHeadings,ShouldAutoSize,WithStyles
  public $data;

    public function headings(): array
    {
        $class_id = request()->segment(2);
        $partner_id = request()->segment(3);
        return $this->titles($class_id, $partner_id);
    }

    public function collection()
    {
        $type = request()->segment(2);
        $partner_id = request()->segment(3);
        $user_id = request()->segment(4);
        $date = date('Y-m-d');
        if($type == 'today' && $partner_id > 0){
            $task = (int)$user_id > 0 ? \App\Models\Task::where('user_id', $user_id)->whereDate('created_at', date('Y-m-d', strtotime(request('start'))))->get(['client_id']) :  \App\Models\Task::whereDate('created_at', date('Y-m-d', strtotime(request('start'))))->get(['client_id']);
            $clients = \App\Models\Client::where('partner_id', $partner_id)->whereIn('id', $task)->orderBy('id', 'DESC')
            ->get()->map(fn ($pay) => [
                'account' => (string)$pay->account,
                'phone' => !empty($pay->codename) ? $pay->codename->code : $pay->code,
                'date' => $pay->ptpdate,
                'amount' => (string)($pay->ptpamount),
                'about' => $pay->placement,
            ]);
        }
        if($type != 'today' && $partner_id > 0){
            if($type == 'week' && $partner_id > 0){
                $start = date('Y-m-d', strtotime(request('start')));
                $end  = date('Y-m-d',strtotime('+6 day',strtotime($start)));
            }

            if($type == 'month' && $partner_id > 0){
            $start = date('Y-m-d', strtotime(request('start')));
            $end  = date('Y-m-d',strtotime('+29 day',strtotime($start)));
            }
            $i = 1;
            $partner = \App\Models\Partner::where('id', $partner_id)->first();
            if(!empty($partner) && strtolower($partner->name) == 'equity bank'){
            // Equity Bank Headers
                $list = 'S/N,Customer Names,Account Number,Customer Mobile Number,Employer Name,OUTSTANDING LOAN BALANCE,NEXT OF KIN NAME,Amount Received,Reason Code,Follow up/Next action';
                // S/N	Collector	Customer Names	Account Number	Customer Mobile Number	Employer Name	 OUTSTANDING LOAN BALANCE 	NEXT OF KIN NAME	Next Kin Phone	 Amount Received Jan'23 	 Reason Code 	 Follow up/Next action 
                $clients = \App\Models\Client::where('partner_id', $partner_id)->where('status', 1)->orderBy('id', 'DESC')
                ->get()->map(fn ($pay, $i=1) => [
                    'id' => $i+1,
                    'collector' => $pay->user->name,
                    'name' => $pay->name,
                    'account' => $pay->account,
                    'phone' => $pay->phone,
                    'employer' => $pay->employer,
                    'amount' => (string)($pay->amount),
                    'nextkin' => $pay->nextkin,
                    'nextkinphone' => $pay->nextkinphone,
                    'payments' => $pay->payments()->whereBetween('date', [$start, $end])->sum('amount'),
                    'code' => $pay->code,
                    'placement' => $pay->placement,
                    'about' => $pay->code
                ]);
            }
            if(!empty($partner) && strtolower($partner->name) == 'stanbick bank'){
                // Stanbick Bank
                $list = 'Collector,Customer Name,Employer,Account number,Contacts,Branch,Outstanding Balance(TZS),Amount Received,Reason Code,Follow up/Next action,Recall/Retain';
                $clients = \App\Models\Client::where('partner_id', $partner_id)->where('status', 1)->orderBy('id', 'DESC')
                ->get()->map(fn ($pay, $i=1) => [
                    'id' => $pay->user->name,
                    'name' => $pay->name,
                    'employer' => $pay->employer,
                    'account' => "$pay->account",
                    'phone' => str_replace('+255', '+255(000)', $pay->phone),
                    'branch' => $pay->branch,
                    'amount' => (string)($pay->amount),
                    'payments' => $pay->payments()->whereBetween('date', [$start, $end])->sum('amount'),
                    'code' => $pay->code,
                    'placement' => $pay->placement,
                    'about' => $pay->code
                ]);
            }
            if(!empty($partner) && strtolower($partner->name) == 'nmb bank'){
                // NMB Bank
                $list = 'COLLECTOR,BRANCH NAME,CUST NAME,ACCOUNT NUMBER,SETT ACC,PRINC BAL,PHONE NUMBER,PAYMENT,REASON CODE,STATUS,PLACEMENT';
                $clients = \App\Models\Client::where('partner_id', $partner_id)->where('status', 1)->orderBy('id', 'DESC')
                ->get()->map(fn ($pay, $i=1) => [
                    'id' => $pay->user->name,
                    'branch' => $pay->branch,
                    'name' => $pay->name,
                    'account' => $pay->account,
                    'employer' => $pay->deposit_account,
                    'amount' => (string)($pay->amount),
                    'phone' => $pay->phone,
                    'payments' => $pay->payments()->whereBetween('date', [$start, $end])->sum('amount'),
                    'code' => $pay->code,
                    'status' => $pay->code,
                    'placement' => $pay->placement,
                ]);
            }
            if(!empty($partner) && strtolower($partner->name) == 'crdb bank'){
                // CRDB Bank
                $list = 'Loan Acc. No.,Customer Name,Segment,Description,Branch,Zone,Aproved loan amount_txccy,
                Total Exposure,Days past due,System classification,Employer Name,Debt collector,Loan collection Officer,Status,Date';
                $clients = \App\Models\Client::where('partner_id', $partner_id)->where('status', 1)->orderBy('id', 'DESC')
                ->get()->map(fn ($pay, $i=1) => [
                    'account' => $pay->account,
                    'name' => $pay->name,
                    'segment' => '',
                    'description' => '',
                    'branch' => $pay->branch,
                    'zone' => '',
                    'amount' => (string)($pay->amount),
                    'payments' => $pay->payments()->whereBetween('date', [$start, $end])->sum('amount'),
                    'days' => '',
                    'system' => '',
                    'employer' => $pay->employer,
                    'collector' => $pay->user->name,
                    'loanofficer' => '',
                    'status' => $pay->placement,
                    'date' => '',
                ]);
            }
           
        }

        return   $clients;
    }

    public function titles($class_id, $partner_id = 0)
    {
        if($class_id == 'today'){
            $list = 'Account Number,Action Codes,PTP Date,PTP Amount,Remarks,Future Review Date,Executor,Attorney,Summon Issue Date,Judgement Granted Date,Judgement Amount,Name of Liquidator,Date of First Meeting,Date of Second Meeting,Final L&D Date,Date of Attachment,Asset Valuation Amount,Storage Location,Date Sold,Sold Amount,Date Outsourced,Name of Insurer,Date of Claim Lodged,FSV';
        }else{
            $partner = \App\Models\Partner::where('id', $partner_id)->first();
            if(!empty($partner) && strtolower($partner->name) == 'equity bank'){
                // Equity Bank Headers
                $list = 'S/N,Collector,Customer Names,Account Number,Customer Mobile Number,Employer Name,OUTSTANDING LOAN BALANCE,NEXT OF KIN NAME,NEXT KIN PHONE,Amount Received,Reason Code,Follow up/Next action';
            }
            if(!empty($partner) && strtolower($partner->name) == 'stanbick bank'){
                // Stanbick Bank
            $list = 'Collector,Customer Name,Employer,Account number,Contacts,Branch,Outstanding Balance(TZS),Amount Received,Reason Code,Follow up/Next action,Recall/Retain';
            }
            if(!empty($partner) && strtolower($partner->name) == 'nmb bank'){
                // NMB Bank
            $list = 'COLLECTOR,BRANCH NAME,CUST NAME,ACCOUNT NUMBER,SETT ACC,PRINC BAL,PHONE NUMBER,PAYMENT,REASON CODE,STATUS,PLACEMENT';
            }
            if(!empty($partner) && strtolower($partner->name) == 'crdb bank'){
                // CRDB Bank
            $list = 'Loan Acc. No.,Customer Name,Segment,Description,Branch,Zone,Aproved loan amount_txccy,Total Exposure,Days past due,System classification,Employer Name,Debt collector,Loan collection Officer,Status,Date';
            }
        }

        $title = explode(',', rtrim($list, ','));
    
        if ($title) {
            return $title;
        } else {
            return redirect()->back()->with('error','Seems no customers allocated to this partner');
        } 
    
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true, 'background' => 'orange', 'size' => 12]],

            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }

    public function bindValue999(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_NUMERIC);

            return true;
        }

        if (is_string($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_NUMERIC);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }
}
