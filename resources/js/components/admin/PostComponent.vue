<template>
        <div class="row justify-content-center">
            <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Post's Table</h3>

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
                                <th>Post Title</th>
                                <th>Category</th>
                                <th>Tag</th>
                                <th>Post By</th>
                                <th>Post On</th>
                                <th>Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(post, index) in posts" :key="post.id">
                                <td>{{ index+1 }}</td>
                                <td class="font-weight-bold">{{ post.title|sortlength(25,'. . .') }}</td>
                                <td v-if="post.category">{{ post.category.name }}</td>
                                <td class="red" v-else>Unknow</td>
                                <td v-if="post.tag">{{ post.tag.name }}</td>
                                <td class="red" v-else>Unknow</td>
                                <td v-if="post.user">{{ post.user.name }}</td>
                                <td class="red" v-else>Unknow</td>
                                <td>{{ post.created_at|timeFormat}}</td>
                                <td>
                                     <a href="#" class="alert-link" @click="editModel(post)"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                     <a href="#" class="alert-link" @click="deletePost(post.id)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNewTitle" v-show="!editmode">Create a new post</h5>
                            <h5 class="modal-title" id="addNewTitle" v-show="editmode">Update Post</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                            <form enctype="multipart/form-data"
                                @submit.prevent="editmode ? updatePost() : createPost()"
                                @keydown="form.onKeydown($event)">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Post Title</label>
                                        <input v-model="form.title" type="text" name="title" class="form-control"
                                            placeholder="Enter a post title"
                                            :class="{ 'is-invalid': form.errors.has('title') }">
                                        <has-error :form="form" field="title"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label>Post Body</label>
                                        <textarea v-model="form.details" id="details" name="details" class="form-control" rows="10"
                                            placeholder="Enter a post details"
                                            :class="{ 'is-invalid': form.errors.has('details') }"></textarea>
                                        <has-error :form="form" field="details"></has-error>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Select Category</label>
                                                <select class="form-control" v-model="form.category_id" name="category_id"
                                                    :class="{ 'is-invalid': form.errors.has('category_id') }">
                                                    <option disabled value="">Select One</option>
                                                    <option v-for="category in categories" :value="category.id">
                                                        {{ category.name }}</option>
                                                </select>
                                                <has-error :form="form" field="category_id"></has-error>
                                            </div>
                                            <div class="form-group">
                                                <label>Select Tag</label>
                                                <select class="form-control" v-model="form.tag_id" name="tag_id"
                                                    :class="{ 'is-invalid': form.errors.has('tag_id') }">
                                                    <option disabled value="">Select One</option>
                                                    <option v-for="tag in tags" :value="tag.id">{{ tag.name }}</option>
                                                </select>
                                                <has-error :form="form" field="category_id"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Upload Post Image</label>
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
                                        <div class="col-md-4">
                                            <div class="timeline-body">
                                                <label class="text-center">Post Image</label>
                                                <img :src="editmode ? updatePostImage() : form.photo" width="230"
                                                    height="150">
                                            </div>
                                        </div>
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
                    tags: {},
                    posts: {},
                    // Create a new form instance
                    form: new Form({
                        id:'',
                        title: '',
                        details: '',
                        category_id: '',
                        tag_id: '',
                        status: '',
                        photo:'',
                    })
                }
            },
            methods: {
                updatePostImage() {
                    let img = this.form.photo;
                    if (img.length > 200) {
                        return this.form.photo
                    } else {
                        return `assets/admin/image/post/${this.form.photo}`
                    }
                },
                ourImage(img) {
                        return "assets/admin/image/post/" + img;
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
                updatePost(){
                this.$Progress.start()
                this.form.put("/api/posts/"+this.form.id)
                    .then(() => {
                        $('#addNew').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Post Update in successfully'
                        })
                        Fire.$emit('AfterCreate')
                        this.$Progress.finish()
                    }).catch(() => {
                        this.$Progress.fail()
                    })
                },
                editModel(post){
                    this.editmode = true;
                    this.form.reset()
                    this.form.clear()
                    $('#addNew').modal('show')
                    this.form.fill(post)
                },
                newModel(){
                    this.editmode = false;
                    this.form.reset()
                    this.form.clear()
                    $('#addNew').modal('show')
                },
                deletePost(id) {
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
                            this.form.delete('/api/posts/' + id)
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
                createPost() {
                    this.$Progress.start()
                    this.form.post("/api/posts")
                        .then(() => {
                            $('#addNew').modal('hide')
                            Toast.fire({
                                icon: 'success',
                                title: 'Post Create in successfully'
                            })
                            Fire.$emit('AfterCreate')
                            this.$Progress.finish()
                        }).catch(() => {
                            this.$Progress.fail()
                        })
                },

                loadPost() {
                    this.$Progress.start()
                    axios.get('/api/posts').then(({
                        data
                    }) => {
                        this.posts = data
                        this.$Progress.finish()
                    }).catch(() => {
                        this.$Progress.fail()
                    })
                },
                loadCat() {
                    axios.get('/api/categories').then(({data}) => {this.categories = data})
                },
                loadTag() {
                    axios.get('/api/tags').then(({data}) => {this.tags = data})
                },
            },
            mounted() {
                this.loadPost();
                this.loadCat();
                this.loadTag();
                Fire.$on('AfterCreate', () => {
                    this.loadPost();
                })
            }
    }
</script>
