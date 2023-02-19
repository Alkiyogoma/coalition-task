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
            'alltasks' => \App\Models\Task::where('status_id', 2)->orderBy('id', 'desc')->limit(10)
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
        'tasks' => \App\Models\Task::whereNotIn('status_id', [2])->orderBy('id', 'desc')->limit(10)
        ->get()->map(fn ($pay) => [
            'id' => $pay->id,
            'uuid' => $pay->uuid,
            'name' => $pay->title,
            'about' => $pay->about,
            'date' => date('d M, Y', strtotime($pay->task_date)),
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
