<?phpnamespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class VisitorImport implements ToModel, WithHeadingRow
{
   
    public function model(array $row)
    {
        $user = Client::where('name', $row['customer'])->where('branch', $row['branch'])->first();
        $emloyer = isset($row['employer']) && $row['employer'] != '' ? \App\Models\Employer::where('name', $row['employer'])->first() : [];
        $branch =  \App\Models\Branch::where('name', $row['branch'])->first();
        $brach = !empty($branch) ? $branch : \App\Models\Branch::create(['name' => $row['branch']]);
        $emp = !empty($emloyer) ? $emloyer : \App\Models\Employer::create(['name' => isset($row['employer']) && $row['employer'] != '' ? $row['employer'] : $row['customer'], 'phone' => isset($row['phone']) && $row['phone'] != '' ? $row['phone'] : '0']);
        $staff = \App\Models\User::where(DB::raw('lower(name)'), 'like', '%'.strtolower($row['collector']).'%')->first();
        $partner = \App\Models\User::where(DB::raw('lower(name)'), 'like', '%'.strtolower($row['partner']).'%')->first();
      if(empty($user)){
            $user = \App\Models\Client::create([
                'name' => $row['customer'],
                'sex' => 'Male',
                'uuid' => (string) Str::uuid(),
                'employer' => $row['employer'],
                'phone' => isset($row['phone']) && $row['phone'] != '' ? validate_phone_number(trim($row['phone']))[1] : 0,
                'user_id' => !empty($staff) ? $staff->id : Auth::User()->id,
                'branch' => $row['branch'],
                'branch_id' => $brach->id,
                'employer_id' => $emp->id,
                'account' => $row['account'],
                'amount' => (float)$row['balance'],
                'code' => date("mH"),
                'address' => $row['branch'] != '' ? $row['branch'] : 'Dar Es Salaam',
                'partner_id' => $row['partner_id'],
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
                    'installment_id' => \App\Models\ClientInstallment::where('client_id', $user->id)->orderBy('id')->first()->id,
                    'amount' => (float)$row['payment'],
                    'date' => date('Y-m-d'),
                    'method_id' => 2,
                    'about' => 'Received from '. $row['customer'],
                    'reference' => date("MYH"),
                    'status' => 1,
                    'user_id' => !empty($staff) ? $staff->id : Auth::User()->id,
                ]);
            }
        }else{
            if(isset($row['payment']) && (int)$row['payment'] > 0){
                \App\Models\Payment::create([
                    'client_id' => $user->id,
                    'uuid' => (string) Str::uuid(),
                    'installment_id' => \App\Models\ClientInstallment::where('client_id', $user->id)->orderBy('id')->first()->id,
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