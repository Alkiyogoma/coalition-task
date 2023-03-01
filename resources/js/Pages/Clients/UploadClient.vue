<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body pt-0">
                    <form  method="post" action="/clientUpload"  enctype='multipart/form-data'>
                     
                        <h5 class="font-weight-normal" id="modal-title-notification"> Upload Customers form Our Partners </h5>
                            <hr class="horizontal dark mt-3 mb-2" />
                            <input type="hidden" :value="_token" name="_token" class="form-control">

                            <div class="input-group input-group-outline my-3">
                                <input  class="form-control" required type="file" name="files"  placeholder="Attach Here Excel with patner customers" />
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group">
                                        <li class="list-group-item border-0 px-0">
                                            <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault"> confirm uploaded customers was from a partner</label>
                                            <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault1">Fill all column as required before uploading</label>
                                            <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault1">After Succesful upload review uploaded customers</label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <a href="/assets/sample_one.xlsx" class="label bg-gradient-primary label-lg label-rounded py-2 px-2 w-30 mt-4 mb-0" for="flexSwitchCheckDefault1">Download Sample One </a>
                                        <br>
                                        <a href="/assets/sample_two.xlsx" class="label bg-gradient-primary label-lg label-rounded py-2 px-2 w-30 mt-4 mb-0" for="flexSwitchCheckDefault1">Download Sample Two</a>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Upload customers</button>
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="flex items-center justify-end border-gray-100">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</template>
<script>
    import { Link } from '@inertiajs/vue3'
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
            users: Array,
            methods: Array,
            clients: Array,
            _token: String
        },
        remember: 'form',
        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    partner_id: '',
                    employer: '',
                    phone: '',
                    address: '',
                    branch: '',
                    collector: '',
                    amount: '',
                    user_id: '',
                    account: '',
                    payment: '',
                    installment_id: '',
                }),
            }
        },
        methods: {
            store() {
                this.form.post('/saveclient')
            },
        },
    }

</script>
