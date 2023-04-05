<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class PaymentImport implements ToModel, WithHeadingRow
{
   
    public function model(array $row)
    {
        $user = Client::where('name', $row['customer'])->orWhere(DB::raw('lower(account)'), 'like', '%'.strtolower($row['account']).'%')->first();
        $staff = \App\Models\User::where(DB::raw('lower(name)'), 'like', '%'.strtolower($row['collector']).'%')->first();
        if(!empty($user)){
            $installment = \App\Models\ClientInstallment::where('client_id', $user->id)->orderBy('id')->first();
                if(empty($installment)){
                    $installment =   \App\Models\ClientInstallment::create([
                        'name' => 'First Installment',
                        'start_date'  => date('Y-m-d'),
                        'end_date'   => date('Y-m-d', strtotime('+30 days')),
                        'received_amount'  => 0,
                        'amount'  => (float)str_replace(',', '', $row['amount']),
                        'status' => 1,
                        'user_id' => !empty($staff) ? $staff->id : Auth::User()->id,
                        'client_id' => $user->id,
                        'installment_id' => 1,
                        'installment_type_id' => 2
                    ]);
                }
                if(isset($row['amount']) && (int)$row['amount'] > 0){
                    \App\Models\Payment::create([
                        'client_id' => $user->id,
                        'uuid' => (string) Str::uuid(),
                        'installment_id' => $installment->installment_id,
                        'amount' => (float)str_replace(',', '', $row['amount']),
                        'date' => date('Y-m-d'),
                        'method_id' => 2,
                        'about' => 'Received from '. $row['customer'],
                        'reference' => date("MYH"),
                        'status' => 1,
                        'user_id' => !empty($staff) ? $staff->id : Auth::User()->id,
                    ]);
                }
            }else{
                $user = Client::first();
                return $user;
            }
                
        }

    }