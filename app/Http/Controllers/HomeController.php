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
            'total' => \App\Models\Task::count(),
            'averages' => DB::select('SELECT a.id, a.name, COUNT(b.id) as total FROM tasks b JOIN task_type a on b.task_type_id=a.id GROUP BY a.id, a.name'),
            'taskstatus' => DB::select('SELECT a.id, a.name, COUNT(b.id) as total FROM tasks b JOIN task_status a on b.status_id=a.id GROUP BY a.id, a.name'),
        
        'users' => DB::table('users')->orderBy('id')->get(),
        'projects' => \App\Models\Project::orderBy('id')->get(),
        'tasktypes' => DB::table('task_type')->orderBy('id')->get(),
        'task_priority' => \App\Models\TaskType::whereNotNull('name')->get(),
        'task_status' => DB::table('task_status')->orderBy('id')->get(),
        '_token' => csrf_token(),
        'color' => ['info','primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark']

    ]);
    }


    public function tasks($id=null)
    {
     $task  = request('project') != '' ? \App\Models\Task::where(['project_id' => request('project')]) : (request('type') != '' ?  \App\Models\Task::where([request('type') => request('status_id')]) : \App\Models\Task::whereNotNull('about'));
        return inertia('Tasks/Profile',
        [
        'tasks' => $task->orderBy('priority_id', 'asc')->orderBy('status_id', 'asc')->get()->map(fn ($pay) => [
            'id' => $pay->id,
            'uuid' => $pay->uuid,
            'name' => $pay->title,
            'about' => $pay->about,
            'date' => date('d M, Y', strtotime($pay->task_date)),
            'time' => timeAgo($pay->created_at),
            'user' => !empty($pay->user) ? $pay->user->name : 'Not Defined',
            'client' => !empty($pay->client) ? $pay->client->name : 'Not Defined',
            'phone' => !empty($pay->client) ? $pay->client->phone : 'Not Defined',
            'type' => !empty($pay->priority) ? $pay->priority->name : 'Normal',
            'status' => !empty($pay->taskstatus) ? $pay->taskstatus->name : 'On progess',
            'project' => !empty($pay->project) ? $pay->project->name : 'Followup',
        ]),
        'user' => \App\Models\User::first(),
        'users' => DB::table('users')->orderBy('id')->get(),
        'projects' => \App\Models\Project::orderBy('id')->get(),
        'tasktypes' =>  \App\Models\TaskType::orderBy('id')->get(),
        'task_priority' =>  \App\Models\TaskPriority::orderBy('id')->get(),
        'task_status' =>  \App\Models\TaskStatus::orderBy('id')->get(),
        '_token' => csrf_token(),
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
                'title' => $pay->project->name,
                'about' => $pay->about,
                'date' => date('d M, Y', strtotime($pay->next_date)),
                'time' =>  date('jS M Y, h:i:s A ',strtotime($pay->next_date)),
                'type' => !empty($pay->tasktype) ? $pay->tasktype->name : 'Followup',
                'status' => !empty($pay->taskstatus) ? $pay->taskstatus->name : 'On progess',
                'project' => (!empty($pay->client) ? $pay->client->name : 'Not Defined') . ' - ' . (!empty($pay->project) ? $pay->project->name : 'Followup'),
            ]),
            'user' => \App\Models\User::first(),
            'color' => ['info','primary', 'secondary', 'success', 'info', 'warning', 'danger', 'dark']
        ]);
    }

public function calendar_data($id = null){
    $tasks = \App\Models\Task::orderBy('id', 'desc')->limit(120)
    ->get()->map(fn ($pay) => [
       'start' => date('Y-m-d', strtotime($pay->next_date)),
       'title' => $pay->tasktype->name . ' - ' . $pay->taskstatus->name,
       'end' =>  date('Y-m-d', strtotime($pay->next_date)),
       'className' =>  $pay->status_id ==2 ? 'bg-gradient-info px-2' : 'bg-gradient-success px-2'
    ]);
    return response()->json($tasks);
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
             'task_date' => date('Y-m-d'),
             'uuid' => (string) Str::uuid(),
             'priority_id' => request('priority_id'),
             'status_id' => request('status_id'),
             'next_date' => request('date'),
             'task_type_id' => request('task_type_id'),
             'project_id' => request('project_id'),
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

  public function departments()
  {
      $id = request()->segment(2);
      
      return Inertia::render('Tasks/Project', [
          'users' => \App\Models\Project::whereNotNull('id')
              ->orderBy('id')
              ->paginate(12)->withQueryString()
              ->through(fn ($User) => [
                  'id' => $User->id,
                  'uuid' => $User->uuid,
                  'name' => $User->name,
                  'website' => $User->about,
                  'clients' =>   !empty($User->tasks) ? $User->tasks->count() : '0',
                  'created_at' => $User->created_at,
                  'edit_url' => url('users.edit', $User),
              ]),
      ]);
  }

  public function addDept()
  {
      return Inertia::render('Tasks/AddProject',
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
