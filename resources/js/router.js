import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './views/Home';
import CompaniesIndex from './views/CompaniesIndex';
import CompaniesCreate from './views/CompaniesCreate';
import CompaniesShow from './views/CompaniesShow';
import CompaniesEdit from './views/CompaniesEdit';
import EmployeesIndex from './views/EmployeesIndex';
import EmployeesCreate from './views/EmployeesCreate';
import EmployeesShow from './views/EmployeesShow';
import EmployeesEdit from './views/EmployeesEdit';

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', component: Home},
        { path: '/companies', component: CompaniesIndex},
        { path: '/companies/create', component: CompaniesCreate},
        { path: '/companies/:id', component: CompaniesShow},
        { path: '/companies/:id/edit', component: CompaniesEdit},
        { path: '/employees', component: EmployeesIndex},
        { path: '/employees/create', component: EmployeesCreate},
        { path: '/employees/:id', component: EmployeesShow},
        { path: '/employees/:id/edit', component: EmployeesEdit}
    ],
    mode: 'history'
});