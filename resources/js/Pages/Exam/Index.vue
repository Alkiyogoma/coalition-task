<template>

    <!-- With avatar -->
    <h4
      class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300"
    >
      Table with avatars
    </h4>
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
      <Link class="px-3 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600" href="/contacts/create">
        <span>Create</span>
        <span class="hidden md:inline">&nbsp;Contact</span>
      </Link>
    </div>
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
      <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
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
            <Link class="flex items-center px-2 py-2 focus:text-indigo-500" :href="`/contacts/${contact.id}/view`">
              {{ contact.dob }}
            </Link>
          </td>
          <td class="px-2 py-2">
            <Link class="flex items-center px-2 py-2 focus:text-indigo-500" :href="`/contacts/${contact.id}/view`">
              {{ contact.roll }}
            </Link>
          </td>
          <td class="px-2 py-2">
            <Link class="flex items-center px-2 py-2" :href="`/contacts/${contact.id}/view`" tabindex="-1">
              {{ contact.phone }}
            </Link>
          </td>
          <td class="px-2 py-2">
            <div class="flex items-center space-x-4 text-sm">
                  <Link class="flex items-center px-4" :href="`/contacts/${contact.id}/view`" tabindex="-1">
                  <icon name="cheveron-right" fill="currentColor" class="block w-6 h-6 fill-gray-400" />
                </Link>
                  <Link :href="`/contacts/${contact.id}/edit`" tabindex="-1"
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
                  <Link :href="`/contacts/${contact.id}/delete`" tabindex="-1"
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
