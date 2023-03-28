<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class UsersImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
       // dd($row);
        $user = Client::where('account', $row['account'])->first();
        $branch =  isset($row['branch']) && $row['branch'] != '' ? \App\Models\Branch::where('name', $row['branch'])->first() : [];
        $cbranch = empty($branch) ? (!empty(\App\Models\Branch::where(DB::raw('lower(name)'), 'like', '%'.strtolower($row['partner']).'%')->first()) ? \App\Models\Branch::where(DB::raw('lower(name)'), 'like', '%'.strtolower($row['partner']).'%')->first() : \App\Models\Branch::create(['name' => $row['partner']])) : $branch;
        $employer = isset($row['employer']) && $row['employer'] != '' ? \App\Models\Employer::where('name', $row['employer'])->first() : [];

        $phone = isset($row['phone']) && $row['phone'] != '' ? str_replace(['(000)', ' ', '(', ')'], ['','', '',''], $row['phone']) : 0;
        $emp = !empty($employer) ? $employer : \App\Models\Employer::create(['name' => isset($row['employer']) && $row['employer'] != '' ? $row['employer'] : $row['customer'], 'phone' => isset($phone) && $phone != '' ? $phone : '0']);
        $staff = \App\Models\User::where(DB::raw('lower(name)'), 'like', '%'.strtolower($row['collector']).'%')->first();
        $partner = \App\Models\Partner::where(DB::raw('lower(name)'), 'like', '%'.strtolower($row['partner']).'%')->first();
        if(empty($user)){
            $user = \App\Models\Client::create([
                'name' => $row['customer'],
                'sex' => 'Male',
                'uuid' => (string) Str::uuid(),
                'employer' => isset($row['employer']) && $row['employer'] != '' ? $row['employer'] : '',
                'phone' => isset($phone) && $phone != '' ? validate_phone_number(trim($phone))[1] : 0,
                'user_id' => !empty($staff) ? $staff->id : Auth::User()->id,
                'branch' => $cbranch->name,
                'branch_id' => $cbranch->id,
                'employer_id' => $emp->id,
                'account' => $row['account'],
                'amount' => (float)str_replace(',', '', $row['balance']),
                'code' => isset($row['code']) && $row['code'] != '' ? $row['code'] : '',
                'placement' => isset($row['nextaction']) && $row['nextaction'] != '' ? $row['nextaction'] : '',
                'kinphone' => isset($row['kinphone']) && $row['kinphone'] != '' ? $row['kinphone'] : '',
                'nextkin' => isset($row['nextkin']) && $row['nextkin'] != '' ? $row['nextkin'] : '',
                'address' => isset($row['address']) && $row['address'] != '' ? $row['address'] :  $cbranch->name,
                'partner_id' => !empty($partner) ? $partner-> id : 1,
                'collector' => $row['collector'],
                'deposit_account' => isset($row['settementaccount']) ? $row['settementaccount'] : null,
            ]);

            $installment = \App\Models\Installment::orderBy('id')->first();
        
                \App\Models\ClientInstallment::create([
                'name' => $installment->name,
                'start_date'  => date('Y-m-d'),
                'end_date'   => date('Y-m-d', strtotime('+30 days')),
                'received_amount'  => 0,
                'amount'  => (float)$row['balance'],
                'status' => 1,
                'user_id' => !empty($staff) ? $staff->id : Auth::User()->id,
                'client_id' => $user->id,
                'installment_id' => $installment->id,
                'installment_type_id' => 2
            ]);
         
            if(isset($row['payment']) && (int)$row['payment'] > 0){
                \App\Models\Payment::create([
                    'client_id' => $user->id,
                    'uuid' => (string) Str::uuid(),
                    'installment_id' => \App\Models\ClientInstallment::where('client_id', $user->id)->orderBy('id')->first()->installment_id,
                    'amount' => (float)$row['payment'],
                    'date' => date('Y-m-d'),
                    'method_id' => 2,
                    'about' => 'Received from '. $row['customer'],
                    'reference' => date("MYH"),
                    'status' => 1,
                    'user_id' => !empty($staff) ? $staff->id : Auth::User()->id,
                ]);
            }
            return $user;
        }else{
            if(isset($row['payment']) && (int)$row['payment'] > 0){
                \App\Models\Payment::create([
                    'client_id' => $user->id,
                    'uuid' => (string) Str::uuid(),
                    'installment_id' => \App\Models\ClientInstallment::where('client_id', $user->id)->orderBy('id')->first()->installment_id,
                    'amount' => (float)$row['payment'],
                    'date' => date('Y-m-d'),
                    'method_id' => 2,
                    'about' => 'Received from '. $row['customer'],
                    'reference' => date("MYH"),
                    'status' => 1,
                    'user_id' => !empty($staff) ? $staff->id : Auth::User()->id,
                ]);
            }
            return $user;
        }
                
        }


}