<template>
        <div class="row justify-content-center">
            <div class="col-md-8 mt-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tags Table</h3>

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
                                <th>Tag name</th>
                                <th>Date</th>
                                <th>Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(tag, index) in tags" :key="tag.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ tag.name }}</td>
                                <td>{{ tag.created_at|timeFormat }}</td>
                                <td>
                                     <a href="#" class="alert-link" @click="editModel(tag)"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                     <a href="#" class="alert-link" @click="deleteTag(tag.id)"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
                            <h5 class="modal-title" id="addNewTitle" v-show="editmode">Update tags</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="editmode ? updateTag() : createTag()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Tag Name</label>
                                    <input v-model="form.name" type="text" name="name" class="form-control"
                                        placeholder="Enter a tag name" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
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
                    tags: {},
                    // Create a new form instance
                    form: new Form({
                        id:'',
                        name: '',
                    })
                }
            },
            methods: {
                updateTag(){
                this.$Progress.start()
                this.form.put("/api/tags/"+this.form.id)
                    .then(() => {
                        $('#addNew').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Tag Update in successfully'
                        })
                        Fire.$emit('AfterCreate')
                        this.$Progress.finish()
                    }).catch(() => {
                        this.$Progress.fail()
                    })
                },
                editModel(tag){
                    this.editmode = true;
                    this.form.reset()
                    this.form.clear()
                    $('#addNew').modal('show')
                    this.form.fill(tag)
                },
                newModel(){
                    this.editmode = false;
                    this.form.reset()
                    this.form.clear()
                    $('#addNew').modal('show')
                },
                deleteTag(id) {
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
                            this.form.delete('/api/tags/' + id)
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
                createTag() {
                    this.$Progress.start()
                    this.form.post("/api/tags")
                        .then(() => {
                            $('#addNew').modal('hide')
                            Toast.fire({
                                icon: 'success',
                                title: 'Tag Create in successfully'
                            })
                            Fire.$emit('AfterCreate')
                            this.$Progress.finish()
                        }).catch(() => {
                            this.$Progress.fail()
                        })
                },

                loadTag() {
                    this.$Progress.start()
                    axios.get('/api/tags').then(({
                        data
                    }) => {
                        this.tags = data
                        this.$Progress.finish()
                    }).catch(() => {
                        this.$Progress.fail()
                    })
                },
            },
            mounted() {
                this.loadTag();
                Fire.$on('AfterCreate', () => {
                    this.loadTag();
                })
            }
    }
</script>
