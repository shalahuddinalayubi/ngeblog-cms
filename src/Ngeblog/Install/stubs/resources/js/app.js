import Vue from 'vue';
import VModal from 'vue-js-modal';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

window.Vue = require('vue').default;

Vue.use(VModal);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('tag', require('./../../vendor/ngeblog/app/src/Ngeblog/Tag/resources/js/components/Tag.vue').default);

Vue.component('reply-comment', require('./../../vendor/ngeblog/app/src/Ngeblog/Comment/resources/js/components/ReplyComment.vue').default)
Vue.component('edit-comment', require('./../../vendor/ngeblog/app/src/Ngeblog/Comment/resources/js/components/EditComment.vue').default)

Vue.component('the-post-editor', require('./../../vendor/ngeblog/app/src/Ngeblog/Post/resources/js/components/ThePostEditor').default)

Vue.component('the-navbar-dropdown-account', require('./../../vendor/ngeblog/app/src/Ngeblog/Template/resources/js/components/TheNavbarDropdownAccount.vue').default)
Vue.component('the-navbar-dropdown-post', require('./../../vendor/ngeblog/app/src/Ngeblog/Template/resources/js/components/TheNavbarDropdownPost.vue').default)
Vue.component('the-navbar-dropdown-file', require('./../../vendor/ngeblog/app/src/Ngeblog/Template/resources/js/components/TheNavbarDropdownFile.vue').default)

Vue.component('the-upload-file', require('./../../vendor/ngeblog/app/src/Ngeblog/File/resources/js/components/TheUploadFile.vue').default)

Vue.component('pagination', require('./../../vendor/ngeblog/app/src/Ngeblog/Post/resources/js/components/Pagination.vue').default)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
