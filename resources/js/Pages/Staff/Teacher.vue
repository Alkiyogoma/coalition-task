<template>
    <br>
    <!-- CTA -->
    <a id="topheader" class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
        :href="`/contacts/${contact.uuid}/edit`">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                </path>
            </svg>
            <span> {{ contact.name }} Profile</span>
        </div>
        <span>Edit Profile &RightArrow;</span>
    </a>

    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                Teacher Profile
            </h4>
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-2 py-2">Parent Name</th>
                            <th class="px-2 py-2"> {{ contact.name }}</th>
                            <th class="px-2 py-2"> Sex</th>
                            <th class="px-2 py-2"> {{ contact.sex }}</th>
                        </tr>

                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-2 py-2">Phone</th>
                            <th class="px-2 py-2"> {{ contact.phone }}</th>
                            <th class="px-2 py-2">Address</th>
                            <th class="px-2 py-2"> {{ contact.address }}</th>
                        </tr>


                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-2 py-2"> Email</th>
                            <th class="px-2 py-2"> {{ contact.email }}</th>
                            <th class="px-2 py-2">Login Code</th>
                            <th class="px-2 py-2"> {{ contact.login_code }}</th>
                        </tr>

                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div v-if="subjects.length" class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
            Teaching Subjects
        </h4>
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-2 py-2">Subject</th>
                        <th class="px-2 py-2">Class</th>
                        <th class="px-2 py-2">Type</th>
                        <th class="px-2 py-2">IS Counted</th>
                        <th class="px-2 py-2">Results</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <tr v-for="exam in subjects" :key="exam.subject_id" class="text-gray-700 dark:text-gray-400">
                        <td class="px-2 py-2">
                            <div class="flex items-center text-sm">
                                <div>
                                    <p class="font-semibold">{{ exam.subject }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-2 text-sm">
                            {{ exam.class }}
                        </td>
                        <td class="px-2 py-2 text-xs">
                            <span
                                class="px-2 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                {{ exam.subject_type }}
                            </span>
                        </td>
                        <td class="px-2 py-2 text-xs">
                            <span class="px-2 py-2 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700">
                                {{ exam.status }}
                            </span>
                        </td>
                            <td class="px-2 py-2 text-xs">
                                <div class="flex items-center space-x-4 text-sm">
              <Link :href="`/subjects/${exam.id}/view`" tabindex="-1"
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
                <span class="ml-2">Results</span>
              </Link>
              </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    <div v-if="students.length" class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
        <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
            Student Profiles
        </h4>
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-2 py-2">Student</th>
                        <th class="px-2 py-2">Class</th>
                        <th class="px-2 py-2">Section</th>
                        <th class="px-2 py-2">Birth</th>
                        <th class="px-2 py-2">Reg No</th>
                        <th class="px-2 py-2">View</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <tr v-for="exam in students" :key="exam.subject_id" class="text-gray-700 dark:text-gray-400">
                        <td class="px-2 py-2">
                            <div class="flex items-center text-sm">
                                <div>
                                    <p class="font-semibold">{{ exam.name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-2 text-sm">
                            {{ exam.classes }}
                        </td>

                        <td class="px-2 py-2 text-sm">
                            {{ exam.section }}
                        </td>

                        <td class="px-2 py-2 text-sm">
                            {{ exam.dob }}
                        </td>
                        <td class="px-2 py-2 text-xs">
                            <span
                                class="px-2 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                {{ exam.roll }}
                            </span>
                        </td>
                        <td>
                            <Link :href="`/contacts/${exam.uuid}/view`" tabindex="-1"
                                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                aria-label="View">
                            <icon name="user" fill="currentColor" class="block w-6 h-6 fill-gray-400" />
                            View
                            </Link>
                        </td>

                    </tr>

                </tbody>
            </table>

            <table v-if="exams.length" class="table table-striped">
                <thead>
                    <tr>
                        <th class="col-sm-1">#</th>
                        <th class="col-sm-2">Exam Name</th>
                        <th class="col-sm-1">Subject Name</th>
                        <th class="col-sm-1">Class Name</th>
                        <th class="col-sm-1">Year</th>
                        <th class="col-sm-1">Max score</th>
                        <th class="col-sm-1">Min Score</th>
                        <th class="col-sm-1">Average</th>
                        <th class="col-sm-1">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="subject_average in exams">
                        <td>{{ $i }}</td>
                        <td>{{ $subject_average.exam }}</td>
                        <td>{{  $subject_average.subject_name }}</td>
                        <td>{{  $subject_average.classes }}</td>
                        <td>{{  $subject_average.academic_year }}</td>
                        <td>{{ $subject_average.max }}</td>
                        <td>{{ $subject_average.min }}</td>
                        <td>{{ round($subject_average.avg, 1) }}</td>
                        <td> <a href="`/dashboard/teacher/${subject_average.subjectID/$teacher_info.teacherID/$subject_average.examID`"
                                class="btn btn-success btn-sm">View</a> </td>
                    </tr>

                </tbody>
            </table>

        </div>
    </div>

</template>

<script>
    import {
        Head,
        Link
    } from '@inertiajs/vue3'
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
            contact: Object,
            students: Array,
            exams: Array,
            subjects: Array
        },
        watch: {
            form: {
                deep: true,
                handler: throttle(function () {
                    this.$inertia.get('/contacts', pickBy(this.form), {
                        preserveState: true
                    })
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
