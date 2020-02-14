require('./bootstrap');
window.Vue = require('vue');
// support moment
//Support momments

import {
    filter
} from './filter'

// Support vue router
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

//import router
import {routes} from './routes'

const router = new VueRouter({
    mode: 'history',
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
Vue.component('public-master', require('./components/public/PublicMaster.vue').default);

//Passport-View
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);


// Vue.filter('upText', function (text) {
//     return text.charAt(0).toUpperCase() + text.slice(1)
// });

// Vue.filter('timeFormat', (arg) => {
//     return moment(arg).format("Do MMM YYYY");
// });

// Vue.filter('sortlength', function (text, length, suffix) {
//     return text.substring(0, length) + suffix;
// });


const app = new Vue({
    router
}).$mount('#app')