import Vue from 'vue';
import Cookies from 'js-cookie';
import VueRouter from 'vue-router';

import AuthLayout from '@/views/layout/auth';
import HelpdeskLayout from '@/views/layout/helpdesk';
import DashboardLayout from "@/views/layout/dashboard";

import AuthLoginPage from '@/views/pages/auth/login';
import AuthRegisterPage from '@/views/pages/auth/register';
import AuthRecoverPage from '@/views/pages/auth/recover';
import AuthResetPage from '@/views/pages/auth/reset';

import HelpdeskTicketsListPage from "@/views/pages/tickets/list";
import HelpdeskTicketsNewPage from "@/views/pages/tickets/new";
import HelpdeskTicketsManagePage from "@/views/pages/tickets/manage";

import DashboardHomePage from "@/views/pages/dashboard/home";



import DashboardTicketsList from "@/views/pages/dashboard/tickets/list";
import DashboardTicketsNew from "@/views/pages/dashboard/tickets/new";
import DashboardTicketsManage from "@/views/pages/dashboard/tickets/manage";
import DashboardTicketsEdit from "@/views/pages/dashboard/tickets/editEquipo"

import DashboardEquiposList from "@/views/pages/dashboard/equipos/list";
import DashboardEquiposNew from "@/views/pages/dashboard/equipos/new";
import DashboardEquiposManage from "@/views/pages/dashboard/equipos/manage";
import DashboardEquiposEdit from "@/views/pages/dashboard/equipos/editEquipo"

import AdminDashboardStatusesList from "@/views/pages/dashboard/admin/statuses/list";
import AdminDashboardStatusesEdit from "@/views/pages/dashboard/admin/statuses/edit";

import AdminDashboardPrioritiesList from "@/views/pages/dashboard/admin/priorities/list";
import AdminDashboardPrioritiesEdit from "@/views/pages/dashboard/admin/priorities/edit";

import AdminDashboardUsersList from "@/views/pages/dashboard/admin/users/list";
import AdminDashboardUsersNew from "@/views/pages/dashboard/admin/users/new";
import AdminDashboardUsersEdit from "@/views/pages/dashboard/admin/users/edit";

import AdminDashboardUserRolesList from "@/views/pages/dashboard/admin/user-roles/list";
import AdminDashboardUserRolesNew from "@/views/pages/dashboard/admin/user-roles/new";
import AdminDashboardUserRolesEdit from "@/views/pages/dashboard/admin/user-roles/edit";

import AdminDashboardSettingsIndex from "@/views/pages/dashboard/admin/settings";
import AdminDashboardSettingsGeneral from "@/views/pages/dashboard/admin/settings/general";
import AdminDashboardSettingsSEO from "@/views/pages/dashboard/admin/settings/seo";
import AdminDashboardSettingsAppearance from "@/views/pages/dashboard/admin/settings/appearance";
import AdminDashboardSettingsLocalization from "@/views/pages/dashboard/admin/settings/localization";
import AdminDashboardSettingsAuthentication from "@/views/pages/dashboard/admin/settings/authentication";
import AdminDashboardSettingsOutgoingMail from "@/views/pages/dashboard/admin/settings/outgoing-mail";
import AdminDashboardSettingsLogging from "@/views/pages/dashboard/admin/settings/logging";
import AdminDashboardSettingsCaptcha from "@/views/pages/dashboard/admin/settings/captcha";

import AdminDashboardLanguagesList from "@/views/pages/dashboard/admin/language/list";
import AdminDashboardLanguagesNew from "@/views/pages/dashboard/admin/language/new";
import AdminDashboardLanguagesEdit from "@/views/pages/dashboard/admin/language/edit";


import AdminDashboardTurnosList from "@/views/pages/dashboard/admin/turnos/list";
import AdminDashboardTurnosNew from "@/views/pages/dashboard/admin/turnos/new";
import AdminDashboardTurnosEdit from "@/views/pages/dashboard/admin/turnos/Edit";


import AdminDashboardOficinasList from "@/views/pages/dashboard/admin/oficinas/list";
import AdminDashboardOficinasNew from "@/views/pages/dashboard/admin/oficinas/new";
import AdminDashboardOficinasEdit from "@/views/pages/dashboard/admin/oficinas/edit";

import AdminDashboardCategoriasList from "@/views/pages/dashboard/admin/categorias/list";
import AdminDashboardCategoriasNew from "@/views/pages/dashboard/admin/categorias/new";
import AdminDashboardCategoriasEdit from "@/views/pages/dashboard/admin/categorias/edit";


import AccountPage from "@/views/pages/account/account";

import DashboardNotFoundPage from "@/views/pages/dashboard/error/not-found";
import PageNotFoundPage from "@/views/pages/error/not-found";

import AdminDashboardEmpleadosList from "@/views/pages/dashboard/admin/empleados/list";
import AdminDashboardEmpleadosNew from "@/views/pages/dashboard/admin/empleados/new";
import AdminDashboardEmpleadosEdit from "@/views/pages/dashboard/admin/empleados/edit";


