<template>
    <span id="publichome">
        <div class="site-section bg-white">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h2 class="h4 mb-4">About Us</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae voluptatem mollitia
                            obcaecati
                            quod maxime. Soluta libero eligendi voluptatum, natus debitis.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum, quasi!</p>
                        <p><a href="#" class="btn btn-primary text-white px-5">Our works</a></p>
                    </div>
                    <div class="col-md-4">
                        <img src="assets/public/images/about_1.jpg" alt="Image" class="img-fluid">
                    </div>
                    <div class="col-md-4">

                        <h2 class="h4 mb-4">Our expertise and skills</h2>

                        <div class="progress-wrap mb-4">
                            <div class="d-flex">
                                <span>Writing</span>
                                <span class="ml-auto">55%</span>
                            </div>
                            <div class="progress rounded-0" style="height: 7px;">
                                <div class="progress-bar" role="progressbar" style="width: 55%;" aria-valuenow="55"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="progress-wrap mb-4">
                            <div class="d-flex">
                                <span>WordPress</span>
                                <span class="ml-auto">85%</span>
                            </div>
                            <div class="progress rounded-0" style="height: 7px;">
                                <div class="progress-bar" role="progressbar" style="width: 85%;" aria-valuenow="85"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="progress-wrap mb-4">
                            <div class="d-flex">
                                <span>Bootstrap</span>
                                <span class="ml-auto">93%</span>
                            </div>
                            <div class="progress rounded-0" style="height: 7px;">
                                <div class="progress-bar" role="progressbar" style="width: 93%;" aria-valuenow="93"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <div class="progress-wrap mb-4">
                            <div class="d-flex">
                                <span>jQuery</span>
                                <span class="ml-auto">83%</span>
                            </div>
                            <div class="progress rounded-0" style="height: 7px;">
                                <div class="progress-bar" role="progressbar" style="width: 83%;" aria-valuenow="83"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <div class="site-section bg-light">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md-7 mx-auto text-center">
                        <h2 class="heading-29190">Our Services</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-3" v-for="service in services.slice(0, 4)" :key="service.id">
                        <div class="service-29128 text-center">
                            <span class="d-block wrap-icon">
                                <span class="icon-desktop_mac"></span>
                            </span>
                            <h3>{{ service.title }}</h3>
                            <p>{{ service.details|sortlength(100,' . .') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section bg-white">
      <div class="container">

        <div class="row mb-5">
          <div class="col-md-7 mx-auto text-center">
            <h2 class="heading-29190">Our Works</h2>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="item web">
              <a href="work-single.html" class="item-wrap" data-fancybox="gal">
                <span class="icon-add"></span>
                <img class="img-fluid" src="assets/public/images/img_1.jpg">
              </a>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4">
            <div class="item web">
              <a href="work-single.html" class="item-wrap" data-fancybox="gal">
                <span class="icon-add"></span>
                <img class="img-fluid" src="assets/public/images/img_2.jpg">
              </a>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4">
            <div class="item web">
              <a href="work-single.html" class="item-wrap" data-fancybox="gal">
                <span class="icon-add"></span>
                <img class="img-fluid" src="assets/public/images/img_3.jpg">
              </a>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4">
            <div class="item web">
              <a href="work-single.html" class="item-wrap" data-fancybox="gal">
                <span class="icon-add"></span>
                <img class="img-fluid" src="assets/public/images/img_4.jpg">
              </a>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4">
            <div class="item web">
              <a href="work-single.html" class="item-wrap" data-fancybox="gal">
                <span class="icon-add"></span>
                <img class="img-fluid" src="assets/public/images/img_5.jpg">
              </a>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-4">
            <div class="item web">
              <a href="work-single.html" class="item-wrap" data-fancybox="gal">
                <span class="icon-add"></span>
                <img class="img-fluid" src="assets/public/images/img_6.jpg">
              </a>
            </div>
          </div>

        </div>

        
      </div>
    </div>

    <div class="site-section bg-light">
      <div class="container">

        <div class="row mb-5">
          <div class="col-md-7 mx-auto text-center">
            <h2 class="heading-29190">Testimonials</h2>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6" v-for="testimonial in testimonials.slice(0, 3)" :key="testimonial.id">
            
            <div>
              <div class="person-pic-39219 mb-4">
                <img :src="getTestimPhoto(testimonial.photo)" alt="Image" class="img-fluid">
              </div>  
              
              <blockquote class="quote_39823">
                <p>{{ testimonial.details }}</p>
              </blockquote>
              <p>— {{ testimonial.name }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
 <div class="site-section bg-white">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-7 mx-auto text-center">
            <h2 class="heading-29190">Blog</h2>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="post-entry-1 h-100">
              <a href="single.html">
                <img src="assets/public/images/img_1.jpg" alt="Image"
                 class="img-fluid">
              </a>
              <div class="post-entry-1-contents">
                
                <h2><a href="single.html">Lorem ipsum dolor sit amet</a></h2>
                <span class="meta d-inline-block mb-3">July 17, 2019 <span class="mx-2">by</span> <a href="#">Admin</a></span>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores eos soluta, dolore harum molestias consectetur.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="post-entry-1 h-100">
              <a href="single.html">
                <img src="assets/public/images/img_2.jpg" alt="Image"
                 class="img-fluid">
              </a>
              <div class="post-entry-1-contents">
                
                <h2><a href="single.html">Lorem ipsum dolor sit amet</a></h2>
                <span class="meta d-inline-block mb-3">July 17, 2019 <span class="mx-2">by</span> <a href="#">Admin</a></span>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores eos soluta, dolore harum molestias consectetur.</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="post-entry-1 h-100">
              <a href="single.html">
                <img src="assets/public/images/img_3.jpg" alt="Image"
                 class="img-fluid">
              </a>
              <div class="post-entry-1-contents">
                
                <h2><a href="single.html">Lorem ipsum dolor sit amet</a></h2>
                <span class="meta d-inline-block mb-3">July 17, 2019 <span class="mx-2">by</span> <a href="#">Admin</a></span>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores eos soluta, dolore harum molestias consectetur.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </span>
</template>
<script>
    export default {
      data() {
        return {
            services: {},
            testimonials: {},
        }
    },
    methods:{
      getTestimPhoto(img) {
          return "assets/admin/image/upload/" + img;
      },
      loadTestimonial() {
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
      loadService() {
          this.$Progress.start()
          axios.get('/api/services').then(({
              data
          }) => {
              this.services = data.data
              this.$Progress.finish()
          }).catch(() => {
              this.$Progress.fail()
          })
      },
    },
    mounted() {
        this.loadService();
        this.loadTestimonial(),
        Fire.$on('AfterCreate', () => {
            this.loadService();
        })
    }
    }
</script>
