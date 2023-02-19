<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Define {{ type }} Info</h5>
                </div>
                <div class="card-body pt-0">
                        <form @submit.prevent="store">
                          <div class="row">
                            <text-input v-model="form.name" :error="form.errors.name" required :placeholder="`${ type } name`" />
                                <text-input v-model="form.phone" required :error="form.errors.phone" placeholder="Phone" />
                            </div>
                            <div class="row">
                                <text-input v-model="form.address" :error="form.errors.address" placeholder="Address" />
                                <text-input v-model="form.email"  :error="form.errors.email" placeholder="Email" />
                          </div>
                            <div class="row">
                            <div
                                class="flex items-center justify-end border-gray-100">
                                <loading-button :loading="form.processing"  type="submit">Add {{ type }}</loading-button>
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
          type: String,
        },
        remember: 'form',
        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    phone: '',
                    address: '',
                    email: '',
                }),
            }
        },
        methods: {
            store() {
                this.form.post('/save/'+this.type)
            },
        },
    }

</script>
