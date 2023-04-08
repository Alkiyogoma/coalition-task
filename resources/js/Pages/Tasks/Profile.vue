<template>
  <div class="row">
    <div class="col-lg-6 col-12 d-flex ms-auto">
      List of project tasks
    </div>
    <div class="col-lg-6 col-12 d-flex ms-auto">
      <a data-bs-toggle="modal" data-bs-target="#exampleModalLong" class="btn btn-icon btn-outline-secondary ms-auto">
        <i class="material-icons text-lg me-2">add_task</i> Add Task
      </a>
    </div>
  </div>
  <div class="row gx-4">
    <div class="col-lg-12">
      <draggable class="dragArea list-group w-full" :list="list" @change="log">
        <div class="card rounded-md mt-1" v-for="task in list" :key="task.name">
          <div class="card-body">
            <p class="text-sm">{{ task.about }}</p>
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
                <i class="material-icons text-sm me-1 cursor-pointer">schedule</i>
              </div>
              <span class="text-sm me-2"> {{ task.time }}</span>
              <div>
                <i class="material-icons text-xl me-1 cursor-pointer">edit_note</i>
              </div>
              <span class="text-sm me-2"> <b>Edit</b></span>
              <div>
                <i class="material-icons text-xl me-1 ml-4 cursor-pointer">format_list_bulleted</i>
              </div>
              <span class="text-sm me-2">
                <div class="dropstart">
                  <a href="javascript:;" class="text-success" id="dropdownDesignCard" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <b><u>Change Status</u></b>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-lg-start px-2 py-3" aria-labelledby="dropdownDesignCard">
                    <li v-for="method in task_status" :key="method.id"><a class="dropdown-item border-radius-md"
                        :href="`/taskstatus/${task.uuid}/${method.id}`">{{ method.name }}</a></li>
                    <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li>
                      <Link class="dropdown-item border-radius-md text-danger" :href="`/deletetask/${task.uuid}/delete`">
                      Delete Task</Link>
                    </li>
                  </ul>
                </div>
              </span>
            </div>

          </div>
        </div>
      </draggable>
    </div>
  </div>

  <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-weight-normal" id="modal-title-exampleModalLong"> Add New Task Performed to Clients
          </h5>
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
                <option v-for="installment in clients" :value="installment.id" :key="installment.id">{{ installment.name
                }}</option>
              </select>
            </div>

            <div class="input-group input-group-outline my-3">
              <select required class="form-control" name="user_id" id="choices-currency-edit">
                <option value="" selected=""> Task Allocated to</option>
                <option v-for="installment in users" :value="installment.id" :key="installment.id">{{ installment.name }}
                </option>
              </select>
            </div>
            <div class="input-group input-group-outline my-3">
              <select required class="form-control" name="task_type_id" id="choices-currency-edit">
                <option value="" selected="">Select Task Category</option>
                <option v-for="installment in tasktypes" :value="installment.id" :key="installment.id">{{ installment.name
                }}</option>
              </select>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="input-group input-group-outline my-3">
                  <select required class="form-control" name="priority_id" id="choices-currency">
                    <option value="" selected="">Select Task Priority</option>
                    <option v-for="priority in task_priority" :value="priority.id" :key="priority.id">{{ priority.name }}
                    </option>
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
              <textarea name="about" required class="multisteps-form__textarea form-control" rows="3"
                :placeholder="`Write your activity performed`" spellcheck="false"></textarea>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="input-group input-group-outline my-3">
                  <input onfocus="(this.type = 'datetime-local')" class="form-control" required
                    onblur="(this.type = 'text')" name="date" placeholder="Set Next Action Date" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group input-group-outline my-3">
                  <select required class="form-control" name="next_type_id" id="choices-currency">
                    <option value="" selected="">Next Action Activity</option>
                    <option v-for="priority in tasktypes" :value="priority.id" :key="priority.id">{{ priority.name }}
                    </option>
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

import { defineComponent } from 'vue'
import { VueDraggableNext } from 'vue-draggable-next'

export default {
  props: {
    _token: String,
    user: Array,
    clients: Array,
    tasks: Array,
    alltasks: Array,
    task_priority: Array,
    tasktypes: Array,
    averages: Array,
    total: Number,
    task_status: Array,
    statues: Array,
    color: Array,
  },
  components: {
    Link,
    draggable: VueDraggableNext,
  },
  data() {
    return {
      enabled: true,
      list: this.tasks,
      dragging: false,
    }
  },
  methods: {
    log(event) {
      console.log(event)
    },
  }
};
</script>