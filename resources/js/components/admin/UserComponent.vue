<template>
    <div class="row justify-content-center">
        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User's Table</h3>

                    <div class="card-tools">
                        <button class="btn btn-primary" @click="newModel">Add new <i class="fa fa-plus"
                                aria-hidden="true"></i></button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>About</th>
                                <th>Type</th>
                                <th>Position</th>
                                <th>Registered At</th>
                                <th>Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, index) in users" :key="user.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td v-if="user.about">{{ user.about|sortlength(25,'. . .') }}</td>
                                <td class="red" v-else>Unknow</td>
                                <td>{{ user.type | upText}}</td>
                                <td v-if="user.position">{{ user.position }}</td>
                                <td class="red" v-else>Unknow</td>
                                <td>{{ user.created_at|timeFormat}}</td>
                                <td>
                                    <a href="#" class="alert-link" @click="editModel(user)"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                    <a href="#" class="alert-link" @click="deleteUser(user.id)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewTitle" v-show="!editmode">Create a new user</h5>
                        <h5 class="modal-title" id="addNewTitle" v-show="editmode">Update user</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form enctype="multipart/form-data" @submit.prevent="editmode ? updateUser() : createUser()"
                        @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input v-model="form.name" type="text" name="name" class="form-control"
                                    placeholder="Enter a user name"
                                    :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>E-mail</label>
                                <input v-model="form.email" type="text" name="email" class="form-control"
                                    placeholder="Enter a user emil"
                                    :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <label>About</label>
                                <textarea v-model="form.about" id="about" name="about" class="form-control" rows="10"
                                    placeholder="Enter a user details"
                                    :class="{ 'is-invalid': form.errors.has('about') }"></textarea>
                                <has-error :form="form" field="about"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Position</label>
                                <input v-model="form.position" type="text" name="position" class="form-control"
                                    placeholder="Enter a user position" :class="{ 'is-invalid': form.errors.has('position') }">
                                <has-error :form="form" field="position"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Select Category</label>
                                <select class="form-control" v-model="form.type" name="type"
                                    :class="{ 'is-invalid': form.errors.has('type') }">
                                    <option disabled value="">Select One</option>
                                    <option value="admin">Admin</option>
                                    <option value="author">Author</option>
                                    <option value="user">User</option>
                                </select>
                                <has-error :form="form" field="type"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input v-model="form.password" type="password" name="password" class="form-control"
                                    placeholder="Enter a user password" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" v-show="!editmode">Save</button>
                            <button type="submit" class="btn btn-success" v-show="editmode">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                editmode: false,
                users: {},
                // Create a new form instance
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    about: '',
                    type: '',
                    position: '',
                    password: '',
                    photo: '',
                })
            }
        },
        methods: {
            updateUser() {
                this.$Progress.start()
                this.form.put("/api/users/" + this.form.id)
                    .then(() => {
                        $('#addNew').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'User Update in successfully'
                        })
                        Fire.$emit('AfterCreate')
                        this.$Progress.finish()
                    }).catch(() => {
                        this.$Progress.fail()
                    })
            },
            editModel(user) {
                this.editmode = true;
                this.form.reset()
                this.form.clear()
                $('#addNew').modal('show')
                this.form.fill(user)
            },
            newModel() {
                this.editmode = false;
                this.form.reset()
                this.form.clear()
                $('#addNew').modal('show')
            },
            deleteUser(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start()
                        this.form.delete('/api/users/' + id)
                            .then(() => {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                                this.$Progress.finish()
                                Fire.$emit('AfterCreate')
                            }).catch(() => {
                                this.$Progress.fail()
                            })

                    }
                })
            },
            createUser() {
                this.$Progress.start()
                this.form.post("/api/users")
                    .then(() => {
                        $('#addNew').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'User Create in successfully'
                        })
                        Fire.$emit('AfterCreate')
                        this.$Progress.finish()
                    }).catch(() => {
                        this.$Progress.fail()
                    })
            },

            loadUser() {
                this.$Progress.start()
                axios.get('/api/users').then(({
                    data
                }) => {
                    this.users = data
                    this.$Progress.finish()
                }).catch(() => {
                    this.$Progress.fail()
                })
            },
        },
        mounted() {
            this.loadUser();
            Fire.$on('AfterCreate', () => {
                this.loadUser();
            })
        }
    }
</script>
