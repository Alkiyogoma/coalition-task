<template>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 pb-3">
                <a class="text-white text-capitalize ps-3">List of Bank Partners</a>
                <Link :href="`/add-partner`" style="float: right; margin-right: 4em;" class="mr-4 text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                  <span class="btn btn-primary btn-sm bg-gradient-secondary"> <i class="material-icons text-lg me-2">person_add</i> Add Partner</span>
                </Link>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">S/N</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Group</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Contacts</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> Phone</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customers</th>
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
                      
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ user.group }}</span>
                      </td>
                      
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ user.clients }}</span>
                      </td>
                      
                      <td class="align-middle text-center">
                        <Link :href="`/clients/partner/${ user.id }`" class="text-white font-weight-bold  " data-toggle="tooltip" data-original-title="Edit user">
                          <span class="btn btn-outline-success btn-sm mb-0">customers</span>
                        </Link>
                      </td>
                      
                      <td class="align-middle text-center">
                        <Link :href="`/collectors/${ user.uuid }/bank`" class="text-white font-weight-bold  " data-toggle="tooltip" data-original-title="Edit user">
                          <span class="btn btn-outline-success btn-sm mb-0">Staffs</span>
                        </Link>
                      </td>
                        <td class="align-middle">
                        <Link :href="`/collections/${ user.id }/partner`" class="text-secondary font-weight-bold" data-toggle="tooltip" data-original-title="Edit user">
                          <span class="btn btn-outline-info btn-sm mb-0">Collections</span>
                        </Link>
                        <!-- 
                        <a href="javascript:;" class="ml-4 text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                          <span class="badge badge-sm bg-gradient-secondary">Delete</span>
                        </a> -->
                      </td>
                      
                      <td class="align-middle text-center">
                        <a :href="`/bank/${ user.uuid }/edit`" class="text-secondary font-weight-bold" data-toggle="tooltip" data-original-title="Edit user">
                          <span class="btn btn-outline-primary btn-sm mb-0">Edit</span>
                        </a>
                      </td>
                    </tr>
                 
                
        <tr  class="text-gray-700 dark:text-gray-400" v-if="users.data.length === 0">
          <td class="px-2 py-2" colspan="4">No Banks found.</td>
        </tr>
                  </tbody>
                </table>
              </div>
              <pagination class="mt-2" :links="users.links" />

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
  },
}
</script>
