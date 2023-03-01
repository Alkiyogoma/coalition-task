<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body pt-0">
                    <h5 class="font-weight-normal" id="modal-title-notification"> Received Amount from <u>Customer</u> </h5>
                    <hr class="horizontal dark mt-3 mb-2" />
                    <form  method="post" action="/savePayment">
                            
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Received Amount</label>
                                    <input type="number" step="0.01" required name="payment" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    <select required class="form-control" name="client_id" id="choices-client_id-edit">
                                        <option value="" selected="">Select Customer</option>
                                        <option v-for="installment in clients" :value="installment.id">{{ installment.name }}</option>
                                    </select>
                                <input type="hidden" :value="_token" name="_token" class="form-control">
                            </div>
                        </div>
                        </div>
                               
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    <select required class="form-control" name="user_id" id="choices-currency-edit">
                                        <option value="" selected=""> Collector?</option>
                                        <option v-for="installment in users" :value="installment.id">{{ installment.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Reference No#</label>
                                    <input type="text" required name="reference" class="form-control">
                                </div>
                            </div>
                        </div>
                            <div class="input-group input-group-outline my-3">
                                <select required class="form-control" name="installment_id" id="choices-currency-edit">
                                    <option value="" selected="">Select Installments</option>
                                    <option v-for="installment in installments" :value="installment.id">{{ installment.name }}</option>
                                </select>
                            </div>
                            <div class="input-group input-group-outline my-3">
                                <input onfocus="(this.type = 'date')" class="form-control" required onblur="(this.type = 'text')" name="date"  placeholder="Amount Received Date" />
                            </div>
                            <div class="input-group input-group-outline my-3">
                                <select required class="form-control" name="method_id" id="choices-currency">
                                    <option value="" selected="">Select Payment Method</option>
                                    <option v-for="method in methods" :value="method.id">{{ method.name }}</option>
                                </select>
                            </div>
                            <div class="input-group input-group-outline my-3">
                                <textarea name="about" required class="multisteps-form__textarea form-control" rows="3" placeholder="Write your comment." spellcheck="false"></textarea>
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item border-0 px-0">
                                <div class="form-check form-switch ps-0">
                                    <input class="form-check-input ms-auto" name="status" value="1" type="radio" id="flexSwitchCheckDefault">
                                    <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault">I confirm amount was received by bank</label>
                                <br>
                                    <input class="form-check-input ms-auto" name="status" value="0" type="radio" id="flexSwitchCheckDefault1">
                                    <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault1">I can't confirm amount was received by bank</label>
                                </div>
                                </li>
                            </ul>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Save Payment</button>
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="flex items-center justify-end border-gray-100">
                                        <a href="/uploadPayments" class="btn bg-gradient-secondary btn-lg btn-rounded w-100 mt-4 mb-0" type="submit">Upload Payments From Excel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</template>
<script>
    import { Link } from '@inertiajs/vue3'
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
            methods: Array,
            clients: Array,
            partners: Array,
            installments: Array,
            _token: String
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
