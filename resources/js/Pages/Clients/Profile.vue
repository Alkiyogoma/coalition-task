<template>
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-body">
        <div class="row">
          <div class="col-12 col-md-6 col-xl-4">
            <div class="card card-plain h-100">
              <div class="card-header border-1 pb-0 p-3">
                <h6 class="mb-0">Profile Information</h6>
              </div>

              <div class="card-body p-3">
                <ul class="list-group">
                  <li class="list-group-item mb-0 border-0 pt-0 text-sm"><strong class="text-dark">Full Name:</strong>
                    &nbsp; {{ user.name }}</li>
                  <li class="list-group-item mb-0 border-0 text-sm"><strong class="text-dark">Mobile:</strong> &nbsp; {{
                    user.phone }}</li>
                  <li class="list-group-item mb-0 border-0 text-sm"><strong class="text-dark">Branch:</strong> &nbsp; {{
                    user.branch }}</li>
                  <li class="list-group-item mb-0 border-0 text-sm"><strong class="text-dark">Account#:</strong> &nbsp; {{
                    user.account }}</li>
                  <li class="list-group-item mb-0 border-0 text-sm"><strong class="text-dark">Princ Balance#:</strong>
                    &nbsp; {{ user.amount }}</li>
                  <li class="list-group-item mb-0 border-0 text-sm"><strong class="text-dark">Paid Amount#:</strong>
                    &nbsp; {{ user.paid }}</li>
                  <li class="list-group-item mb-0 border-0 text-sm"><strong class="text-dark">Collector#:</strong> &nbsp;
                    {{ user.collector }}</li>
                  <li class="list-group-item mb-0 border-0 text-sm">
                    <Link :href="`/customer/${user.uuid}/edit`" class="text-secondary font-weight-bold  "
                      data-toggle="tooltip" data-original-title="Edit user">
                    <span class="btn btn-outline-primary btn-sm mb-0">Edit Profile</span>
                    </Link>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-xl-8">
            <div class="card card-plain h-100">
              <div class="card-header  border-1 pb-0 p-3">
                <h6 class="mb-0">Last Activities</h6>
              </div>
              <div class="card-body p-1">
                <ul class="list-group">
                  <li class="list-group-item mb-0 border-0 d-flex align-items-center">
                    <div class="d-flex align-items-start flex-column justify-content-center">
                      <div v-for="task in tasks" :key="task.id">
                        <h6 class="text-sm">{{ task.user }} &nbsp; &nbsp; - &nbsp; &nbsp; {{ task.time }}</h6>
                        <p class="text-xs" style="border-bottom: 3px black !important;">
                          Task Type - {{ task.type }} &nbsp; &nbsp; &nbsp;
                          When - {{ task.date }} &nbsp; &nbsp; &nbsp; Next Action - {{ task.nexttask }}
                          <br /> <b>Comment</b> - {{ task.about }}
                        </p>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <table class="table end-0">
            <tbody class="nav nav-pills nav-fill p-1" role="tablist">
              <th class="nav-item">
                <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="modal" data-bs-target="#exampleModalLong">
                  <i class="material-icons text-lg position-relative">layers</i>
                  <span class="ms-1">Activities</span>
                </a>
              </th>
              <th class="nav-item">
                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">
                  <i class="material-icons text-lg position-relative">mark_as_unread</i>
                  <span class="ms-1">Messages</span>
                </a>
              </th>
              <th class="nav-item">
                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="modal" data-bs-target="#modal-notification">
                  <i class="material-icons text-lg position-relative">menu</i>
                  <span class="ms-1">Add Payment</span>
                </a>
              </th>

              <th class="nav-item">
                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="modal" data-bs-target="#modal-tracing">
                  <i class="material-icons text-lg position-relative">manage_search</i>
                  <span class="ms-1">Skip Tracing</span>
                </a>
              </th>

              <th class="nav-item">
                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="modal" data-bs-target="#modal-notification1">
                  <i class="material-icons text-lg position-relative">find_replace</i>
                  <span class="ms-1">Recall</span>
                </a>
              </th>
            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-12">
            <!-- <div class="card-header pb-0">
                            <h6>Defined Client Payment Installments</h6>
                        </div> -->
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                      Installments</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                      Amount</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                      Paid amount</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                      Remained</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="install in installments" :key="install.id">
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div class="m-3">
                          <i class="material-icons text-lg position-relative">tags</i>
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm"> {{ install.name }}</h6>
                          <p class="text-sm font-weight-normal text-secondary mb-0"><span class="text-success">{{
                            install.start_date }}</span> <b> to </b> {{ install.end_date }}</p>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-sm font-weight-normal mb-0">{{ install.amount }}</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <p class="text-sm font-weight-normal text-success">{{ install.paid }}</p>
                    </td>
                    <td class="align-middle text-end">
                      <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                        <p class="text-sm font-weight-normal mb-0">{{ install.balance }}</p>
                        <i class="ni ni-bold-down text-sm ms-1 text-success"></i>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="card">

              <div class="card-body">

                <div class="table-responsive">
                  <table class="table table-flush">
                    <thead class="thead-light">
                      <tr>
                        <!-- Collector 	 Customer Name 	 Employer 	 Account number 	 Contacts 	 Branch 	 Outstanding Balance(TZS) 	 Amount Received Jan'23  -->

                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Collector</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Customer Name
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Account number
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Branch</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount Received
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="payment in collections" :key="payment.id">
                        <td class="text-sm font-weight-normal">{{ payment.collector }}</td>
                        <td class="text-sm font-weight-normal">{{ payment.name }} </td>
                        <td class="text-sm font-weight-normal">{{ payment.account }}</td>
                        <td class="text-sm font-weight-normal">{{ payment.branch }}</td>
                        <td class="align-middle text-center text-sm">
                          {{ money(payment.amount) }}
                        </td>
                        <td class="text-sm font-weight-normal">{{ payment.date }}</td>
                        <td class="text-sm font-weight-normal">
                          <Link :href="`/receipt/${payment.uuid}/payment`"> <i class="material-icons text-lg">payments</i>
                          View</Link>

                        </td>
                      </tr>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <!-- Modal -->
      <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title font-weight-normal" id="exampleModalLabel">New message to {{ user.name }}</h6>
              <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form role="form text-left" method="post" action="/sendMessage">
              <div class="modal-body">
                <input type="hidden" :value="user.id" name="client_id" class="form-control">
                <input type="hidden" :value="user.user_id" name="user_id" class="form-control">
                <input type="hidden" :value="user.phone" name="phone" class="form-control">
                <input type="hidden" :value="user._token" name="_token" class="form-control">

                <div class="input-group input-group-outline my-3">
                  <textarea name="body" required minlength="50" class="multisteps-form__textarea form-control" rows="5"
                    :placeholder="`Write a messages to remind ${user.name} his/her Outstanding Balance of ${user.remained} `"
                    spellcheck="false"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-primary">Send message</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification"
      aria-hidden="true">
      <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-normal" id="modal-title-notification"> Received Amount from <u>{{ user.name
            }}</u> </h5>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form role="form text-left" method="post" action="/savePayment">
              <div class="input-group input-group-outline my-3">
                <label>Remained Amount &nbsp; - &nbsp; </label> {{ user.remained }} <br>
              </div>
              <div class="input-group input-group-outline my-3">
                <label class="form-label">Received Amount</label>
                <input type="number" step="0.01" required name="payment" class="form-control">
                <input type="hidden" :value="user.id" name="client_id" class="form-control">
                <input type="hidden" :value="user.user_id" name="user_id" class="form-control">
                <input type="hidden" :value="user._token" name="_token" class="form-control">
              </div>
              <div class="input-group input-group-outline my-3">
                <label class="form-label">Reference No#</label>
                <input type="text" required name="reference" class="form-control">
              </div>
              <div class="input-group input-group-outline my-3">
                <select required class="form-control" name="installment_id" id="choices-currency-edit">
                  <option value="" selected="">Select Installments</option>
                  <option v-for="installment in installments" :key="installment.id" :value="installment.id">{{
                    installment.name }}</option>
                </select>
              </div>
              <div class="input-group input-group-outline my-3">
                <input onfocus="(this.type = 'date')" class="form-control" required onblur="(this.type = 'text')"
                  name="date" placeholder="Amount Received Date" />

              </div>
              <div class="input-group input-group-outline my-3">
                <select required class="form-control" name="method_id" id="choices-currency">
                  <option value="" selected="">Select Payment Method</option>
                  <option v-for="method in methods" :key="method.id" :value="method.id">{{ method.name }}</option>
                </select>
              </div>
              <div class="input-group input-group-outline my-3">
                <textarea name="about" required class="multisteps-form__textarea form-control" rows="3"
                  placeholder="Write your comment." spellcheck="false"></textarea>
              </div>
              <ul class="list-group">
                <li class="list-group-item mb-0 border-0 px-0">
                  <div class="form-check form-switch ps-0">
                    <input class="form-check-input ms-auto" name="status" value="1" type="radio"
                      id="flexSwitchCheckDefault">
                    <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault">I
                      confirm amount was received by bank</label>
                    <br>
                    <input class="form-check-input ms-auto" name="status" value="0" type="radio"
                      id="flexSwitchCheckDefault1">
                    <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault1">I
                      can't confirm amount was received by bank</label>
                  </div>
                </li>
              </ul>
              <div class="text-center">
                <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Save
                  Payment</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-tracing" tabindex="-1" role="dialog" aria-labelledby="modal-tracing"
      aria-hidden="true">
      <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-normal" id="modal-title-tracing"> Skip Tracing for <u>{{ user.name }}</u>
            </h5>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form role="form text-left" method="post" action="/saveTrace">
              <div class="input-group input-group-outline">
                <label>Customer Balance &nbsp; - &nbsp; </label> {{ user.remained }} <br>
              </div>
              <div class="input-group input-group-outline my-3">
                <input type="hidden" :value="user.id" name="client_id" class="form-control">
                <input type="hidden" :value="user._token" name="_token" class="form-control">
              </div>
              <div class="input-group input-group-outline my-3">
                <select required class="form-control" name="user_id" id="choices-currency-edit">
                  <option value="" selected="">Select Assigned Staff</option>
                  <option v-for="staff in staffs" :key="staff.id" :value="staff.id">{{ staff.name }}</option>
                </select>
              </div>
              <div class="input-group input-group-outline my-3">
                <textarea name="about" required class="multisteps-form__textarea form-control" rows="4"
                  placeholder="Write your comment about this customer." spellcheck="false"></textarea>
              </div>

              <div class="text-center">
                <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Submit to
                  Tracing</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
      aria-hidden="true">
      <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-normal" id="modal-title-exampleModalLong"> Add Task Performed</h5>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form role="form text-left" method="post" action="/saveTask">

              <!-- <div class="input-group input-group-outline my-2">
                      <label class="form-label">Task Title</label>
                      <input type="text" required name="title" class="form-control"> -->
              <input type="hidden" :value="user.id" name="client_id" class="form-control">
              <input type="hidden" :value="user.user_id" name="user_id" class="form-control">
              <input type="hidden" :value="user._token" name="_token" class="form-control">
              <!-- </div> -->
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group input-group-outline my-2">
                    <select required class="form-control" name="task_type_id" id="choices-currency-edit">
                      <option value="" selected="">Select Task Category</option>
                      <option v-for="installment in tasktypes" :key="installment.id" :value="installment.id">{{
                        installment.name }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group input-group-outline my-2">
                    <select required class="form-control" name="client_status_id" id="choices-currency-edit">
                      <option :value="`${user.client_status_id}`" selected="">Current Customer Status</option>
                      <option v-for="status in client_status" :key="status.id" :value="status.id">{{ status.name }}
                      </option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group input-group-outline my-2">
                    <select required class="form-control" name="action_code_id" id="choices-currency">
                      <option value="" selected="">Select Action Code</option>
                      <option v-for="priority in task_priority" :key="priority.id" :value="priority.id">{{ priority.name
                      }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group input-group-outline my-2">
                    <select required class="form-control" name="status_id" id="choices-currency">
                      <option value="" selected=""> Current Task Status</option>
                      <option v-for="method in task_status" :key="method.id" :value="method.id">{{ method.name }}</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="input-group input-group-outline my-2">
                <textarea name="about" required class="multisteps-form__textarea form-control" rows="3"
                  :placeholder="`Write your activity performed to ${user.name}.`" spellcheck="false"></textarea>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group input-group-outline my-2">
                    <input onfocus="(this.type = 'datetime-local')" class="form-control" required
                      onblur="(this.type = 'text')" name="date" placeholder="Set Next Action Date" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group input-group-outline my-2">
                    <select required class="form-control" name="next_type_id" id="choices-currency">
                      <option value="" selected="">Next Action Activity</option>
                      <option v-for="priority in tasktypes" :key="priority.id" :value="priority.id">{{ priority.name }}
                      </option>
                    </select>
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
</div>
  </template>
<script>
export default {
  props: {
    name: String,
    user: Object,
    staffs: Array,
    tasks: Array,
    installments: Array,
    reports: Array,
    payments: Array,
    methods: Array,
    collections: Array,
    task_priority: Array,
    tasktypes: Array,
    client_status: Array,
    task_status: Array,
  },
  methods: {
    money: function (value) {
      let val = (value / 1).toFixed(2).replace(',', '.')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }
  }
};
</script>