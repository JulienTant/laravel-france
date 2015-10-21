import Vue from 'Vue'
import VueResource from 'vue-resource'
Vue.config.debug = true;

Vue.use(VueResource);
Vue.http.headers.common['X-CSRF-TOKEN'] = window.document.querySelector('meta#token').getAttribute('value');
//Vue.http.otpions.common['X-CSRF-TOKEN'] = window.document.querySelector('meta#token').getAttribute('value');


import app from './app'
new Vue(app).$mount('#app');