<template>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-3">
            <a class="text-white text-capitalize ps-3">List of All Compy Clients</a>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">

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
                <tr v-for="user in users.data" :key="user.id">
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ user.id }}</span>
                  </td>
                  <td>
                    <Link :href="`/client/${user.uuid}/view`" class="text-secondary font-weight-bold  "
                      data-toggle="tooltip" data-original-title="Edit user">
                    <h6 class="mb-0 text-sm">{{ user.name }}</h6>
                    </Link>
                  </td>

                  <!-- <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ user.employer }}</span>
                  </td> -->
                  <td class="align-middle text-center">
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
                  <!-- <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ user.code }}</span>
                  </td> -->
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ user.collector }}</span>
                  </td>
                  <td class="align-middle">
                    <Link :href="`/client/${user.uuid}/view`" class="text-secondary font-weight-bold  "
                      data-toggle="tooltip" data-original-title="Edit user">
                    <span class="btn btn-outline-primary btn-sm mb-0">Profile</span>
                    </Link>
                    <!-- <a href="javascript:;" class="ml-3 text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                      <span class="badge badge-sm bg-gradient-primary">Edit</span>
                    </a>
                    <a href="javascript:;" class="ml-4 text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                      <span class="badge badge-sm bg-gradient-secondary">Delete</span>
                    </a> -->
                  </td>
                </tr>


                <tr class="text-gray-700 dark:text-gray-400" v-if="users.data.length === 0">
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

  <div class="row mt-4">
    <div class="col-sm-6">
      <div class="card mt-4">
        <div class="card-header pb-0 p-3">
          <h6 class="mb-0">Bank Customers Summary</h6>
        </div>
        <div class="card-body p-3">
          <ul class="list-group">
            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
              <div class="d-flex align-items-center">
                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                  <i class="material-icons opacity-10">launch</i>
                </div>
                <div class="d-flex flex-column">
                  <h6 class="mb-1 text-dark text-sm">Total accounts</h6>
                  <span class="font-weight-bold">Account Portifolio</span>
                </div>
              </div>
              <div class="d-flex"> 
                  {{ clients }}
              </div>
            </li>
            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
              <div class="d-flex align-items-center">
                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                  <i class="material-icons opacity-10">book_online</i>
                </div>
                <div class="d-flex flex-column">
                  <h6 class="mb-1 text-dark text-sm">Scanned accounts</h6>
                  <span class="text-xs">Reached Accounts</span>
                </div>
              </div>
              <div class="d-flex">
                  {{ reached }}
              </div>
            </li>
            <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
              <div class="d-flex align-items-center">
                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                  <i class="material-icons opacity-10">priority_high</i>
                </div>
                <div class="d-flex flex-column">
                  <h6 class="mb-1 text-dark text-sm">Pending accounts</h6>
                  <span class="font-weight-bold">Not Scanned account</span>
                </div>
              </div>
              <div class="d-flex">
                  {{ pending }}
              </div>
            </li>
            
            <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
              <div class="d-flex align-items-center">
                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                  <i class="material-icons opacity-10">payments</i>
                </div>
                <div class="d-flex flex-column">
                  <h6 class="mb-1 text-dark text-sm">Active accounts</h6>
                  <span class="font-weight-bold">Active Phone Numbers</span>
                </div>
              </div>
              <div class="d-flex">
                  {{ active }}
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-sm-6 mt-sm-0 mt-4">
      <div class="card h-100">
        <div class="card-header pb-0 p-3">
          <div class="row">
            <div class="col-md-6">
              <h6 class="mb-0">Skip Tracing Summary </h6>
            </div>
            <div class="col-md-6 d-flex justify-content-end align-items-center">
              <i class="material-icons me-2 text-lg">global_search</i>
              <small>View</small>
            </div>
          </div>
        </div>
        <div class="card-body p-3">
          <ul class="list-group">
            <li class="list-group-item border-0 justify-content-between ps-0 pb-0 border-radius-lg">
              <div class="d-flex">
                <div class="d-flex align-items-center">
                  <button
                    class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i
                      class="material-icons text-lg">label_important</i></button>
                  <div class="d-flex flex-column">
                    <h6 class="mb-1 text-dark text-sm">Total accounts </h6>
                  </div>
                </div>
                <div class="d-flex mr-3 align-items-center text-success text-gradient text-sm font-weight-bold ms-auto">
                  {{ skip }}
                </div>
              </div>
              <hr class="horizontal dark mt-3 mb-2" />
            </li>
            <li class="list-group-item border-0 justify-content-between ps-0 pb-0 border-radius-lg">
              <div class="d-flex">
                <div class="d-flex align-items-center">
                  <button
                    class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i
                      class="material-icons text-lg">label_important</i></button>
                  <div class="d-flex flex-column">
                    <h6 class="mb-1 text-dark text-sm">Recovered accounts </h6>
                  </div>
                </div>
                <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold ms-auto">
                  {{ skip }}
                </div>
              </div>
              <hr class="horizontal dark mt-3 mb-2" />
            </li>
            <li class="list-group-item border-0 justify-content-between ps-0 pb-0 border-radius-lg">
              <div class="d-flex">
                <div class="d-flex align-items-center">
                  <button
                    class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i
                      class="material-icons text-lg">label_important</i></button>
                  <div class="d-flex flex-column">
                    <h6 class="mb-1 text-dark text-sm">Unrecovered accounts </h6>
                  </div>
                </div>
                
                <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold ms-auto">
                  {{ inactive }}
                </div>
              </div>
              <hr class="horizontal dark mt-3 mb-2" />
            </li>
            <li class="list-group-item border-0 justify-content-between ps-0 pb-0 border-radius-lg">
              <div class="d-flex">
                <div class="d-flex align-items-center">
                  <button
                    class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i
                      class="material-icons text-lg">label_important</i></button>
                  <div class="d-flex flex-column">
                    <h6 class="mb-1 text-dark text-sm">Inactive accounts </h6>
                  </div>
                </div>
                <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold ms-auto">
                 {{ inactive }}
                </div>
              </div>
              <hr class="horizontal dark mt-3 mb-2" />
            </li>
            
          </ul>
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
    clients: String,
    active: String,
    pending: String,
    reached: String,
    skip: String,
    inactive: String,
    amount: String,
    total: String,
    users: Object,
    total_student: Number
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
    money: function (value) {
      let val = (value / 1).toFixed(2).replace(',', '.')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }
  },
}
</script>
