<template>
  <div class="container px-6 mx-auto grid">
    <br>
            <!-- CTA -->
            <Link
              class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
              :href="`/contacts/${contact.uuid}/view`"
            >
              <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
              </svg>
                <span>
                    <Link class="text-indigo-400 hover:text-indigo-600 ml-3" href="/students">Update </Link>
                    <span class="text-indigo-400 font-medium">/
                    {{ form.name }}
                  </span>
                </span>
              </div>
              <span>View more &RightArrow;</span>
            </Link>

    <div class="row">
      <div class="col-md-12">
    
    <!-- <trashed-message v-if="contact.deleted_at" class="mb-6" @restore="restore"> This contact has been deleted. </trashed-message> -->
    <div class="px-2 py-2 mb-8 bg-white w-full overflow-hidden rounded-lg shadow-xs overflow-x-auto dark:bg-gray-800">
      <form @submit.prevent="update" class="px-2 py-2 mb-8">
        <div class="grid gap-6 mb-8 md:grid-cols-2">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" value="{{ contact.name }}" label="Fullname" />
          <select-input v-model="form.sex" :error="form.errors.sex" required class="pb-8 pr-6 w-full lg:w-1/2" label="Student Sex">
            <option value="{{ contact.sex }}">{{ contact.sex }}</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select-input>
          <text-input v-model="form.dob" :error="form.errors.dob" class="pb-8 pr-6 w-full lg:w-1/2" :value="contact.dob" label="dob" />
          <text-input v-model="form.roll" :error="form.errors.roll" class="pb-8 pr-6 w-full lg:w-1/2" label="roll" />
          <text-input v-model="form.address" :error="form.errors.address" class="pb-8 pr-6 w-full lg:w-1/2" value="{{ contact.address }}" label="Address" />
          <text-input v-model="form.jod" :error="form.errors.jod" class="pb-8 pr-6 w-full lg:w-1/2"  :value="contact.jod" type="date" label="jod"/>
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
          
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!contact.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Contact</button>
          <loading-button :loading="form.processing" class="px-3 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600  rounded-lg shadow-md" type="submit">Update Contact</loading-button>
        </div>
        </div>
      </form>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
// import Layout from '@/Shared/Layout'
import TextInput from '../../Shared/TextInput'
import SelectInput from '../../Shared/SelectInput'
import LoadingButton from '../../Shared/LoadingButton'
import TrashedMessage from '../../Shared/TrashedMessage'

export default {
  components: {
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  props: {
    contact: Object,
    levels: Array,
    religions: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.contact.name,
        organization_id: this.contact.organization_id,
        sex: this.contact.sex,
        roll: this.contact.roll,
        dob: this.contact.dob,
        address: this.contact.address,
        jod: this.contact.jod,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/contacts/${this.contact.id}`)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this contact?')) {
        this.$inertia.delete(`/contacts/${this.contact.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this contact?')) {
        this.$inertia.put(`/contacts/${this.contact.id}/restore`)
      }
    },
  },
}
</script>
