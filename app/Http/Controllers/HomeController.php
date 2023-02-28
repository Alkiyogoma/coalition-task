<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    }
 
    public function payments($id = null, $group = null)
    {
        $date = "'".date('Y-m-d')."'";
        $where_date = request('days') > 0 ? date('Y-m-d', strtotime('- '.request('days').'days')) : date('Y-m-01');
        $where_ = request('days') > 0 ? "'".date('Y-m-d', strtotime('- '.request('days').'days'))."'" : "'".date('Y-m-01')."'";
        $payments = DB::select('WITH alltasks as(SELECT c.id, c.name, sum(b.amount) as total, COUNT(DISTINCT b.client_id) as client FROM `payments` b JOIN `clients` a on b.client_id=a.id join partners c on c.id=a.partner_id where b.created_at >='.$where_.' GROUP BY c.id, c.name), allusers as (SELECT a.id, a.name, sum(b.amount) as amount, COUNT(b.id) as clients FROM `clients` b JOIN `partners` a on b.partner_id=a.id where b.status=1 GROUP BY a.id, a.name) select a.id, a.name, a.total, a.client, b.amount, b.clients from alltasks a left join allusers b on a.id=b.id order by total desc;');
        return inertia('Dashboard/Payment',
        [
            'partners' => $payments,
            'collections' => DB::select('SELECT b.uuid, a.name as collector, a.uuid as user_id, b.client_id, c.name, c.account, c.branch, c.phone, b.amount as amount, b.date FROM `payments` b JOIN `users` a on b.user_id=a.id join clients c on c.id=b.client_id ORDER BY a.id desc limit 20;'),
            'payments' => DB::select('SELECT a.id, a.name, a.code, count(b.id) as total, sum(b.amount) as amount, COUNT(DISTINCT b.client_id) as client FROM `payments` b JOIN `users` a on b.user_id=a.id WHERE date <='.$date.' GROUP BY a.id, a.name, a.code ORDER BY sum(b.amount) desc')

        ]);
    }


    public function index($id = null, $group = null)
    {
        $date = "'".date('Y-m-d')."'";
        $where_date = request('days') > 0 ? date('Y-m-d', strtotime('- '.request('days').'days')) : date('Y-m-01');
        $where_ = request('days') > 0 ? "'".date('Y-m-d', strtotime('- '.request('days').'days'))."'" : "'".date('Y-m-01')."'";
        $payments = DB::select('WITH alltasks as(SELECT a.id, a.name, a.sex, sum(b.amount) as total, COUNT(DISTINCT b.client_id) as client FROM `payments` b JOIN `users` a on b.user_id=a.id where b.created_at >'.$where_.' GROUP BY a.id, a.name,a.sex), allusers as (SELECT a.id, a.name, sum(b.amount) as amount, COUNT(b.id) as clients FROM `clients` b JOIN `users` a on b.user_id=a.id where b.status=1 GROUP BY a.id, a.name) select a.id, a.name, a.sex, a.total, a.client, b.amount, b.clients from alltasks a left join allusers b on a.id=b.id order by total desc;');
        
        return inertia('Dashboard/Dashboard',
        [
            'payments' => $payments,
            'tasks' => money(\App\Models\Task::whereDate('created_at', '>', $where_date)->count()),
            'amounts' => money(\App\Models\Payment::whereDate('created_at', '>', $where_date)->sum('amount')),
            'messages' => money(\App\Models\Message::whereDate('created_at', '>', $where_date)->count()),
            'clients' => money(\App\Models\Client::whereDate('created_at', '>', $where_date)->count()),
            'collections' => DB::select('SELECT a.id, a.name, a.code, count(b.id) as total, sum(b.amount) as amount, COUNT(DISTINCT b.client_id) as client FROM `payments` b JOIN `users` a on b.user_id=a.id WHERE date ='.$date.' GROUP BY a.id, a.name, a.code')

        ]);
    }

    public function tasks()
    {
    
        return inertia('Tasks/Task',
        [
            'usertasks' => DB::select('WITH alltasks as(
                SELECT a.id, a.name, COUNT(b.id) as total, COUNT(DISTINCT b.client_id) as client FROM `tasks` b JOIN `users` a on b.user_id=a.id  GROUP BY a.id, a.name),
                allusers as (SELECT a.id, a.name, COUNT(b.id) as completed FROM `tasks` b JOIN `users` a on  b.user_id=a.id where b.status_id=2 GROUP BY a.id, a.name)
                select a.id, a.name, a.total, a.client, b.completed from alltasks a left join allusers b on a.id=b.id order by total desc limit 7'),
            'total' => \App\Models\Task::count(),
            'averages' => DB::select('SELECT a.id, a.name, COUNT(b.id) as total FROM `tasks` b JOIN `task_type` a on b.task_type_id=a.id GROUP BY a.id, a.name'),
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
        'tasktypes' => DB::table('task_type')->orderBy('id')->get(),
        'task_priority' => DB::table('task_priority')->orderBy('id')->get(),
        'task_status' => DB::table('task_status')->orderBy('id')->get(),
        '_token' => csrf_token()

    ]);
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
}
