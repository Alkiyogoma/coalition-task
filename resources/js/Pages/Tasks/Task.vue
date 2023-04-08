<template>
    <div class="row">
        <div class="col-lg-6 col-12 d-flex ms-auto">
            Staffs Activities
        </div>
        <div class="col-lg-6 col-12 d-flex ms-auto">
            <a data-bs-toggle="modal" data-bs-target="#exampleModalLong" class="btn btn-icon btn-outline-secondary ms-auto">
                <i class="material-icons text-lg me-2">add_task</i> Add Task
            </a>
        </div>
    </div>
    <div class="row mb-5 mb-md-0">
        <div class="col-sm-6">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0"> Task Status Percentages</h6>
                        <button type="button"
                            class="btn btn-icon-only btn-rounded btn-outline-secondary mb-0 ms-2 btn-sm d-flex align-items-center justify-content-center ms-auto"
                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="See how much traffic do you get from social media">
                            <i class="material-icons text-sm">priority_high</i>
                        </button>
                    </div>
                </div>

                <div class="card-body p-3">
                    <ul class="list-group">

                        <li v-for="average in taskstatus" :key="average.id"
                            class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                            <div class="w-100">
                                <div class="d-flex align-items-center mb-2">
                                    <Link class="btn btn-youtube btn-simple mb-0 p-0" :href="`tasks?status_id=${ average.id }&type=status_id`">
                                        <span
                                            :class="`badge bg-gradient-${color[Math.floor(Math.random() * color.length)]} me-3`">
                                            {{ average.total }} </span>
                                    <span class="me-2 text-sm font-weight-normal text-capitalize ms-2">{{ average.name
                                    }}</span>
                                    <span class="ms-auto text-sm font-weight-normal">{{ Math.ceil(average.total * 100 / total)
                                    }}%</span>
                                    </Link>
                                </div>
                                <div>
                                    <div class="progress progress-md">
                                        <div :class="`progress-bar bg-gradient-dark w-${callPercent(Math.ceil(average.total * 100 / total))}`"
                                            role="progressbar" :aria-valuenow="`${Math.ceil(average.total * 100 / total)}`"
                                            aria-valuemin="0" :aria-valuemax="`${Math.ceil(average.total * 100 / total)}`">
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
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0"> Tasks Types Percentages</h6>
                        <button type="button"
                            class="btn btn-icon-only btn-rounded btn-outline-secondary mb-0 ms-2 btn-sm d-flex align-items-center justify-content-center ms-auto"
                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="See how much traffic do you get from social media">
                            <i class="material-icons text-sm">priority_high</i>
                        </button>
                    </div>
                </div>

                <div class="card-body p-3">
                    <ul class="list-group">

                        <li v-for="average in averages" :key="average.id"
                            class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                            <div class="w-100">
                                <div class="d-flex align-items-center mb-2">
                                    <Link class="btn btn-youtube btn-simple mb-0 p-0" :href="`tasks?status_id=${ average.id }&type=task_type_id`">
                                        <span
                                            :class="`badge bg-gradient-${color[Math.floor(Math.random() * color.length)]} me-3`">
                                            {{ average.total }} </span>
                                    <span class="me-2 text-sm font-weight-normal text-capitalize ms-2">{{ average.name
                                    }}</span>
                                    <span class="ms-auto text-sm font-weight-normal">{{ Math.ceil(average.total * 100 / total)
                                    }}%</span>
                                    </Link>
                                </div>
                                <div>
                                    <div class="progress progress-md">
                                        <div :class="`progress-bar bg-gradient-dark w-${callPercent(Math.ceil(average.total * 100 / total))}`"
                                            role="progressbar" :aria-valuenow="`${Math.ceil(average.total * 100 / total)}`"
                                            aria-valuemin="0" :aria-valuemax="`${Math.ceil(average.total * 100 / total)}`">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="modal-title-exampleModalLong"> Add New Task Performed to
                        projects </h5>
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
                                <option value="" selected="">Select Project</option>
                                <option v-for="installment in projects" :value="installment.id" :key="installment.id">{{
                                    installment.name }}</option>
                            </select>
                        </div>

                        <div class="input-group input-group-outline my-3">
                            <select required class="form-control" name="user_id" id="choices-currency-edit">
                                <option value="" selected=""> Task Allocated to</option>
                                <option v-for="installment in users" :value="installment.id" :key="installment.id">{{
                                    installment.name }}</option>
                            </select>
                        </div>
                        <div class="input-group input-group-outline my-3">
                            <select required class="form-control" name="task_type_id" id="choices-currency-edit">
                                <option value="" selected="">Select Task Category</option>
                                <option v-for="installment in tasktypes" :value="installment.id" :key="installment.id">{{
                                    installment.name }}</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    <select required class="form-control" name="priority_id" id="choices-currency">
                                        <option value="" selected="">Select Task Priority</option>
                                        <option v-for="priority in task_priority" :value="priority.id" :key="priority.id">{{
                                            priority.name }}</option>
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
                            <div class="col-md-12">
                                <div class="input-group input-group-outline my-3">
                                    <input onfocus="(this.type = 'datetime-local')" class="form-control" required
                                        onblur="(this.type = 'text')" name="date" placeholder="Set Next Action Date" />
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Save
                                Task</button>
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
        projects: Array,
        tasks: Array,
        taskstatus: Array,
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