<template>

            <div class="row">
                <div class="col-lg-6 col-12 d-flex ms-auto">
                    Staffs Activities
                </div>
                <div class="col-lg-6 col-12 d-flex ms-auto">
                    <a  data-bs-toggle="modal" data-bs-target="#exampleModalLong" class="btn btn-icon btn-outline-secondary ms-auto">
                        <i class="material-icons text-lg me-2">add</i>   Add Task
                    </a>
                    <div class="dropleft ms-3">
                        <button class="btn bg-gradient-dark dropdown-toggle" type="button" id="dropdownImport"           data-bs-toggle="dropdown" aria-expanded="false">
                            Today
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownImport">
                            <li><a class="dropdown-item" href="javascript:;">Yesterday</a></li>
                            <li><a class="dropdown-item" href="javascript:;">Last 7 days</a></li>
                            <li><a class="dropdown-item" href="javascript:;">Last 30 days</a></li>
                        </ul>
                    </div>
                    
                </div>
            </div>
            <div class="row mb-5 mb-md-0">
                <div class="col-sm-6">
                    <div class="card h-100">
                        <div class="card-header pb-0 p-3">
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0">Top Tasks Percentages</h6>
                                <button type="button"     class="btn btn-icon-only btn-rounded btn-outline-secondary mb-0 ms-2 btn-sm d-flex align-items-center justify-content-center ms-auto"     data-bs-toggle="tooltip" data-bs-placement="bottom"     title="See how much traffic do you get from social media">
                                    <i class="material-icons text-sm">priority_high</i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="card-body p-3">
                            <ul class="list-group">
                               
                                <li v-for="average in averages" :key="average.id" class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                    <div class="w-100">
                                        <div class="d-flex align-items-center mb-2">
                                            <a class="btn btn-youtube btn-simple mb-0 p-0" href="javascript:;">
                                                <span :class="`badge bg-gradient-${color[Math.floor(Math.random() * color.length)]} me-3`"> {{ average.total }} </span>
                                            </a>
                                            <span
                                                class="me-2 text-sm font-weight-normal text-capitalize ms-2">{{ average.name }}</span>
                                            <span class="ms-auto text-sm font-weight-normal">{{ Math.ceil(average.total*100/total) }}%</span>
                                        </div>
                                        <div>
                                            <div class="progress progress-md">
                                                <div :class="`progress-bar bg-gradient-dark w-${ callPercent(Math.ceil(average.total*100/total)) }`" role="progressbar"        :aria-valuenow="`${ Math.ceil(average.total*100/total) }`" aria-valuemin="0" :aria-valuemax="`${ Math.ceil(average.total*100/total) }`">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card h-100 mt-4 mt-md-0">
                        <div class="card-header pb-0 p-3">
                            <div class="d-flex align-items-center">
                                <h6>Completed Tasks</h6>
                                <button type="button"     class="btn btn-icon-only btn-rounded btn-outline-success mb-0 ms-2 btn-sm d-flex align-items-center justify-content-center ms-auto"     data-bs-toggle="tooltip" data-bs-placement="bottom"     title="Data is based from sessions and is 100% accurate">
                                    <i class="material-icons text-sm">done</i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body px-3 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Employee</th>
                                            <th class="align-middle text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Customers</th>
                                            <th class="align-middle text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Tasks</th>
                                            <th class="align-middle text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Complete</th>
                                            <th class="align-middle text-center text-sm text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="user in usertasks" :key="user.id">
                                            <td>
                                                <p class="text-sm font-weight-normal mb-0">{{ user.name }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-normal mb-0">{{ user.client }}</p> 
                                            </td>
                                            
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-normal mb-0">{{ user.total }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-normal mb-0">{{ user.completed }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-normal mb-0">{{ Math.ceil(user.completed*100/user.total) }}%</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row gx-4">
            <div class="col-lg-6">
                <div class="card mt-4">
                    <div class="card-header pb-0">
                        <h6>Latest New Client Tasks</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="timeline timeline-one-side" data-timeline-axis-style="dotted">
                            <div v-for="task in tasks" :key="task.id" class="timeline-block">
                                <span class="timeline-step bg-dark p-3">
                                    <i class="material-icons text-white text-sm opacity-10">
                                        notifications
                                    </i>
                                </span>
                                <div class="timeline-content pt-1">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">{{ task.name }}</h6>
                                    <p class="text-secondary text-xs mt-1 mb-1"> <Link :href="`/client/${task.uuid}/view`">Client: {{ task.client }}</Link> - {{ task.time }}</p>
                                    <p class="text-sm text-dark">
                                       -  {{ task.about }}
                                    </p>
                                    <div class="d-flex">
                                        <div>
                                            <i class="material-icons text-sm me-1 cursor-pointer">notifications</i>
                                        </div>
                                        <span class="text-sm me-2">{{ task.type }}</span>
                                        <div>
                                            <i class="material-icons text-sm me-1 cursor-pointer">layers</i>
                                        </div>
                                        <span class="text-sm me-2">{{ task.status }}</span>
                                        <div>
                                            <i class="material-icons text-sm me-1 cursor-pointer">thumb_up</i>
                                        </div>
                                        <span class="text-sm me-2"> {{ task.time }}</span>
                                        <div>
                                            <i class="material-icons text-xl me-1 cursor-pointer">more_vert</i>
                                        </div>
                                        <span class="text-sm me-2">
                                        <div class="dropstart">
                                            <a href="javascript:;" class="text-success" id="dropdownDesignCard" data-bs-toggle="dropdown" aria-expanded="false">
                                            <b><u>Update</u></b>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-lg-start px-2 py-3" aria-labelledby="dropdownDesignCard">
                                                <li v-for="method in task_status" :key="method.id"><Link class="dropdown-item border-radius-md" :href="`/taskstatus/${task.uuid}/${method.id}`">{{ method.name }}</Link></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><Link class="dropdown-item border-radius-md text-danger" :href="`/deletetask/${task.uuid}/delete`">Delete Task</Link></li>
                                            </ul>
                                        </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="col-lg-6 mt-lg-0">
                <div class="card mt-4 bg-gradient-dark">
                    <div class="card-header bg-transparent pb-0">
                        <h6 class="text-white">Completed Client Tasks</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="timeline timeline-dark timeline-one-side" data-timeline-axis-style="dotted">
                            <div v-for="task in alltasks" :key="task.id" class="timeline-block">
                                <span class="timeline-step bg-dark p-3">
                                    <i class="material-icons text-white text-sm opacity-10">
                                        done
                                    </i>
                                </span>
                                <div class="timeline-content pt-1">
                                    <h6 class="text-white text-sm font-weight-bold mb-0">{{ task.name }}</h6>
                                    <p class="text-secondary text-xs mt-1 mb-0">{{ task.user }} - {{ task.time }} - {{ task.type }}</p>
                                    <p class="text-sm text-white">
                                        {{ task.about }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-normal" id="modal-title-exampleModalLong"> Add New Task Performed to Clients </h5>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
                <form role="form text-left" method="post" action="/saveTask">
                  
                  <!-- <div class="input-group input-group-outline my-3">
                      <label class="form-label">Task Title</label>
                      <input type="text" required name="title" class="form-control">
                  </div> -->
                  <input type="hidden" :value="_token" name="_token" class="form-control">

                <div class="input-group input-group-outline my-3">
                    <select required class="form-control" name="client_id" id="choices-currency-edit">
                        <option value="" selected="">Select Customer</option>
                        <option v-for="installment in clients" :value="installment.id" :key="installment.id">{{ installment.name }}</option>
                    </select>
                </div>
                
                <div class="input-group input-group-outline my-3">
                    <select required class="form-control" name="user_id" id="choices-currency-edit">
                        <option value="" selected=""> Task Allocated to</option>
                        <option v-for="installment in users" :value="installment.id" :key="installment.id">{{ installment.name }}</option>
                    </select>
                </div>
                <div class="input-group input-group-outline my-3">
                    <select required class="form-control" name="task_type_id" id="choices-currency-edit">
                        <option value="" selected="">Select Task Category</option>
                        <option v-for="installment in tasktypes" :value="installment.id" :key="installment.id">{{ installment.name }}</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <select required class="form-control" name="action_code_id" id="choices-currency">
                                <option value="" selected="">Select Action Code</option>
                                <option v-for="priority in task_priority" :value="priority.id" :key="priority.id">{{ priority.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <select required class="form-control" name="status_id" id="choices-currency">
                                <option value="" selected=""> Current Task Status</option>
                                <option v-for="method in task_status" :value="method.id" :key="method.id">{{ method.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="input-group input-group-outline my-3">
                    <textarea name="about" required class="multisteps-form__textarea form-control" rows="3" :placeholder="`Write your activity performed`" spellcheck="false"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <input onfocus="(this.type = 'datetime-local')" class="form-control" required onblur="(this.type = 'text')" name="date"  placeholder="Set Next Action Date" />
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="input-group input-group-outline my-3">
                        <select required class="form-control" name="next_type_id" id="choices-currency">
                            <option value="" selected="">Next Action Activity</option>
                            <option v-for="priority in tasktypes" :value="priority.id" :key="priority.id">{{ priority.name }}</option>
                        </select>
                    </div>
                    </div>
                </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Save Task</button>
                  </div> 
                </form>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';


export default {
    props: {
        _token: String,
        users: Array,
        clients: Array,
        tasks: Array,
        alltasks: Array,
        color: Array,
        task_priority: Array,
        tasktypes: Array,
        averages: Array,
        total: Number,
        task_status: Array,
        usertasks: Array,
    },
    components: { Link },
    methods: {
    callPercent: function (num) {
      
      if (num % 5 == 0 || num % 10 == 0) {
            return num;
        }
        
        // calculate the difference between the number and the next multiple of 5 or 10
        var diff = 0;
        if (num < 5) {
            diff = 5 - num;
        } else if (num < 10) {
            diff = 10 - num;
        } else {
            diff = 10 - (num % 10);
        }
        
        // add the difference to the number to get the next multiple of 5 or 10
        var nextMultiple = 0;
        nextMultiple = num + diff;
        
        return nextMultiple;
    }
  }
};
</script>