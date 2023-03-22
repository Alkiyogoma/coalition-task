<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Define Partner Info</h5>
                </div>
                <div class="card-body pt-0">
                        <form @submit.prevent="store">
                          <div class="row">
                            <text-input v-model="form.name" :error="form.errors.name" required :label="`Partner name`" />
                                <text-input v-model="form.phone" required :error="form.errors.phone" label="Phone" />
                            </div>
                            <div class="row">
                                <text-input v-model="form.address" :error="form.errors.address" label="Address" />
                                <text-input v-model="form.email"  :error="form.errors.email" label="Email" />
                          </div>
                          
                          <div class="row">
                                <text-input v-model="form.website" :error="form.errors.website" label="Website" />
                                <select-input v-model="form.partner_group_id" :error="form.errors.partner_group_id" required  label="Partner Category">
                                    <option :value="null" />
                                    <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
                                </select-input>
                          </div>
                            <div class="row">
                                <select-input v-model="form.user_id" :error="form.errors.user_id" required  label="Bank Team Leader">
                                    <option :value="null" />
                                    <option v-for="role in users" :key="role.id" :value="role.id">{{ role.name }}</option>
                                </select-input>
                                <div class="col-sm-6"> <br>
                                    <loading-button :loading="form.processing"  type="submit">Add Bank</loading-button>
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
            uuid: String,
            users: Array,
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
                    partner_group_id: '',
                    email: '',
                    about: '',
                }),
            }
        },
        methods: {
            store() {
                this.form.post('/savepartner')
            },
        },
    }

</script>
