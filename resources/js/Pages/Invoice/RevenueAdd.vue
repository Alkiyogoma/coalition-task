<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header p-0 position-relative z-index-2">
            <h5 class="px-4" id="modal-title-exampleModalLong"> Add New Revenue Transaction</h5>
        </div>
        <div class="card-body">
                <form role="form text-left" method="post" action="/revenueadd">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Payer Name</label>
                                <input type="text" required name="payer_name" class="form-control">
                            </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="input-group input-group-outline my-3">
                                <label class="form-label">Payer Phone</label>
                                <input type="text" required name="payer_phone" class="form-control">
                                <input type="hidden" :value="_token" name="_token" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-outline my-3">
                                <select required class="form-control" name="account_group_id" id="choices-currency-edit">
                                    <option value="" selected="">Select Account Category</option>
                                    <option v-for="installment in categories" :value="installment.id">{{ installment.name }}</option>
                                </select>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Received Amount</label>
                                <input type="number" step=".01" required name="amount" class="form-control">
                            </div>
                        </div>
                    </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <select required class="form-control" name="method_id" id="choices-currency">
                                <option value="" selected="">Select Payment Method</option>
                                <option v-for="method in methods" :value="method.id">{{ method.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <select required class="form-control" name="user_id" id="choices-currency-edit">
                                <option value="" selected="">Select Received by Staff?</option>
                                <option v-for="installment in users" :value="installment.id">{{ installment.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="input-group input-group-outline my-3">
                    <textarea name="note" required class="multisteps-form__textarea form-control" rows="3" :placeholder="`Write description here`" spellcheck="false"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <input onfocus="(this.type = 'date')" class="form-control" required onblur="(this.type = 'text')" name="date"  placeholder="Set Transaction  Date" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Reference</label>
                            <input type="text" required name="reference" class="form-control">
                        </div>
                    </div>
                </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-50 mt-2 mb-0">Save Revenue</button>
                  </div> 
                </form>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Icon from '../../Shared/Icon'

export default {
  components: {
    Head,
    Icon,
    Link,
  },
  props: {
    users: Object,
    categories: Object,
    methods: Object,
    _token: String
  },
  remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                name: '',
                amount: '',
                payer_name: '',
                payer_phone: '',
                date: '',
                method_id: '',
                note: '',
                amount: '',
                user_id: '',
                account_group_id: '',
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
