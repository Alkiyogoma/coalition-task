<template>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-3">
                <a class="text-white text-capitalize ps-3">List of All Compy Clients</a>
                <a href="/add-customer" style="float: right; margin-right: 4em;" class="mr-4 text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                  <span class="btn btn-primary btn-sm bg-gradient-secondary"><i class="material-icons text-lg me-2">person_add</i> Add Clients</span>
                </a>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
                <!-- <label class="block text-gray-700">Trashed:</label>
                <select v-model="form.trashed" class="form-select mt-1 w-full">
                  <option :value="null" />
                  <option value="with">With Trashed</option>
                  <option value="only">Only Trashed</option>
                </select> -->
              </search-filter>
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">S/N</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                      <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employer</th> -->
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Account number</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Contacts</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Branch</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Balance</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Received</th>
                      <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Reason Code</th> -->
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Collector</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody v-if="!users.length">
                    <tr  v-for="user in users.data" :key="user.id">
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ user.id }}</span>
                      </td>
                      <td>
                        <Link :href="`/client/${user.uuid}/view`" class="text-secondary font-weight-bold  " data-toggle="tooltip" data-original-title="Edit user">
                             <h6 class="mb-0 text-sm">{{ user.name }}</h6>
                        </Link>
                      </td>
                      <td class="align-middle bg-dark text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ user.account }}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ user.phone }}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ user.branch }}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ money(user.amount) }}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ money(user.paid) }}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ user.collector }}</span>
                      </td>
                        <td class="align-middle">
                          <Link :href="`/client/${user.uuid}/view`" class="text-secondary font-weight-bold  " data-toggle="tooltip" data-original-title="Edit user">
                          <span class="btn btn-outline-primary btn-sm mb-0">Profile</span>
                        </Link>
                        
                      </td>
                    </tr>
                 
                
        <tr  class="text-gray-700 dark:text-gray-400" v-if="users.data.length === 0">
          <td class="px-2 py-2" colspan="4">No Clients found.</td>
        </tr>
                  </tbody>
                </table>
              </div>
              <pagination class="mt-1" :links="users.links" />

            </div>
          </div>
        </div>
      </div>
      
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import SearchFilter from '../../Shared/SearchFilter'
import Pagination from '../../Shared/Pagination'
import Icon from '../../Shared/Icon'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    SearchFilter,
  },
  props: {
    filters: Object,
    groups: Array,
    users: Object,
    total_student : Number
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/clients', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
    money: function(value) {
          let val = (value/1).toFixed(2).replace(',', '.')
          return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      }
  },
}
</script>
