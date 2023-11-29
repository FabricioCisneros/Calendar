<template>
    <div>
        <div class="my-3 mx-4 uppercase text-gray-200 text-xs">
            {{ $t('General') }}
        </div>
        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.StatusController']"
             :label="$t('Calendario') " :mobile="mobile" icon="font-awesome.calendar-regular" to="/dashboard/admin/calendar"></menu-item>
          
        <div
            v-if="$store.state.permissions && (
                $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.UserController'] ||
                $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.UserRoleController'] ||
                $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.SettingController'] ||
                $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.LanguageController']
            )"
            class="my-3 mx-4 uppercase text-gray-300 text-xs"
        >
            {{ $t('Administration') }}
        </div>

        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.StatusController']"
            :label="$t('Actividades')"
            :mobile="mobile"
            icon="font-awesome.tasks-regular"
            to="/dashboard/admin/activity"
        ></menu-item>
        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.CategoriasController']"
            :label="$t('Categorias')" :mobile="mobile" icon="font-awesome.tags-regular"
            to="/dashboard/admin/categorias"></menu-item>
    
        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.StatusController']"
            :label="$t('Estatus de la actividad')"
            :mobile="mobile"
            icon="font-awesome.tasks-regular"
            to="/dashboard/admin/statuses"
        ></menu-item>

        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.StatusController']"
            :label="$t('Personal')"
            :mobile="mobile"
            icon="font-awesome.user-regular"
            to="/dashboard/admin/personal"
        ></menu-item>

        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.UserController']"
            :label="$t('Users')"
            :mobile="mobile"
            icon="font-awesome.users-regular"
            to="/dashboard/admin/users"
        ></menu-item>


        <div  class="my-3 mx-4 uppercase text-gray-300 text-xs" >Configuracion del sitio</div>
        <menu-item
            
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.UserRoleController']"
            :label="$t('User roles')"
            :mobile="mobile"
            icon="font-awesome.id-card-regular"
            to="/dashboard/admin/user-roles"
        ></menu-item>
        <menu-item
            v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.SettingController']"
            :label="$t('Settings')"
            :mobile="mobile"
            icon="font-awesome.cog-regular"
            to="/dashboard/admin/settings"
        ></menu-item>
    </div>
</template>

<script>
import MenuItem from "@/components/layout/dashboard/menu/menu-item";

export default {
    name: "menu-list",
    components: {MenuItem},
    props: {
        mobile: {
            type: Boolean,
            required: false
        },
    }
}
</script>

