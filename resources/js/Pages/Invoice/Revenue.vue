<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header p-0 position-relative  z-index-2">
          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-3">
            <span class="text-white text-capitalize ps-3">Company Revenues Transactions</span>
            <Link :href="`/revenueadd`" style="float: right; margin-right: 4em;"
              class="mr-4 text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit revenue">
              <span class="btn btn-primary btn-sm bg-gradient-secondary"> <i class="material-icons text-sm">add</i>&nbsp;&nbsp; 
              Add Revenue</span>
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
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount </th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Reference</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Receiver</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                </tr>
              </thead>
              <tbody v-if="!revenues.length">
                <tr v-for="revenue in revenues.data" :key="revenue.id">
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ revenue.id }}</span>
                  </td>
                  <td>
                    <h6 class="mb-0 text-sm">{{ revenue.account }}</h6>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ revenue.amount }}</span>
                  </td>
                  <td class="align-middle">
                    <span class="text-secondary text-xs font-weight-bold">{{ revenue.reference }}</span>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ revenue.date }}</span>
                  </td>
                  
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ revenue.name }}</span>
                  </td>
                  <td class="align-middle">
                    
                    <Link :href="`/receipt/${revenue.uuid}/view`" class="text-secondary font-weight-bold">
                        <span class="badge badge-sm bg-gradient-info">Receipt</span>
                    </Link>
                    <Link :href="`/revenueedit/${ revenue.uuid }/edit`" class="text-secondary font-weight-bold" data-toggle="tooltip" data-original-title="Edit user">
                          <span class="badge badge-sm bg-gradient-secondary"> Edit </span>
                    </Link>
                    <Link :href="`/revenuedelete/${revenue.uuid}/delete`" class="text-secondary font-weight-bold">
                        <span class="badge badge-sm bg-gradient-success">Delete</span>
                    </Link>
                  </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400" v-if="revenues.data.length === 0">
                  <td class="px-2 py-2" colspan="4">No Revenues Transaction found.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination :links="revenues.links" />

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
    revenues: Object,
    from_date: String,
    to_date: String,
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
        this.$inertia.get('/revenues', pickBy(this.form), { preserveState: true })
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
