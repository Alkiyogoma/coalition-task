<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Define New Account Group</h5>
                </div>
                <div class="card-body pt-0">
                        <form @submit.prevent="store">
                          <div class="row">
                            <text-input v-model="form.name" :error="form.errors.name" required :placeholder="`Account name`" />
                            <text-input v-model="form.code" required :error="form.errors.code" placeholder="Account Code" />
                            <text-input v-model="form.about" required :error="form.errors.about" placeholder="About  This Account Group" />
                            <select-input v-model="form.account_id" :error="form.errors.account_id" required 
                                label=" Account Group Category?">
                                <option :value="null" />
                                <option v-for="organization in categories" :key="organization.id"
                                    :value="organization.id">{{ organization.name }}</option>
                            </select-input>
                          
                            <div
                                class="flex items-center justify-end border-gray-100">
                                <loading-button :loading="form.processing"  type="submit">Add Chart of Account</loading-button>
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
    import TextInput from '../../Shared/TextInputB'
    import SelectInput from '../../Shared/SelectInput'
    import LoadingButton from '../../Shared/LoadingButton'
    import TextareaInput from '../../Shared/TextareaInput'

    export default {
        components: {
            Link,
            LoadingButton,
            SelectInput,
            TextareaInput,
            TextInput,
        },
        props: {
            categories: Array,
        },
        remember: 'form',
        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    code: '',
                    about: '',
                    account_id: '',
                }),
            }
        },
        methods: {
            store() {
                this.form.post('/savechart')
            },
        },
    }

</script>
