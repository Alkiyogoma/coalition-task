<template>
   
            <br>
            <!-- CTA -->
            <a
              class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
              href="/contacts/create"
            >
              <div class="flex items-center">
                <svg
                  class="w-5 h-5 mr-2"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                >
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                  ></path>
                </svg>
                <span>List of {{ type }} School Students</span>
              </div>
              <span> Add Student &RightArrow;</span>
            </a>
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"
                    ></path>
                  </svg>
                </div>
                <Link class="focus:text-indigo-500" href="/students">
                <div>
                  <p
                    class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                  >
                    Active
                  </p>
                  <p
                    class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                  >
                    {{ total_student }}
                  </p>
                </div>
                </Link>
              </div>
              <div  v-for="classlevel in levels" :key="levels.id">
              <!-- Card -->
              <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      fill-rule="evenodd"
                      d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
                <Link class="focus:text-indigo-500" :href="`/students/${classlevel.id}/${classlevel.name}`">
                <div>
                  <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    {{ classlevel.name }}
                  </p>
                  <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ classlevel.student }}
                  </p>
                </div>
              </Link>
              </div>
            </div>
            
              <!-- Card -->
              <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <div
                  class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      fill-rule="evenodd"
                      d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </div>
                <Link class="focus:text-indigo-500" href="/students">
                  <div>
                    <p
                      class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                    >
                      Inactive
                    </p>
                    <p
                      class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                    >
                      35
                    </p>
                  </div>
                </Link>
              </div>
            </div>

      
  <div class="grid gap-1 mb-8  xl:grid-cols-12">
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <a class="px-3 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600" href="/contacts/create">
        <span>Create</span>
      </a>
    </div>
    <div class="px-2 py-2 mb-8 bg-white w-full overflow-hidden rounded-lg shadow-xs dark:bg-gray-800">
      <!-- <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs"> -->
    <div class="w-full overflow-x-auto">
  
      <table class="w-full whitespace-no-wrap table">
          <thead>
            <tr
              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
            >
            <th class="px-2 py-2">S/N</th>
            <th class="px-2 py-2">Name</th>
            <th class="px-2 py-2">Sex</th>
            <th class="px-2 py-2">Date of Birth</th>
            <th class="px-2 py-2">Number</th>
            <th class="px-2 py-2">Parent Phone</th>
            <th class="px-2 py-2">Actions</th>
          </tr>
          </thead>
          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
          <tr v-for="contact in contacts.data" :key="contact.id" class="text-gray-700 dark:text-gray-400">
            <td class="px-2 py-2">
              {{ contact.id }}
          </td>
            <td class="px-2 py-2">
                <div class="flex items-center text-sm">
                  <!-- Avatar with inset shadow -->
                  <div
                    class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                  >
                
                    <img
                      class="object-cover w-full h-full rounded-full"
                      src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjE3Nzg0fQ"
                      alt=""
                      loading="lazy"
                    />
                    <div
                      class="absolute inset-0 rounded-full shadow-inner"
                      aria-hidden="true"
                    ></div>
                  </div>
                  <div>
                    <p class="font-semibold"> {{ contact.name }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">
                      {{  contact.classes }}({{  contact.section }})
                    </p>
                  </div>
                </div>
              </td>
          
              <td class="px-2 py-2">
                {{ contact.sex }}
          </td>
          <td class="px-2 py-2">
            <Link class="flex items-center px-2 py-2 focus:text-indigo-500" :href="`/contacts/${contact.uuid}/view`">
              {{ contact.dob }}
            </Link>
          </td>
          <td class="px-2 py-2">
            <Link class="flex items-center px-2 py-2 focus:text-indigo-500" :href="`/contacts/${contact.uuid}/view`">
              {{ contact.roll }}
            </Link>
          </td>
          <td class="px-2 py-2">
            <Link class="flex items-center px-2 py-2" :href="`/contacts/${contact.uuid}/view`" tabindex="-1">
              {{ contact.phone }}
            </Link>
          </td>
          <td class="px-2 py-2">
            <div class="flex items-center space-x-4 text-sm">
                  <Link class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" :href="`/contacts/${contact.uuid}/view`" tabindex="-1">
                  <!-- <icon name="cheveron-right" fill="currentColor" class="block w-6 h-6 fill-gray-400" /> -->
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                  <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" /> Profile
                </svg>
                </Link>
                  <Link :href="`/contacts/${contact.uuid}/edit`" tabindex="-1"
                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                    aria-label="Edit"
                  >
                    <svg
                      class="w-5 h-5"
                      aria-hidden="true"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                      ></path>
                    </svg>
                  </Link>
                  <Link :href="`/contacts/${contact.uuid}/delete`" tabindex="-1"
                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                    aria-label="Delete"
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
        
        <tr  class="text-gray-700 dark:text-gray-400" v-if="contacts.data.length === 0">
          <td class="px-2 py-2" colspan="4">No contacts found.</td>
        </tr>
      </tbody>
      </table>
      </div>
    <pagination class="mt-6" :links="contacts.links" />
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
    contacts: Object,
    levels: Object,
    total_student: Number,
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
