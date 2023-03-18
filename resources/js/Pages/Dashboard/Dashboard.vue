<template>
     <div class="container-fluid py-4">
      <div class="row">
              <div class="col-md-6 col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-header mx-4 p-3 text-center">
                    <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                      <i class="material-icons opacity-10">payments</i>
                    </div>
                  </div>
                  <div class="card-body pt-0 p-3 text-center">
                    <h6 class="text-center mb-0">Amounts</h6>
                    <h5 class="mb-0">{{ amounts }}</h5>
                    <hr class="horizontal dark my-3">
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-header mx-4 p-3 text-center">
                    <div class="icon icon-shape icon-lg bg-gradient-info shadow text-center border-radius-lg">
                      <i class="material-icons opacity-10">person</i>
                    </div>
                  </div>
                  <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">Clients</h6>
                    <h5 class="mb-0">{{ clients }}</h5>
                    <hr class="horizontal dark my-3">
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-header mx-4 p-3 text-center">
                    <div class="icon icon-shape icon-lg bg-gradient-secondary shadow text-center border-radius-lg">
                      <i class="material-icons opacity-10">layers</i>
                    </div>
                  </div>
                  <div class="card-body pt-0 p-3 text-center">
                    <h6 class="text-center mb-0">Tasks</h6>
                    <h5 class="mb-0">{{ tasks }}</h5>
                   <!-- <span class="text-xs">Belong Interactive</span> -->
                    <hr class="horizontal dark my-3">
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-header mx-4 p-3 text-center">
                    <div class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-lg">
                      <i class="material-icons opacity-10">message</i>
                    </div>
                  </div>
                  <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">Mesages</h6>
                        <h5 class="mb-0">{{ messages }}</h5>
                        <hr class="horizontal dark my-3">
                  </div>
                </div>
              </div>
            </div>
          </div>
      
      <div class="row mt-5 mb-4">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
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
                      <li><Link class="dropdown-item border-radius-md" href="/dashboard">This Month</Link></li>
                      <li><Link class="dropdown-item border-radius-md" href="/dashboard?days=60">Last Month</Link></li>
                      <li><Link class="dropdown-item border-radius-md" href="/dashboard?days=6">Last 7 days</Link></li>
                      <li><Link class="dropdown-item border-radius-md" href="/dashboard?days=1">Yesterday</Link></li>
                      <li><Link class="dropdown-item border-radius-md" href="/dashboard?days=0">Today</Link></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employee Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Clients</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Collected</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Score</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="payment in payments" :key="payment.id">
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="px-2">
                              <img :src="`/${ callSex(payment.sex) }`" class="avatar avatar-xs rounded-circle">
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
                              <span class="text-xs font-weight-bold">{{ Math.ceil(payment.total*100/payment.amount) }}%</span>
                            </div>
                          </div>
                          <div class="progress">
                            <div :class="`progress-bar bg-gradient-info w-${ callPercent(Math.ceil(payment.total*100/payment.amount)) }`" role="progressbar" v-bind:aria-valuenow="`${ Math.ceil(payment.total*100/payment.amount) }`" aria-valuemin="0" :aria-valuemax="`${ Math.ceil(payment.total*100/payment.amount) }`"></div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card h-100">
            <div class="card-header pb-0 p-3">
              <div class="row">
                <div class="col-6 d-flex align-items-center">
                  <h6 class="mb-0">Today Summary</h6>
                </div>
                <div class="col-6 text-end">
                  <Link href="/payments" class="btn btn-outline-primary btn-sm mb-0">View All</Link>
                </div>
              </div>
            </div>
            <div class="card-body p-3 pb-0">
              <ul class="list-group">
                <li v-for="collect in collections" :key="collect.id" class="list-group-item border-0 d-flex justify-content-between ps-0 mb-0 border-radius-lg">
                  <div class="d-flex flex-column">
                    <h6 class="mb-0 text-dark font-weight-bold text-sm"> - {{ collect.name }}</h6>
                  </div>
                  <div class="d-flex align-items-center text-sm">
                    <a class="btn btn-link text-dark text-sm mb-0 px-0">{{ money(collect.amount) }}</a>
                  </div>
                </li>
              </ul>
            </div>
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
      'payments' : Array,
      'collections': Array,
      'clients': String,
      'messages': String,
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
      }else{
        return 'assets/img/team-4.jpg'
      }
    },
    money: function(value) {
        let val = (value/1).toFixed(2).replace(',', '.')
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }
  }
};
</script>
