<template>
                <br>
                <!-- CTA -->
                <a
                  class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
                  href="/view-subjects"
                >
                  <div class="flex items-center">
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
                  <path
                    d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"
                  ></path>
                  <path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                    <span class="pl-4">Select Class Subjects</span>
                  </div>
                  <span> Defined Subjects &RightArrow;</span>
                </a>
    
                <!-- Responsive cards -->
             

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
      <Link class="px-3 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600" href="/subjects/create">
        <span>Create</span>
        <span class="hidden md:inline">&nbsp;subject</span>
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
            <th class="px-2 py-2">Sections</th>
            <th class="px-2 py-2">Teacher</th>
            <th class="px-2 py-2">Students</th>
            <th class="px-2 py-2">Order ID</th>
            <th class="px-2 py-2">Actions</th>
          </tr>
          </thead>
          <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
          <tr v-for="subject in subjects.data" :key="subject.id" class="text-gray-700 dark:text-gray-400">
            <td class="px-2 py-2">
              {{ subject.id }}
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
                    <p class="font-semibold"> {{ subject.name }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">
                      {{  subject.classlevel }}({{  subject.section }})
                    </p>
                  </div>
                </div>
              </td>
          
              <td class="px-2 py-2">
                {{ subject.sections }}
          </td>
          <td class="px-2 py-2">
            <Link class="flex items-center px-2 py-2 focus:text-indigo-500" :href="`/subjects/${subject.id}/view`">
              {{ subject.teacher }}
            </Link>
          </td>
          <td class="px-2 py-2">
            <Link class="flex items-center px-2 py-2 focus:text-indigo-500" :href="`/subjects/${subject.id}/view`">
              {{ subject.student }}
            </Link>
          </td>
          <td class="px-2 py-2">
            <Link class="flex items-center px-2 py-2" :href="`/subjects/${subject.id}/view`" tabindex="-1">
              {{ subject.numeric }}
            </Link>
          </td>
          <td class="px-2 py-2">
            <div class="flex items-center space-x-4 text-sm">
              <Link :href="`/subjects/${subject.id}/view`" tabindex="-1"
                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                    aria-label="View"
                  >
                <svg
                  class="w-5 h-3"
                  aria-hidden="true"
                  fill="none"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  viewBox="0 0 16 16"
                  stroke="currentColor"
                >
                  <path
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                  ></path>
                </svg>
                <span class="ml-2">Subjects</span>
              </Link>
              </div>
          </td>
        </tr>
        
        <tr  class="text-gray-700 dark:text-gray-400" v-if="subjects.data.length === 0">
          <td class="px-2 py-2" colspan="4">No subjects found.</td>
        </tr>
      </tbody>
      </table>
      <br> <hr>
    </div>
    <pagination class="mt-6" :links="subjects.links" />
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
    subjects: Object,
    all_subjects: Array
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
        this.$inertia.get('/subjects', pickBy(this.form), { preserveState: true })
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
