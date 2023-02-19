<template>
<br>
          <!-- CTA -->
          <Link
            class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
            href="/students"
          >
            <div class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
              </svg>
              <span>Student Registration  Form</span>
            </div>
            <span> Go Back &RightArrow;</span>
          </Link>


      <form @submit.prevent="store">
        <div
            class="px-2 py-2 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
          >
        <div class="grid gap-6 mb-8 md:grid-cols-2">
          <text-input v-model="form.name" :error="form.errors.name" required class="pb-8 pr-6 w-full lg:w-1/2" label="Student  Fullname" />
          <select-input v-model="form.sex" :error="form.errors.sex" required class="pb-8 pr-6 w-full lg:w-1/2" label="Student Sex">
            <option :value="null" />
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select-input>
          <text-input v-model="form.dob" :error="form.errors.dob" type="date" required class="pb-8 pr-6 w-full lg:w-1/2" label="Date of Birth" />
          <text-input v-model="form.jod" :error="form.errors.jod" type="date" required class="pb-8 pr-6 w-full lg:w-1/2" label="Joining Date" />
          <text-input v-model="form.roll" :error="form.errors.roll" required class="pb-8 pr-6 w-full lg:w-1/2" label="Reg Number" />
          <text-input v-model="form.address" :error="form.errors.address" required class="pb-8 pr-6 w-full lg:w-1/2" label="Address" />
          <select-input v-model="form.religion_id" :error="form.errors.religion_id" required class="pb-8 pr-6 w-full lg:w-1/2" label=" Student Religion">
            <option :value="null" />
            <option v-for="religion in religions" :key="religion.id" :value="religion.id">{{ religion.religion }}</option>
          </select-input>  
          <select-input v-model="form.class" :error="form.errors.class_id" required id="class_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Student Class">
            <option :value="null" />
            <option v-for="level in levels" :key="level.classesID" :value="level.classesID">{{ level.classes }}</option>
          </select-input>
       
          <select-input v-model="form.section_id" :error="form.errors.section_id" required class="pb-8 pr-6 w-full lg:w-1/2" id="section_id" label="Class Stream">
            <option :value="null" />
          </select-input>

          <select-input v-model="form.academicyear_id" :error="form.errors.academicyear_id" required id="academicyear_id" class="pb-8 pr-6 w-full lg:w-1/2" label=" Select Academic Year">
            <option :value="null" />
          </select-input>
      

          <select-input v-model="form.parent" :error="form.errors.parent" id="parentstatus" class="pb-8 pr-6 w-full lg:w-1/2" label="Select Parent Status">
            <option :value="null" />
            <option value="newparent">Add New Parent</option>
            <option value="parent">Parent Exist in a System</option>
          </select-input>
          <div id="parents" style="display: none;">
          <text-input v-model="form.pname" :error="form.errors.pname" class="pb-8 pr-6 w-full lg:w-1/2" label="Parent  Fullname" />
          <select-input v-model="form.psex" :error="form.errors.psex" class="pb-8 pr-6 w-full lg:w-1/2" label="Parent Sex">
            <option :value="null" />
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select-input>
          <text-input v-model="form.phone" :error="form.errors.phone" class="pb-8 pr-6 w-full lg:w-1/2" label="Parent  Phone" />
          <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2" label="Parent  Email" />
        </div>
        <div id="allparents" style="display: none;">
          <select-input v-model="form.parent_id" :error="form.errors.parent_id" class="pb-8 pr-6 w-full lg:w-1/2 js-example-basic- " label="Select Student Parent">
            <option :value="null" />
            <option v-for="level in parents" :key="level.id" :value="level.id">{{ level.name }}  ({{ level.phone }})</option>
          </select-input>
       
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" >Save Student</loading-button>
        </div>
      </div>
    </div>

      </form>
</template>

<script>
 
import { Link } from '@inertiajs/vue3'
// import Layout from '@/Shared/Layout'
import TextInput from '../../Shared/TextInput'
import SelectInput from '../../Shared/SelectInput'
import MultipleInput from '../../Shared/MultipleInput'
import LoadingButton from '../../Shared/LoadingButton'
import TrashedMessage from '../../Shared/TrashedMessage'

export default {
  components: {
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    MultipleInput,
    TrashedMessage,
  },
  props: {
    levels: Array,
    religions: Array,
    parents: Array
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: '',
        dob: '',
        email: '',
        phone: '',
        academicyear_id: '',
        psex: '',
        pname: '',
        parent_id: '',
        religion_id: '',
        jod: '',
        section_id: '',
        sex: '',
        address: '',
        roll: '',
      }),
    }
  },
  methods: {
    store() {
      this.form.post('/contacts')
    },
  },
}

$(document).ready(function() {
       
      $('#parentstatus').change(function (event) {
        var class_id = $(this).val();
        if (class_id === '') {
          $('#allparents').hide();
          $('#parents').hide();
        }
        if (class_id === 'newparent') {
          $('#allparents').hide();
          $('#parents').show();
        }
        if (class_id === 'parent') {
          $('#allparents').show();
          $('#parents').hide();
        }
      });
    });
</script>
