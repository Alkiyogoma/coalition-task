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

class CodeExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements WithCustomValueBinder,FromCollection, WithHeadings,ShouldAutoSize,WithStyles
{
  public $data;

    public function headings(): array
    {
        $partner_id = request()->segment(2);
        return $this->titles($partner_id);
    }

    public function collection()
    {
        $partner_id = request()->segment(2);
        $user_id = request()->segment(3);
        $start = request('start') != '' ? request('start') : date('Y-m-01');
        $end = request('end') != '' ? request('end') : date('Y-m-d');
        $partner = (int)$partner_id > 0 ? \App\Models\Partner::where('id', $partner_id)->first()->name : 'All Banks';
        $customers = [];
        $clients = [];
        if((int)$user_id > 0 && $partner_id > 0){
            $customers = \App\Models\Client::whereBetween('ptpdate', [$start, $end])->where('user_id', $user_id)->where('partner_id', $partner_id)->where('code', request('code'))->orderBy('id', 'asc');
        }elseif((int)$user_id > 0){
            $customers = \App\Models\Client::whereBetween('ptpdate', [$start, $end])->where('user_id', $user_id)->where('code', request('code'))->orderBy('id', 'asc');
        }elseif((int)$partner_id > 0){
            $customers = \App\Models\Client::whereBetween('ptpdate', [$start, $end])->where('partner_id', $partner_id)->where('code', request('code'))->orderBy('id', 'asc');
            $clients = \App\Models\Client::whereBetween('ptpdate', [$start, $end])->where('partner_id', $partner_id)->where('code', request('code'))->orderBy('id', 'DESC')->get();

        }
        if(count($customers->get()) && $partner_id > 0){
           
            $i = 1;
            $partner = \App\Models\Partner::where('id', $partner_id)->first();
            if(!empty($partner) && strtolower($partner->name) == 'equity bank'){
            // Equity Bank Headers
                $list = 'S/N,Customer Names,Account Number,Customer Mobile Number,Employer Name,OUTSTANDING LOAN BALANCE,NEXT OF KIN NAME,Amount Received,Reason Code,Follow up/Next action';
                // S/N	Collector	Customer Names	Account Number	Customer Mobile Number	Employer Name	 OUTSTANDING LOAN BALANCE 	NEXT OF KIN NAME	Next Kin Phone	 Amount Received Jan'23 	 Reason Code 	 Follow up/Next action 
                $clients = $customers->get()->map(fn ($pay, $i=1) => [
                    'id' => $i+1,
                    'collector' => $pay->user->name,
                    'name' => $pay->name,
                    'account' => $pay->account,
                    'phone' => $pay->phone,
                    'employer' => $pay->employer,
                    'amount' => (string)($pay->amount),
                    'nextkin' => $pay->nextkin,
                    'nextkinphone' => $pay->nextkinphone,
                    'payments' => $pay->ptpamount,
                    'code' => $pay->code,
                    'placement' => $pay->placement,
                    'about' => $pay->code
                ]);
            }
            if(!empty($partner) && strtolower($partner->name) == 'stanbic bank'){
                // stanbic Bank
                $clients = $customers->get()->map(fn ($pay, $i=1) => [
                    'id' => $pay->user->name,
                    'name' => $pay->name,
                    'employer' => $pay->employer,
                    'account' => "$pay->account",
                    'phone' => str_replace('+255', '+255(000)', $pay->phone),
                    'branch' => $pay->branch,
                    'amount' => (string)($pay->amount),
                    'payments' => $pay->ptpamount,
                    'code' => $pay->code,
                    'placement' => $pay->placement,
                    'about' => $pay->code
                ]);
            }
            if(!empty($partner) && strtolower($partner->name) == 'nmb bank'){
                // NMB Bank
                $clients = $customers->get()->map(fn ($pay, $i=1) => [
                    'id' => $pay->user->name,
                    'branch' => $pay->branch,
                    'name' => $pay->name,
                    'account' => $pay->account,
                    'employer' => $pay->deposit_account,
                    'amount' => (string)($pay->amount),
                    'phone' => $pay->phone,
                    'payments' => $pay->ptpamount,
                    'code' => $pay->code,
                    'status' => $pay->code,
                    'placement' => $pay->placement,
                ]);
            }
            if(!empty($partner) && strtolower($partner->name) == 'crdb bank'){
                // CRDB Bank
                $clients = $customers->get()->map(fn ($pay, $i=1) => [
                    'account' => $pay->account,
                    'name' => $pay->name,
                    'segment' => '',
                    'description' => '',
                    'branch' => $pay->branch,
                    'zone' => '',
                    'amount' => (string)($pay->amount),
                    'payments' => $pay->ptpamount,
                    'days' => '',
                    'system' => '',
                    'employer' => $pay->employer,
                    'collector' => $pay->user->name,
                    'loanofficer' => '',
                    'status' => $pay->placement,
                    'date' => '',
                ]);
            }
           
        }else{
            return redirect('codereports')->with('success', 'No Customer Data Available');
        }
        return  $clients;
    }

    public function titles($partner_id = 0)
    {
        $list = '';
        if($partner_id > 0){
            $partner = \App\Models\Partner::where('id', $partner_id)->first();
            if(!empty($partner) && strtolower($partner->name) == 'equity bank'){
                // Equity Bank Headers
                $list = 'S/N,Collector,Customer Names,Account Number,Customer Mobile Number,Employer Name,OUTSTANDING LOAN BALANCE,NEXT OF KIN NAME,NEXT KIN PHONE,Amount Received,Reason Code,Follow up/Next action';
            }
            if(!empty($partner) && strtolower($partner->name) == 'stanbic bank'){
                // stanbic Bank Stanbic Bank
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
