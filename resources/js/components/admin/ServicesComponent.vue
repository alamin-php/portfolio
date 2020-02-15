<template>
        <div class="row justify-content-center">
            <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Services Table</h3>

                    <div class="card-tools">
                        <button class="btn btn-primary" @click="newModel">Add new <i class="fa fa-plus" aria-hidden="true"></i></button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Icon</th>
                                <th>Titel</th>
                                <th>Details</th>
                                <th>Date</th>
                                <th>Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(service, index) in services" :key="service.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ service.icon }}</td>
                                <td>{{ service.title }}</td>
                                <td>{{ service.details|sortlength(35,'. . .') }}</td>
                                <td>{{ service.created_at|timeFormat}}</td>
                                <td>
                                     <a href="#" class="alert-link" @click="editModel(service)"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                     <a href="#" class="alert-link" @click="deleteService(service.id)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNewTitle" v-show="!editmode">Create a new</h5>
                            <h5 class="modal-title" id="addNewTitle" v-show="editmode">Update services</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="editmode ? updateService() : createService()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Service Icon</label>
                                    <input v-model="form.icon" type="text" name="icon" class="form-control"
                                        placeholder="ex: fab fa-home" :class="{ 'is-invalid': form.errors.has('icon') }">
                                    <has-error :form="form" field="icon"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Service Title</label>
                                    <input v-model="form.title" type="text" name="title" class="form-control"
                                        placeholder="ex: Development" :class="{ 'is-invalid': form.errors.has('title') }">
                                    <has-error :form="form" field="title"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Post Body</label>
                                    <textarea v-model="form.details" id="details" name="details" class="form-control" rows="5"
                                        placeholder="Enter a post details"
                                        :class="{ 'is-invalid': form.errors.has('details') }"></textarea>
                                    <has-error :form="form" field="details"></has-error>
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
                    editmode:false,
                    services: {},
                    // Create a new form instance
                    form: new Form({
                        id:'',
                        icon: '',
                        title: '',
                        details: '',
                    })
                }
            },
            methods: {
                updateService(){
                this.$Progress.start()
                this.form.put("/api/services/"+this.form.id)
                    .then(() => {
                        $('#addNew').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Service Update in successfully'
                        })
                        Fire.$emit('AfterCreate')
                        this.$Progress.finish()
                    }).catch(() => {
                        this.$Progress.fail()
                    })
                },
                editModel(service){
                    this.editmode = true;
                    this.form.reset()
                    this.form.clear()
                    $('#addNew').modal('show')
                    this.form.fill(service)
                },
                newModel(){
                    this.editmode = false;
                    this.form.reset()
                    this.form.clear()
                    $('#addNew').modal('show')
                },
                deleteService(id) {
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
                            this.form.delete('/api/services/' + id)
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
                createService() {
                    this.$Progress.start()
                    this.form.post("/api/services")
                        .then(() => {
                            $('#addNew').modal('hide')
                            Toast.fire({
                                icon: 'success',
                                title: 'Service Create in successfully'
                            })
                            Fire.$emit('AfterCreate')
                            this.$Progress.finish()
                        }).catch(() => {
                            this.$Progress.fail()
                        })
                },

                loadService() {
                    this.$Progress.start()
                    axios.get('/api/services').then(({
                        data
                    }) => {
                        this.services = data
                        this.$Progress.finish()
                    }).catch(() => {
                        this.$Progress.fail()
                    })
                },
            },
            mounted() {
                this.loadService();
                Fire.$on('AfterCreate', () => {
                    this.loadService();
                })
            }
    }
</script>
