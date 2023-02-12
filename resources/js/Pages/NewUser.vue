<template>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Basic Info</h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group input-group-static">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" placeholder="Alec">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-static">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" placeholder="Thompson">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-6">
                                <label class="form-label mt-4 ms-0">I'm</label>
                                <div class="input-group input-group-outline">
                                    <select class="form-control" name="choices-gender" id="choices-gender">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                
                                <label class="form-label mt-4 ms-0">Birth Date</label>
                                <div class="input-group input-group-outline">
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-6">
                                <div class="input-group input-group-static">
                                    <label>Email</label>
                                    <input type="email" class="form-control" placeholder="example@email.com">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-static">
                                    <label>Confirm Email</label>
                                    <input type="email" class="form-control" placeholder="example@email.com">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-6">
                                <div class="input-group input-group-static">
                                    <label>Your location</label>
                                    <input type="text" class="form-control" placeholder="Sydney, A">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-static">
                                    <label>Phone Number</label>
                                    <input type="number" class="form-control" placeholder="+40 735 631 620">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 align-self-center">
                                <label class="form-label mt-4 ms-0">Language</label>
                                <select class="form-control" name="choices-language" id="choices-language">
                                    <option value="English">English</option>
                                    <option value="French">French</option>
                                    <option value="Spanish">Spanish</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label mt-4">Skills</label>
                                <input class="form-control" id="choices-skills" type="text"
                                    value="vuejs, angular, react" placeholder="Enter something" />
                            </div>
                        </div>
                        <hr>
                        <div class="input-group input-group-outline">
                            <label class="form-label">Staff Role</label>
                                <input type="text" name="role" class="form-control">
                        </div>
                        <div class="input-group input-group-outline my-4">
                            <label class="form-label">New password</label>
                            <input type="password" class="form-control">
                        </div>
                        <div class="input-group input-group-outline">
                            <label class="form-label">Confirm New password</label>
                            <input type="password" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
