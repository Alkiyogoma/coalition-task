<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header p-0 position-relative  z-index-2">
          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-3">
            <span class="text-white text-capitalize ps-3">Company expenses Transactions</span>
            <Link :href="`/expenseadd`" style="float: right; margin-right: 4em;"
              class="mr-4 text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit expense">
              <span class="btn btn-primary btn-sm bg-gradient-secondary"> <i class="material-icons text-sm">add</i>&nbsp;&nbsp; 
              Add expense</span>
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
              <tbody v-if="!expenses.length">
                <tr v-for="expense in expenses.data" :key="expense.id">
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ expense.id }}</span>
                  </td>
                  <td>
                    <h6 class="mb-0 text-sm">{{ expense.account }}</h6>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ expense.amount }}</span>
                  </td>
                  <td class="align-middle">
                    <span class="text-secondary text-xs font-weight-bold">{{ expense.reference }}</span>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ expense.date }}</span>
                  </td>
                  
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ expense.name }}</span>
                  </td>
                  <td class="align-middle">

                    <Link :href="`/voucher/${expense.uuid}/view`" class="text-secondary font-weight-bold">
                        <span class="badge badge-sm bg-gradient-info">voucher</span>
                    </Link>
                    <Link :href="`/expenseedit/${ expense.uuid }/edit`" class="text-secondary font-weight-bold" data-toggle="tooltip" data-original-title="Edit user">
                          <span class="badge badge-sm bg-gradient-secondary"> Edit </span>
                    </Link>
                    <Link :href="`/expensedelete/${expense.uuid}/delete`" class="text-secondary font-weight-bold">
                        <span class="badge badge-sm bg-gradient-success">Delete</span>
                    </Link>
                  </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400" v-if="expenses.data.length === 0">
                  <td class="px-2 py-2" colspan="4">No Transactions found.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination :links="expenses.links" />

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
    expenses: Object,
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
        this.$inertia.get('/expenses', pickBy(this.form), { preserveState: true })
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
