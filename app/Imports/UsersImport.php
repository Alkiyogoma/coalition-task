<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Clients;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsersImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {

        $email =  random_username($row[1]).'@darsms.co.tz';
        $dob = date('Y-d-m');
        if(is_array(validate_phone_number(trim($row[2])))){
        $user = Clients::where('user_id', Auth::User()->id)->where('name', $row[1])->where('phone', validate_phone_number(trim($row[2]))[1])->first();
        if(empty($user)){

        $user = Clients::create([
           'name' => $row[1],
           'phone'  => validate_phone_number(trim($row[2]))[1],
           'email'  => $email,
           'status'  => 1,
           'address'  => $row[3],
           'jod'  => $dob,
           'user_id' => Auth::User()->id
        ]);
   // id	name	email	phone	address	jod	code
        }
        if($row[4] != '' && $user){
            $family = \App\Models\Group::where('user_id', Auth::User()->id)->where('code', strtoupper(rtrim($row[4])))->first();
            $project = \App\Models\Contribution::where('user_id', Auth::User()->id)->where('code', strtoupper(rtrim($row[4])))->first();
        if(!empty($family)){
                \App\Models\GroupMember::create(['group_id' => $family->id,'status' => 1, 'client_id' => $user->id, 'join_date' => date('Y-m-d')]);
           }
        if(!empty($project)){
            \App\Models\ContributionMember::create(['contribution_id' => $project->id,'status' => 1, 'user_id' => Auth::User()->id, 'client_id' => $user->id, 'join_date' => date('Y-m-d')]);
            if($row[5] > 0){
                \App\Models\Collect::create(array_merge(['amount' => $row[5], 'date' => date('Y-m-d'), 'reference' => "KA".date("Yis"), 'method_id' =>1, 'about' => 'Uploaded', 'client_id' => $user->id, 'contribution_id' => $project->id, 'user_id' => Auth::User()->id]));
            }
       }
    }
        
    }
}
    return true;

    }
}
