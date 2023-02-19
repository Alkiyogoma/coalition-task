<template>
    <br>
    <!-- CTA -->
    <Link
      class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
      href="/items"
    >
      <div class="flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
          <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0118 9.375v9.375a3 3 0 003-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 00-.673-.05A3 3 0 0015 1.5h-1.5a3 3 0 00-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6zM13.5 3A1.5 1.5 0 0012 4.5h4.5A1.5 1.5 0 0015 3h-1.5z" clip-rule="evenodd" />
          <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 013 20.625V9.375zm9.586 4.594a.75.75 0 00-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 00-1.06 1.06l1.5 1.5a.75.75 0 001.116-.062l3-3.75z" clip-rule="evenodd" />
        </svg>
  
  
        <span class="ml-3">Add New Item</span>
      </div>
      <span class="mr-3"> Go back  &RightArrow;</span>
    </Link>
           
            <div
              class="px-2 py-2 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
            >   
        <form @submit.prevent="store">
          <div class="grid gap-6 mb-8 md:grid-cols-2">
  
            <text-input type="date" v-model="form.date" :error="form.errors.date" class="mb-3 pr-6 w-full lg:w-1/2" label="Set Date" />
            <select-input v-model="form.status" :error="form.errors.stataus" required class="pb-8 pr-6 w-full lg:w-1/2" label="Usage Status">
              <option :value="null" />
              <option value="1">Used</option>
              <option value="2">Sold</option>
          </select-input>
            <text-input v-model="form.vendor" :error="form.errors.vendor" placeholder="Enter Full name"  class="mb-3 pr-6 w-full lg:w-1/2" label="Reveceive or Given to" />
            <text-input v-model="form.contact" :error="form.errors.contact" placeholder="Enter contact info" class="mb-5 pr-6 w-full lg:w-1/2" label="Reveceive Contact" />
         
            </div>
            <div class="grid gap-6 mb-8 md:grid-cols-2">
              <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800" v-for="(input,k) in form.inputs" :key="k">
                <select-input v-model="form.inputs.item_id" :error="form.errors.inputs" class="mb-5 pr-6 w-full lg:w-1/2" label="Select Item  Name">
                    <option :value="null" />
                    <option v-for="teacher in groups" :key="teacher.id" :value="teacher.id">{{ teacher.name }}</option>
                </select-input>
                <text-input v-model="form.inputs.quantity" :error="form.errors.inputs" placeholder="Enter Quantity" class="mb-3 pr-6 w-full lg:w-1/2" label="Item Quantity " />
                <div class="flex items-center space-x-4">
                    <span  @click="remove(k)" v-show="k || ( !k && form.inputs.length > 1)" class="flex items-center  px-2 py-2 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"> <icon name="remove" /> Remove  </span>
                    <span  @click="add(k)" v-show="k == form.inputs.length-1" class="flex items-center  px-2 py-2 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"><icon name="addtag" /> Add Item </span>
                </div>
            </div>
            </div>
            <textarea-input v-model="form.note" :error="form.errors.note" class="mb-5 pr-6 w-full lg:w-1/2" label="About Items" />

        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
            <loading-button :loading="form.processing" class="btn-indigo" type="submit">Add {{ type }}</loading-button>
          </div>          
          
        </form>
      </div>
      
  </template>
  
  <script>
  import { Link } from '@inertiajs/vue3'
  import TextInput from '../../Shared/TextInput'
  import SelectInput from '../../Shared/SelectInput'
  import TextareaInput from '../../Shared/TextareaInput'
  import LoadingButton from '../../Shared/LoadingButton'
  import Icon from '../../Shared/Icon'

  export default {
    components: {
      Link, Icon,
      LoadingButton,
      SelectInput,
      TextareaInput,
      TextInput,
    },
    props: {
      groups: Array,
      type: String
    },
    remember: 'form',
    data() {
      return {
        form: this.$inertia.form({
          vendor: '',
          contact: '',
          note: '',
          date: '',
          status: '',
          item_id: '',
          quantity: '',
          inputs: [
            {
                item_id: '',
                quantity: ''
            }
        ]
        }),
    }
  },
  methods: {
    store() {
      this.form.post('/saveusage/'+ this.type)
    },
    add(index) {
        this.form.inputs.push({ item_id: '', quantity: '' });
    },
    remove(index) {
        this.form.inputs.splice(index, 1);
        }
  },
}
  </script>
  