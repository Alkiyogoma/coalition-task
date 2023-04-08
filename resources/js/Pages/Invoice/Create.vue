<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Customer Basic Info</h5>
                </div>
                <div class="card-body pt-0">
                        <form @submit.prevent="store">
                          <div class="row">
                            <text-input v-model="form.name" :error="form.errors.name" required label="Client name" />
                                <text-input v-model="form.phone" required :error="form.errors.phone" label="Phone" />
                            </div>
                            <div class="row">
                                <text-input v-model="form.address" :error="form.errors.address" label="Address" />
                                <text-input v-model="form.account" required :error="form.errors.account" label="Account Number" />
                          </div>
                        
                          <div class="row">
                              <text-input v-model="form.amount" required type="number" step=".01" min="1" :error="form.errors.amount" label="Credit Balance" />
                              <text-input v-model="form.payment" required type="number" min="0" step=".01" :error="form.errors.payment" label="Received Amount" />
                          </div>
                            <div class="row">
                              <text-input v-model="form.branch" required  :error="form.errors.branch" label="Customer Branch" />
                              <text-input v-model="form.employer" :error="form.errors.employer" label="Customer Employer" />
                          </div>
                          <div class="row">
                            <select-input v-model="form.partner_id" :error="form.errors.partner_id" required 
                                label="From Partner?">
                                <option :value="null" />
                                <option v-for="organization in partners" :key="organization.id"     :value="organization.id">{{ organization.name }}</option>
                            </select-input>
                            
                            <select-input v-model="form.installment_id" :error="form.errors.installment_id" required  label="Payment Installments">
                                <option :value="null" />
                                <option v-for="role in installments" :key="role.id"     :value="role.id">{{ role.name }}</option>
                            </select-input>
                          </div>
                          <div class="row">
                            <text-input v-model="form.collector" required  :error="form.errors.collector" label="Collector Name" />
                            
                            <select-input v-model="form.user_id" :error="form.errors.user_id" required 
                                label="Assigned Staff?">
                                <option :value="null" />
                                <option v-for="user in users" :key="user.id"     :value="user.id">{{ user.name }}</option>
                            </select-input>
                          </div>
                          
                            <div class="row">
                            <div
                                class="flex items-center justify-end border-gray-100">
                                <loading-button :loading="form.processing" class="btn-indigo" type="submit">Add Customer</loading-button>
                            </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
</template>
<script>
    import {
        Link
    } from '@inertiajs/vue3'
    // import Layout from '../Shared/Layout'
    import TextInput from '../../Shared/TextInputB'
    import SelectInput from '../../Shared/SelectInput'
    import MultipleInput from '../../Shared/MultipleInput'
    import LoadingButton from '../../Shared/LoadingButton'

    export default {
        components: {
            Link,
            LoadingButton,
            SelectInput,
            MultipleInput,
            TextInput,
        },
        props: {
          users: Array,
          partners: Array,
          installments: Array,
        },
        remember: 'form',
        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    partner_id: '',
                    employer: '',
                    phone: '',
                    address: '',
                    branch: '',
                    collector: '',
                    amount: '',
                    user_id: '',
                    account: '',
                    payment: '',
                    installment_id: '',
                }),
            }
        },
        methods: {
            store() {
                this.form.post('/saveclient')
            },
        },
    }

</script>
