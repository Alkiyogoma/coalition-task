<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header p-0 position-relative z-index-2">
            <h5 class="px-4" id="modal-title-exampleModalLong"> Update {{ payment.account }} Transaction  </h5>
        </div>
        <div class="card-body">
                <form role="form text-left" method="post" :action="`/revenueedit/${payment.uuid}/edit`">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-outline my-3">
                                <select required class="form-control" name="account_group_id" id="choices-currency-edit">
                                    <option :value="`${payment.account_group_id}`"  selected="">Select Account Category</option>
                                    <option v-for="installment in categories" :value="installment.id">{{ installment.name }}</option>
                                </select>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Received Amount</label>
                                <input type="number" step=".01" :value="payment.amount" required name="amount" class="form-control">
                            </div>
                        </div>
                    </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <select required class="form-control" name="method_id" id="choices-currency">
                                <option :value="`${payment.method_id}`" selected="">Select Payment Method</option>
                                <option v-for="method in methods" :value="method.id">{{ method.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <select required class="form-control" name="user_id" id="choices-currency-edit">
                                <option :value="`${payment.user_id}`"  selected="">Select Received by Staff?</option>
                                <option v-for="installment in users" :value="installment.id">{{ installment.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="input-group input-group-outline my-3">
                    <textarea name="note"  :value="payment.note" required class="multisteps-form__textarea form-control" rows="3" :placeholder="`Write description here`" spellcheck="false"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <input onfocus="(this.type = 'date')" class="form-control" required onblur="(this.type = 'text')" name="date"  :value="payment.date" :placeholder="`Date - ${payment.date}`" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Reference</label>
                            <input type="text"  :value="payment.reference"  required name="reference" class="form-control">
                        </div>
                    </div>
                </div>
                  <div class="text-center">
                    <input type="hidden" :value="_token" name="_token" class="form-control">
                     <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-50 mt-4 mb-0">Update revenue</button>
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
    payment: Object,
    _token: String
  },
  remember: 'form',
    data() {
        return {
            form: this.$inertia.form({
                name: this.payment.name,
                account_group_id: this.payment.account_group_id,
                method_id: this.payment.method_id,
                roll: this.payment.roll,
                amount: this.payment.amount,
                note: this.payment.note,
                jod: this.payment.date,
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
