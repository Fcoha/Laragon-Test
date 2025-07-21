import Vue from 'vue';
import Router from 'vue-router';
import Home from '../views/MainPage.vue';
import Login from '../views/Login.vue';
import Register from '../views/Login.vue';
import Dashboard from '../views/Dashboard.vue';
import DashboardAdmin from '../views/DashboardAdmin.vue'

Vue.use(Router);

const routes = [
    {path: '/', name: 'Home', component: Home},
    {path: '/login', name: 'Login', component: Login},
    {path: '/register', name: 'Register', component: Register},
    {path: '/dashboard', name: 'Dashboard', component: Dashboard},
    {path: '/dashboardadmin', name: 'DashboardAdmin', component: DashboardAdmin}
];

export default new Router({
  mode: 'history',
  routes,
});