<template>
        <div class="row justify-content-center">
            <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Testimonials Table</h3>

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
                                <th>Photo</th>
                                <th>Details</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(testimonial, index) in testimonials" :key="testimonial.id">
                                <td>{{ index+1 }}</td>
                                <td v-if="testimonial.photo"><img class="profile-user-img img-fluid img-circle" :src="getPhoto(testimonial.photo)" alt="No Image"></td>
                                <td>{{ testimonial.details|sortlength(35,'. . .') }}</td>
                                <td>{{ testimonial.name }}</td>
                                <td>{{ testimonial.created_at|timeFormat}}</td>
                                <td>
                                     <a href="#" class="alert-link" @click="editModel(testimonial)"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                     <a href="#" class="alert-link" @click="deletetestimonial(testimonial.id)"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
                            <h5 class="modal-title" id="addNewTitle" v-show="editmode">Update testimonials</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form @submit.prevent="editmode ? updatetestimonial() : createtestimonial()" @keydown="form.onKeydown($event)">
                            <div class="modal-body">
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Upload Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input @change="changePhoto($event)" class="custom-file-input"
                                                    name="photo" type="file"
                                                    :class="{ 'is-invalid': form.errors.has('photo') }">
                                                <has-error :form="form" field="photo"></has-error>
                                                <label class="custom-file-label" for="exampleInputFile">Choose
                                                    file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="timeline-body">
                                        <label class="text-center">Image</label>
                                        <img :src="editmode ? updateImage() : form.photo" width="130" height="100">
                                    </div>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label>Details</label>
                                    <textarea v-model="form.details" id="details" name="details" class="form-control" rows="5"
                                        placeholder="Enter a post details"
                                        :class="{ 'is-invalid': form.errors.has('details') }"></textarea>
                                    <has-error :form="form" field="details"></has-error>
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input v-model="form.name" type="text" name="name" class="form-control"
                                        placeholder="ex: Abdullah" :class="{ 'is-invalid': form.errors.has('name') }">
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
                    testimonials: {},
                    // Create a new form instance
                    form: new Form({
                        id:'',
                        photo: '',
                        details: '',
                        name: '',
                    })
                }
            },
            methods: {
                updatetestimonial(){
                this.$Progress.start()
                this.form.put("/api/testimonials/"+this.form.id)
                    .then(() => {
                        $('#addNew').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'testimonial Update in successfully'
                        })
                        Fire.$emit('AfterCreate')
                        this.$Progress.finish()
                    }).catch(() => {
                        this.$Progress.fail()
                    })
                },
                updateImage() {
                    let img = this.form.photo;
                    if (img.length > 200) {
                        return this.form.photo
                    } else {
                        return `assets/admin/image/upload/${this.form.photo}`
                    }
                },
                getPhoto(img){
                    return "assets/admin/image/upload/"+img;
                }, 
                changePhoto(event) {
                    let file = event.target.files[0];
                    if (file.size > 1048576) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Image is too large!'
                        })
                    } else {
                        let reader = new FileReader();
                        reader.onload = event => {
                            this.form.photo = event.target.result
                            console.log(event.target.result)
                        };
                        reader.readAsDataURL(file);
                    }
                },
                editModel(testimonial){
                    this.editmode = true;
                    this.form.reset()
                    this.form.clear()
                    $('#addNew').modal('show')
                    this.form.fill(testimonial)
                },
                newModel(){
                    this.editmode = false;
                    this.form.reset()
                    this.form.clear()
                    $('#addNew').modal('show')
                },
                deletetestimonial(id) {
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
                            this.form.delete('/api/testimonials/' + id)
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
                createtestimonial() {
                    this.$Progress.start()
                    this.form.post("/api/testimonials")
                        .then(() => {
                            $('#addNew').modal('hide')
                            Toast.fire({
                                icon: 'success',
                                title: 'testimonial Create in successfully'
                            })
                            Fire.$emit('AfterCreate')
                            this.$Progress.finish()
                        }).catch(() => {
                            this.$Progress.fail()
                        })
                },

                loadtestimonial() {
                    this.$Progress.start()
                    axios.get('/api/testimonials').then(({
                        data
                    }) => {
                        this.testimonials = data.data
                        this.$Progress.finish()
                    }).catch(() => {
                        this.$Progress.fail()
                    })
                },
            },
            mounted() {
                this.loadtestimonial();
                Fire.$on('AfterCreate', () => {
                    this.loadtestimonial();
                })
            }
    }
</script>
