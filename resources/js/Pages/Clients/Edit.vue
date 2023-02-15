<template>
  <br>
  <!-- CTA -->
  <Link
    class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
    href="/classes"
  >
    <div class="flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
        <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0118 9.375v9.375a3 3 0 003-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 00-.673-.05A3 3 0 0015 1.5h-1.5a3 3 0 00-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6zM13.5 3A1.5 1.5 0 0012 4.5h4.5A1.5 1.5 0 0015 3h-1.5z" clip-rule="evenodd" />
        <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 013 20.625V9.375zm9.586 4.594a.75.75 0 00-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 00-1.06 1.06l1.5 1.5a.75.75 0 001.116-.062l3-3.75z" clip-rule="evenodd" />
      </svg>


      <span class="ml-3">Edit School Class</span>
    </div>
    <span class="mr-3"> Go back  &RightArrow;</span>
  </Link>
         
          <div
            class="px-2 py-2 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
          >   
      <form @submit.prevent="update">
       
          <text-input v-model="form.classes" :error="form.errors.classes" class="mb-3 pr-6 w-full lg:w-1/2" label="Class name" />
          <text-input type="number" v-model="form.classes_numeric" :error="form.errors.classes_numeric" class="mb-5 pr-6 w-full lg:w-1/2" label="Class Order ID" />
          <select-input v-model="form.classlevel_id" :error="form.errors.classlevel_id" class="mb-5 pr-6 w-full lg:w-1/2" label="Classlevel">
            <option :value="null" />
            <option v-for="classlevel in classlevels" :key="classlevel.classlevel_id" :value="classlevel.classlevel_id">{{ classlevel.name }}</option>
          </select-input>
          <select-input v-model="form.user_id" :error="form.errors.user_id" class="mb-5 pr-6 w-full lg:w-1/2" label="Class Teacher">
            <option :value="null" />
            <option v-for="teacher in teachers" :key="teacher.id" :value="teacher.id">{{ teacher.name }}</option>
          </select-input>
          <text-input v-model="form.note" :error="form.errors.note" class="mb-5 pr-6 w-full lg:w-1/2" label="About This Class" />
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Update Class</loading-button>
        </div>
        
      </form>
    </div>
    
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import TextInput from '../../Shared/TextInput'
import SelectInput from '../../Shared/SelectInput'
import MultipleInput from '../../Shared/MultipleInput'
import LoadingButton from '../../Shared/LoadingButton'

export default {
  components: {
    Link,
    LoadingButton,
    SelectInput,
    MultipleInput,
    TextInput,
  },
  props: {
    classes: Array,
    classlevels: Array,
    teachers: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        classes:  this.classes.classes,
        classlevel_id:  this.classes.classlevel_id,
        user_id:  this.classes.user_id,
        note:  this.classes.note,
        classes_numeric:  this.classes.classes_numeric,
      }),
    }
  },
  methods: {
    update() {
      if (confirm('Are you sure you want to edit this class?')) {
        this.form.post('/classes/'+ this.classes.uuid +'/update')
      }
    },
  },
}
</script>
