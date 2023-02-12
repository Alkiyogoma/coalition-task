<template>
                <br>
                <!-- CTA -->
                <a
                  class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
                  :href="`/contacts/${contact.uuid}/edit`"
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
                    <span>  {{ contact.name }} Profile</span>
                  </div>
                  <span>Edit Profile &RightArrow;</span>
                </a>
                
                <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4"  v-if="new_invoice">
                  <!-- Card -->
                  <div
                    class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
                  >
                    <div
                      class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500"
                    >
                      
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path  fill-rule="evenodd" d="M4.423,9.141H3.565c-0.237,0-0.429,0.192-0.429,0.429s0.192,0.429,0.429,0.429h0.858c0.237,0,0.429-0.192,0.429-0.429S4.66,9.141,4.423,9.141 M6.997,16.861H6.139c-0.237,0-0.429,0.192-0.429,0.43s0.192,0.429,0.429,0.429h0.858c0.237,0,0.429-0.191,0.429-0.429S7.234,16.861,6.997,16.861 M4.423,16.861H3.565c-0.237,0-0.429,0.192-0.429,0.43s0.192,0.429,0.429,0.429h0.858c0.237,0,0.429-0.191,0.429-0.429S4.66,16.861,4.423,16.861M13.861,9.998h0.857c0.236,0,0.429-0.192,0.429-0.429s-0.192-0.429-0.429-0.429h-0.857c-0.237,0-0.43,0.192-0.43,0.429S13.624,9.998,13.861,9.998 M14.719,16.861h-0.857c-0.237,0-0.43,0.192-0.43,0.43s0.192,0.429,0.43,0.429h0.857c0.236,0,0.429-0.191,0.429-0.429S14.955,16.861,14.719,16.861 M15.576,13.001c-0.236,0-0.429,0.192-0.429,0.43c0,0.236,0.192,0.429,0.429,0.429c0.237,0,0.43-0.192,0.43-0.429C16.006,13.193,15.813,13.001,15.576,13.001 M6.997,9.141H6.139c-0.237,0-0.429,0.192-0.429,0.429s0.192,0.429,0.429,0.429h0.858c0.237,0,0.429-0.192,0.429-0.429S7.234,9.141,6.997,9.141M12.145,9.141h-0.857c-0.236,0-0.429,0.192-0.429,0.429s0.193,0.429,0.429,0.429h0.857c0.237,0,0.43-0.192,0.43-0.429S12.382,9.141,12.145,9.141 M17.722,10.856V7.424c0-0.948-0.769-1.716-1.716-1.716h-0.617l-1.038-3.873c-0.245-0.916-1.186-1.458-2.101-1.213L3.592,2.912C2.676,3.157,2.133,4.098,2.378,5.014l0.186,0.695H2.278c-0.947,0-1.716,0.768-1.716,1.716V17.72c0,0.947,0.769,1.716,1.716,1.716h13.728c0.947,0,1.716-0.769,1.716-1.716v-1.716c0.947,0,1.716-0.769,1.716-1.716v-1.716C19.438,11.624,18.669,10.856,17.722,10.856 M16.006,6.566c0.473,0,0.857,0.384,0.857,0.858v0.238c-0.253-0.146-0.544-0.238-0.857-0.238h-0.157l-0.229-0.858H16.006z M14.41,5.372l0.55,2.053H6.67L14.41,5.372z M3.814,3.741l8.657-2.29c0.458-0.123,0.928,0.149,1.051,0.607l0.222,0.828L3.43,5.621l-0.223-0.83C3.084,4.333,3.356,3.863,3.814,3.741M1.42,7.424c0-0.474,0.384-0.858,0.858-0.858h0.517l0.229,0.858H2.278c-0.314,0-0.605,0.091-0.858,0.238V7.424z M16.863,17.72c0,0.474-0.385,0.858-0.857,0.858H2.278c-0.474,0-0.858-0.385-0.858-0.858V9.141c0-0.474,0.384-0.858,0.858-0.858h13.728c0.473,0,0.857,0.384,0.857,0.858v1.715h-1.716c-0.947,0-1.716,0.768-1.716,1.716v1.716c0,0.947,0.769,1.716,1.716,1.716h1.716V17.72z M18.58,14.288c0,0.474-0.385,0.857-0.858,0.857h-2.574c-0.474,0-0.857-0.384-0.857-0.857v-1.716c0-0.474,0.384-0.858,0.857-0.858h2.574c0.474,0,0.858,0.385,0.858,0.858V14.288z M9.571,16.861H8.713c-0.237,0-0.429,0.192-0.429,0.43s0.192,0.429,0.429,0.429h0.858c0.236,0,0.429-0.191,0.429-0.429S9.808,16.861,9.571,16.861M12.145,16.861h-0.857c-0.236,0-0.429,0.192-0.429,0.43s0.193,0.429,0.429,0.429h0.857c0.237,0,0.43-0.191,0.43-0.429S12.382,16.861,12.145,16.861 M9.571,9.141H8.713c-0.237,0-0.429,0.192-0.429,0.429s0.192,0.429,0.429,0.429h0.858C9.808,9.998,10,9.806,10,9.569S9.808,9.141,9.571,9.141"></path>
                      </svg>
                    </div>
                    <div>
                      <p
                        class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                      >
                        Invoice Amount
                      </p>
                      <p
                        class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                      >
                        {{ new_invoice.total }}
                      </p>
                    </div>
                  </div>
                  <!-- Card -->
                  <div
                    class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
                  >
                    <div
                      class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
                    >
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.109,8.392H4.249c-0.238,0-0.43,0.193-0.43,0.431c0,0.238,0.192,0.431,0.43,0.431h0.861c0.238,0,0.43-0.193,0.43-0.431C5.54,8.585,5.347,8.392,5.109,8.392 M4.249,4.088h11.19c0.238,0,0.431-0.192,0.431-0.43c0-0.238-0.192-0.431-0.431-0.431H4.249c-0.238,0-0.43,0.192-0.43,0.431C3.818,3.896,4.011,4.088,4.249,4.088 M2.527,5.81H17.16c0.238,0,0.431-0.192,0.431-0.43c0-0.238-0.192-0.431-0.431-0.431H2.527c-0.238,0-0.43,0.192-0.43,0.431C2.097,5.617,2.289,5.81,2.527,5.81 M18.452,6.67H1.236c-0.476,0-0.861,0.385-0.861,0.861v8.608c0,0.475,0.385,0.86,0.861,0.86h17.216c0.475,0,0.86-0.386,0.86-0.86V7.531C19.312,7.056,18.927,6.67,18.452,6.67 M1.666,7.531c0.238,0,0.431,0.192,0.431,0.431c0,0.238-0.192,0.43-0.431,0.43c-0.238,0-0.43-0.192-0.43-0.43C1.236,7.724,1.428,7.531,1.666,7.531 M1.666,16.14c-0.238,0-0.43-0.192-0.43-0.431c0-0.237,0.192-0.431,0.43-0.431c0.238,0,0.431,0.193,0.431,0.431C2.097,15.947,1.904,16.14,1.666,16.14 M18.021,16.14c-0.238,0-0.431-0.192-0.431-0.431c0-0.237,0.192-0.431,0.431-0.431s0.431,0.193,0.431,0.431C18.452,15.947,18.26,16.14,18.021,16.14 M18.452,14.496c-0.136-0.048-0.279-0.078-0.431-0.078c-0.714,0-1.291,0.578-1.291,1.291c0,0.151,0.03,0.295,0.078,0.431H2.878c0.048-0.136,0.079-0.279,0.079-0.431c0-0.713-0.579-1.291-1.292-1.291c-0.151,0-0.295,0.03-0.43,0.078V9.174c0.135,0.048,0.279,0.079,0.43,0.079c0.713,0,1.292-0.578,1.292-1.291c0-0.152-0.031-0.295-0.079-0.431h13.93C16.761,7.667,16.73,7.81,16.73,7.962c0,0.713,0.577,1.291,1.291,1.291c0.151,0,0.295-0.031,0.431-0.079V14.496z M18.021,8.392c-0.238,0-0.431-0.192-0.431-0.43c0-0.238,0.192-0.431,0.431-0.431s0.431,0.192,0.431,0.431C18.452,8.2,18.26,8.392,18.021,8.392 M15.438,14.418h-0.86c-0.238,0-0.431,0.192-0.431,0.43c0,0.238,0.192,0.431,0.431,0.431h0.86c0.238,0,0.431-0.192,0.431-0.431C15.869,14.61,15.677,14.418,15.438,14.418 M9.844,8.392c-1.901,0-3.443,1.542-3.443,3.443s1.542,3.443,3.443,3.443s3.443-1.542,3.443-3.443S11.745,8.392,9.844,8.392 M11.233,13.271c-0.071,0.162-0.169,0.297-0.292,0.403c-0.124,0.108-0.268,0.189-0.434,0.246c-0.166,0.058-0.295,0.089-0.488,0.097v0.4H9.673v-0.4c-0.208-0.004-0.35-0.037-0.522-0.099c-0.174-0.063-0.322-0.151-0.445-0.267s-0.219-0.257-0.286-0.424c-0.067-0.168-0.099-0.361-0.095-0.579h0.659c-0.003,0.256,0.052,0.459,0.168,0.608c0.115,0.147,0.257,0.226,0.522,0.233v-1.417c-0.158-0.042-0.265-0.094-0.422-0.154c-0.156-0.061-0.297-0.139-0.422-0.234c-0.125-0.095-0.226-0.215-0.303-0.36c-0.077-0.144-0.115-0.323-0.115-0.538c0-0.187,0.035-0.352,0.106-0.494c0.072-0.143,0.168-0.261,0.289-0.357c0.121-0.096,0.261-0.168,0.419-0.22C9.383,9.665,9.5,9.64,9.673,9.64V9.256h0.348V9.64c0.173,0,0.287,0.023,0.441,0.07c0.154,0.047,0.288,0.117,0.401,0.211c0.114,0.093,0.204,0.212,0.272,0.356c0.067,0.145,0.101,0.312,0.101,0.503h-0.659c-0.008-0.199-0.059-0.351-0.153-0.457c-0.095-0.105-0.197-0.158-0.404-0.158V11.4c0.173,0.048,0.293,0.103,0.459,0.165c0.166,0.062,0.312,0.142,0.439,0.239c0.127,0.098,0.229,0.219,0.306,0.363c0.077,0.144,0.116,0.321,0.116,0.532C11.341,12.919,11.305,13.109,11.233,13.271M10.458,12.332c-0.067-0.051-0.143-0.092-0.228-0.123c-0.085-0.031-0.123-0.06-0.21-0.082v1.363c0.208-0.016,0.329-0.076,0.462-0.185c0.133-0.107,0.199-0.277,0.199-0.512c0-0.109-0.02-0.2-0.061-0.275C10.581,12.444,10.526,12.383,10.458,12.332 M9.069,10.74c0,0.094,0.019,0.174,0.058,0.241c0.039,0.066,0.087,0.122,0.148,0.169c0.06,0.047,0.128,0.085,0.208,0.114s0.109,0.054,0.19,0.073v-1.171c-0.208,0-0.32,0.044-0.434,0.132C9.126,10.386,9.069,10.533,9.069,10.74"></path>
                      </svg>
                    </div>
                    <div>
                      <p
                        class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                      >
                        Paid Amount
                      </p>
                      <p
                        class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                      >
                      {{ new_invoice.paid }}
                      </p>
                    </div>
                  </div>
                  <!-- Card -->
                  <div
                    class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
                  >
                    <div
                      class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500"
                    >
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill="evenodd" d="M11.174,14.993h1.647c0.228,0,0.412-0.184,0.412-0.411v-1.648c0-0.228-0.185-0.411-0.412-0.411h-1.647c-0.227,0-0.412,0.184-0.412,0.411v1.648C10.762,14.81,10.947,14.993,11.174,14.993 M3.759,13.346h4.943c0.227,0,0.412-0.184,0.412-0.412c0-0.228-0.185-0.411-0.412-0.411H3.759c-0.227,0-0.412,0.184-0.412,0.411C3.347,13.162,3.532,13.346,3.759,13.346 M3.759,14.993h3.295c0.228,0,0.412-0.184,0.412-0.411S7.282,14.17,7.055,14.17H3.759c-0.227,0-0.412,0.185-0.412,0.412S3.532,14.993,3.759,14.993 M14.881,5.932H1.7c-0.455,0-0.824,0.369-0.824,0.824v9.886c0,0.454,0.369,0.823,0.824,0.823h13.181c0.455,0,0.823-0.369,0.823-0.823V6.755C15.704,6.301,15.336,5.932,14.881,5.932M14.881,16.642H1.7v-5.767h13.181V16.642z M14.881,8.403H1.7V6.755h13.181V8.403z M18.176,2.636H4.995c-0.455,0-0.824,0.37-0.824,0.824v1.236c0,0.228,0.185,0.412,0.412,0.412c0.228,0,0.412-0.184,0.412-0.412V3.46h13.181v9.886H16.94c-0.228,0-0.412,0.185-0.412,0.412s0.185,0.412,0.412,0.412h1.235c0.455,0,0.824-0.369,0.824-0.824V3.46C19,3.006,18.631,2.636,18.176,2.636"></path>
                      </svg>
                    </div>
                    <div>
                      <p
                        class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                      >
                        Unpaid Amount
                      </p>
                      <p
                        class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                      >
                      {{ new_invoice.balance }}
                      </p>
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
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 8.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v8.25A2.25 2.25 0 006 16.5h2.25m8.25-8.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-7.5A2.25 2.25 0 018.25 18v-1.5m8.25-8.25h-6a2.25 2.25 0 00-2.25 2.25v6" />
                      </svg>
                    </div>
                    <div>
                      <p
                        class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                      >
                        Exam Reports
                      </p>
                      <p
                        class="text-lg font-semibold text-gray-700 dark:text-gray-200"
                      >
                        35
                      </p>
                    </div>
                  </div>
                </div>
    
                <!-- Cards with title -->
               
                <div class="grid gap-6 mb-8 md:grid-cols-2">
                  <div
                    class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
                  >
                  <h4
                  class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300"
                >
                  Student Academic Perfomance
                </h4>
                <hr>
                    <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                      Single Exam Results
                    </h4>
                    
                        <div class="w-full overflow-x-auto">
                            <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                                >
                                <th class="px-2 py-2">Exam</th>
                                <th class="px-2 py-2">Total</th>
                                <th class="px-2 py-2">Everage</th>
                                <th class="px-2 py-2">Date</th>
                                <th class="px-2 py-2">View</th>
                                </tr>
                            </thead>
                            <tbody v-if="exams.length"
                                class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                            >
                                <tr  v-for="exam in exams" :key="exam.examID" class="text-gray-700 dark:text-gray-400">
                                <td class="px-2 py-2">
                                    <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold">{{ exam.exam }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ exam.name }}({{ exam.year }})
                                        </p>
                                    </div>
                                    </div>
                                </td>
                                <td class="px-2 py-2 text-sm">
                                    {{ exam.sum }}
                                </td>
                                <td class="px-2 py-2 text-xs">
                                    <span
                                    class="px-2 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                                    >
                                    {{ exam.average }}
                                    </span>
                                </td>
                                <td class="px-2 py-2 text-sm">
                                    {{ exam.date }}
                                </td>
                                <td class="px-2 py-2 text-sm">
                                    <Link :href="`/contacts/${exam.examID}/${exam.student_id}/${exam.academic_year_id}/view`" tabindex="-1"
                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                        aria-label="View"
                                    >
                                    <icon name="cheveron-right" fill="currentColor" class="block w-6 h-6 fill-gray-400" />

                                    </Link>
                                </td>
                                </tr>

                            </tbody>
                            </table>
                        </div>

                  </div>
                  <div
                    class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
                  >
                  <h4
                  class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300"
                >
                Student Payment Reports
                </h4> <hr>
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                      Student Invoices
                    </h4>
                      <div class="w-full overflow-x-auto">
                          <table class="w-full whitespace-no-wrap">
                          <thead>
                              <tr
                              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                              >
                              <th class="px-2 py-2">Invoice Amount</th>
                              <th class="px-2 py-2">Paid</th>
                              <th class="px-2 py-2">Unpaid</th>
                              <th class="px-2 py-2">View</th>
                              </tr>
                          </thead>
                          <tbody v-if="invoices.length"
                              class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                          >
                              <tr  v-for="invoice in invoices" :key="invoice.invoice_id" class="text-gray-700 dark:text-gray-400">
                              <td class="px-2 py-2">
                                  <div class="flex items-center text-sm">
                                  <div>
                                      <p class="font-semibold">{{ invoice.total }}</p>
                                      <p class="text-xs text-gray-600 dark:text-gray-400">
                                          {{ invoice.name }}
                                      </p>
                                  </div>
                                  </div>
                              </td>
                              <td class="px-2 py-2 text-sm">
                                  {{ invoice.paid }}
                              </td>
                              
                              <td class="px-2 py-2 text-xs">
                                  <span
                                  class="px-2 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                                  >
                                  {{ invoice.balance }}
                                  </span>
                              </td>
                              <td class="px-2 py-2 text-sm">
                                  <Link :href="`/contacts/${invoice.invoice_id}/${invoice.student_id}/view`" tabindex="-1"
                                      class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                      aria-label="View"
                                  >
                                  <icon name="cheveron-right" fill="currentColor" class="block w-6 h-6 fill-gray-400" />
                                  View Invoice
                                  </Link>
                                  <Link :href="`/contacts/${invoice.invoice_id}/${invoice.student_id}/view`" tabindex="-1"
                                      class="flex items-center justify-between text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                      aria-label="View"
                                  >
                                  <icon name="cheveron-right" fill="currentColor" class="block w-6 h-6 fill-gray-400" />
                                  Payments
                                  </Link>
                              </td>
                              </tr>

                          </tbody>
                          </table>
                      </div>
                  </div>
                </div>

                <div class="grid gap-6 mb-8 md:grid-cols-2">
              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                  Student Profile
                </h4>
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-2 py-2">Student Name</th>
                        <th class="px-2 py-2"> {{ contact.name }}</th>
                        </tr>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-2 py-2">Sex</th>
                        <th class="px-2 py-2"> {{ contact.sex }}</th>
                        </tr>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                          <th class="px-2 py-2">Birth</th>
                          <th class="px-2 py-2"> {{ contact.dob }}</th>
                        </tr>
                        
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                          <th class="px-2 py-2">Address</th>
                          <th class="px-2 py-2"> {{ contact.address }}</th>
                        </tr>
                        
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                          <th class="px-2 py-2">Current Class</th>
                          <th class="px-2 py-2"> {{ contact.classes }}</th>
                        </tr>
                        
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                          <th class="px-2 py-2">Stream</th>
                          <th class="px-2 py-2"> {{ contact.section }}</th>
                        </tr>
                        
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                          <th class="px-2 py-2">Reg. No</th>
                          <th class="px-2 py-2"> {{ contact.roll }}</th>
                        </tr>
                        
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                          <th class="px-2 py-2">Stream</th>
                          <th class="px-2 py-2">
                            <a :href="`/contacts/${contact.uuid}/edit`" tabindex="-1"
                                      class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                      aria-label="View"
                                  >
                                  <icon name="user" fill="currentColor" class="block w-6 h-6 fill-gray-400" />
                                  View edit
                                  </a>
                                </th>
                        </tr>
                    </thead>
                    </table>
                </div>
              </div>
              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                  Parent Profile
                </h4>
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-2 py-2">Parent Name</th>
                        <th class="px-2 py-2"> {{ parent.name }}</th>
                        </tr>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-2 py-2">Parent Sex</th>
                        <th class="px-2 py-2"> {{ parent.sex }}</th>
                        </tr>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                          <th class="px-2 py-2">Phone</th>
                          <th class="px-2 py-2"> {{ parent.phone }}</th>
                        </tr>
                        
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                          <th class="px-2 py-2">Address</th>
                          <th class="px-2 py-2"> {{ parent.address }}</th>
                        </tr>
                        
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                          <th class="px-2 py-2">Parent Email</th>
                          <th class="px-2 py-2"> {{ parent.email }}</th>
                        </tr>
                        
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                          <th class="px-2 py-2">Login Code</th>
                          <th class="px-2 py-2"> {{ parent.login_code }}</th>
                        </tr>
                        
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                          <th class="px-2 py-2">Acc. Type</th>
                          <th class="px-2 py-2"> {{ parent.usertype }}</th>
                        </tr>
                        
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                          <th class="px-2 py-2">Profile</th>
                          <th class="px-2 py-2">  
                            <Link  :href="`/viewuser/${parent.uuid}/parent`" tabindex="-1"
                                      class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                      aria-label="View"
                                  >
                                  <icon name="user" fill="currentColor" class="block w-6 h-6 fill-gray-400" />
                                  View Profile
                                  </Link>
 </th>
                        </tr>
                    </thead>
                    </table>
                </div>
              </div>
            </div>
              <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
              <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                  Student Payments
                </h4>
                <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                                >
                                <th class="px-2 py-2">Payment date</th>
                                <th class="px-2 py-2">Amount</th>
                                <th class="px-2 py-2">Method</th>
                                <th class="px-2 py-2">Bank Account</th>
                                <th class="px-2 py-2">Receipt</th>
                                <th class="px-2 py-2">View</th>
                                </tr>
                            </thead>
                            <tbody v-if="payments.length"
                                class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                            >
                                <tr  v-for="exam in payments" :key="exam.id" class="text-gray-700 dark:text-gray-400">
                                <td class="px-2 py-2">
                                    <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold">{{ exam.date }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ exam.transaction_id }}
                                        </p>
                                    </div>
                                    </div>
                                </td>
                              
                                <td class="px-2 py-2 text-xs">
                                    <span
                                    class="px-2 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                                    >
                                    {{ exam.amount }}
                                    </span>
                                </td>
                                <td class="px-2 py-2 text-xs">
                                    {{ exam.method }}
                                </td>
                                <td class="px-2 py-2 text-xs">
                                    {{ exam.bank }}
                                </td>
                                <td class="px-2 py-2 text-xs">
                                    {{ exam.receipt }}
                                </td>
                                <td class="px-2 py-2 text-sm">
                                  <Link  :href="`/receipts/${exam.uuid}/view`" tabindex="-1"
                                      class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                      aria-label="View"
                                  >
                                  <icon name="user" fill="currentColor" class="block w-6 h-6 fill-gray-400" />
                                   Receipt
                                  </Link>
                                </td>
                                </tr>

                            </tbody>
                            </table>
                </div>
              </div>
            <!-- <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
              <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
                  Student Subjects
                </h4>
                <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                                >
                                <th class="px-2 py-2">Exam</th>
                                <th class="px-2 py-2">Total</th>
                                <th class="px-2 py-2">View</th>
                                </tr>
                            </thead>
                            <tbody v-if="subjects.length"
                                class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                            >
                                <tr  v-for="exam in subjects" :key="exam.subject_id" class="text-gray-700 dark:text-gray-400">
                                <td class="px-2 py-2">
                                    <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold">{{ exam.subject }}</p>
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
                                
                                </tr>

                            </tbody>
                            </table>
                </div>
              </div> -->
            
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
    contact: Object,
    subjects: Array,
    invoices: Array,
    exams: Array,
    parent: Array,
    payments: Array,
    new_invoice: Object,
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
