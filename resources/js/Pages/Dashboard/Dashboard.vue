<template>
  <div class="container-fluid bg-white py-4">
    <div class="row">
      <div class="col-md-6 col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-header mx-4 p-3 text-center">
            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
              <i class="material-icons opacity-10">payments</i>
            </div>
          </div>
          <div class="card-body pt-0 p-3 text-center">
            <h6 class="text-center mb-0">Total Amount</h6>
            <h5 class="mb-0">{{ bank.amounts }}</h5>
            <hr class="horizontal dark my-3">
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-header mx-4 p-3 text-center">
            <div class="icon icon-shape icon-lg bg-gradient-info shadow text-center border-radius-lg">
              <i class="material-icons opacity-10">shopping_cart</i>
            </div>
          </div>
          <div class="card-body pt-0 p-3 text-center">
            <h6 class="text-center mb-0">Collected</h6>
            <h5 class="mb-0">{{ bank.payments }}</h5>
            <hr class="horizontal dark my-3">
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-header mx-4 p-3 text-center">
            <div class="icon icon-shape icon-lg bg-gradient-secondary shadow text-center border-radius-lg">
              <i class="material-icons opacity-10">people</i>
            </div>
          </div>
          <div class="card-body pt-0 p-3 text-center">
            <h6 class="text-center mb-0">Customers</h6>
            <h5 class="mb-0">{{ bank.members }}</h5>
            <!-- <span class="text-xs">Belong Interactive</span> -->
            <hr class="horizontal dark my-3">
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-header mx-4 p-3 text-center">
            <div class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-lg">
              <i class="material-icons opacity-10">person</i>
            </div>
          </div>
          <div class="card-body pt-0 p-3 text-center">
            <h6 class="text-center mb-0">Paid Customers</h6>
            <h5 class="mb-0">{{ bank.customers }}</h5>
            <hr class="horizontal dark my-3">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row bg-white mt-1 mb-4">
    <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
     
          <div class="row">
            <div class="col-lg-6 col-7">
              <h6> Collection Dashboard</h6>
            </div>
            <div class="col-lg-6 col-5 my-auto text-end">
              <div class="dropdown float-lg-end pe-4">
                <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-ellipsis-v text-secondary"></i> View
                </a>
                <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                  <li>
                    <Link class="dropdown-item border-radius-md" href="/dashboard">This Month</Link>
                  </li>
                  <li>
                    <Link class="dropdown-item border-radius-md" href="/dashboard?days=60">Last Month</Link>
                  </li>
                  <li>
                    <Link class="dropdown-item border-radius-md" href="/dashboard?days=6">Last 7 days</Link>
                  </li>
                  <li>
                    <Link class="dropdown-item border-radius-md" href="/dashboard?days=1">Yesterday</Link>
                  </li>
                  <li>
                    <Link class="dropdown-item border-radius-md" href="/dashboard?days=0">Today</Link>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employee Name</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customers</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Collected
                  </th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Score</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="payment in payments" :key="payment.id">
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div class="px-2">
                        <img :src="`/${callSex(payment.sex)}`" class="avatar avatar-xs rounded-circle">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">{{ payment.name }}</h6>
                      </div>
                    </div>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold"> {{ payment.client }} </span>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold"> {{ money(payment.amount) }} </span>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold"> {{ money(payment.total) }} </span>
                  </td>
                  <td class="align-middle">
                    <div class="progress-wrapper w-75 mx-auto">
                      <div class="progress-info">
                        <div class="progress-percentage">
                          <span class="text-xs font-weight-bold">{{ Math.ceil(payment.total * 100 / payment.amount)
                          }}%</span>
                        </div>
                      </div>
                      <div class="progress">
                        <div
                          :class="`progress-bar bg-gradient-info w-${callPercent(Math.ceil(payment.total * 100 / payment.amount))}`"
                          role="progressbar" v-bind:aria-valuenow="`${Math.ceil(payment.total * 100 / payment.amount)}`"
                          aria-valuemin="0" :aria-valuemax="`${Math.ceil(payment.total * 100 / payment.amount)}`"></div>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
     
    <div class="col-lg-4">
          <div class="row">
            <div class="col-6 d-flex align-items-center">
              <h6 class="mb-0">Today Summary</h6>
            </div>
            <div class="col-6 text-end">
              <Link href="/payments" class="btn btn-outline-primary btn-sm mb-0">View All</Link>
            </div>
          </div>
        
          <ul class="list-group">
            <li v-for="collect in collections" :key="collect.id"
              class="list-group-item border-0 d-flex justify-content-between ps-0 mb-0 border-radius-lg">
              <div class="d-flex flex-column">
                <h6 class="mb-0 text-dark font-weight-bold text-sm"> - {{ collect.name }}</h6>
                <span class="text-xs"> {{ collect.total }} - Customers</span>

              </div>
              <div class="d-flex align-items-center text-sm">
                <a class="btn btn-link text-dark text-sm mb-0 px-0">{{ money(collect.amount) }}</a>
              </div>
            </li>
          </ul>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-center font-weight-bolder opacity-7">S/N</th>
              <th class="text-uppercase text-secondary text-left font-weight-bolder"> Bank Name</th>
              <th class="text-uppercase">Team Leader</th>
              <th class="text-uppercase text-secondary text-center font-weight-bolder opacity-7">Customers</th>
              <th class="text-uppercase text-secondary text-center font-weight-bolder opacity-7"> Scanned</th>
              <th class="text-uppercase text-secondary text-center font-weight-bolder opacity-7">NotScanned</th>
              <th class="text-uppercase text-secondary text-center font-weight-bolder opacity-7">SKip Tracing</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{ user.no }}</span>
              </td>
              <td>
                <h6 class="mb-0 text-sm">{{ user.name }}</h6>
              </td>

              <td class="align-middle">
                <span class="text-secondary text-xs font-weight-bold">{{ user.user }}</span>
              </td>

              <td class="align-middle text-center">
                <Link :href="`/clients/partner/${user.id}`" class="text-white font-weight-bold  " data-toggle="tooltip" data-original-title="Edit user">
                  <span class="text-secondary text-xs font-weight-bold">{{ user.clients }}</span>
                </Link>
              </td>

              <td class="align-middle text-center">
                <Link :href="`/clients/partner/${user.id}?status=1,2,3`" class="text-white font-weight-bold  " data-toggle="tooltip" data-original-title="Edit user">
                  <span class="btn btn-outline-info btn-sm mb-0"> {{ user.reached }}</span>
                </Link>
              </td>

              <td class="align-middle text-center">
                <Link :href="`/clients/partner/${user.id}?status=all`" class="text-white font-weight-bold  " data-toggle="tooltip" data-original-title="Edit user">
                  <span class="btn btn-outline-dark btn-sm mb-0"> {{ user.pending }}</span>
                </Link>
              </td>
              <td class="align-middle text-center">
                <Link :href="`/clients/partner/${user.id}?status=1`" class="text-white font-weight-bold  " data-toggle="tooltip" data-original-title="Edit user">
                  <span class="btn btn-outline-success btn-sm mb-0"> {{ user.skip }}</span>
                </Link>
              </td>

            </tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
<script>
import { Head, Link } from "@inertiajs/vue3";
import { Chart } from "highcharts-vue";
export default {
  components: {
    Link, Head,
    highcharts: Chart,
  },
  props: {
    'payments': Array,
    'bank': Array,
    'collections': Array,
    'clients': String,
    'users': Object,
    'amounts': String,
    'tasks': String,
  },
  data() {
    return {
      'number': 1
    };
  },
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
    },
    callSex: function (sex) {

      if (sex == 'Female') {
        return 'assets/img/team-3.jpg';
      } else {
        return 'assets/img/team-4.jpg'
      }
    },
    money: function (value) {
      let val = (value / 1).toFixed(2).replace(',', '.')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }
  }
};
</script>
