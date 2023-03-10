<template>

      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-3">
                <a class="text-white text-capitalize ps-3">List of All Compy Staffs</a>
                <a href="/add-user" style="float: right; margin-right: 4em;" class="mr-4 text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                  <span class="btn btn-primary btn-sm bg-gradient-secondary"> <i class="material-icons text-lg me-2">person</i> Add Staff</span>
                </a>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsivdde p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">S/N</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fullname</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phone</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Department</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                      <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Birth</th> -->
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employed</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody v-if="!users.length">
                    <tr  v-for="user in users.data" :key="user.id">
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ user.id }}</span>
                      </td>
                      <td>
                            <h6 class="mb-0 text-sm">{{ user.name }}</h6>
                      </td>
                      
                      <td class="align-middle">
                        <span class="text-secondary text-xs font-weight-bold">{{ user.email }}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ user.phone }}</span>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{ user.department }}</p>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ user.role }}</span>
                      </td>
                      <!-- <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ user.dob }}</span>
                      </td> -->
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ user.jod }}</span>
                      </td>
                        <td class="align-middle">
                        <Link :href="`/profile/${user.uuid}`" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          <span class="badge badge-sm bg-gradient-success">View</span>
                        </Link>
                        <Link :href="`/clients/user/${user.id}`"  class="ml-3 text-info font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          <span class="badge badge-sm bg-gradient-info">Clients</span>
                        </Link>
                        <a href="javascript:;" class="ml-3 text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          <span class="badge badge-sm bg-gradient-secondary">Edit</span>
                        </a>
                        <!-- <a href="javascript:;" class="ml-4 text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          <span class="badge badge-sm bg-gradient-secondary">Delete</span>
                        </a> -->
                      </td>
                    </tr>
                 
                
                  </tbody>
                </table>
              </div>
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
  // data() {
  //   return {
  //     form: {
  //       search: this.filters.search,
  //       trashed: this.filters.trashed,
  //     },
  //   }
  // },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/contacts', pickBy(this.form), { preserveState: true })
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
