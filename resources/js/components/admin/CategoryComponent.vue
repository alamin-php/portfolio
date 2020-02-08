<template>
        <div class="row justify-content-center">
            <div class="col-md-8 mt-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categories Table</h3>

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
                                <th>Category name</th>
                                <th>Date</th>
                                <th>Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(category, index) in categories" :key="category.id">
                                <td>{{ index+1 }}</td>
                                <td>{{ category.name }}</td>
                                <td>{{ category.created_at|timeFormat}}</td>
                                <td>
                                     <a href="#" class="alert-link" @click="editModel(category)"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                     <a href="#" class="alert-link" @click="deletecategory(category.id)"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
                            <h5 class="modal-title" id="addNewTitle" v-show="editmode">Update categories</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="editmode ? updatecategory() : createcategory()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input v-model="form.name" type="text" name="name" class="form-control"
                                        placeholder="Enter a category name" :class="{ 'is-invalid': form.errors.has('name') }">
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
                    categories: {},
                    // Create a new form instance
                    form: new Form({
                        id:'',
                        name: '',
                    })
                }
            },
            methods: {
                updatecategory(){
                this.$Progress.start()
                this.form.put("/api/categories/"+this.form.id)
                    .then(() => {
                        $('#addNew').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Category Update in successfully'
                        })
                        Fire.$emit('AfterCreate')
                        this.$Progress.finish()
                    }).catch(() => {
                        this.$Progress.fail()
                    })
                },
                editModel(category){
                    this.editmode = true;
                    this.form.reset()
                    this.form.clear()
                    $('#addNew').modal('show')
                    this.form.fill(category)
                },
                newModel(){
                    this.editmode = false;
                    this.form.reset()
                    this.form.clear()
                    $('#addNew').modal('show')
                },
                deletecategory(id) {
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
                            this.form.delete('/api/categories/' + id)
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
                createcategory() {
                    this.$Progress.start()
                    this.form.post("/api/categories")
                        .then(() => {
                            $('#addNew').modal('hide')
                            Toast.fire({
                                icon: 'success',
                                title: 'Category Create in successfully'
                            })
                            Fire.$emit('AfterCreate')
                            this.$Progress.finish()
                        }).catch(() => {
                            this.$Progress.fail()
                        })
                },

                loadcategory() {
                    this.$Progress.start()
                    axios.get('/api/categories').then(({
                        data
                    }) => {
                        this.categories = data
                        this.$Progress.finish()
                    }).catch(() => {
                        this.$Progress.fail()
                    })
                },
            },
            mounted() {
                this.loadcategory();
                Fire.$on('AfterCreate', () => {
                    this.loadcategory();
                })
            }
    }
</script>
