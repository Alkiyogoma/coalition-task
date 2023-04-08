<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header p-0 position-relative  z-index-2">
          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-3">
            <span class="text-white text-capitalize ps-3">List of All Charts of Account</span>
            <Link :href="`/accounts`" style="float: right; margin-right: 4em;"
              class="mr-4 text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
              <span class="btn bg-gradient-dark mb-0"> <i class="material-icons text-lg me-2">layers</i>
              Account Groups</span>
            </Link>
            <Link :href="`/addaccount`" style="float: right; margin-right: 4em;"
              class="mr-4 text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
              <span class="btn btn-primary btn-sm bg-gradient-secondary"> <i class="material-icons text-sm">add</i>&nbsp;&nbsp; 
              Add Account</span>
            </Link>
           
          </div>
        </div>
        <div class="card-body">
          <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
          </search-filter>
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">S/N</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Group Name</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Code </th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Charts</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                </tr>
              </thead>
              <tbody v-if="!users.length">
                <tr v-for="user in users.data" :key="user.id">
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ user.id }}</span>
                  </td>
                  <td>
                    <h6 class="mb-0 text-sm">{{ user.name }}</h6>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ user.code }}</span>
                  </td>
                  <td class="align-middle">
                    <span class="text-secondary text-xs font-weight-bold">{{ user.type }}</span>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ user.groups }}</span>
                  </td>
                  <td class="align-middle">
                    <Link :href="`/accounts/${user.id}/view`" class="btn btn-outline-info btn-sm mb-0">View </Link>
                    <Link :href="`/accounts/${user.id}/delete`" class="btn btn-outline-primary btn-sm mb-0">Delete</Link>
                  </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400" v-if="users.data.length === 0">
                  <td class="px-2 py-2" colspan="4">No Customers found.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination :links="users.links" />

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
    users: Object,
    type: String,
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
        this.$inertia.get('/groups', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
