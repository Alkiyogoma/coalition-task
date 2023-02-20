<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Define Department Details</h5>
                </div>
                <div class="card-body pt-0">
                        <form @submit.prevent="store">
                          <div class="row">
                            <text-input v-model="form.name" :error="form.errors.name" required :label="`Department name`" />
                                <text-input v-model="form.phone" required :error="form.errors.phone" label="Department Phone" />
                            </div>
                            <div class="row">
                                <text-input v-model="form.address" :error="form.errors.address" label="Department Address" />
                                <text-input v-model="form.email"  :error="form.errors.email" label="Department Email" />
                          </div>
                          
                          <div class="input-group input-group-static mb-4">
                            <label for="user_id">Head of Departmrent </label>
                            <select v-model="form.user_id" :error="form.errors.partner_group_id" required class="form-control" label="Partner Category">
                                <option :value="null" />
                                <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
                            </select>
                            </div>
                                <div class="input-group input-group-outline my-3">
                                    <textarea  v-model="form.about" required class="form-control" rows="3" :placeholder="`Write About This Department`" spellcheck="false"></textarea>
                                </div>
                            <div class="row">
                            <div
                                class="flex items-center justify-end border-gray-100">
                                <loading-button :loading="form.processing"  type="submit">Add Department</loading-button>
                            </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
</template>
<script>
    import {
        Link
    } from '@inertiajs/vue3'
    // import Layout from '../Shared/Layout'
    import TextInput from '../../Shared/TextInputB'
    import SelectInput from '../../Shared/SelectInput'
    import TextAreaInput from '../../Shared/TextAreaInput'
    import LoadingButton from '../../Shared/LoadingButton'

    export default {
        components: {
            Link,
            LoadingButton,
            SelectInput,
            TextAreaInput,
            TextInput,
        },
        props: {
            uuid: String,
            roles: Array,
        },
        remember: 'form',
        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    phone: '',
                    address: '',
                    website: '',
                    uuid: '',
                    user_id: '',
                    email: '',
                    about: '',
                }),
            }
        },
        methods: {
            store() {
                this.form.post('/saveDept')
            },
        },
    }

</script>
