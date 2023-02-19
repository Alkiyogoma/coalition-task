<template>
<br>
    <!-- CTA -->
    <Link
        class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
        href="/view-subjects">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
            </path>
        </svg>
        <span>Add new School Subject</span>
    </div>
    <span>Go Back  &RightArrow;</span>
    </Link>

    <div class="px-2 py-2 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

    <form @submit.prevent="store">
            <text-input v-model="form.subject_name" :error="form.errors.subject_name" class="pb-8 pr-6 w-full lg:w-1/2"
                label="Subject name" />
            <text-input v-model="form.code" :error="form.errors.code" class="pb-8 pr-6 w-full lg:w-1/2"
                label="Subject Code" />
            
            <text-input v-model="form.arrangement" :error="form.errors.arrangement" class="pb-8 pr-6 w-full lg:w-1/2"
                label="Subject Order ID" />
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
            <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Subject</loading-button>
        </div>
    </form>
</div>
</template>

<script>
    import {
        Link
    } from '@inertiajs/vue3'
    // import Layout from '../Shared/Layout'
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
            organizations: 2,
        },
        remember: 'form',
        data() {
            return {
                form: this.$inertia.form({
                    code: '',
                    subject_name: '',
                    arrangement: '',
                }),
            }
        },
        methods: {
            store() {
                this.form.post('/putsubject')
            },
        },
    }

</script>
