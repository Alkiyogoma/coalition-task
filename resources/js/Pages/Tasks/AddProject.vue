<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Define Project Details</h5>
                </div>
                <div class="card-body pt-0">
                    <form @submit.prevent="store">
                        <div class="row">
                            <div class="input-group input-group-outline my-3">
                                <input v-model="form.name" :error="form.errors.name" class="form-control" required :placeholder="`Project name`" />
                            </div>
                        </div>
                <div class="input-group input-group-outline my-3">
                    <textarea v-model="form.about" required class="form-control" rows="3"
                        :placeholder="`Write About this project`" spellcheck="false"></textarea>
                </div>
                <div class="row">
                    <div class="flex items-center justify-end border-gray-100">
                        <loading-button :loading="form.processing" type="submit">Add Project</loading-button>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
</div></template>
<script>
import {
    Link
} from '@inertiajs/vue3'
// import Layout from '../Shared/Layout'
import TextInput from '../../Shared/TextInputB'
import SelectInput from '../../Shared/SelectInput'
import TextareaInput from '../../Shared/TextareaInput'
import LoadingButton from '../../Shared/LoadingButton'

export default {
    components: {
        Link,
        LoadingButton,
        SelectInput,
        TextareaInput,
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
