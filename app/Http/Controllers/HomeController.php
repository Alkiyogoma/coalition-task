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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return inertia('Dashboard');
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
}