import DashboardDirectorioList from "@/views/pages/dashboard/directorios/list";
import DashboardDirectorioNew from "@/views/pages/dashboard/directorios/new";
import DashboardDirectorioEdit from "@/views/pages/dashboard/directorios/edit";

import AdminDashboardChecklistList from "@/views/pages/dashboard/admin/checklist/list";
import AdminDashboardChecklistNew from "@/views/pages/dashboard/admin/checklist/new";


import DashboardAdminActivityList from "@/views/pages/dashboard/admin/activity/list"
import DashboardAdminActivityNew from "@/views/pages/dashboard/admin/activity/new"
import DashboardAdminActivityEdit from "@/views/pages/dashboard/admin/activity/edit"

import DashboardAdminPersonalList from "@/views/pages/dashboard/admin/personal/list";
import DashboardAdminPersonalNew from "@/views/pages/dashboard/admin/personal/new";
import DashboardAdminPersonalEdit from "@/views/pages/dashboard/admin/personal/edit";

import DashboardAdminCalendarList from "@/views/pages/dashboard/admin/calendar/list";
import DashboardAdminCalendarNew from "@/views/pages/dashboard/admin/calendar/new";
import DashboardAdminCalendarEdit from "@/views/pages/dashboard/admin/calendar/edit";


Vue.use(VueRouter);

