<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class PaymentExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements WithCustomValueBinder,FromCollection, WithHeadings,ShouldAutoSize,WithStyles
{
  //  class CustomerExport extends DefaultValueBinder implements WithCustomValueBinder,FromCollection, WithHeadings,ShouldAutoSize,WithStyles
  public $data;

    public function headings(): array
    {
        $class_id = request()->segment(2);
        $partner_id = request()->segment(3);
        return $this->titles($class_id, $partner_id);
    }

    public function collections($group = 0, $id = 0, $export = null)
    {
        
       
    }

    public function collection()
    {
        $group = request()->segment(2);
        $id = request()->segment(3);
        if((int)($id) > 0 && (int)$group > 0){
            $user= \App\Models\User::where('id', $id)->first();
            $partner= \App\Models\Partner::where('id', $group)->first();
            $where_condition = " AND f.id=$user->id and a.partner_id=$group ";
        }elseif((int)($id) > 0 && (int)$group == 0){
            $user= \App\Models\User::where('id', $id)->first();
            $where_condition = " AND f.id=$user->id ";
        }elseif((int)$group > 0){
            $partner= \App\Models\Partner::where('id', $group)->first();
            $where_condition = " AND a.partner_id=$group ";
        }else{
            $where_condition = '';
        }
        $where_ = request('days') > 0 ? "'".date('Y-m-d', strtotime('- '.request('days').'days'))."'" :  (request('days') != '' && request('days') != 'null' ? "'".date('Y-m-d')."'" : "'".date('Y-m-01')."'");
        $payments = collect(DB::select('SELECT b.id, f.name as collector, a.name, a.account, a.branch, a.amount, b.amount as payment, b.date FROM `payments` b JOIN `users` f on b.user_id=f.id join clients a on a.id=b.client_id where b.created_at >='.$where_. ' '. $where_condition.' ORDER BY b.id desc;'));
     //   dd($payments);
        return $payments;

    }

    public function titles($class_id, $partner_id = 0)
    {
    /*    if($class_id == 'today'){
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
    */
        $list = 'SN,COLLECTOR,CUSTOMER NAME,ACCOUNT NUMBER,BRANCH,LOAN BALANCE,AMOUNT RECEIVED,DATE';
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
