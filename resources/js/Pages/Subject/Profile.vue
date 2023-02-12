<template>
                <br>
                <!-- CTA -->
                <a
                  class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
                  href="/subjects"
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
                    <span class="pl-4">{{ classes.classes }} Subjects</span>
                  </div>
                  <span>Go Back &RightArrow;</span>
                </a>
    
                <!-- Responsive cards -->
               
          <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
              <h4 class="mb-1 ml-4 py-4 font-semibold text-gray-600 dark:text-gray-300">
                List of {{ classes.classes }} Subjects
                </h4>
                <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                                >
                                <th class="px-2 py-2">S/N</th>
                                <th class="px-2 py-2">Subject</th>
                                <th class="px-2 py-2">Code</th>
                                <th class="px-2 py-2"> Type</th>
                                <th class="px-2 py-2">Teacher</th>
                                <th class="px-2 py-2">Is Counted</th>
                                <th class="px-2 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody
                                class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                            >
                              <tr  v-for="exam in subjects.data" :key="exam.id" class="text-gray-700 dark:text-gray-400">
                                <td class="px-2 py-2 text-sm">
                                    {{ exam.id }}
                                </td>
                                <td class="px-2 py-2">
                                    <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold">{{ exam.name }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ exam.subject_type }}
                                        </p>
                                    </div>
                                    </div>
                                </td>
                                <td class="px-2 py-2 text-sm">
                                    {{ exam.code }}
                                </td>
                                <td class="px-2 py-2 text-xs">
                                    <span
                                    class="px-2 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                                    >
                                    {{ exam.subject_type }}
                                    </span>
                                </td>
                                <td class="px-2 py-2 text-sm">
                                    {{ exam.teacher }}
                                </td>
                                
                                <td class="px-2 py-2 text-sm">
                                  <span class="px-2 py-2 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">
                                    {{ exam.counted }}
                                  </span>
                                </td>
                                <td class="px-2 py-2 text-sm">
                                <Link :href="`/subjects/${exam.subject_id}/edit`" tabindex="-1"
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
                                </td>
                                </tr>

                            </tbody>
                            </table>
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
    subjects: Object,
    classes: Array,
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
