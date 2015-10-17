import Vue from 'Vue'
import VueResource from 'vue-resource'
Vue.use(VueResource);
Vue.http.headers.common['X-CSRF-TOKEN'] = window.document.querySelector('meta#token').value;

import app from './app'
new Vue(app).$mount('#app');