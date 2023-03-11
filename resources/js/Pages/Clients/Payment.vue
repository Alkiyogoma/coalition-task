<template>
        <div class="row mt-1">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-8 col-5 my-auto">
                    <div class="dropdown">
                        <span class="mb-0 px-1"> {{ title }} - {{ date }} </span>

                        <a class="cursor-pointer px-6" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-ellipsis-v text-secondary"></i> Change Period
                        </a>
                        <ul class="dropdown-menu px-2 py-2 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                        <li><a class="dropdown-item border-radius-md" :href="`${ url }`">This Month</a></li>
                        <li><a class="dropdown-item border-radius-md" :href="`${ url }?days=60`">Last Month</a></li>
                        <li><a class="dropdown-item border-radius-md" :href="`${ url }?days=6`">Last 7 days</a></li>
                        <li><a class="dropdown-item border-radius-md" :href="`${ url }?days=1`">Yesterday</a></li>
                        <li><a class="dropdown-item border-radius-md" :href="`${ url }?days=0`">Today</a></li>
                        </ul>
                    </div>
                    </div>
                    <div class="col-lg-4 col-5 my-auto">
                        <a href="/paymentadd" style="float: right; margin-right: 4em;" class="mr-4 text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                            <span class="btn btn-primary btn-sm bg-gradient-secondary"><i class="material-icons text-lg me-2">add</i> Add Payments</span>
                        </a>
                    </div>

                </div>
                </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bank Name</th>
                      <th class="text-uppercase text-secondary align-middle text-center font-weight-bolder opacity-7 ps-2">Customers</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Target</th>
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
                            <h6 class="mb-0 text-sm"><Link :href="`/collections/${ payment.id }/0`">{{ payment.name }}</Link></h6>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-center font-weight-bold"> {{ payment.client }} </span>
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
        <hr>
                <div class="card">

                    <div class="card-body">

                        <div class="table-responsive">
                        <table class="table table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <!-- Collector 	 Customer Name 	 Employer 	 Account number 	 Contacts 	 Branch 	 Outstanding Balance(TZS) 	 Amount Received Jan'23  -->

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Collector</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Customer Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Account number</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Branch</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount Received </th>
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
                                        <a :href="`/receipt/${payment.uuid}/payment`"> <i class="material-icons text-lg">payments</i> View</a>
                                   
                                    </td>
                                </tr>
                              
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4 col-5 my-auto">
                        <a :href="`${ url }/export?days=${ days }`" style="float: right; margin-right: 4em;" class="mr-4 text-white font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                            <span class="btn btn-primary btn-sm bg-gradient-info"><i class="material-icons text-lg me-2">payments</i> Export Payments</span>
                        </a>
                    </div>
            </div>
        </div>
    </div>
</template>

<script>

import { Head, Link } from "@inertiajs/vue3";
import { Chart } from "highcharts-vue";
import DataTable from 'datatables.net-vue3'

export default {
    components: {
        DataTable,
        Link, Head,
        highcharts: Chart,
    },
    props: {
        payments: Array,
        partners: Array,
        date: String,
        title: String,
        days: String,
        url: String,
        days: String,
        collections: Array
    },
    methods: {
        money: function(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        callSex: function (sex) {
        
        if (sex == 'Female') {
                return 'assets/img/team-3.jpg';
        }else{
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
    }
};
</script>