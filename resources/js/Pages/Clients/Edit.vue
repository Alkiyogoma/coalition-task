<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5>Edit Customer Basic Info</h5>
        </div>
        <div class="card-body pt-0">
          <form @submit.prevent="store">
            <div class="row">
              <text-input v-model="form.name" :error="form.errors.name" required label="Client name" />
              <text-input v-model="form.phone" required :error="form.errors.phone" label="Phone" />
            </div>
            <div class="row">
              <text-input v-model="form.address" :error="form.errors.address" label="Address" />
                <select-input v-model="form.sex" :error="form.errors.sex" required id="choices-gender">
                    <option value="" selected>---- Sex---</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select-input>
            </div>

            <div class="row">
              <text-input v-model="form.kinphone"  type="text"  :error="form.errors.kinphone"
                label="NextKin Phone" class="input-group input-group-outline my-3"/>
              <text-input v-model="form.nextkin"  type="text" :error="form.errors.nextkin"
                label="Nextkin Name" class="input-group input-group-outline my-3"/>
            </div>
            <div class="row">
              <text-input v-model="form.branch" required :error="form.errors.branch" label="Customer Branch" />
              <text-input v-model="form.employer" :error="form.errors.employer" label="Customer Employer" />
            </div>
            <div class="row">
              <select-input v-model="form.user_id" :error="form.errors.user_id" required label="Assigned Staff?">
                <option :value="null" />
                <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
              </select-input>

              <select-input v-model="form.installment_id" :error="form.errors.installment_id" required
                label="Payment Installments">
                <option :value="form.installment_id" />
                <option v-for="role in installments" :key="role.id" :value="role.id">{{ role.name }}</option>
              </select-input>
            </div>
            <div class="row">
              <text-input v-model="form.collector" required :error="form.errors.collector" label="Collector Name" />

              <select-input v-model="form.status" :error="form.errors.status" required label="Curent Customer status?">
                    <option :value="null" selected></option>
                    <option value="1">Active Customer</option>
                    <option value="2">Skip Tracing </option>
                    <option value="3">To Recall</option>
                    <option value="0">Inactive Customer</option>
              </select-input>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="flex items-center justify-end border-gray-100">
                  <loading-button :loading="form.processing" type="submit">Update
                    Customer</loading-button>
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
    partners: Array,
    customer: Array,
    installments: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.customer.name,
        employer: this.customer.employer,
        phone: this.customer.phone,
        address: this.customer.address,
        branch: this.customer.branch,
        collector: this.customer.collector,
        status: this.customer.status,
        user_id: this.customer.user_id,
        kinphone: this.customer.kinphone,
        nextkin: this.customer.nextkin,
        installment_id: this.customer.installment_id,
      }),
    }
  },
  methods: {
    store() {
      if (confirm('Are you sure you want to edit this customer?')) {
        this.form.post('/update/' + this.customer.uuid + '/edit')
      }
    },
  },
}

</script>