let routes = [
    {
        path: '/', redirect: '/auth/login',
    },
    {
        path: '/auth', component: AuthLayout, redirect: '/auth/login',
        children: [
            {path: 'login', component: AuthLoginPage, meta: {middleware: 'guest'}},
            {path: 'register', component: AuthRegisterPage, meta: {middleware: ['guest', 'register']}},
            {path: 'recover', component: AuthRecoverPage, meta: {middleware: 'guest'}},
            {path: 'reset/:token', component: AuthResetPage, meta: {middleware: 'guest'}},
        ]
    },
    {
        path: '/dashboard', component: DashboardLayout, redirect: '/dashboard/home', meta: {dashboard_access: true},
        children: [
            {path: 'home', component: DashboardHomePage, meta: {middleware: 'auth', dashboard_access: true}},
            
            {path: 'Equipos', component: DashboardEquiposList, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.TicketController'}},
            {path: 'Equipos/new', component: DashboardEquiposNew, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.TicketController'}},
            {path: 'Equipos/:uuid/manage', component: DashboardEquiposManage, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.TicketController'}},
            {path: 'Equipos/:uuid/edit', component: DashboardEquiposEdit, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.TicketController'}},
                        
            {path: 'Directorio-de-equipos', component:DashboardDirectorioList, meta: {middleware:'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.DirectorioController'}},
            {path: 'Directorio-de-equipos/new', component:DashboardDirectorioNew, meta: {middleware:'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.DirectorioController'}},
            {path: 'Directorio-de-equipos/edit', component:DashboardDirectorioEdit, meta: {middleware:'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.DirectorioController'}},

            
            {path: 'admin/checklist', component:AdminDashboardChecklistList, meta:{middleware:'auth',dashboard_access:true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.ChecklistController'}},
            {path: 'admin/checklist/new', component:AdminDashboardChecklistNew, meta:{middleware:'auth',dashboard_access:true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.ChecklistController'}},
            //CAMBIOS CATALOGOS
            
            {path: 'admin/oficinas', component: AdminDashboardOficinasList, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.OficinasController'}},
            {path: 'admin/oficinas/new', component: AdminDashboardOficinasNew, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.OficinasController'}},
            {path: 'admin/oficinas/:id/edit', component: AdminDashboardOficinasEdit, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.OficinasController'}},

            {path: 'admin/turnos', component: AdminDashboardTurnosList, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.TurnoController'}},
            {path: 'admin/turnos/new', component: AdminDashboardTurnosNew, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.TurnoController'}},
            {path: 'admin/turnos/:id/edit', component: AdminDashboardTurnosEdit, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.TurnoController'}},
             
            {path: 'admin/categorias', component: AdminDashboardCategoriasList, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.CategoriasController'}},
            {path: 'admin/categorias/new', component: AdminDashboardCategoriasNew, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.CategoriasController'}},
            {path: 'admin/categorias/:id/edit', component: AdminDashboardCategoriasEdit, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.CategoriasController'}},

            {path: 'admin/empleados', component: AdminDashboardEmpleadosList, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.EmpleadosController'}},
            {path: 'admin/empleados/new', component: AdminDashboardEmpleadosNew, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.EmpleadosController'}},
            {path: 'admin/empleados/:id/edit', component: AdminDashboardEmpleadosEdit, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.EmpleadosController'}},


            {path: 'admin/activity', component:DashboardAdminActivityList, meta:{middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.EmpleadosController'}},
            {path: 'admin/activity/new', component:DashboardAdminActivityNew, meta:{middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.EmpleadosController'}},
            {path: 'admin/activity/:id/edit', component:DashboardAdminActivityEdit, meta:{middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.EmpleadosController'}},
            //FIN DE LOS CAMBIOS DE CATALOGOS
            {path: 'admin/statuses', component: AdminDashboardStatusesList, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.StatusController'}},
            {path: 'admin/statuses/:id/edit', component: AdminDashboardStatusesEdit, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.StatusController'}},

            {path: 'admin/personal', component:DashboardAdminPersonalList, meta:{middleware:'auth', dashboard_access:true, controller:'App.Http.Controllers.Api.Dashboard.Admin.PersonalController'}},
            {path: 'admin/personal/new', component:DashboardAdminPersonalNew, meta:{middleware:'auth', dashboard_access:true, controller:'App.Http.Controllers.Api.Dashboard.Admin.PersonalController'}},
            {path: 'admin/personal/:id/edit', component:DashboardAdminPersonalEdit, meta:{middleware:'auth', dashboard_access:true, controller:'App.Http.Controllers.Api.Dashboard.Admin.PersonalController'}},

            {path: 'admin/calendar', component:DashboardAdminCalendarList, meta:{middleware:'auth', dashboard_access:true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.CalendarController'}},

            {path: 'admin/priorities', component: AdminDashboardPrioritiesList, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.PriorityController'}},
            {path: 'admin/priorities/:id/edit', component: AdminDashboardPrioritiesEdit, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.PriorityController'}},

            {path: 'admin/users', component: AdminDashboardUsersList, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.UserController'}},
            {path: 'admin/users/new', component: AdminDashboardUsersNew, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.UserController'}},
            {path: 'admin/users/:id/edit', component: AdminDashboardUsersEdit, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.UserController'}},

            {path: 'admin/user-roles', component: AdminDashboardUserRolesList, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.UserRoleController'}},
            {path: 'admin/user-roles/new', component: AdminDashboardUserRolesNew, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.UserRoleController'}},
            {path: 'admin/user-roles/:id/edit', component: AdminDashboardUserRolesEdit, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.UserRoleController'}},

            {path: 'admin/settings', component: AdminDashboardSettingsIndex, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.SettingController'}},
            {path: 'admin/settings/general', component: AdminDashboardSettingsGeneral, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.SettingController'}},
            {path: 'admin/settings/seo', component: AdminDashboardSettingsSEO, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.SettingController'}},
            {path: 'admin/settings/appearance', component: AdminDashboardSettingsAppearance, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.SettingController'}},
            {path: 'admin/settings/localization', component: AdminDashboardSettingsLocalization, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.SettingController'}},
            {path: 'admin/settings/authentication', component: AdminDashboardSettingsAuthentication, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.SettingController'}},
            {path: 'admin/settings/outgoing-mail', component: AdminDashboardSettingsOutgoingMail, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.SettingController'}},
            {path: 'admin/settings/logging', component: AdminDashboardSettingsLogging, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.SettingController'}},
            {path: 'admin/settings/captcha', component: AdminDashboardSettingsCaptcha, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.SettingController'}},

            {path: 'admin/languages', component: AdminDashboardLanguagesList, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.LanguageController'}},
            {path: 'admin/languages/new', component: AdminDashboardLanguagesNew, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.LanguageController'}},
            {path: 'admin/languages/:id/edit', component: AdminDashboardLanguagesEdit, meta: {middleware: 'auth', dashboard_access: true, controller: 'App.Http.Controllers.Api.Dashboard.Admin.LanguageController'}},

            {path: '*', component: DashboardNotFoundPage, meta: {middleware: 'auth', dashboard_access: true}},
        ],
        scrollBehavior(to, from, savedPosition) {
            return { x: 0, y: 0 };
          },
    },
    {
        path: '/account', component: AccountPage, meta: {middleware: 'auth'},
    },
    {path: '*', component: PageNotFoundPage},
];

let router = new VueRouter({
    routes,
    mode: "history"
});

// Router auth middleware
router.beforeResolve((to, from, next) => {
    if (to.meta.middleware || to.meta.controller) {
        if (!localStorage.getItem('token') && to.meta.middleware.includes('auth')) {
            Cookies.set('intended_url', to.path);
            next('/auth/login');
        } else if (!window.app.register && to.meta.middleware.includes('register')) {
            next('/auth/login');
        } else if (localStorage.getItem('token') && to.meta.middleware.includes('guest')) {
            next('/dashboard/admin/Calendar');
        } else if (localStorage.getItem('token') && to.meta.middleware.includes('auth')) {
            axios.post('api/auth/check', {controller: to.meta.controller}).then(function (response) {
                if (!response.data.access) {
                    Cookies.set('intended_url', to.path);
                    next('/auth/login');
                } else {
                    if (to.meta.dashboard_access && !response.data.dashboard_access) {
                        next('/dashboard/admin/Calendar');
                    } else {
                        response.data.access ? next() : to.meta.controller ? next('/dashboard/home') : next('/auth/login');
                    }
                }
            });
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
