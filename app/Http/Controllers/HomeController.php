<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Imports\UsersImport;
use App\Imports\PaymentImport;
use App\Exports\CustomerExport;
use App\Exports\CodeExport;
use App\Exports\PaymentExport;
use Maatwebsite\Excel\Facades\Excel;
use \App\Models\Client;
use \App\Models\Message;
use DateTime;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->data = array();

    }
 
    public function payments($id = null, $group = null)
    {
        $date = "'".date('Y-m-d')."'";
        $where_date = request('days') > 0 ? date('Y-m-d', strtotime('- '.request('days').'days')) : date('Y-m-01');
        $where_ = request('days') > 0 ? "'".date('Y-m-d', strtotime('- '.request('days').'days'))."'" : "'".date('Y-m-01')."'";
        
        if(Auth::User()->role_id < 3){
            $where_condition = '';
        }elseif(Auth::User()->role_id == 3){
            $where_condition = " AND a.partner_id in (SELECT id from partners where user_id =".Auth::User()->id .") ";
        }else{
            $user= \App\Models\User::where('id', Auth::User()->id)->first();
            $where_condition = " AND a.user_id=$user->id ";
        }

        $payments = DB::select('WITH alltasks as(SELECT c.id, c.name, sum(b.amount) as total, COUNT(DISTINCT b.client_id) as client FROM payments b JOIN clients a on b.client_id=a.id join partners c on c.id=a.partner_id where b.created_at >='.$where_.$where_condition.' GROUP BY c.id, c.name), allusers as (SELECT b.id, b.name, sum(a.amount) as amount, COUNT(a.id) as clients FROM clients a JOIN partners b on a.partner_id=b.id where a.status=1 '.$where_condition.' GROUP BY b.id, b.name) select a.id, a.name, a.total, a.client, b.amount, b.clients from alltasks a left join allusers b on a.id=b.id order by total desc;');
        return inertia('Dashboard/Payment',
        [
            'partners' => $payments,
            'collections' => DB::select('SELECT b.uuid, c.name as collector, c.uuid as user_id, b.client_id, a.name, a.account, a.branch, a.phone, b.amount as amount, b.date FROM payments b JOIN users c on b.user_id=c.id join clients a on a.id=b.client_id ORDER BY c.id desc limit 20;'),
            'payments' => DB::select('SELECT c.id, c.name, c.code, count(b.id) as total, sum(b.amount) as amount, COUNT(DISTINCT b.client_id) as client FROM payments b JOIN users c on b.user_id=c.id JOIN clients a on b.client_id=a.id  WHERE date <='.$date.$where_condition.' GROUP BY c.id, c.name, c.code ORDER BY sum(b.amount) desc')

        ]);
    }


    public function index($id = null, $group = null)
    {
        if((int)Auth::User()->role_id == 3){
           return $this->teamLeader(Auth::User()->id);
        }
        $date = "'".date('Y-m-d')."'";
        $where_date = request('days') > 0 ? date('Y-m-d', strtotime('- '.request('days').'days')) : (request('days') != '' ? date('Y-m-d') : date('Y-m-01'));
        $where_ = request('days') > 0 ? "'".date('Y-m-d', strtotime('- '.request('days').'days'))."'" :  (request('days') != '' ? "'".date('Y-m-d')."'" : "'".date('Y-m-01')."'");
        $payments = DB::select('WITH alltasks as(SELECT a.id, a.name, a.sex, sum(b.amount) as total, COUNT(DISTINCT b.client_id) as client FROM payments b JOIN users a on b.user_id=a.id where b.created_at >='.$where_.' GROUP BY a.id, a.name,a.sex), allusers as (SELECT a.id, a.name, sum(b.amount) as amount, COUNT(b.id) as clients FROM clients b JOIN users a on b.user_id=a.id where b.status=1 GROUP BY a.id, a.name) select a.id, a.name, a.sex, a.total, a.client, b.amount, b.clients from alltasks a left join allusers b on a.id=b.id order by total desc;');
        
        return inertia('Dashboard/Dashboard',
        [
            'payments' => $payments,
            'tasks' => money(\App\Models\Task::whereDate('created_at', '>=', $where_date)->count()),
            'amounts' => money(\App\Models\Payment::whereDate('created_at', '>=', $where_date)->sum('amount')),
            'users' => \App\Models\Partner::get()
                ->map(fn ($User, $j=1) => [
                    'no' => $j+1,
                    'id' => $User->id,
                    'uuid' => $User->uuid,
                    'address' => $User->address,
                    'name' => $User->name,
                    'email' => $User->email,
                    'phone' => $User->phone,
                    'website' => $User->website,
                    'user' =>  !empty($User->user) > 0 ? $User->user->name : 'BANK',
                    'clients' =>   !empty($User->clients) ? $User->clients->count() : '0',
                    'active' => !empty($User->clients) ? $User->clients()->where('client_status_id', 3)->count() : 0,
                    'pending' => !empty($User->clients) ? $User->clients()->whereNull('client_status_id')->count() : 0,
                    'reached' => !empty($User->clients) ? $User->clients()->whereNotNull('client_status_id')->count() : 0,
                    'skip' => !empty($User->clients) ? $User->clients()->where('client_status_id', 1)->count() : 0,
                    'inactive' => !empty($User->clients) ? $User->clients()->where('client_status_id', 2)->count() : 0,
                    'amount' => !empty($User->clients) ? $User->clients()->sum('amount') : 0,
                    'created_at' => $User->created_at,
                ]),
            'clients' => money(\App\Models\Client::whereDate('created_at', '>=', $where_date)->count()),
            'collections' => DB::select('SELECT a.id, a.name, a.code, count(b.id) as total, sum(b.amount) as amount, COUNT(DISTINCT b.client_id) as client FROM payments b JOIN users a on b.user_id=a.id WHERE date ='.$date.' GROUP BY a.id, a.name, a.code'),
            'bank' => [
                'members' => \App\Models\Client::count(),
                'amounts' => money(\App\Models\Client::sum('amount')),
                'payments' => money(\App\Models\Payment::sum('amount')),
                'customers' => money(\App\Models\Client::whereIn('id', \App\Models\Payment::distinct()->get(['client_id']))->count()),        
            ],

        ]);
    }


    
    public function teamLeader($uuid = null, $group = null)
    {
        $where_date = request('days') > 0 ? date('Y-m-d', strtotime('- '.request('days').'days')) : date('Y-m-01');
        $where_ = request('days') > 0 ? "'".date('Y-m-d', strtotime('- '.request('days').'days'))."'" : "'".date('Y-m-01')."'";
        $payments = DB::select('WITH alltasks as(SELECT c.id, c.name, sum(b.amount) as total, COUNT(DISTINCT b.client_id) as client FROM payments b JOIN clients a on b.client_id=a.id join partners c on c.id=a.partner_id where b.created_at >='.$where_.' GROUP BY c.id, c.name), allusers as (SELECT a.id, a.name, sum(b.amount) as amount, COUNT(b.id) as clients FROM clients b JOIN partners a on b.partner_id=a.id where b.status=1 GROUP BY a.id, a.name) select a.id, a.name, a.total, a.client, b.amount, b.clients from alltasks a left join allusers b on a.id=b.id order by total desc;');
        $user_id = $uuid != '' ? \App\Models\User::where('uuid', $uuid)->first()->id : Auth::User()->id;
            $date = "'".date('Y-m-d')."'";
            $where_date = request('days') > 0 ? date('Y-m-d', strtotime('- '.request('days').'days')) : (request('days') != '' ? date('Y-m-d') : date('Y-m-01'));
            $where_ = request('days') > 0 ? "'".date('Y-m-d', strtotime('- '.request('days').'days'))."'" :  (request('days') != '' ? "'".date('Y-m-d')."'" : "'".date('Y-m-01')."'");
            $payments = DB::select('WITH alltasks as(SELECT a.id, a.name, a.sex, sum(b.amount) as total, COUNT(DISTINCT b.client_id) as client FROM payments b JOIN users a on b.user_id=a.id where b.created_at >='.$where_.' GROUP BY a.id, a.name,a.sex), allusers as (SELECT a.id, a.name, sum(b.amount) as amount, COUNT(b.id) as clients FROM clients b JOIN users a on b.user_id=a.id where b.status=1 GROUP BY a.id, a.name) select a.id, a.name, a.sex, a.total, a.client, b.amount, b.clients from alltasks a left join allusers b on a.id=b.id order by total desc;');
            $bank = \App\Models\Partner::where('user_id', $user_id);
            return inertia('Clients/Dashboard', [
                'payments' => $payments,
                'tasks' => money(\App\Models\Task::whereIn('client_id', \App\Models\Client::whereIn('partner_id', $bank->get(['id']))->get(['id']))->whereDate('created_at', '>=', $where_date)->count()),
                'amounts' => money(\App\Models\Payment::whereIn('client_id', \App\Models\Client::whereIn('partner_id', $bank->get(['id']))->get(['id']))->whereDate('created_at', '>=', $where_date)->sum('amount')),
                'messages' => money(\App\Models\Message::whereDate('created_at', '>=', $where_date)->count()),
                'clients' => money(\App\Models\Client::whereIn('partner_id', $bank->get(['id']))->whereDate('created_at', '>=', $where_date)->count()),
                'users' => \App\Models\Partner::where('user_id', $user_id)->get()
                ->map(fn ($User) => [
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
                'collections' => DB::select('SELECT a.id,a.uuid, a.name, a.code, count(b.id) as total, sum(b.amount) as amount, COUNT(DISTINCT b.client_id) as client FROM payments b JOIN users a on b.user_id=a.id join clients d on d.id=b.client_id WHERE d.partner_id in (select id from partners where user_id='.$user_id.') GROUP BY a.id, a.name, a.code order by sum(b.amount) DESC '),
                'partners' => $payments,
                'bank' => [
                    'members' => \App\Models\Client::whereIn('partner_id', $bank->get(['id']))->get(['id'])->count(),
                    'amounts' => money(\App\Models\Client::whereIn('partner_id', $bank->get(['id']))->sum('amount')),
                    'payments' => money(\App\Models\Payment::whereIn('client_id', \App\Models\Client::whereIn('partner_id', $bank->get(['id']))->get(['id']))->sum('amount')),
                    'customers' => money(\App\Models\Client::whereIn('partner_id', $bank->get(['id']))->whereIn('id', \App\Models\Payment::distinct()->get(['client_id']))->count()),        
                ],

        ]);
    }
    
    public function partnerStaff($id){
        $partner = \App\Models\Partner::where('uuid', $id)->first();
        return inertia('Clients/Staffs',
        [
            'users' => \App\Models\User::whereIn('id', \App\Models\Client::where('partner_id', $partner->id)->distinct()->get(['user_id']))->get()
                ->map(fn ($User) => [
                'id' => $User->id,
                'uuid' => $User->uuid,
                'name' => $User->name,
                'email' => $User->email,
                'phone' => $User->phone,
                'clients' => $User->clients()->where('partner_id', $partner->id)->count(),
                'amount' => $User->clients()->where('partner_id', $partner->id)->sum('amount'),
                'total' => \App\Models\Payment::whereIn('client_id', $User->clients()->where('partner_id', $partner->id)->get(['id']))->sum('amount'), //$User->clients()->where('partner_id', $partner->id)->count(),
                'created_at' => $User->created_at,
        ]),
        'bank' => [
            'members' => $partner->clients()->count(),
            'bankname' => $partner->name,
            'payments' =>  \App\Models\Payment::whereIn('client_id', $partner->clients()->get(['id']))->sum('amount'),
            'amounts' => $partner->clients()->sum('amount'),
            'uuid' => $partner->uuid,
            'id' => $partner->id,
            'leader' => $partner->user->name,

        ],
    ]);

    }
    public function tasks()
    {
    
        return inertia('Tasks/Task',
        [
            'usertasks' => DB::select('WITH alltasks as(
                SELECT a.id, a.name, COUNT(b.id) as total, COUNT(DISTINCT b.client_id) as client FROM tasks b JOIN users a on b.user_id=a.id  GROUP BY a.id, a.name),
                allusers as (SELECT a.id, a.name, COUNT(b.id) as completed FROM tasks b JOIN users a on  b.user_id=a.id where b.status_id=2 GROUP BY a.id, a.name)
                select a.id, a.name, a.total, a.client, b.completed from alltasks a left join allusers b on a.id=b.id order by total desc limit 7'),
            'total' => \App\Models\Task::count(),
            'averages' => DB::select('SELECT a.id, a.name, COUNT(b.id) as total FROM tasks b JOIN task_type a on b.task_type_id=a.id GROUP BY a.id, a.name'),
            'alltasks' => \App\Models\Task::where('status_id', 2)->orderBy('id', 'desc')->limit(20)
            ->get()->map(fn ($pay) => [
            'id' => $pay->id,
            'uuid' => $pay->uuid,
            'name' => $pay->title,
            'about' => $pay->about,
            'time' => timeAgo($pay->created_at),
            'date' => date('d M, Y', strtotime($pay->task_date)),
            'user' => !empty($pay->user) ? $pay->user->name : 'Not Defined',
            'type' => !empty($pay->tasktype) ? $pay->tasktype->name : 'Followup',
            'client' => !empty($pay->client) ? $pay->client->name : 'Not Defined',
            'phone' => !empty($pay->client) ? $pay->client->phone : 'Not Defined',
            'status' => !empty($pay->taskstatus) ? $pay->taskstatus->name : 'On progess',
            'nexttask' => !empty($pay->nexttask) ? $pay->nexttask->name : 'Followup',
        ]),
        'tasks' => \App\Models\Task::whereNotIn('status_id', [2])->orderBy('id', 'desc')->limit(20)
        ->get()->map(fn ($pay) => [
            'id' => $pay->id,
            'uuid' => $pay->client->uuid,
            'name' => $pay->title,
            'about' => $pay->about,
            'date' => date('d M, Y', strtotime($pay->task_date)),
            'time' => timeAgo($pay->created_at),
            'user' => !empty($pay->user) ? $pay->user->name : 'Not Defined',
            'client' => !empty($pay->client) ? $pay->client->name : 'Not Defined',
            'phone' => !empty($pay->client) ? $pay->client->phone : 'Not Defined',
            'type' => !empty($pay->tasktype) ? $pay->tasktype->name : 'Followup',
            'status' => !empty($pay->taskstatus) ? $pay->taskstatus->name : 'On progess',
            'nexttask' => !empty($pay->nexttask) ? $pay->nexttask->name : 'Followup',
        ]),
        'users' => DB::table('users')->orderBy('id')->get(),
        'clients' => DB::table('clients')->orderBy('id')->get(),
        'tasktypes' => DB::table('task_type')->where('group_id', 1)->orderBy('id')->get(),
        'task_priority' => \App\Models\ActionCode::where('partner_id', 1)->get(),
        'task_status' => DB::table('task_status')->orderBy('id')->get(),
        '_token' => csrf_token(),
        'color' => ['info','primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark']

    ]);
    }



    public function profile($id=null)
    {
     $uuid = $id !='' ? $id : Auth::User()->uuid;
     $user = \App\Models\User::where('uuid', $uuid)->first();
        return inertia('Tasks/Profile',
        [
            'total' => \App\Models\Task::where('user_id', $user->id)->count(),
            'averages' => DB::select('SELECT a.id, a.name, COUNT(b.id) as total FROM tasks b JOIN task_type a on b.task_type_id=a.id WHERE  b.user_id='. $user->id . ' GROUP BY a.id, a.name'),
            'statues' => DB::select('SELECT a.id, a.name, COUNT(b.id) as total FROM tasks b JOIN task_status a on b.status_id=a.id WHERE  b.user_id='. $user->id . ' GROUP BY a.id, a.name'),
            'alltasks' => \App\Models\Task::where('user_id', $user->id)->where('status_id', 2)->orderBy('id', 'desc')->limit(20)
            ->get()->map(fn ($pay) => [
            'id' => $pay->id,
            'uuid' => $pay->uuid,
            'name' => $pay->title,
            'about' => $pay->about,
            'time' => timeAgo($pay->created_at),
            'date' => date('d M, Y', strtotime($pay->task_date)),
            'user' => !empty($pay->user) ? $pay->user->name : 'Not Defined',
            'type' => !empty($pay->tasktype) ? $pay->tasktype->name : 'Followup',
            'client' => !empty($pay->client) ? $pay->client->name : 'Not Defined',
            'phone' => !empty($pay->client) ? $pay->client->phone : 'Not Defined',
            'status' => !empty($pay->taskstatus) ? $pay->taskstatus->name : 'On progess',
            'nexttask' => !empty($pay->nexttask) ? $pay->nexttask->name : 'Followup',
        ]),
        'tasks' => \App\Models\Task::where('user_id', $user->id)->whereNotIn('status_id', [2])->orderBy('id', 'desc')->limit(120)
        ->get()->map(fn ($pay) => [
            'id' => $pay->id,
            'uuid' => $pay->uuid,
            'name' => $pay->title,
            'about' => $pay->about,
            'date' => date('d M, Y', strtotime($pay->task_date)),
            'time' => timeAgo($pay->created_at),
            'user' => !empty($pay->user) ? $pay->user->name : 'Not Defined',
            'client' => !empty($pay->client) ? $pay->client->name : 'Not Defined',
            'phone' => !empty($pay->client) ? $pay->client->phone : 'Not Defined',
            'type' => !empty($pay->tasktype) ? $pay->tasktype->name : 'Followup',
            'status' => !empty($pay->taskstatus) ? $pay->taskstatus->name : 'On progess',
            'nexttask' => !empty($pay->nexttask) ? $pay->nexttask->name : 'Followup',
        ]),
        'user' => $user,
        'clients' => DB::table('clients')->where('status', 1)->where('user_id', $user->id)->orderBy('id')->get(),
        'tasktypes' => DB::table('task_type')->where('group_id', 1)->orderBy('id')->get(),
        'task_priority' =>  \App\Models\ActionCode::where('partner_id', 1)->get(),
        'task_status' => DB::table('task_status')->orderBy('id')->get(),
        '_token' => csrf_token(),
        'client_status' => DB::table('client_status')->orderBy('id')->get(),
        'color' => ['info','primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark']

    ]);
    }

    
    public function calendar($id=null)
    {
     $uuid = $id !='' ? $id : Auth::User()->uuid;
     $user = \App\Models\User::where('uuid', $uuid)->first();
   
        return inertia('Tasks/Calendar',
        [
            'alltasks' => \App\Models\Task::where('user_id', $user->id)->whereDate('next_date', '>=', date('Y-m-d'))->orderBy('next_date', 'asc')->limit(20)
            ->get()->map(fn ($pay) => [
                'id' => $pay->id,
                'uuid' => $pay->client->uuid,
                'title' => $pay->title,
                'about' => $pay->about,
                'date' => date('d M, Y', strtotime($pay->next_date)),
                'time' =>  date('jS M Y, h:i:s A ',strtotime($pay->next_date)),
                'user' => !empty($pay->user) ? $pay->user->name : 'Not Defined',
                'client' => !empty($pay->client) ? $pay->client->name : 'Not Defined',
                'phone' => !empty($pay->client) ? $pay->client->phone : 'Not Defined',
                'type' => !empty($pay->tasktype) ? $pay->tasktype->name : 'Followup',
                'status' => !empty($pay->taskstatus) ? $pay->taskstatus->name : 'On progess',
                'nexttask' => (!empty($pay->client) ? $pay->client->name : 'Not Defined') . ' - ' . (!empty($pay->nexttask) ? $pay->nexttask->name : 'Followup'),
            ]),
            'user' => $user,
            'color' => ['info','primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark']

    ]);
    }

public function calendar_data($id = null){
    $uuid = $id !='' ? $id : Auth::User()->uuid;
    $user = \App\Models\User::where('uuid', $uuid)->first();
    $tasks = \App\Models\Task::where('user_id', $user->id)->orderBy('id', 'desc')->limit(120)
    ->get()->map(fn ($pay) => [
       'start' => date('Y-m-d', strtotime($pay->task_date)),
       'title' => $pay->title . ' - ' .$pay->client->name,
       'end' =>  date('Y-m-d', strtotime($pay->next_date)),
       'className' =>  $pay->status_id ==2 ? 'bg-gradient-info px-2' : 'bg-gradient-success px-2'
    ]);
    return response()->json($tasks);
   //  json_encode($tasks);
}

    public function receipt($id)
    {
        if ($id != '') {
            $payment= \App\Models\Payment::where('uuid', $id)->first();
            $array['school'] = \App\Models\Setting::first();
            $array['payment'] = [
                    'id' => $payment->id,
                    'uuid' => $payment->uuid,
                    'date' => date('M d, Y', strtotime($payment->date)),
                    'created_at' => timeAgo($payment->created_at),
                    'reference' => $payment->reference,
                    'method' => !empty($payment->method) ? $payment->method->name : 'Cash',
                    'payer' => $payment->client->name,
                    'phone' => $payment->client->phone,
                    'account' => $payment->client->account,
                    'branch' => $payment->client->branch,
                    'note' => $payment->about,
                    'name' => $payment->user->name,
                    'userrole' => $payment->user->role->name,
                    'amount' => money($payment->amount),
                    'words' => number_to_words($payment->amount),
                ];
            $array['title'] = 'STEAM Generation Recoveries LTD Payment Receipt';
            return Inertia::render('Invoice/PaymentReceipt', $array);
        }
    }


    public function collections($group = 0, $id = 0, $export = null)
    {
        if(($id === 'export' || $group === 'export') || $export == 'export'){
            $date = date('F-d');
            $partner = request()->segment(2) > 0 ? \App\Models\Partner::where('id', request()->segment(2))->first()->name : 'All Banks';
            $name = (request()->segment(3) > 0 ? split_name(\App\Models\User::where('id', request()->segment(3))->first()->name)['first'] : 'All Staff');
            return Excel::download(new PaymentExport, 'Report_'.date('Mi').'_'.$partner.'_'.$name.'.xlsx');
        
        }
        $title = 'Payment Collections Since ';
        if((int)($id) > 0 && (int)$group > 0){
            $user= \App\Models\User::where('id', $id)->first();
            $partner= \App\Models\Partner::where('id', $group)->first();
            $where_condition = " AND f.id=$user->id and a.partner_id=$group ";
            $title = 'Collections of '.$user->name.' from '. $partner->name.' Since ';

        }elseif((int)($id) > 0 && (int)$group == 0){
            $user= \App\Models\User::where('id', $id)->first();
            $title = 'Collections of '.$user->name.' Since ';
            $where_condition = " AND f.id=$user->id ";
        }elseif((int)$group > 0){
            $partner= \App\Models\Partner::where('id', $group)->first();
            $where_condition = " AND a.partner_id=$group ";
            $title = 'Collections from '. $partner->name.' Since ';

        }else{
            if(Auth::User()->role_id < 3){
                $where_condition = '';
            }elseif(Auth::User()->role_id == 3){
                $where_condition = " AND a.partner_id in (SELECT id from partners where user_id =".Auth::User()->id .") ";
                $title = 'All Staff';
            }else{
                $user= \App\Models\User::where('id', Auth::User()->id)->first();
                $title = 'Collections of '.$user->name.' Since ';
                $where_condition = " AND f.id=$user->id ";
            }
        } 
        $date = "'".date('Y-m-d')."'";
        $where_date = request('days') > 0 ? date('Y-m-d', strtotime('- '.request('days').'days')) : (request('days') != '' ? date('Y-m-d') : date('Y-m-01'));
        $where_ = request('days') > 0 ? "'".date('Y-m-d', strtotime('- '.request('days').'days'))."'" :  (request('days') != '' ? "'".date('Y-m-d')."'" : "'".date('Y-m-01')."'");
        $payments = DB::select('WITH alltasks as(SELECT c.id, c.name, sum(b.amount) as total, COUNT(DISTINCT b.client_id) as client FROM payments b JOIN clients a on b.client_id=a.id join partners c on c.id=a.partner_id join users f on f.id=a.user_id where b.created_at >='.$where_. ' '. $where_condition.' GROUP BY c.id, c.name), allusers as (SELECT b.id, b.name, sum(a.amount) as amount, COUNT(a.id) as clients FROM clients a JOIN partners b on a.partner_id=b.id  join users f on f.id=a.user_id   where a.status=1 '.$where_condition .' GROUP BY b.id, b.name) select a.id, a.name, a.total, a.client, b.amount, b.clients from alltasks a left join allusers b on a.id=b.id order by total desc;');
   
        return inertia('Clients/Payment',
        [
            'title' => $title,
            'user' => $id,
            'date' => $where_date,
            'url' => url()->current(),
            'days' => request('days'),
            'payments' => $payments,
            'collections' => DB::select('SELECT b.uuid, f.name as collector, f.uuid as user_id, b.client_id, a.name, a.account, a.branch, a.phone, b.amount as amount, b.date FROM payments b JOIN users f on b.user_id=f.id join clients a on a.id=b.client_id where b.created_at >='.$where_. ' '. $where_condition.' ORDER BY b.id desc;'),
        ]);
    }

    public function AddPayment(){
        return Inertia::render('Clients/AddPayment',
        [
            'users' => DB::table('users')->get(),
            'partners' => DB::table('partners')->get(),
            'installments' => DB::table('installments')->get(),
            '_token' => csrf_token(),
            'clients' => DB::table('clients')->orderBy('id')->get(),
            'methods' => DB::table('payment_methods')->orderBy('id', 'desc')->get(),
        ]);
    }
    
    public function uploadPayments(){
        return Inertia::render('Clients/UploadPayment',
        [
            'users' => DB::table('users')->get(),
            '_token' => csrf_token(),
        ]);
    }
           
    public function clientUploads(){
        return Inertia::render('Clients/UploadClient',
        [
            'users' => DB::table('users')->get(),
            '_token' => csrf_token(),
        ]);
    }
           

    public function uploadPayment() 
    {
        Excel::import(new PaymentImport, request()->file('files'));
        return redirect('/payments')->with('success', 'All Members Uploaded Successfully!');
    }

    public function clientUpload() 
    {
        ini_set('memory_limit', '444M');
        Excel::import(new UsersImport, request()->file('files'));
        return redirect('clients')->with('success', 'All Students Uploaded Successfully!');
    }

    public function exportReport(){
        $date = date('F-d');
        $partner = \App\Models\Partner::where('id', request()->segment(3))->first();

        return Excel::download(new CustomerExport, 'Report_'.request()->segment(2).'_'.$partner->name.'_'.split_name(Auth::User()->name)['first'].'.xlsx');
    }

    public function exportReportCode(){
        $date = date('F-d');
        $partner = request()->segment(2);
        $user_id = request()->segment(3);
        
        $start = request('start') != '' ? request('start') : date('Y-m-01');
        $end = request('end') != '' ? request('end') : date('Y-m-d');
        $partner = \App\Models\Partner::where('id', request()->segment(2))->first();
        if((int)$user_id > 0 && $partner > 0){
            $clients = \App\Models\Client::whereBetween('ptpdate', [$start, $end])->where('user_id', $user_id)->where('partner_id', $partner)->where('code', request('code'))->orderBy('id', 'DESC')->get();
        }elseif((int)$user_id > 0){
            $clients = \App\Models\Client::whereBetween('ptpdate', [$start, $end])->where('user_id', $user_id)->where('code', request('code'))->orderBy('id', 'DESC')->get();

        }elseif((int)$partner > 0){
            $clients = \App\Models\Client::whereBetween('ptpdate', [$start, $end])->where('partner_id', $partner)->where('code', request('code'))->orderBy('id', 'DESC')->get();
        }
        if(count($clients) == 0) {
            return redirect('codereports')->with('success', 'No Customer Data Available');
        }
        return Excel::download(new CodeExport, request('code').'Report_'.request()->segment(2).'_'.$partner->name.'_'.split_name(Auth::User()->name)['first'].'.xlsx');
    }

    // public function studentExport(){
    //     return Excel::download(new StudentExport, 'exported_visitors.xlsx');
    // }



    public function messages()
    { 
        return inertia('Message');
    }
    public function inbox()
    { 
        $this->data['messages'] = \App\Models\Message::where('user_id', Auth::User()->id)->orderBy('id', 'DESC')->get();
        return view('message.inbox', $this->data);
    }

     public function templates()
    { 
        $this->data['messages'] = \App\Models\Template::orderBy('id', 'DESC')->get();
        return view('message.templates', $this->data);
    }

    public function addtemplate()
    { 
        if($_POST){
            \App\Models\Template::create(request()->all());
            return redirect('templates')->with('success', 'Success - '. request('name'). ' Added');
     }
        $this->data['messages'] = \App\Models\Message::where('user_id', Auth::User()->id)->orderBy('id', 'DESC')->limit(5)->get();
        return view('message.addtemp', $this->data);
    }

    public function sent()
    { 
        if(request()->segment(2) != ''){
            return redirect()->back()->with('success', 'Your Message Should have atleast 10 Words. Please try Again!!!');
        }
        $this->data['messages'] = \App\Models\Message::whereIn('user_id', \App\Models\User::where('status', 1)->get(['id']))->orderBy('id', 'DESC')->paginate(3);
        return view('message.sent', $this->data);
    }

  
    public function sendSingle()
    {
        $id = request('user_id');
        $message = request('name') != '' ?  request('name') :  request('body');
        $user = Client::where('id', $id)->first();
      
        if ($user) {
            if(strlen($message) > 10){
            send_sms(str_replace('+', '', validate_phone_number(trim($user->phone))[1]), $message, Auth::User()->username);
            $sent = Message::create(['title' => $user->name.' Sent Message', 'user_id' => Auth::User()->id, 'phone' => validate_phone_number(trim($user->phone))[1], 'body' => $message, 'sender_id' =>  Auth::User()->username, 'status' => 1]);
            if($sent){
                return request('body') != '' ? redirect()->back()->with('success', 'SMS Sent to '.$user->name) : '';

                return response()->json([
                "title" => "SMS Sent to ".$user->name,
                "text" => $message,
                "icon" => "success"
            ]);
        }
        }else{
            return response()->json([
                "title" => Auth::User()->name,
                "text" => "You have to write something to send this message at least 10 words",
                "icon" => "error"
            ]);
        }
        } else {
            return response()->json([
                "title" => "Message Failed!",
                "text" => 'User Information Not Found',
                "icon" => "error"
            ]);
        }
    }

        
        public function send()
        {
            $this->data['users'] = \App\Models\Client::where('status', 1)->get();
            if(Auth::User()->role_id < 3){
                $this->data['groups'] = \App\Models\Partner::get();
                $this->data['users'] = \App\Models\Client::where('status', 1)->get();
            }elseif(Auth::User()->role_id == 3){
                $this->data['groups'] = \App\Models\Partner::where('user_id', Auth::User()->id)->get();
                $this->data['users'] = \App\Models\Client::whereIn('partner_id', \App\Models\Partner::where('user_id', Auth::User()->id)->get(['id']))->where('status', 1)->get();
            }else{
                $user= \App\Models\User::where('id', Auth::User()->id)->first();
                $this->data['groups'] = \App\Models\Partner::whereIn('id', \App\Models\Client::where('user_id', Auth::User()->id)->distinct()->get(['partner_id']))->get();
                $this->data['users'] = \App\Models\Client::where('user_id', Auth::User()->id)->where('status', 1)->get();
            }
            $this->data['families'] = \App\Models\Client::where('user_id', Auth::User()->id)->where('status', 1)->get();
            $this->data['leaders'] = \App\Models\Branch::get();
            $this->data['visitors'] = \App\Models\Employer::get();

            if($_POST){
                //Send SMS to Leaders
                $users = [];
                if(request('leader_id') != '' && request('leader_id')[0] == 'all'){
                    $users = \App\Models\Client::where('status', 1)->whereIn('branch_id', \App\Models\Branch::where('status', 1)->get(['id']))->get();
                }elseif(request('leader_id') != ''){
                    $users = \App\Models\Client::where('status', 1)->whereIn('branch_id', request('leader_id'))->get();
                }

                //Send SMS to Family Member
                if(request('family_id') != '' && request('family_id')[0] == 'all'){
                    $users = \App\Models\Client::where('status', 1)->where('user_id', Auth::User()->id)->get();
                }elseif(request('family_id') != ''){
                    $users = \App\Models\Client::where('user_id', Auth::User()->id)->where('status', 1)->whereIn('id', request('family_id'))->get();
                }
               
                //Send SMS to Visitors Member
                if(request('visitor_id') != '' && request('visitor_id')[0] == 'all'){
                    $users = \App\Models\Client::where('status', 1)->where('status', 1)->get();
                }elseif(request('visitor_id') != ''){
                    $users = \App\Models\Client::where('status', 1)->whereIn('employer_id', request('visitor_id'))->get();
                }

                //Send SMS to Believer Member
                if(request('believer_id') != '' && request('believer_id')[0] == 'all'){
                    $users = \App\Models\Client::where('status', 1)->where('status', 1)->get();
                }elseif(request('believer_id') != ''){
                    $users = \App\Models\Client::where('status', 1)->whereIn('id', request('believer_id'))->get();
                }

                //Send SMS to Groups
                if(request('group_id') != '' && request('group_id')[0] == 'all'){
                    $users = \App\Models\Client::where('status', 1)->get();
                }elseif(request('group_id') != '' && request('group_id')[0] != 'all'){
                    $users = \App\Models\Client::where('status', 1)->whereIn('partner_id',  request('group_id'))->get();
                }

                //Send SMS to all members
                if(request('client_id') != '' && request('client_id')[0] == 'all'){
                    $users = \App\Models\Client::where('status', 1)->where('status', 1)->get();
                }elseif(request('client_id') != ''){
                    $users = \App\Models\Client::where('status', 1)->whereIn('id', request('client_id'))->get();
                }

                //Send SMS to Employers
                if(request('member_id') != '' && request('member_id')[0] == 'all'){
                    $users = \App\Models\Client::where('status', 1)->get();
                }elseif(request('member_id') != '' && request('member_id')[0] != 'all'){
                    $users = \App\Models\Client::where('status', 1)->whereIn('partner_id',  request('member_id'))->get();
                }

                $message = request('body');
                if (count($users) > 0 && strlen($message) > 15) {  
                    foreach($users as $user){ 
                       if($user->phone != ''){
                        $body = str_replace('#name', $user->name, $message);
                        $body = str_replace('#balance', money($user->amount), $body);
                        $body = str_replace('#amount', money($user->amount), $body);
                        $body = isset($user->partner) && !empty($user->partner) ? str_replace('#bank', $user->partner->name, $body) : str_replace('#amount', $user->amount, $body);
                        \App\Models\Message::create(['title' => $user->name.' New Message', 'user_id' => $user->id, 'phone' => validate_phone_number(trim($user->phone))[1], 'body' => $body, 'status' => 1]);
                        send_sms(str_replace('+', '', validate_phone_number(trim($user->phone))[1]), $body);
                    }
                }
                return redirect()->back()->with('success', 'Congraturations ' . count($users) . ' Messages Sent Successfully');
            }else{
                    return redirect()->back()->with('error', 'Your Message Should have atleast 10 Words. Please try Again!!!');
                }
            }
            $setting = DB::table('setting')->first()->sms_enabled;
            if((int)$setting < 20){
                return redirect('messages/setting')->with('error', 'Your Message balance is less than 20 SMS. Please buy new sms now!!');
            }
            return view('message.add', $this->data);
        }

        public function setting()
        {
            $week = date('Y-m-d', strtotime('-7 days'));
            $month = (int)date('m');
            $this->data['this_day'] = \App\Models\Message::whereYear('created_at', date('Y'))->whereDate('created_at', date("Y-m-d"))->count();
            $this->data['this_month'] = \App\Models\Message::whereYear('created_at', date('Y'))->whereMonth('created_at', $month)->count();
            $this->data['this_week'] = \App\Models\Message::where('created_at', '>=', $week)->count();
            $this->data["datas"] = DB::SELECT('SELECT count(id) as ynumber, DATE(t.created_at) as date FROM messages t  GROUP BY DATE(t.created_at) ORDER BY DATE(t.created_at) desc limit 8');
            return view('message.reports', $this->data);
        }
        
        public function trynew()
        {
            return view('layouts.default');
        }

        public function buySMS()
        {
            $message =  church_name(). ' ';  
            $message .= request('comment');
            $message .= chr(10);
            $message .= 'Number of SMS - '. request('message');   
            $message .= chr(10);
            $message .= 'Phone - '. request('phone');
            $message .= chr(10);
            $message .= 'Method - '. request('method');
           send_sms('255744158016', $message);
            if(Auth::User()->phone != ''){
            send_sms(Auth::User()->phone, 'Hello '.Auth::User()->name .', DARSMS have Received your order to buy '. request('message'). ' SMS we will send you invoice soon.');
           }
           return redirect()->back()->with('success', 'We have Received Your Order of ' . request('message') . ' SMS we will send you invoice to pay.');
        }

        
        public function send_to_numbers(){
            $message = request('message');
            $key_name = request('sender_name') != '' ? request('sender_name') : 'INFO';
            $custom_numbers = request('numbers');
            
            if($custom_numbers != ''){
                $numbers = [];
                if (preg_match('/,/', $custom_numbers)) {
                    $numbers = explode(',', $custom_numbers);
                } else if (preg_match('/ /', $custom_numbers)) {
                    $numbers = explode(' ', $custom_numbers);
                } else {
                    $numbers = [$custom_numbers];
                }
                $sent_to = 0;
                $wrong = 0;
                $invalid_numbers = '';

                foreach ($numbers as $number) {
                    $valid = validate_phone_number($number);
                    if (is_array($valid)) {
                        $sent_to++;
                    $message = request('body');
                            $body = $message;
                            \App\Models\Message::create(['title' => 'New Message', 'user_id' => Auth::User()->id, 'sender_id' => Auth::User()->username, 'phone' => str_replace('+', '', $valid[1]), 'body' => $body, 'return_code' => $key_name, 'status' => 0]);
                    } else {
                        $wrong++;
                        $invalid_numbers .= $number . ',';
                    }
                }
                return redirect()->back()->with('success', 'Congraturations ' . $sent_to. ' Messages Sent Successfully');
            }
        
        redirect()->back()->with('success', 'Mesage Sent');
    }


    
    public function comments($type)
    {
        $partner = request('partner_id');
        $user_id = request('user_id');
        
        $task = \App\Models\Task::where('user_id', Auth::User()->id)->whereDate('created_at', date('Y-m-d'))->first();
        $this->data['start'] = date('Y-m-d');
        if($type == 'today'){
            $this->data['codes'] = \App\Models\ActionCode::where('partner_id', 9)->get();
        }else{
            $this->data['codes'] = \App\Models\ActionCode::where('partner_id', 1)->get();
        }
        $this->data['url'] = !empty($task) ? "exportreport/".$type."/".$task->client->partner_id."/".Auth::User()->id : '';
        $task =   \App\Models\Task::where('user_id', Auth::User()->id)->whereDate('created_at', date('Y-m-d'))->get(['client_id']);
        $this->data['clients'] = \App\Models\Client::whereIn('id', $task)->orderBy('id', 'DESC')->get();
        if($type == 'today' && $partner > 0){
            $task = (int)$user_id > 0 ? \App\Models\Task::where('user_id', $user_id)->whereDate('created_at', request('start'))->get(['client_id']) :  \App\Models\Task::whereDate('created_at', '>=', date('Y-m-01'))->get(['client_id']);
            $this->data['clients'] = \App\Models\Client::where('partner_id', $partner)->whereIn('id', $task)->orderBy('id', 'DESC')->get();
            $this->data['url'] = "exportreport/$type/$partner/$user_id";
            $this->data['start'] = date('Y-m-d', strtotime(request('start')));
        }
        if($type == 'week' && $partner > 0){
            $start = date('Y-m-d', strtotime(request('start')));
            $end  = date('Y-m-d',strtotime('+6 day',strtotime($start)));
            $this->data['start'] = $start;
            $task = (int)$user_id > 0 ? \App\Models\Task::where('user_id', $user_id)->whereBetween('task_date', [$start, $end])->get(['client_id']) :  \App\Models\Task::whereDate('created_at', '>=', date('Y-m-01'))->get(['client_id']);
            $this->data['clients'] = \App\Models\Client::where('partner_id', $partner)->whereIn('id', $task)->orderBy('id', 'DESC')->get();
            $this->data['url'] = "exportreport/$type/$partner/$user_id";
        }
        if($type == 'month' && $partner > 0){
            
            $start = date('Y-m-d', strtotime(request('start')));
            $end  = date('Y-m-d',strtotime('+29 day',strtotime($start)));
            $this->data['start'] = $start;
            $task = (int)$user_id > 0 ? \App\Models\Task::where('user_id', $user_id)->whereBetween('task_date', [$start, $end])->get(['client_id']) :  \App\Models\Task::whereDate('created_at', '>=', date('Y-m-01'))->get(['client_id']);
            $this->data['clients'] = \App\Models\Client::where('partner_id', $partner)->whereIn('id', $task)->orderBy('id', 'DESC')->get();
            $this->data['url'] = "exportreport/$type/$partner/$user_id";
        }
        $this->data['types'] = $type;
        if(Auth::User()->role_id < 3){
            $this->data['partners'] = \App\Models\Partner::get();
        }elseif(Auth::User()->role_id == 3){
            $this->data['partners'] = \App\Models\Partner::where('user_id', Auth::User()->id)->get();
        }else{
            $user= \App\Models\User::where('id', Auth::User()->id)->first();
            $this->data['partners'] = \App\Models\Partner::whereIn('id', \App\Models\Client::where('user_id', Auth::User()->id)->distinct()->get(['partner_id']))->get();
        }
        return view('message.comments', $this->data);
    }

   
   public function callClient()
    {
        $class_level_id = request('partner_id');
        $classes = (int) $class_level_id == 0 ? \App\Models\Client::where('user_id', Auth::User()->id)->get() : \App\Models\Client::where('partner_id', $class_level_id)->get();
        if ((int)request('group_id') > 0) {
            $classes = \App\Models\Client::where('group_id',  request('group_id'))->get();
        }

        if (!empty($classes)) {
            echo "<option value='all'>All Customers</option>";
            foreach ($classes as $class) {
                echo '<option value=' . $class->id . '>' . $class->name . ' - '. $class->account . '</option>';
            }
        } else {
            echo "0";
        }
    }


    function staffClient()
    {
        $id = request('partner_id');
        $classes = \App\Models\User::whereIn('id', \App\Models\Client::where('partner_id', $id)->distinct()->get(['user_id']))->get();
        if (count($classes)) {
            echo "<option value='all'>All Staff</option>";
            foreach ($classes as $class) {
                echo '<option value=' . $class->id . '>' . $class->name . '</option>';
            }
        } else {
            echo "0";
        }
    }

    function callGroup()
    {
        $class_level_id = request('group_id');
        if ((int) $class_level_id > 0) {
            $classes = \App\Models\Client::where('group_id', $class_level_id)->get();
            if (!empty($classes)) {
                echo "<option value='null'> Select Class </option>";
                echo "<option value='all'>All Classes</option>";
                foreach ($classes as $class) {
                    echo '<option value=' . $class->id . '>' . $class->account . '</option>';
                }
            } else {
                echo '0';
            }
        } else {
            echo "0";
        }
    }

    /**
     * @accessed: -- Add student view
     */
    public function callTasks()
    {
        $class_level_id = request('user_id');
        $classes = \App\Models\Task::where('user_id', $class_level_id)->orderBy('id', 'desc')->get();
        if (count($classes) > 0) {
            echo '<option value="">select task</option>';
            foreach ($classes as $value) {
                echo '<option value="' . $value->id . '">' . $value->title . '</option>';
            }
        } else {
            echo "0";
        }
    }
    
    public function getCode(){
        $code = \App\Models\ActionCode::where('code',  request('code'))->first();
        if (!empty($code)) {
            echo $code->about;
        }else{
            echo request('code');
        }
        if((int)request('client_id') > 0){
            \App\Models\Client::where('id', request('client_id'))->update(['code' => request('code'),  'placement' => $code->about]);
        }
        if((int)request('client_id') > 0 && request('type') != 'code'){
            \App\Models\Client::where('id', request('client_id'))->update([request('type') => request('type_value')]);
        }
    }

    public function saveTask(){
        $title = \App\Models\TaskType::where('id', request('task_type_id'))->first();

         \App\Models\Task::create([
             'title' => !empty($title) ? $title->name : (request('title') != '' ? request('title') : 'Followup'),
             'about' => request('about'),
             'user_id' => request('user_id'),
             'client_id' => request('client_id'),
             'task_date' => date('Y-m-d'),
             'uuid' => (string) Str::uuid(),
             'action_code_id' => request('action_code_id'),
             'status_id' => request('status_id'),
             'next_date' => request('date'),
             'task_type_id' => request('task_type_id'),
             'next_type_id' => request('next_type_id'),
             'created_by' => request('user_id')
         ]);
         $code = \App\Models\ActionCode::where('id', request('action_code_id'))->first();
         $client = \App\Models\Client::where('id', request('client_id'))->first();
         !empty($code) ? \App\Models\Client::where('id', request('client_id'))->update(['code' => $code->code, 'client_status_id' => (int)request('client_status_id') > 0 ? (int)request('client_status_id') : $client->task_status_id,  'ptpdate' => request('date') != '' ? request('date') : date('Y-m-d')]) : '';

        return redirect()->back()->with('success', 'Task Created Successfully');
     }
 
     public function deleteTask($id)
     { 
        \App\Models\Task::where('uuid', $id)->delete();
       return redirect()->back()->with('warning', 'Task Deleted');
     }

     public function updateTask($id, $status)
     { 
        \App\Models\Task::where('uuid', $id)->update(['status_id' => $status]);
        return redirect(url()->previous())->with('success', 'Task Updated');
    }


    
    public function roles()
    {
        $this->data['roles'] = \App\Models\Role::get();
        return view('message.roles', $this->data);
    }

    public function permissions()
    {

        $id = request()->segment(2);
        if($_POST){
            $permission = \App\Models\Permission::create(request()->all());
            \App\Models\RoleHasPermission::create(['role_id' => 1, 'permission_id' => $permission->id]);
        }
        $this->data['role_'] =  \App\Models\Role::where('id', $id)->first();
        $this->data['groups'] = \App\Models\PermissionGroup::get();
        return view('message.permission', $this->data);
    
    }

    public function groups()
    {
        return view('message.roles');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function savePermits()
    {   
        if($_POST){
      
        foreach(request('permission_id') as $value){
            $check  = \App\Models\RoleHasPermission::where('role_id', request('role_id'))->where('permission_id', $value)->first();
            if(empty($check)){
                \App\Models\RoleHasPermission::create(['role_id' => request('role_id'), 'permission_id' => $value]);
            }
        }
        return redirect()->back()->with('message', 'New Post created successfully');
    }
}

  
  public function search()
  {
      $q = request('q');

      if (strlen($q) > 3) { //prevent empty search which load all results
          $users = \App\Models\User::where(DB::raw('lower(name)'), 'like', '%'.strtolower($q).'%')
          ->orWhere(DB::raw('lower(phone)'), 'like', '%'.strtolower($q).'%')->orderBy('name')->limit(5)->get();

          $students = \App\Models\Client::where(DB::raw('lower(name)'), 'like', '%'.strtolower($q).'%')
          ->orWhere(DB::raw('lower(phone)'), 'like', '%'.strtolower($q).'%')
          ->orWhere(DB::raw('lower(account)'), 'like', '%'.strtolower($q).'%')->where('status', 1)->orderBy('name')->limit(7)->get();
          
          if (count($students) > 0) {
              echo '<div class="w-full overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-1 py-1">-</th>
                        <th class="px-1 py-1">Customer </th>
                        <th class="px-1 py-1">Bank</th>
                        <th class="px-1 py-1">Account</th>
                        <th class="px-1 py-1">Balance</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">';

              foreach ($students as $user) {

                echo '<tr class="text-gray-700 dark:text-gray-400">
                  <td class="px-1 py-1 text-sm"></td>
                  <td class="px-1 py-1 text-sm">
                    <a class="flex items-center justify-between text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" href="/client/' . $user->uuid . '/view">
                        ' .  $user->name . '</a>
                    </td>
                    <td class="px-1 py-1 text-sm">' .   $user->partner->name . '</td>
                    <td class="px-1 py-1 text-sm">
                        <a class="flex items-center justify-between text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" href="/client/' . $user->uuid . '/view">
                        ' .   $user->account . '</a>
                    </td>
                    <td class="px-1 py-1 text-sm">
                        <a class="flex items-center justify-between text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" href="/client/' . $user->uuid . '/view">
                        ' .   money($user->amount) . '</a>
                    </td>
                </tr>';
              }
              echo '</tbody></table><hr></div>';
          }
      } else {
          echo 'Result Not Found, Try Again.';
      }
  }

        public function saveTrace(){
            \App\Models\Client::where('id', request('client_id'))->update(['status' => 3]);
            \App\Models\Task::create([
                'title' => 'Start Skip Tracking',
                'about' => request('about'),
                'user_id' => request('user_id'),
                'client_id' => request('client_id'),
                'task_date' => date('Y-m-d'),
                'uuid' => (string) Str::uuid(),
                'action_code_id' => 1,
                'status_id' => 3,
                'next_date' => request('date'),
                'task_type_id' => 17,
                'next_type_id' => 1,
                'created_by' => Auth::User()->id,
            ]);

            \App\Models\Tracing::create([
                'about' => request('about'),
                'user_id' => Auth::User()->id,
                'client_id' => request('client_id'),
                'date' => date('Y-m-d'),
                'staff_id' => request('user_id'),
                'task_type_id' => 17,
            ]);
        return redirect()->back()->with('success', 'Start Tracing Created Successfully');
    }

        public function tracing($type = null) {
        
            $partner = request('partner_id');
            $user_id = request('user_id');            
            $this->data['start'] = date('Y-m-d');
            $start = request('start_date') != '' ? "'".request('start_date')."'" : "'".date('Y-m-01')."'";
            $end = request('end_date') != '' ? "'".request('end_date')."'" : "'".date('Y-m-d')."'";
            $user = (int)$user_id > 0 ? \App\Models\User::where('id', $user_id)->first()->name : 'All Users';
            $bank = (int)$partner > 0 ? \App\Models\Partner::where('id', $partner)->first()->name : 'All Banks';
            $task = (int)$user_id > 0 ? \App\Models\Tracing::where('staff_id', $user_id)->whereBetween('date', [$start, $end])->get(['client_id']) :  \App\Models\Tracing::whereDate('date', '>=', date('Y-m-01'))->get(['client_id']);
            $this->data['clients'] = (int)$partner > 0 ? \App\Models\Client::where('partner_id', $partner)->whereIn('id', $task)->orderBy('id', 'DESC')->get() : \App\Models\Client::whereIn('id', $task)->orderBy('id', 'DESC')->get();
            $this->data['url'] = "exportreport/$type/$partner/$user_id";
            
            $where = (int)$user_id > 0 && $partner > 0 ? ' AND a.staff_id = ' . $user_id . ' AND c.partner_id = ' . $partner . '' : ( (int)$user_id > 0 ? ' AND a.staff_id = ' . $user_id . '' : ((int)$partner > 0 ? ' AND c.partner_id = '.$partner : '' ));
            $where_user =  (int)$user_id > 0 ? ' AND user_id = ' . $user_id . ' ' : '';
            $scanned = collect(DB::select('SELECT count(a.*) from tracing a join clients c on a.client_id=c.id WHERE a.id in (select distinct trace_id from trace_clients where trace_id>0 '.$where_user.') AND a.date between '.$start. ' AND '.$end.$where))->first()->count;
            $recoved = collect(DB::select('SELECT count(a.*) from tracing a join clients c on a.client_id=c.id WHERE a.id in (select distinct trace_id from trace_clients where trace_id>0 '.$where_user.') AND a.phone is not null AND a.date between '.$start. ' AND '.$end.$where))->first()->count;
            $total = collect(DB::select('SELECT count(a.*) from tracing a join clients c on a.client_id=c.id WHERE a.date between '.$start. ' AND '.$end.$where))->first()->count;
            $pending = collect(DB::select('SELECT count(a.*) from tracing a join clients c on a.client_id=c.id WHERE a.id NOT IN (select distinct trace_id from trace_clients where trace_id>0) AND a.date between '.$start. ' AND '.$end.$where))->first()->count;
            $remained = $total - $recoved;

            $this->data['types'] = $type;
            $this->data['report'] = [
                'scanned' => $scanned,
                'recoved' => $recoved,
                'total' => $total,
                'pending' => $pending,
                'remained' => $remained,
                'user' => $user,
                'bank' => $bank,
             ];
            $this->data['start_date'] = $start;
            $this->data['end_date'] = $end;
            $this->data['partners'] = \App\Models\Partner::get();
            $this->data['codes'] = \App\Models\TaskType::where('group_id', 2)->get();
            return view('message.tracing', $this->data);
        }

        public function getTrace(){
            $code = \App\Models\TaskType::where('id',  request('code'))->first();
            if (!empty($code)) {
                echo $code->about;
            }else{
                echo 'Not valid task type';
            }
            if((int)request('client_id') > 0){
                \App\Models\Tracing::where('client_id', request('client_id'))->update(['task_type_id' => request('code')]);
                if(request('type_value') != '' && (request('type') == 'phone' || request('type') == 'about')){
                    \App\Models\Tracing::where('client_id', request('client_id'))->update([request('type') => request('type_value')]);
                    if(request('type') == 'phone' && strlen(request('type_value')) > 9){
                        \App\Models\Client::where('id', request('client_id'))->update(['status' => 1, 'phone' => request('type_value')]);
                    }
                }
                $trace = \App\Models\TraceClient::where('trace_id', request('trace_id'))->first();
                if(empty($trace)){
                    \App\Models\TraceClient::create([
                    'task_type_id' => request('code'),
                    'trace_id' => request('trace_id'),
                    'about' => request('type_value'),
                    'user_id' => Auth::User()->id,
                ]);
            }else{
                $trace = \App\Models\TraceClient::where('trace_id', request('trace_id'))->wheredate('created_at', date('Y-m-d'))
                ->update([
                    'task_type_id' => request('code'),
                    'trace_id' => request('trace_id'),
                    'about' => request('about'),
                    'user_id' => Auth::User()->id,
                ]);

            }
            echo 'Success';
        }
    }


    public function codereports($type = null) {
        
        $partner = request('partner_id');
        $user_id = request('user_id');            
        $start = request('start_date') != '' ? request('start_date') : date('Y-m-01');
        $end = request('end_date') != '' ? request('end_date') : date('Y-m-d');
        $user = (int)$user_id > 0 ? \App\Models\User::where('id', $user_id)->first()->name : 'All Users';
        $bank = (int)$partner > 0 ? \App\Models\Partner::where('id', $partner)->first()->name : 'All Banks';
        $this->data['url'] = "exportreportcode/$partner/$user_id";
        $clients = [];
        if((int)$user_id > 0 && $partner > 0){
            $clients = \App\Models\Client::whereBetween('ptpdate', [$start, $end])->where('user_id', $user_id)->where('partner_id', $partner)->where('code', request('code'))->orderBy('id', 'DESC')->get();
        }elseif((int)$user_id > 0){
            $clients = \App\Models\Client::whereBetween('ptpdate', [$start, $end])->where('user_id', $user_id)->where('code', request('code'))->orderBy('id', 'DESC')->get();

        }elseif((int)$partner > 0){
            $clients = \App\Models\Client::whereBetween('ptpdate', [$start, $end])->where('partner_id', $partner)->where('code', request('code'))->orderBy('id', 'DESC')->get();
        }
        $this->data['start_date'] = $start;
        $this->data['end_date'] = $end;
        $this->data['code'] = request('code');
        $this->data['clients'] = $clients;
        $this->data['partners'] = \App\Models\Partner::get();
        $this->data['codes'] = \App\Models\ActionCode::where('partner_id', 1)->get();
        return view('message.codereport', $this->data);
    }


}
