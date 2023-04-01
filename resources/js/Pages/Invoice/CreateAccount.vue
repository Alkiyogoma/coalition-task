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
                            <text-input v-model="form.name" :error="form.errors.name" required :placeholder="`Group name`" />
                            <text-input v-model="form.code" required :error="form.errors.cde" placeholder="Group Code" />
                            <select-input v-model="form.type_id" :error="form.errors.type_id" required 
                                label="Group Type?">
                                <option :value="null" />
                                <option v-for="organization in categories" :key="organization.id"                   :value="organization.id">{{ organization.name }}</option>
                            </select-input>
                            
                          </div>
                            <div class="row">
                            <div
                                class="flex items-center justify-end border-gray-100">
                                <loading-button :loading="form.processing"  type="submit">Add Group</loading-button>
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
            categories: Array,
        },
        remember: 'form',
        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    code: '',
                    type_id: '',
                }),
            }
        },
        methods: {
            store() {
                this.form.post('/savegroup')
            },
        },
    }

</script>
