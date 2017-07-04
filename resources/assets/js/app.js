
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */
import App from './App.vue';
import store from './vuex/store.js';

//element
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-default/index.css';
import 'font-awesome/css/font-awesome.min.css';

//vueRouter
import VueRouter from 'vue-router';
import routes from './routes.js';

import NProgress from 'nprogress';
import 'nprogress/nprogress.css';

Vue.use(NProgress);
Vue.use(ElementUI);
Vue.use(VueRouter);

Vue.component('vue-table-pagination', require('./components/dashboard/TablePagination.vue'));
Vue.component('vue-table', require('./components/dashboard/Table.vue'));
Vue.component('passport-clients', require('./components/passport/Clients.vue'));
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue'));
Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue'));

const router = new VueRouter({
    history: true,
    root: 'dashboard',
    linkActiveClass: 'active',
    routes
});



//start
new Vue({router, store, render: h => h(App)}).$mount('#app')