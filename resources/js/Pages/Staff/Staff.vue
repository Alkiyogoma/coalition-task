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
                <!-- <li class="list-group-item border-0  text-sm"><strong class="text-dark">
                    Joined:</strong> &nbsp;{{ staff.jod }}</li>

                <li class="list-group-item border-0  text-sm"><strong class="text-dark">
                    Last Login:</strong> &nbsp;{{ staff.jod }}</li>
                -->
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
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customers</th>
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
                          <span class="me-2 text-xs font-weight-bold">{{
                            callPercent(Math.ceil(payment.total * 100 / payment.amount)) }}%</span>
                          <div>
                            <div class="progress">
                              <div class="progress-bar bg-gradient-info" role="progressbar"
                                :aria-valuenow="`${callPercent(Math.ceil(payment.total * 100 / payment.amount))}`"
                                aria-valuemin="0" aria-valuemax="100"
                                :style="`width: ${callPercent(Math.ceil(payment.total * 100 / payment.amount))}%;`"></div>
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
    <div class="col-lg-12 mt-lg-0">
      <div class="card">
        <div class="card-body">
          <h6 class="text-dark">{{ staff.name }} Banks</h6>
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employee
                    Name</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Target</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Collected</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Customers</th>
                    
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Scanned</th>
                    
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Pending</th>
                    
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Active</th>
                    
                    
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Skip</th>
                    
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Inactive</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="payment in users" :key="payment.id">
                  <td>
                    <div class="d-flex py-1">
                      <div class="px-2">
                        <img src="/assets/images/logo.jpg" class="avatar avatar-xs rounded-circle">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <Link :href="`/collections/${payment.id}/${staff.id}`">
                        <h6 class="mb-0 text-sm">{{ payment.name }}</h6>
                        </Link>
                      </div>
                    </div>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold"> {{ money(payment.amount) }} </span>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <Link :href="`/collections/${payment.id}/${staff.id}`">
                      <u class="text-xs font-weight-bold"> {{ money(payment.total) }} </u>
                    </Link>
                  </td>
                  
                  <td class="align-middle text-center text-sm">
                    <a :href="`/clients/user/${staff.id}/${payment.id}`" class="text-xs font-weight-bold"> <u> {{ (payment.clients) }}</u> </a>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <a :href="`/clients/user/${staff.id}/${payment.id}?status=1,2,3`" class="text-xs font-weight-bold"><u>{{ (payment.reached) }}</u> </a>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <a :href="`/clients/user/${staff.id}/${payment.id}?status=all`" class="text-xs font-weight-bold"><u>{{ (payment.pending) }} </u></a>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <a :href="`/clients/user/${staff.id}/${payment.id}?status=3`" class="text-xs font-weight-bold"><u>{{ (payment.active) }}</u> </a>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <a  :href="`/clients/user/${staff.id}/${payment.id}?status=1`" class="text-xs font-weight-bold"><u> {{ (payment.skip) }}</u> </a>
                  </td>
                
                  <td class="align-middle text-center text-sm">
                    <a :href="`/clients/user/${staff.id}/${payment.id}?status=2`" class="text-xs font-weight-bold"><u>{{ (payment.inactive) }}</u> </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="row mt-2">
    <div class="col-lg-12">

          <h6 class="text-dark">Latest {{ staff.name }} Collections</h6>

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
    collections: Array,
    users: Object,
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
    money: function (value) {
      let val = (value / 1).toFixed(2).replace(',', '.')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    },
    getMonthName: function (monthNumber) {
      const date = new Date();
      date.setMonth(monthNumber - 1);
      return date.toLocaleString([], { month: 'long' });
    },
    callSex: function (sex) {
      if (sex == 'Female') {
        return 'assets/img/team-3.jpg';
      } else {
        return 'assets/img/team-4.jpg'
      }
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
