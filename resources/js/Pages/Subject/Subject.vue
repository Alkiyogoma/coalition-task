<template>
                <br>
                <!-- CTA -->
                <Link
                  class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
                  href="/addsubject"
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
                    <span class="pl-4">List of School Subjects</span>
                  </div>
                  <span>Add Subject &RightArrow;</span>
                </Link>
    
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">

        <br>
        <hr>

        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-2 py-2">S/N</th>
                        <th class="px-2 py-2">Subject</th>
                        <th class="px-2 py-2">code</th>
                        <th class="px-2 py-2">Classes</th>
                        <th class="px-2 py-2">arrangement</th>
                        <th class="px-2 py-2">Take Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <tr v-for="subject in all_subjects" :key="subject.id"
                        class="text-gray-700 dark:text-gray-400">
                        <td class="px-2 py-2 text-sm">
                            {{ subject.id }}
                        </td>
                    
                        <td class="px-2 py-2">
                            <div class="flex items-center text-sm">
                                <div>
                                    <p class="font-semibold">{{ subject.name }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ subject.subject_type }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-2 text-sm">
                            {{ subject.code }}
                        </td>
                        
                        <td class="px-2 py-2 text-xs">
                            <span
                                class="px-2 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                {{ subject.classes }}
                            </span>
                        </td>
                        <td class="px-2 py-2 text-xs">
                            <span
                                class="px-2 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                {{ subject.arrangement }}
                            </span>
                        </td>
                        <td class="px-2 py-2 text-xs">
                            <div v-if="subject.delete == 1" class="flex items-center space-x-4 text-sm">
                                <Link :href="`/deletesubject/${subject.uuid}/delete`" tabindex="-1"
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
                                        fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd"
                                    ></path>
                                    </svg>
                                    <span class="ml-2">Delete</span>
                                </Link>
                                </div>
                        </td>
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
    } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            Link,Head
        },
        props: {
            all_subjects: Array
        }
    }

</script>
