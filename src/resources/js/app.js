require('./bootstrap');

window.Vue = require('vue');

import CKEditor from '@ckeditor/ckeditor5-vue';
import Filters from './filters';
import Multiselect from 'vue-multiselect'
import VeeValidate from 'vee-validate';
import VeeValidateLaravel from 'vee-validate-laravel';
import VueMoment from 'vue-moment';
import VueSweetalert2 from 'vue-sweetalert2';

Vue.use(CKEditor);
Vue.use(Filters);
Vue.use(Multiselect);
Vue.use(VeeValidate);
Vue.use(VeeValidateLaravel);
Vue.use(VueMoment);
Vue.use(VueSweetalert2);

Vue.component('blog-index', require('./views/Index').default);
Vue.component('blog-show', require('./views/Show').default);
Vue.component('file-uploader', require('./components/FileUploader').default);
Vue.component('multiselect', Multiselect);
Vue.component('post-filter', require('./components/PostFilter').default);
Vue.component('post-form', require('./components/PostForm').default);
Vue.component('posts', require('./components/Posts').default);

const app = new Vue({}).$mount('#app');