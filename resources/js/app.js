require('./bootstrap');
window.Vue = require('vue');

// Support vue router
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

const routes =
[
    {path: '/tag',component: require('./components/admin/TagComponent.vue').default},
    {path: '/category',component: require('./components/admin/CategoryComponent.vue').default},
]

const router = new VueRouter({
    routes // short for `routes: routes`
})

// Support v-form
import { Form, HasError, AlertError } from 'vform'
window.Form = Form

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

// Support vue progressbar
import VueProgressBar from 'vue-progressbar'

const options = {
    color: '#38c170',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
}

Vue.use(VueProgressBar, options)

// Import sweet alert
import Swal from 'sweetalert2'
window.Swal = Swal
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
window.Toast = Toast

//Fire import
window.Fire = new Vue();


Vue.component('example-component', require('./components/ExampleComponent.vue').default);


const app = new Vue({
    router
}).$mount('#app')