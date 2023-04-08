<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
      //  $this->middleware('auth');
        $this->data = array();

    }
 

    public function index($id = null, $group = null)
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
        'task_priority' => \App\Models\TaskType::whereNotNull('name')->get(),
        'task_status' => DB::table('task_status')->orderBy('id')->get(),
        '_token' => csrf_token(),
        'color' => ['info','primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark']

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
     
        return inertia('Tasks/Profile',
        [
            'total' => \App\Models\Task::count(),
            'averages' => DB::select('SELECT a.id, a.name, COUNT(b.id) as total FROM tasks b JOIN task_type a on b.task_type_id=a.id  GROUP BY a.id, a.name'),
            'statues' => DB::select('SELECT a.id, a.name, COUNT(b.id) as total FROM tasks b JOIN task_status a on b.status_id=a.id GROUP BY a.id, a.name'),
            'alltasks' => \App\Models\Task::orderBy('id', 'asc')->limit(200)
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
<<<<<<< HEAD
        'tasks' => \App\Models\Task::limit(120)
=======
        'tasks' => \App\Models\Task::whereNotIn('status_id', [2])->orderBy('id', 'desc')->limit(120)
>>>>>>> 2ef31e8f6c2cedfe0afb90cb13f5d89c875afe11
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
        'user' => \App\Models\User::first(),
        'clients' => DB::table('clients')->where('status', 1)->orderBy('id')->get(),
        'tasktypes' =>  \App\Models\TaskType::where('group_id', 1)->orderBy('id')->get(),
        'task_priority' =>  \App\Models\TaskPriority::orderBy('id')->get(),
        'task_status' =>  \App\Models\TaskStatus::orderBy('id')->get(),
        '_token' => csrf_token(),
        'client_status' => DB::table('client_status')->orderBy('id')->get(),
        'color' => ['info','primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark']

    ]);
    }

    
    public function calendar($id=null)
    {
   
        return inertia('Tasks/Calendar',
        [
            'alltasks' => \App\Models\Task::orderBy('id', 'asc')->limit(20)
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
            'user' => \App\Models\User::first(),
            'color' => ['info','primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark']
        ]);
    }

public function calendar_data($id = null){
    $uuid = $id !='' ? $id : Auth::User()->uuid;
    $user = \App\Models\User::where('uuid', $uuid)->first();
    $tasks = \App\Models\Task::orderBy('id', 'desc')->limit(120)
    ->get()->map(fn ($pay) => [
       'start' => date('Y-m-d', strtotime($pay->task_date)),
       'title' => $pay->title . ' - ' .$pay->client->name,
       'end' =>  date('Y-m-d', strtotime($pay->next_date)),
       'className' =>  $pay->status_id ==2 ? 'bg-gradient-info px-2' : 'bg-gradient-success px-2'
    ]);
    return response()->json($tasks);
   //  json_encode($tasks);
}


           
    function callGroup()
    {
        $class_level_id = request('group_id');
        if ((int) $class_level_id > 0) {
            $classes = \App\Models\TaskType::where('group_id', $class_level_id)->get();
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

  
  public function search()
  {
      $q = request('q');

      if (strlen($q) > 3) { //prevent empty search which load all results
          $users = \App\Models\User::where(DB::raw('lower(name)'), 'like', '%'.strtolower($q).'%')
          ->orWhere(DB::raw('lower(phone)'), 'like', '%'.strtolower($q).'%')->orderBy('name')->limit(5)->get();

          $students = \App\Models\Task::where(DB::raw('lower(name)'), 'like', '%'.strtolower($q).'%')
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

  public function departments()
  {
      $id = request()->segment(2);
      
      return Inertia::render('Staff/Department', [
          'users' => \App\Models\TaskStatus::whereNotNull('id')
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

    public function dragTask(){
        return inertia('Tasks/Addsubject');
    }
}
