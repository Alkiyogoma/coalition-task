<template>
    <br>
    <!-- CTA -->
    <a
      class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
      href="/addusage/purchase"
    >
      <div class="flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
          <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0118 9.375v9.375a3 3 0 003-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 00-.673-.05A3 3 0 0015 1.5h-1.5a3 3 0 00-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6zM13.5 3A1.5 1.5 0 0012 4.5h4.5A1.5 1.5 0 0015 3h-1.5z" clip-rule="evenodd" />
          <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 013 20.625V9.375zm9.586 4.594a.75.75 0 00-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 00-1.06 1.06l1.5 1.5a.75.75 0 001.116-.062l3-3.75z" clip-rule="evenodd" />
        </svg>
  
        <span class="ml-3">History of {{ product }} Added List</span>
      </div>
      <span class="mr-3"> New Item  &RightArrow;</span>
    </a>
  
  <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
  <div class="flex items-center justify-between mb-6">
    <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
      <label class="block text-gray-700">Trashed:</label>
      <select v-model="form.trashed" class="form-select mt-1 w-full">
        <option :value="null" />
        <option value="with">With Trashed</option>
        <option value="only">Only Trashed</option>
      </select>
    </search-filter>
  </div>
  <div class="grid gap-6 mb-8  xl:grid-cols-12">
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
  
      <table class="w-full whitespace-no-wrap" v-if="!items.length">
        <thead>
          <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
            <th class="px-2 py-2">S/N</th>
            <th class="px-2 py-2">Added By</th>
            <th class="px-2 py-2">From</th>
            <th class="px-2 py-2">Amount</th>
            <th class="px-2 py-2">Items</th>
            <th class="px-2 py-2">Quanity</th>
            <th class="px-2 py-2" align="left">Actions</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
        <tr v-for="item in items.data" :key="item.id" class="text-gray-700 dark:text-gray-400">
          <td class="px-2 py-2">
            {{ item.reference }}
        </td>
          <td class="px-2 py-2">              
            <div>
                  <p class="font-semibold"> {{ item.name }}</p>
                  <p class="text-xs text-gray-600 dark:text-gray-400">
                    {{  item.date }}
                  </p>
                </div>
            </td>
        <td class="px-2 py-2">
          {{ item.vendor }}
        </td>
        <td class="px-2 py-2">
          {{ item.amount }}
        </td>
        
        <td class="px-2 py-2">
            {{ item.total }}
        </td>
        
        <td class="px-2 py-2">
              {{ item.used }}
        </td>
  
        <td class="px-2 py-2">
          <div class="flex items-center space-x-4 text-sm">
            <Link :href="`/viewstore/${item.uuid}/purchase`" tabindex="-1" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="View">
              <svg
                    class="w-5 h-5"
                    aria-hidden="true"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                  </svg>
            </Link>
            
                <Link :href="`/deletestore/${item.uuid}/delete`" tabindex="-1"
                  class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                  aria-label="Delete" onclick="confirm('Are you sure you want to delete this class?')"
                >
                  <svg
                    class="w-5 h-5"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </Link>
            </div>
        </td>
      </tr>
      
      <tr  class="text-gray-700 dark:text-gray-400" v-if="items.data.length === 0">
        <td class="px-2 py-2" colspan="4">No classes found.</td>
      </tr>
    </tbody>
    </table>
  </div>
  <pagination class="mt-6" :links="items.links" />
  </div>
  </div>
  </div>
  </template>
  
  <script>
  import { Head, Link } from '@inertiajs/inertia-vue3'
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
      items: Object,
      product: String,
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
          this.$inertia.get('/purchase', pickBy(this.form), { preserveState: true })
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
  