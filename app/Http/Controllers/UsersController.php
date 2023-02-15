<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    
        public function index()
        {
            $id = request()->segment(2);
            $staff = request()->segment(3);
         
                $users = \App\Models\User::where('status', 1)
                ->filter(Request::only('search', 'trashed'))
                    ->paginate(11)
                    ->withQueryString()
                    ->through(fn ($user) => [
                        'id' => $user->id,
                        'uuid' => $user->uuid,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => !empty($user->role) ? $user->role->name : 'Staff',
                        'department' => !empty($user->department) ? $user->department->name : 'Staff',
                        'address' => $user->address,
                        'phone' => $user->phone,
                        'dob' => date("Y-m-d", strtotime($user->dob)),
                        'jod' => date("Y-m-d", strtotime($user->jod)),
                        'sex' => ucfirst($user->sex),
                        'last_update' => $user->updated_at,
                        'edit_url' => url('users.edit', $user),
                    ]);
            return Inertia::render('Staff/Index', [
                'filters' => Request::all('search', 'trashed'),
                'users' => $users,
                'groups' => DB::select('SELECT c.name as type, c.id, count(c.id) as total from departments c group by c.name,c.id'),
                'total_student' => \App\Models\User::where('status', 1)->count(),
    
            ]);
        }
    

    public function clients()
    {
        $id = request()->segment(2);
            $staff = request()->segment(3);
         
            $users = \App\Models\Client::where('status', 1)
            ->filter(Request::only('search', 'trashed'))
                ->paginate(11)
                ->withQueryString()
                ->through(fn ($user) => [
                    'id' => $user->id,
                    'uuid' => $user->uuid,
                    'name' => $user->name,
                    'collector' => $user->collector,
                    'partner' => !empty($user->partner) ? $user->partner->name : 'Bank',
                    'staff' => !empty($user->user) ? $user->user->name : $user->collector,
                    'branch' => !empty($user->branchs) ? $user->branchs->name : $user->branch,
                    'employer' => !empty($user->employers) ? $user->employers->name : $user->employer,
                    'code' => $user->code,
                    'amount' => $user->amount,
                    'paid' => $user->payments->sum('amount'),
                    'phone' => $user->phone,
                    'account' => ucfirst($user->account),
                    'last_update' => $user->updated_at,
                    'edit_url' => url('users.edit', $user),
                ]);
        return Inertia::render('Clients/Index', [
            'filters' => Request::all('search', 'trashed'),
            'users' => $users,
            'groups' => DB::select('SELECT c.name as type, c.id, count(c.id) as total from departments c group by c.name,c.id'),
            'total_student' => \App\Models\User::where('status', 1)->count(),

        ]);
    }


    public function address()
    {
        return Inertia::render('Messages', [
            'users' => \App\Models\Client::whereNotNull('district')
                ->orderBy('address')
                ->paginate(12)->withQueryString()
                ->through(fn ($User) => [
                    'id' => $User->address_id,
                    'address' => $User->address,
                    'district' => $User->district,
                    'city' =>  !empty($User->city) > 0 ? $User->city->city : 'Kigoma',
                    'country' =>  $User->city_id > 0 && !empty($User->city->country) ? $User->city->country->country : 'Tanzania',
                    'deleted_at' => $User->deleted_at,
                    'edit_url' => url('users.edit', $User),
                ]),
            'name' => 'Albogast',
            'create_url' => url('users.create'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Staff/Create',
        [
            'departments' => DB::table('departments')->get(),
            'roles' => DB::table('roles')->get(),
        ]);
    }

    public function saveclient(){
            Request::validate([
                'name' => ['required', 'max:200'],
                'amount' => ['required', 'max:50'],
                'account' => ['required', 'max:150'],
                'phone' => ['required', 'max:50'],
                'partner_id' => ['required', 'max:250'],
                'user_id' => ['required', 'max:550'],
                'branch' => ['required', 'max:250'],
                'installment_id' => ['required', 'max:250'],
                'payment' => ['required', 'max:250'],
            ]);
            $emloyer =  \App\Models\Employer::where('name', request('employer'))->first();
            $branch =  \App\Models\Branch::where('name', request('branch'))->first();
            $brach = !empty($branch) ? $branch : \App\Models\Branch::create(['name' => request('branch')]);
            $emp = !empty($emloyer) ? $emloyer : \App\Models\Employer::create(['name' => request('employer') !='' ? request('employer') : request('name')]);
                
            $user = \App\Models\Client::create([
                    'name' => request('name'),
                    'sex' => request('sex'),
                    'uuid' => (string) Str::uuid(),
                    'employer' => request('employer'),
                    'phone' => validate_phone_number(trim(request('phone')))[1],
                    'user_id' => request('user_id'),
                    'branch' => request('branch'),
                    'branch_id' => $brach->id,
                    'employer_id' => $emp->id,
                    'account' => request('account'),
                    'amount' => request('amount'),
                    'code' => date("mH"),
                    'address' => request('address') != '' ? request('address') : 'Dar Es Salaam',
                    'partner_id' => request('partner_id'),
                    'collector' => request('collector'),
                    'placement' => request('placement'),
            ]);
            $inst = (int)request('installment_id');
            $installments = \App\Models\Installment::where('id', '<', $inst+1)->get();
            if(count($installments) && $inst > 0){
                $amount = request('amount')/$inst;
                foreach($installments as $installment){
                    $start = $installment->id*30;
                    $end = $installment->id*30+30;
                    \App\Models\ClientInstallment::create([
                    'name' => $installment->name,
                    'start_date'  => $installment->id == 1 ? date('Y-m-d') : date('Y-m-d', strtotime('+'.$start.' days')),
                    'end_date'   => $installment->id == 1 ? date('Y-m-d', strtotime('+30 days')) : date('Y-m-d', strtotime('+'.$end .' days')),
                    'received_amount'  => 0,
                    'amount'  => $amount,
                    'status' => 1,
                    'user_id' => request('user_id'),
                    'client_id' => $user->id,
                    'installment_id' => $installment->id,
                    'installment_type_id' => 2
                ]);
            }
        }
        if((int)request('payment') > 0){
            \App\Models\Payment::create([
                'client_id' => $user->id,
                'uuid' => (string) Str::uuid(),
                'installment_id' => \App\Models\ClientInstallment::where('client_id', $user->id)->orderBy('id')->first()->id,
                'amount' => request('payment'),
                'date' => date('Y-m-d'),
                'method_id' => 2,
                'about' => 'Received from '. request('name'),
                'reference' => date("MYH"),
                'status' => 1,
                'user_id' => request('user_id'),
            ]);
        }
                
        return redirect('clients')->with('success', 'User created.');
    }


    
    public function addcustomer()
    {
        return Inertia::render('Clients/Create',
        [
            'users' => DB::table('users')->get(),
            'partners' => DB::table('partners')->get(),
            'installments' => DB::table('installments')->get(),
        ]);
    }

    public function saveuser()
    {
            Request::validate([
                'name' => ['required', 'max:200'],
                'sex' => ['required', 'max:50'],
                'email' => ['required', 'max:150', 'email'],
                'phone' => ['required', 'max:50'],
                'address' => ['required', 'max:250'],
                'dob' => ['required', 'max:50'],
                'role_id' => ['required', 'max:50'],
                'department_id' => ['required', 'max:50'],
            ]);
            $user = \App\Models\User::create([
                    'name' => request('name'),
                    'sex' => request('sex'),
                    'uuid' => (string) Str::uuid(),
                    'email' => request('email'),
                    'phone' => validate_phone_number(trim(request('phone')))[1],
                    'password' => Hash::make(request('phone')),
                    'dob' => request('dob'),
                    'salary' => request('salary'),
                    'code' => date("mH"),
                    'address' => request('address') != '' ? request('address') : 'Dar Es Salaam',
                    'department_id' => request('department_id'),
                    'role_id' => request('role_id'),
                    'status' =>  1,
                    'jod' => request('jod'),
            ]);
            \App\Models\UserDepartment::create([
                'department_id' => $user->department_id,
                'user_id' => $user->id,
                'status' =>  1]);

        return redirect('clients')->with('success', 'User created.');
    }



    public function edit(User $User)
    {

        return Inertia::render('Users/Edit', [
            'user' => [
                'id' => $User->id,
                'name' => $User->name,
                'email' => $User->email,
                'phone' => $User->phone,
                'address' => $User->address,
                'city' => $User->city,
                'region' => $User->region,
                'country' => $User->country,
                'postal_code' => $User->postal_code,
                'deleted_at' => $User->deleted_at,
                'contacts' => $User->contacts()->orderByName()->get()->map->only('id', 'name', 'city', 'phone'),
            ],
        ]);
    }

    public function edit_customer(Client $customer)
    {
        $id = request()->segment(2);
        $customer = Client::where('customer_id', $id)->first();
        $next = Client::where('customer_id', '>', $id)->first();
        return Inertia::render('Edit', [
            'user' => [
                'store_id' => $customer->store,
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'email' => $customer->email,
                'active' => $customer->active,
                'create_date' => date("d M, Y", strtotime($customer->create_date)),
                'last_update' => date("d M, Y", strtotime($customer->last_update)),
                'next' => $next,
                'edit_url' => url('users.edit', $customer),
            ],
        ]);
    }
    public function update(User $User)
    {
        $User->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::back()->with('success', 'User updated.');
    }

    public function destroy(User $User)
    {
        $User->delete();

        return Redirect::back()->with('success', 'User deleted.');
    }

    public function restore(User $User)
    {
        $User->restore();

        return Redirect::back()->with('success', 'User restored.');
    }
}
