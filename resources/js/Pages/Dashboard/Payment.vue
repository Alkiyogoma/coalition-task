<template>
    <div class="container-fluid py-4">
        <div class="row mt-1">
            <div class="col-xl-8 col-lg-7">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-0">Transactions</h6>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end align-items-center">
                                <i class="material-icons me-2 text-lg">date_range</i>
                                <small>Collected</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            <li v-for="partner in partners" :key="partner.name" class="list-group-item border-0 justify-content-between ps-0 pb-0 border-radius-lg">
                                <div class="d-flex">
                                    <div class="d-flex align-items-center">
                                        <button
                                            class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i
                                                class="material-icons text-lg">expand_more</i></button>
                                        <div class="d-flex flex-column">
                                            <Link :href="`/collections/${ partner.id }/0`">
                                                <h6 class="mb-1 text-dark text-sm">{{ partner.name }}</h6>
                                                <span class="text-xs"> Amount {{ money(partner.amount)  }}</span>
                                            </Link>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold ms-auto">
                                        TZS {{ money(partner.total) }}
                                    </div>
                                </div>
                                <hr class="horizontal dark mt-3 mb-2" />
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5 mt-lg-0 mt-4">

                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Top Performers</h6>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            <li v-for="collect in payments" :key="collect.name"               class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                        <i class="material-icons opacity-10">person</i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <Link :href="`/collections/0/${ collect.id }`">
                                        <h6 class="mb-1 text-dark text-sm">{{ collect.name }}</h6>
                                        <span class="text-xs">TZS {{ money(collect.amount) }}</span>
                                        </Link>
                                    </div>
                                </div>
                                <div class="d-flex text-end">
                                    <span class="font-weight-bold">  Customers <br> {{ collect.total }}</span>
                                    
                                </div>
                            </li>
                            
                            
                        </ul>
                    </div>
                </div>
            </div>
      
            <div class="row mt-4">
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <h5 class="mb-2">Latest Payments Collections</h5>
                            </div>
                            <div class="col-lg-4 col-5 my-auto">
                                <Link href="/paymentadd" style="float: right; margin-right: 4em;" class="mr-4 text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                    <span class="btn btn-primary btn-sm bg-gradient-secondary"><i class="material-icons text-lg me-2">add</i> Add Payments</span>
                                </Link>
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-uppercase text-dark text-left text-xxs font-weight-bolder opacity-7">Collector</th>
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
                                        <Link :href="`/receipt/${payment.uuid}/payment`"> <i class="material-icons text-lg">payments</i> View</Link>
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
        users: String,
        collections: Array
    },
    methods: {
        money: function(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }
    }
};
</script>