<template>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header p-0 position-relative z-index-2" id="topheader">
              <h5 class="px-4" id="modal-title-exampleModalLong">Received Payment Receipt </h5>
          </div>
          <div id="printablediv">
          <div class="card-body">  
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

                <tr class="text-gray-700 dark:text-gray-400">
                    <th class="px-2 py-2"  align="left">
                        <img src="/assets/images/logo.jpg" style="min-width: 40%; max-width: 50%;" />
                    </th>

                    <th class="px-2 py-2"  style="min-width: 60%;" align="left">
                        {{ school.name }}<br />
                       Address: {{ school.address }}<br />
                       Phone: {{ school.phone }}<br />
                        {{ school.email }}<br />
                    </th>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <th colspan="2" class="px-2 py-2"><center>{{ title }}</center></th>
                </tr>
             

                <tr class="text-gray-700 dark:text-gray-400">
                    <th class="px-2 py-2" align="left">
                    Payer: {{ payment.payer }} .<br />
                        Phone - {{ payment.phone }} <br />
                        Reference - {{ payment.reference }}<br />
                    </th>
                    <th class="px-2 py-2" align="right">
                        Receipt#: {{ payment.reference }}<br />
                        Payment Date: {{ payment.date }}<br />
                        Added Date: {{ payment.created_at }}<br />
                        <!-- Due: February 1, 2015 -->
                    </th>
                </tr>
              
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-2 py-2">Received From</td>
                    <td class="px-2 py-2">{{ payment.account }}</td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-2 py-2">Payment Method</td>
                    <td class="px-2 py-2">{{ payment.method }}</td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-2 py-2">Paid Amount</td>
                    <td class="px-2 py-2">{{ payment.amount }}</td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-2 py-2">Amount in Words</td>
                    <th class="px-2 py-2" colspan="2">{{ payment.words }}</th>
                </tr>
              

                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-2 py-2">Comments</td>
                    <th colspan="2"  class="px-2 py-2"> {{ payment.note }}</th>
                </tr>
                <!-- <tr class="item last">
                    <td class="px-2 py-2">Total Paid</td>
                    <td class="px-2 py-2">{{ payment.amount }}</td>
                </tr>
                <tr class="item last">
                    <td class="px-2 py-2">Current Balance</td>
                    <td class="px-2 py-2">{{ payment.note }}</td>
                </tr> -->

                <tr class="total">
                    <td class="px-2 py-2" align="center">  By  <u>{{ payment.added }}</u><br>
                        {{ payment.userrole }} 
                    </td>
                    <td class="px-2 py-2" align="center">______________________________ <br>
                        Signature 
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>
    </div>
    <button id="printcard" @click="printDownload">Print Download</button>
    
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
    import mapValues from 'lodash/mapValues'
    import Pagination from '../../Shared/Pagination'
    import Icon from '../../Shared/Icon'

    export default {
        components: {
            Head,
            Icon,
            Link,
            Pagination,
        },
        props: {
            payment: Object,
            school: Object,
            title: String,
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
            reset() {
                this.form = mapValues(this.form, () => null)
            },
            printDownload () {
                var divElements = document.getElementById('printablediv').innerHTML;
                document.getElementById('topheader').style.display = 'none';
                document.getElementById('navbarBlur').style.display = 'none';
                document.getElementById('sidenav-main').style.display = 'none';
                document.getElementById('sidenav-collapse-main').style.display = 'none';
                document.getElementById('printcard').style.display = 'none';
                document.getElementById('bottom-icon').style.display = 'none';
                window.print(divElements);
                $('#sidenav-main,#sidenav-collapse-main,#topheader,#navbarBlur, #printcard').show(); 
            }
        },
    }

</script>
