<template>
    <div class="row mt-1 mb-4">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-12 d-flex align-items-center">
                            <h6 class="mb-0">{{ bank.bankname }} Collectors</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employee
                                        Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Customers</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Total</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Collected</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="payment in users" :key="payment.id">
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="px-2">
                                                <img :src="`/${callSex(payment.sex)}`"        class="avatar avatar-xs rounded-circle">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <Link :href="`/clients/user/${ payment.id }`">
                                                    <h6 class="mb-0 text-sm">{{ payment.name }}</h6>
                                                </Link>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold"> {{ payment.clients }} </span>
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
                                                    <span class="text-xs font-weight-bold">{{
                                                        Math.ceil(payment.total * 100 / payment.amount) }}%</span>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div :class="`progress-bar bg-gradient-info w-${callPercent(Math.ceil(payment.total * 100 / payment.amount))}`"        role="progressbar"        v-bind:aria-valuenow="`${Math.ceil(payment.total * 100 / payment.amount)}`"        aria-valuemin="0"        :aria-valuemax="`${Math.ceil(payment.total * 100 / payment.amount)}`">
                                                </div>
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
                            <h6 class="mb-0">{{ bank.bankname }}</h6>
                        </div>
                        <div class="col-6 text-end">
                            <Link href="/payments" class="btn btn-outline-primary btn-sm mb-0">View All</Link>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3 pb-0">
                    <ul class="list-group">
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                    <i class="material-icons opacity-10">people_outline</i>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark text-sm">Total Customers</h6>
                                    <span class="font-weight-bold">{{ money(bank.members) }}</span>
                                </div>
                            </div>
                            <div class="d-flex">
                                <button
                                    class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                        class="ni ni-bold-right" aria-hidden="true"></i> {{ money(bank.amounts) }}</button>
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                    <i class="material-icons opacity-10">payments</i>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark text-sm">Total Amounts</h6>
                                    <span class="font-weight-bold">{{ money(bank.amounts) }}</span>
                                </div>
                            </div>
                            <div class="d-flex">
                                <button
                                    class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                        class="ni ni-bold-right" aria-hidden="true"></i> {{ money(bank.members) }}</button>
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                    <i class="material-icons opacity-10">credit_score</i>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark text-sm">Total Collected</h6>
                                    <span class="font-weight-bold">{{ money(bank.payments) }}</span>
                                </div>
                            </div>
                            <div class="d-flex">
                                <button
                                    class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                        class="ni ni-bold-right" aria-hidden="true"></i> {{ money(bank.payments) }}</button>
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                    <i class="material-icons opacity-10">person</i>
                                </div>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark text-sm">Team Leader</h6>
                                    <span class="font-weight-bold">{{ (bank.leader) }}</span>
                                </div>
                            </div>
                            <div class="d-flex">
                                <button
                                    class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                        class="ni ni-bold-right" aria-hidden="true"></i> {{ money(bank.payments) }}</button>
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
        'bank': Array,
        'users': Object,
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
