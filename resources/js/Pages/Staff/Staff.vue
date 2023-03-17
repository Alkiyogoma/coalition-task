<template>
  <div class="row">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-12 col-md-4 col-sm-6 col-xl-4">
          <div class="card card-plain h-100">

            <div class="card-body p-3">
              <ul class="list-group">
                <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 pt-0">
                  <div class="avatar me-3">
                    <img src="/assets/img/bruce-mars.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                  </div>
                  <div class="d-flex align-items-start flex-column justify-content-center">
                    <h5 class="mb-1">
                      {{ staff.name }}
                    </h5>
                    <p class="mb-0 font-weight-normal text-sm">
                      {{ staff.role }}
                    </p>
                  </div>
                </li>
              </ul>
                  <ul class="list-group">
                    <li class="list-group-item border-0  pt-0 text-sm">
                      <strong class="text-dark">{{ staff.department }}</strong>
                    </li>
                    <li class="list-group-item border-0  text-sm"><strong class="text-dark">Mobile:</strong> &nbsp;
                      {{ staff.phone }}</li>
                    <li class="list-group-item border-0  text-sm"><strong class="text-dark">Email:</strong> &nbsp;
                      {{ staff.email }}</li>
                    <li class="list-group-item border-0  text-sm"><strong class="text-dark">Location:</strong> &nbsp;
                      {{ staff.address }}</li>
                    <li class="list-group-item border-0  text-sm"><strong class="text-dark">
                      Joined:</strong> &nbsp;{{ staff.jod }}</li>
                      
                    <li class="list-group-item border-0  text-sm"><strong class="text-dark">
                      Last Login:</strong> &nbsp;{{ staff.jod }}</li>
                    <li class="list-group-item border-0  pb-0">
                      <strong class="text-dark text-sm">Social:</strong> &nbsp;
                      <a class="btn btn-facebook btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                        <i class="fab fa-facebook fa-lg"></i>
                      </a>
                      <a class="btn btn-twitter btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                        <i class="fab fa-twitter fa-lg"></i>
                      </a>
                      <a class="btn btn-instagram btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                        <i class="fab fa-instagram fa-lg"></i>
                      </a>
                    </li>
                  </ul>
            </div>
          </div>
        </div>
        
        <div class="col-12 col-md-4 col-sm-6 col-xl-8">
      <div class="card">
        <div class="card-body px-0 pb-2">
          <div class="bg-gradient-secondary shadow-secondary border-radius-lg pt-2 pb-1">
            <h6 class="text-white text-capitalize ps-3"> Collections Statistics per Month</h6>
          </div>
          <div class="table-responsive p-0">
            <table class="table align-items-center justify-content-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Months</th>
                  <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">C</th> -->
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Clients</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Collected</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="payment in payments" :key="payment.id">
                  <td>
                      <p class="text-sm font-weight-bold mb-0">{{ getMonthName(payment.month) }}</p>
                  </td>
                  <!-- <td>
                    <p class="align-middle text-center text-sm">{{ payment.clients }}</p>
                  </td> -->
                  <td>
                    <p class="align-middle text-center text-sm">{{ payment.client }}</p>
                  </td>
                  <td>
                    <p class="text-sm font-weight-bold mb-0">{{ money(payment.amount) }}</p>
                  </td>
                 
                  <td>
                    <p class="text-sm font-weight-bold mb-0">{{ money(payment.total) }}</p>
                  </td>
                  <td class="align-middle text-center">
                    <div class="d-flex align-items-center justify-content-center">
                      <span class="me-2 text-xs font-weight-bold">{{ callPercent(Math.ceil(payment.total*100/payment.amount)) }}%</span>
                      <div>
                        <div class="progress">
                          <div class="progress-bar bg-gradient-info" role="progressbar" :aria-valuenow="`${ callPercent(Math.ceil(payment.total*100/payment.amount)) }`"
                            aria-valuemin="0" aria-valuemax="100" :style="`width: ${ callPercent(Math.ceil(payment.total*100/payment.amount)) }%;`"></div>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                
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


  <div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-2 pb-1">
            <h6 class="text-white text-capitalize ps-3">Latest {{ staff.name }} Activities</h6>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="timeline timeline-one-side" data-timeline-axis-style="dotted">
            <div v-for="task in tasks" :key="task.id" class="timeline-block">
                <span class="timeline-step bg-dark p-3">
                    <i class="material-icons text-white text-sm opacity-10">
                        notifications
                    </i>
                </span>
                <div class="timeline-content pt-1">
                    <h6 class="text-dark text-sm font-weight-bold mb-0">{{ task.name }}</h6>
                    <p class="text-sm text-dark">
                        {{ task.about }}
                        <br><Link :href="`/client/${task.uuid}/view`">Client: {{ task.client }}</Link> &nbsp; &nbsp; -&nbsp; &nbsp;  {{ task.time }}
                    </p>
                    <div class="d-flex mt-0">
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
                                                <li v-for="method in task_status" :key="method.id"><a class="dropdown-item border-radius-md" :href="`/taskstatus/${task.uuid}/${method.id}`">{{ method.name }}</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item border-radius-md text-danger" :href="`/deletetask/${task.uuid}/delete`">Delete Task</a></li>
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
  </div>
</template>

<script>
import {
  Head,
  Link
} from '@inertiajs/vue3'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'
import SearchFilter from '../../Shared/SearchFilter'
import Pagination from '../../Shared/Pagination'
import Icon from '../../Shared/Icon'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    SearchFilter,
  },
  props: {
    staff: Object,
    task_status: Array,
    payments: Array,
    tasks: Array,
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/contacts', pickBy(this.form), {
          preserveState: true
        })
      }, 150),
    },
  },
  methods: {
    money: function(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
     getMonthName : function(monthNumber) {
      const date = new Date();
      date.setMonth(monthNumber - 1);
      return date.toLocaleString([], { month: 'long' });
    },
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
    },

  },
}

</script>
