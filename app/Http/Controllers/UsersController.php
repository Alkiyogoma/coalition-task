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
    public function __construct()
    {
        $this->middleware('auth');
    }
        public function index()
        {
            $id = request()->segment(2);
                if($id != ''){
                    $client = \App\Models\User::where('status', 1)->where('department_id', $id);
                }else{
                    $client = \App\Models\User::where('status', 1);
                }
                $users = $client->filter(Request::only('search', 'trashed'))
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
    
        public function departments()
        {
            $id = request()->segment(2);
            
            return Inertia::render('Staff/Department', [
                'users' => \App\Models\Department::whereNotNull('id')
                    ->orderBy('id')
                    ->paginate(12)->withQueryString()
                    ->through(fn ($User) => [
                        'id' => $User->id,
                        'uuid' => $User->uuid,
                        'address' => $User->address,
                        'name' => $User->name,
                        'email' => $User->email,
                        'phone' => $User->phone,
                        'website' => $User->about,
                        'clients' =>   !empty($User->users) ? $User->users->count() : '0',
                        'created_at' => $User->created_at,
                        'edit_url' => url('users.edit', $User),
                    ]),
            ]);
        }

    public function clients()
    {
        $type = request()->segment(2);
        $id = request()->segment(3);
        if($type != '' && $id != ''){
            $check = $type."_id";
            $client = \App\Models\Client::where('status', 1)->where($check, $id);
        }else{
            $client = \App\Models\Client::where('status', 1);
        }
            $users = $client->filter(Request::only('search'))
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


    public function partners()
    {
        $id = request()->segment(2);
        if($id > 0){
            $client = \App\Models\Partner::where('partner_group_id', $id);
        }else{
            $client = \App\Models\Partner::whereNotNull('id');
        }
        return Inertia::render('Clients/Partner', [
            'users' => \App\Models\Partner::whereNotNull('id')
                ->orderBy('id')
                ->paginate(12)->withQueryString()
                ->through(fn ($User) => [
                    'id' => $User->id,
                    'uuid' => $User->uuid,
                    'address' => $User->address,
                    'name' => $User->name,
                    'email' => $User->email,
                    'phone' => $User->phone,
                    'website' => $User->website,
                    'group' =>  !empty($User->partnerGroup) > 0 ? $User->partnerGroup->name : 'BANK',
                    'clients' =>   !empty($User->clients) ? $User->clients->count() : '0',
                    'created_at' => $User->created_at,
                    'edit_url' => url('users.edit', $User),
                ]),
        ]);
    }

  
    public function branches(){
        $id = request()->segment(2);
        if($id == 'employee' || $id == 'employer'){
            $type = 'employer';
            $client = \App\Models\Employer::orderBy('id');
        }else{
            $type = 'branch';
            $client = \App\Models\Branch::orderBy('id');
        }
        return Inertia::render('Clients/Branches', [
            'users' => $client->paginate(12)->withQueryString()
                ->through(fn ($User) => [
                    'id' => $User->id,
                    'uuid' => $User->uuid,
                    'address' => $User->address,
                    'name' => $User->name,
                    'email' => $User->email,
                    'phone' => $User->phone,
                    'clients' =>   !empty($User->clients) ? $User->clients->count() : '0',
                    'created_at' => $User->created_at,
                    'edit_url' => url('users.edit', $User),
                ]),
                'type' => $type
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

    public function client(Client $user)
    {
        $id = request()->segment(2);
        $user = Client::where('uuid', $id)->first();
        return Inertia::render('Clients/Profile', [
            'user' => [
                'id' => $user->id,
                'uuid' => $user->uuid,
                'name' => $user->name,
                'collector' => $user->collector,
                'partner' => !empty($user->partner) ? $user->partner->name : 'Bank',
                'staff' => !empty($user->user) ? $user->user->name : $user->collector,
                'branch' => !empty($user->branchs) ? $user->branchs->name : $user->branch,
                'employer' => !empty($user->employers) ? $user->employers->name : $user->employer,
                'code' => $user->code,
                'amount' => money($user->amount),
                'paid' => money($user->payments->sum('amount')),
                'remained' => money($user->amount - $user->payments->sum('amount')),
                'phone' => $user->phone,
                'account' => ucfirst($user->account),
                'last_update' => $user->updated_at,
                'user_id' => Auth::User()->id,
                '_token' => csrf_token()
            ],
            'installments' => \App\Models\ClientInstallment::where('client_id', $user->id)->orderBy('installment_id')
            ->get()->map(fn ($pay) => [
                'id' => $pay->id,
                'name' => $pay->name,
                'start_date' => date('d M, Y', strtotime($pay->start_date)),
                'end_date' => date('d M, Y', strtotime($pay->end_date)),
                'amount' => money($pay->amount),
                'paid' => money($pay->payments->sum('amount')),
                'balance' => money($pay->amount - $pay->payments->sum('amount')),
            ]),
            'tasks' => \App\Models\Task::where('client_id', $user->id)->orderBy('id', 'desc')->limit(4)
            ->get()->map(fn ($pay) => [
                'id' => $pay->id,
                'uuid' => $pay->uuid,
                'name' => $pay->title,
                'about' => $pay->about,
                'time' => timeAgo($pay->created_at),
                'date' => date('d M, Y', strtotime($pay->task_date)),
                'user' => !empty($pay->user) ? $pay->user->name : 'Not Defined',
                'type' => !empty($pay->tasktype) ? $pay->tasktype->name : 'Followup',
                'status' => !empty($pay->taskstatus) ? $pay->taskstatus->name : 'On progess',
                'nexttask' => !empty($pay->nexttask) ? $pay->nexttask->name : 'Followup',
            ]),
            'alltasks' => \App\Models\Task::where('client_id', $user->id)->orderBy('id', 'desc')->limit(4)
            ->get()->map(fn ($pay) => [
                'id' => $pay->id,
                'uuid' => $pay->uuid,
                'name' => $pay->title,
                'about' => $pay->about,
                'date' => date('d M, Y', strtotime($pay->task_date)),
                'user' => !empty($pay->user) ? $pay->user->name : 'Not Defined',
                'type' => !empty($pay->tasktype) ? $pay->tasktype->name : 'Followup',
                'status' => !empty($pay->taskstatus) ? $pay->taskstatus->name : 'On progess',
                'nexttask' => !empty($pay->nexttask) ? $pay->nexttask->name : 'Followup',
            ]),
            'payments' => DB::table('payments')->where('client_id', $user->id)->orderBy('id', 'desc')->get(),
            'methods' => DB::table('payment_methods')->orderBy('id', 'desc')->get(),
            'tasktypes' => DB::table('task_type')->orderBy('id')->get(),
            'task_priority' => DB::table('task_priority')->orderBy('id')->get(),
            'task_status' => DB::table('task_status')->orderBy('id')->get(),
        ]);
    }


    public function saveClient(){
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


    public function addemployer()
    {
        return Inertia::render('Clients/CreateBranch',
        [
            'type' => request()->segment(2)
        ]);
    }

    public function saveemployer()
    {
            Request::validate([
                'name' => ['required', 'max:100'],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
            ]);

            $id = request()->segment(2);
            if($id == 'employer'){
               \App\Models\Employer::create(request()->all());
            }else{
               \App\Models\Branch::create(request()->all());
            }

        return redirect('branches/'.$id)->with('success', 'User updated.');
    }

    
    public function deleteemployer()
    {
         
        $id = request()->segment(3);
        $type = request()->segment(2);
        if($type == 'employer'){
               \App\Models\Employer::where('id', $id)->delete();
            }else{
               \App\Models\Branch::where('id', $id)->delete();
            }

        return redirect('branches/'.$type)->with('success', 'User updated.');
    }
    

    public function addPartner()
    {
        return Inertia::render('Clients/CreatePartner',
        [
            'roles' => DB::table('partner_groups')->get(),
            'uuid' => (string) Str::uuid()
        ]);
    }

    public function savePartner()
    {
            Request::validate([
                'name' => ['required', 'max:150'],
                'email' => ['nullable', 'max:150', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'partner_group_id' => ['nullable', 'max:50'],
                'website' => ['nullable', 'max:50'],
                'logo' => ['nullable', 'max:25'],
            ]);
            \App\Models\Partner::create(array_merge(request()->all(), ['uuid' => (string) Str::uuid()]));

            return redirect('partners')->with('success', 'User updated.');
        }

        public function addDept()
        {
            return Inertia::render('Staff/AddDept',
            [
                'roles' => DB::table('users')->get(),
                'uuid' => (string) Str::uuid()
            ]);
        }
    
        public function saveDept()
        {
                Request::validate([
                    'name' => ['required', 'max:150'],
                    'email' => ['required', 'max:150', 'email'],
                    'phone' => ['required', 'max:50'],
                    'address' => ['required', 'max:150'],
                    'user_id' => ['required', 'max:150'],
                    'about' => ['required', 'max:500'],
                ]);
                \App\Models\Department::create(array_merge(request()->all(), ['uuid' => (string) Str::uuid()]));
    
                return redirect('departments')->with('success', 'User updated.');
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



    public function savePayment(){
       // dd(request()->all());
        if((int)request('payment') > 0){
          $pay =  \App\Models\Payment::create([
                'client_id' => request('client_id'),
                'uuid' => (string) Str::uuid(),
                'installment_id' => request('client_id') != '' ? request('client_id') : \App\Models\ClientInstallment::where('client_id', request('client_id'))->orderBy('id')->first()->id,
                'amount' => request('payment'),
                'date' => request('date'),
                'method_id' => request('method_id'),
                'about' => request('about'),
                'reference' => date("MYH"),
                'status' => request('status'),
                'user_id' => request('user_id'),
            ]);
            if($pay){
                \App\Models\Task::create([
                    'title' => 'Received Amount of '. request('payment'),
                    'about' => request('about'),
                    'user_id' => request('user_id'),
                    'client_id' => request('client_id'),
                    'task_type_id' => 10,
                    'task_date' => date('Y-m-d'),
                    'uuid' => (string) Str::uuid(),
                    'priority_id' => 1,
                    'status_id' => 2,
                    'next_date' => date('Y-m-d'),
                    'next_type_id' => 1,
                    'created_by' => request('user_id')
                ]);
            }
        }
                
        return Redirect::back()->with('success', 'Received Amount of '. request('payment'));
    }


    public function saveTask(){
       // dd(request()->all());
        \App\Models\Task::create([
            'title' => request('title'),
            'about' => request('about'),
            'user_id' => request('user_id'),
            'client_id' => request('client_id'),
            'task_date' => date('Y-m-d'),
            'uuid' => (string) Str::uuid(),
            'priority_id' => request('priority_id'),
            'status_id' => request('status_id'),
            'next_date' => request('date'),
            'task_type_id' => request('task_type_id'),
            'next_type_id' => request('next_type_id'),
            'created_by' => request('user_id')
        ]);
             
    return Redirect::back()->with('success', 'Received Amount of '. request('payment'));
    }

    public function sendMessage()
    {
        $sms_count_per_sms = ceil(strlen(request('body'))/160);
                        
      $message =  \App\Models\Message::create([
            'title' =>  Auth::User()->name.' Sent New Message',
            'body' => request('body'),
            'phone' =>  validate_phone_number(trim(request('phone')))[1],
            'user_id' => request('user_id'),
            'sms_count' => $sms_count_per_sms, 
            'status' => 0,
            'return_code' => 'Sent',
            'client_id' => request('client_id'),
            'sender_id' => 'STEAM',
            'sms_id' => '1',
            'sms_type' => '1'
        ]);
        
        if($message && (int)$message->client_id > 0){
            \App\Models\Task::create([
                'title' => $message->title,
                'about' => $message->body,
                'user_id' =>  $message->user_id,
                'client_id' =>  $message->client_id,
                'task_type_id' => 5,
                'task_date' => date('Y-m-d'),
                'uuid' => (string) Str::uuid(),
                'priority_id' => 1,
                'status_id' => 2,
                'next_date' => date('Y-m-d'),
                'next_type_id' => 1,
                'created_by' => $message->user_id
            ]);
        }
        return Redirect::back()->with('success', 'Received Amount of '. request('payment'));

    }
}
