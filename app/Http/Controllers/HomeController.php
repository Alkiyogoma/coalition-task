<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Imports\UsersImport;
use App\Imports\PaymentImport;
use App\Exports\CustomerExport;
use Maatwebsite\Excel\Facades\Excel;
use \App\Models\Client;
use \App\Models\Message;
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
        $payments = DB::select('WITH alltasks as(SELECT a.id, a.name, a.sex, sum(b.amount) as total, COUNT(DISTINCT b.client_id) as client FROM `payments` b JOIN `users` a on b.user_id=a.id where b.created_at >='.$where_.' GROUP BY a.id, a.name,a.sex), allusers as (SELECT a.id, a.name, sum(b.amount) as amount, COUNT(b.id) as clients FROM `clients` b JOIN `users` a on b.user_id=a.id where b.status=1 GROUP BY a.id, a.name) select a.id, a.name, a.sex, a.total, a.client, b.amount, b.clients from alltasks a left join allusers b on a.id=b.id order by total desc;');
        
        return inertia('Dashboard/Dashboard',
        [
            'payments' => $payments,
            'tasks' => money(\App\Models\Task::whereDate('created_at', '>=', $where_date)->count()),
            'amounts' => money(\App\Models\Payment::whereDate('created_at', '>=', $where_date)->sum('amount')),
            'messages' => money(\App\Models\Message::whereDate('created_at', '>=', $where_date)->count()),
            'clients' => money(\App\Models\Client::whereDate('created_at', '>=', $where_date)->count()),
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



    public function profile($id=null)
    {
     $uuid = $id !='' ? $id : Auth::User()->uuid;
     $user = \App\Models\User::where('uuid', $uuid)->first();
        return inertia('Tasks/Profile',
        [
            'total' => \App\Models\Task::where('user_id', $user->id)->count(),
            'averages' => DB::select('SELECT a.id, a.name, COUNT(b.id) as total FROM `tasks` b JOIN `task_type` a on b.task_type_id=a.id WHERE  b.user_id='. $user->id . ' GROUP BY a.id, a.name'),
            'statues' => DB::select('SELECT a.id, a.name, COUNT(b.id) as total FROM `tasks` b JOIN `task_status` a on b.task_type_id=a.id WHERE  b.user_id='. $user->id . ' GROUP BY a.id, a.name'),
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
        'clients' => DB::table('clients')->where('user_id', $user->id)->orderBy('id')->get(),
        'tasktypes' => DB::table('task_type')->orderBy('id')->get(),
        'task_priority' => DB::table('task_priority')->orderBy('id')->get(),
        'task_status' => DB::table('task_status')->orderBy('id')->get(),
        '_token' => csrf_token(),
        'color' => ['default','primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark']

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


    public function collections($id = null, $group = null)
    {
        if(strlen($id) > 10 && (int)$group > 0){
            $user= \App\Models\User::where('uuid', $id)->first();
            $where_condition = " AND f.id=$user->id and a.partner_id=$group ";
        }elseif(strlen($id) > 10 && (int)$group == 0){
            $user= \App\Models\User::where('uuid', $id)->first();
            $where_condition = " AND f.id=$user->id ";

        }elseif((int)$group > 0){
            $where_condition = " AND f.partner_id=$group ";
        }else{
            $where_condition = '';
        }
        $date = "'".date('Y-m-d')."'";
        $where_date = request('days') > 0 ? date('Y-m-d', strtotime('- '.request('days').'days')) : date('Y-m-01');
        $where_ = request('days') > 0 ? "'".date('Y-m-d', strtotime('- '.request('days').'days'))."'" : "'".date('Y-m-01')."'";
        $payments = DB::select('WITH alltasks as(SELECT c.id, c.name, sum(b.amount) as total, COUNT(DISTINCT b.client_id) as client FROM `payments` b JOIN `clients` a on b.client_id=a.id join partners c on c.id=a.partner_id join users f on f.id=a.user_id where b.created_at >='.$where_. ' '. $where_condition.' GROUP BY c.id, c.name), allusers as (SELECT b.id, b.name, sum(a.amount) as amount, COUNT(a.id) as clients FROM `clients` a JOIN `partners` b on a.partner_id=b.id  join users f on f.id=a.user_id   where a.status=1 '.$where_condition .' GROUP BY b.id, b.name) select a.id, a.name, a.total, a.client, b.amount, b.clients from alltasks a left join allusers b on a.id=b.id order by total desc;');
   
        return inertia('Clients/Payment',
        [
            'date' => $where_date,
            'url' => url()->current(),
            'days' => request('days'),
            'payments' => $payments,
            'collections' => DB::select('SELECT b.uuid, f.name as collector, f.uuid as user_id, b.client_id, a.name, a.account, a.branch, a.phone, a.amount as amount, b.date FROM `payments` b JOIN `users` f on b.user_id=f.id join clients a on a.id=b.client_id where b.created_at >='.$where_. ' '. $where_condition.' ORDER BY b.id desc;'),

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
        Excel::import(new UsersImport, request()->file('files'));
        return redirect('clients')->with('success', 'All Students Uploaded Successfully!');
    }

    public function exportReport(){
        $date = date('F-d');
        $partner = \App\Models\Partner::where('id', request()->segment(3))->first();

        return Excel::download(new CustomerExport, 'Report_'.request()->segment(2).'_'.$partner->name.'_'.split_name(Auth::User()->name)['first'].'.xlsx');
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
            $this->data['groups'] = \App\Models\Partner::get();
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
        
    //    dd(date('Y-m-d', strtotime(request('start'))));
    //    dd(request()->all());
        $task = \App\Models\Task::where('user_id', Auth::User()->id)->whereDate('created_at', date('Y-m-d'))->first();

        $this->data['url'] = !empty($task) ? "exportreport/".$type."/".$task->client->partner_id."/".Auth::User()->id : '';
        $task =   \App\Models\Task::where('user_id', Auth::User()->id)->whereDate('created_at', date('Y-m-d'))->get(['client_id']);
        $this->data['clients'] = \App\Models\Client::whereIn('id', $task)->orderBy('id', 'DESC')->get();
        if($type == 'today' && $partner > 0){
            $task = (int)$user_id > 0 ? \App\Models\Task::where('user_id', $user_id)->whereDate('created_at', date('Y-m-d'))->get(['client_id']) :  \App\Models\Task::whereDate('created_at', '>=', date('Y-m-01'))->get(['client_id']);
            $this->data['clients'] = \App\Models\Client::where('partner_id', $partner)->whereIn('id', $task)->orderBy('id', 'DESC')->get();
            $this->data['url'] = "exportreport/$type/$partner/$user_id";
        }
        if($type == 'week' && $partner > 0){
            $task = (int)$user_id > 0 ? \App\Models\Task::where('user_id', $user_id)->whereDate('created_at', '>=', date('Y-m-d'))->get(['client_id']) :  \App\Models\Task::whereDate('created_at', '>=', date('Y-m-01'))->get(['client_id']);
            $this->data['clients'] = \App\Models\Client::where('partner_id', $partner)->whereIn('id', $task)->orderBy('id', 'DESC')->get();
            $this->data['url'] = "exportreport/$type/$partner/$user_id";
        }
        if($type == 'month' && $partner > 0){
            $task = (int)$user_id > 0 ? \App\Models\Task::where('user_id', $user_id)->whereDate('created_at', '>=', date('Y-m-d'))->get(['client_id']) :  \App\Models\Task::whereDate('created_at', '>=', date('Y-m-01'))->get(['client_id']);
            $this->data['clients'] = \App\Models\Client::where('partner_id', $partner)->whereIn('id', $task)->orderBy('id', 'DESC')->get();
            $this->data['url'] = "exportreport/$type/$partner/$user_id";
        }
        $this->data['types'] = $type;
        $this->data['partners'] = \App\Models\Partner::get();
        $this->data['codes'] = \App\Models\ActionCode::get();
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
    }

    public function saveTask(){
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
        return redirect()->back()->with('success', 'Mesage Sent');
     }
 
     public function deleteTask($id)
     { 
        \App\Models\Task::where('uuid', $id)->delete();
       return redirect()->back()->with('warning', 'Task Deleted');
     }

     public function updateTask($id, $status)
     { 
        \App\Models\Task::where('uuid', $id)->update(['status_id' => $status]);
      return  redirect(url()->previous())->with('success', 'Task Updated');
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


  
}
