<template>
    <div class="relative flex-1">
        <div class="bg-white border-b border-gray-200 py-6 sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Equipos Registrados') }}</h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <button id="verInactivos"
                        v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.DirectorioStoreController']"
                        class="justify-center w-auto rounded-full border border-gray-400 px-4 py-2 bg-gray text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 mr-9"
                        type="button"
                        @click="verInactivos"
                        style="display: flex; align-items: center;">
                        <div class="flex items-center justify-center">
                            <svg-vue class="h-4 w-4" icon="font-awesome.exclamation"></svg-vue>
                        </div>
                    </button>
                    <router-link
                        v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.DirectorioStoreController']"
                        class="btn btn-blue shadow-sm rounded-sm mr-4" to="/dashboard/Directorio-de-equipos/new">
                        {{ $t('Agregar nuevo equipo') }}
                    </router-link>

                    <div class="rounded-md flex shadow-sm mr-4">
                        <button id="filter-button"
                            class="inline-flex justify-center w-full rounded-md border border border-gray-400 px-4 py-2 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150"
                            type="button" @click="openFiltersSidebar">

                            <svg-vue class="self-center mr-3 h-4 w-4" icon="font-awesome.user-regular"></svg-vue>
                            {{ $t('Filtrar por empleado') }}
                            <svg-vue class="self-center ml-2.5 -mr-1.5 h-3 w-3"
                                icon="font-awesome.chevron-right-solid"></svg-vue>
                        </button>
                        <div v-show="filtersSidebar" class="fixed inset-0 overflow-hidden z-30">
                            <div class="absolute inset-0 overflow-hidden">
                                <section v-on-clickaway="closeFiltersSidebar" :style="{ top: '65px' }"
                                    class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
                                    <transition duration="500"
                                        enter-active-class="transform transition ease-in-out duration-500"
                                        enter-class="translate-x-full" enter-to-class="translate-x-0"
                                        leave-active-class="transform transition ease-in-out duration-500"
                                        leave-class="translate-x-0" leave-to-class="translate-x-full">
                                        <div v-show="filtersSidebar" class="w-screen max-w-xs">
                                            <div class="h-full flex flex-col space-y-4 bg-white shadow-xl">
                                                <header class="px-4 pt-4 sm:px-6">
                                                    <div class="flex items-start justify-between space-x-3">
                                                        <h2 class="text-lg leading-7 font-medium text-gray-900">
                                                            {{ $t('Filtrar por informacion de empleado') }}
                                                        </h2>
                                                        <div class="h-7 flex items-center">
                                                            <button aria-label="Close panel"
                                                                class="text-gray-400 hover:text-gray-500 transition ease-in-out duration-150"
                                                                type="button" @click="closeFiltersSidebar">
                                                                <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </header>
                                                <div class="relative flex-1 px-4 sm:px-6 h-full border-t overflow-y-scroll">
                                                    <div class="absolute inset-0 px-4 sm:px-6">
                                                        <div class="grid grid-cols-3 py-3">
                                                            <div class="col-span-3 mb-2">
                                                                <label
                                                                    class="block text-sm font-medium leading-5 text-gray-700"
                                                                    for="label">
                                                                    {{ $t('Buscar por nombre y/o numero de empleado') }}
                                                                </label>
                                                                <div class="relative flex-grow focus-within:z-10">
                                                                    <div
                                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                        <svg-vue class="h-4 w-4 text-gray-400"
                                                                            icon="font-awesome.user-regular"></svg-vue>
                                                                    </div>
                                                                    <input id="search" v-model.lazy="filters.searchEmpleado"
                                                                        :placeholder="$t('Nombre o Numero de empleado')"
                                                                        aria-label="Search"
                                                                        class="form-input block w-full rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                                                        @change="getDirectorio">
                                                                </div>
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label
                                                                    class="block text-sm font-medium leading-5 text-gray-700"
                                                                    for="label">
                                                                    {{ $t('Correo') }}
                                                                </label>
                                                                <div class="relative flex-grow focus-within:z-10">
                                                                    <div
                                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                        <svg-vue
                                                                            class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400"
                                                                            icon="font-awesome.envelope-solid"></svg-vue>
                                                                    </div>
                                                                    <input id="correo" v-model="filters.correo"
                                                                        :placeholder="$t('correo')" aria-label="correo"
                                                                        class="form-input block w-full rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                                                        @change="getDirectorio">
                                                                </div>
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label
                                                                    class="block text-sm font-medium leading-5 text-gray-700"
                                                                    for="label">
                                                                    {{ $t('Estado') }}
                                                                </label>
                                                                <div class="relative flex-grow focus-within:z-10">
                                                                    <select v-model="selectedStateEmpleado"
                                                                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                                                        @change="updateOficinasEmpleado">
                                                                        <option value="">Selecciona un estado</option>
                                                                        <option v-for="state in DelegacionesList" :value="state">{{
                                                                            state.descripcion }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label
                                                                    class="block text-sm font-medium leading-5 text-gray-700"
                                                                    for="label">
                                                                    {{ $t('Oficina') }}
                                                                </label>
                                                                <input-select id="oficina"
                                                                    v-model="filters.oficinasEmpleado"
                                                                    :options="oficinaListEmpleado" multiple
                                                                    option-label="descripcion" @change="getDirectorio" />
                                                            </div>

                                                            <div class="col-span-3 mb-2">
                                                                <label
                                                                    class="block text-sm font-medium leading-5 text-gray-700"
                                                                    for="label">
                                                                    {{ $t('Turno') }}
                                                                </label>
                                                                <input-select id="Turno" v-model="filters.turnoEmpleado"
                                                                    :options="turnoList" multiple option-label="descripcion"
                                                                    @change="getDirectorio" />
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label
                                                                    class="block text-sm font-medium leading-5 text-gray-700"
                                                                    for="label">
                                                                    {{ $t('items por pagina') }}
                                                                </label>
                                                                <input-select id="per_page" v-model="perPage"
                                                                    :options="[{ id: 5, name: 5 }, { id: 10, name: 10 }, { id: 25, name: 25 }, { id: 50, name: 50 }]"
                                                                    option-label="name" required @change="getDirectorio" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </transition>
                                </section>
                            </div>
                        </div>
                    </div>

 
                    <div class="rounded-md shadow-sm mr-4">
                        <button id="filter-button"
                            class="inline-flex justify-center w-full rounded-md border border border-gray-400 px-4 py-2 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150"
                            type="button" @click="openFiltersSidebarDevice">
                            <svg-vue class="self-center mr-3 h-4 w-4" icon="font-awesome.device-regular"></svg-vue>
                            {{ $t('Filtrar por equipo') }}
                            <svg-vue class="self-center ml-2.5 -mr-1.5 h-3 w-3"
                                icon="font-awesome.chevron-right-solid"></svg-vue>
                        </button>
                        <div v-show="filtersDeviceSidebar" class="fixed inset-0 overflow-hidden z-30">
                            <div class="absolute inset-0 overflow-hidden">
                                <section v-on-clickaway="closeFiltersSidebarDevice" :style="{ top: '65px' }"
                                    class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
                                    <transition duration="500"
                                        enter-active-class="transform transition ease-in-out duration-500"
                                        enter-class="translate-x-full" enter-to-class="translate-x-0"
                                        leave-active-class="transform transition ease-in-out duration-500"
                                        leave-class="translate-x-0" leave-to-class="translate-x-full">
                                        <div v-show="filtersDeviceSidebar" class="w-screen max-w-xs">
                                            <div class="h-full flex flex-col space-y-4 bg-white shadow-xl">
                                                <header class="px-4 pt-4 sm:px-6">
                                                    <div class="flex items-start justify-between space-x-3">
                                                        <h2 class="text-lg leading-7 font-medium text-gray-900">
                                                            {{ $t('Filtrar resultados por caracteristicas del equipo') }}
                                                        </h2>
                                                        <div class="h-7 flex items-center">
                                                            <button aria-label="Close panel"
                                                                class="text-gray-400 hover:text-gray-500 transition ease-in-out duration-150"
                                                                type="button" @click="closeFiltersSidebar">
                                                                <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </header>
                                                <div class="relative flex-1 px-4 sm:px-6 h-full border-t overflow-y-scroll">
                                                    <div class="absolute inset-0 px-4 sm:px-6">
                                                        <div class="grid grid-cols-3 py-3">
                                                            <div class="col-span-3 mb-2">
                                                                <label
                                                                    class="block text-sm font-medium leading-5 text-gray-700"
                                                                    for="label">
                                                                    {{ $t('Buscar por modelo o numero de serie') }}
                                                                </label>
                                                                <div class="relative flex-grow focus-within:z-10">
                                                                    <div
                                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                        <svg-vue class="h-4 w-4 text-gray-400"
                                                                            icon="font-awesome.device-regular"></svg-vue>
                                                                    </div>
                                                                    <input id="search" v-model.lazy="filters.NsModelo"
                                                                        :placeholder="$t('Numero de serie o modelo')"
                                                                        aria-label="Search"
                                                                        class="form-input block w-full rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                                                        @change="getDirectorio">
                                                                </div>
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label
                                                                    class="block text-sm font-medium leading-5 text-gray-700"
                                                                    for="label">
                                                                    {{ $t('Estado') }}
                                                                </label>
                                                                <div class="relative flex-grow focus-within:z-10">
                                                                    <select v-model="selectedStateEquipo"
                                                                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                                                        @change="updateOficinas">
                                                                        <option value="">Selecciona un estado</option>
                                                                        <option v-for="state in DelegacionesList" :value="state">{{
                                                                            state.descripcion }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label
                                                                    class="block text-sm font-medium leading-5 text-gray-700"
                                                                    for="label">
                                                                    {{ $t('Oficina') }}
                                                                </label>
                                                                <input-select id="oficina" v-model="filters.oficinasEquipo"
                                                                    :options="oficinaListEquipo" multiple
                                                                    option-label="descripcion" @change="getDirectorio" />
                                                            </div>

                                                            <div class="col-span-3 mb-2">
                                                                <label
                                                                    class="block text-sm font-medium leading-5 text-gray-700"
                                                                    for="label">
                                                                    {{ $t('Turno') }}
                                                                </label>
                                                                <input-select id="Turno" v-model="filters.turnoEquipo"
                                                                    :options="turnoList" multiple option-label="name"
                                                                    @change="getDirectorio" />
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label
                                                                    class="block text-sm font-medium leading-5 text-gray-700"
                                                                    for="label">
                                                                    {{ $t('items por pagina') }}
                                                                </label>
                                                                <input-select id="per_page" v-model="perPage"
                                                                    :options="[{ id: 5, name: 5 }, { id: 10, name: 10 }, { id: 25, name: 25 }, { id: 50, name: 50 }]"
                                                                    option-label="name" required @change="getDirectorio" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </transition>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
                

            </div>
         <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="my-6 bg-white shadow overflow-hidden sm:rounded-md">
                    <loading :status="loading" />
                    <template v-if="directorioList.length > 0">
                        <ul>
                            <template v-for="(directorio, index) in directorioList">
                                <li :class="{ 'border-t border-gray-200': index !== 0 }">
                                    <div class="flex items-center px-4 py-4 sm:px-6">
                                        <div class="min-w-0 flex-1 flex items-center">
                                            <div class="min-w-0 flex-1 px-4 lg:grid lg:grid-cols-2 lg:gap-4">
                                                <div>
                                                    <div class="text-sm leading-5 font-medium text-blue-600 truncate">{{
                                                        directorio.nomina.nombre }}
                                                    </div>
                                                    <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                                        <svg-vue class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400"
                                                            icon="font-awesome.envelope-solid"></svg-vue>
                                                        <span class="truncate">{{ directorio.nomina.noempleado }}</span>
                                                    </div>
                                                     <div class="flex items-center text-m leading-5 text-gray-500">
                                                        <svg-vue class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400"
                                                            icon="font-awesome.apartment-regular"></svg-vue>
                                                        <span class="truncate">{{
                                                            directorio.nomina.oficina }}</span>
                                                    </div> 
                                                     <div class="flex items-center text-m leading-5 text-gray-500">
                                                        <svg-vue class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400"
                                                            icon="font-awesome.user-tag-regular"></svg-vue>
                                                        <span class="truncate"> {{ directorio.nomina.turno }}</span>
                                                    </div>
                                                </div>
                                                <div class="hidden lg:block">
                                                    <div class="text-sm leading-5 text-gray-900">
                                                        <b>{{ directorio.equipo.modelo }} {{ directorio.equipo.numero_serie
                                                        }}</b>
                                                    </div>
                                                    <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                                        {{directorio.equipo.oficina.descripcion }}
                                                    </div>
                                                    <div class="mt-2 flex items-center text-sm leading-5 text-blue-500">
                                                        {{ directorio.equipo.categoria.name }}
                                                    </div> 
                                                </div>

                                            </div>
                                        </div>

                                        <div
                                        v-if="$store.state.permissions && $store.state.permissions['App.Http.Controllers.Api.Dashboard.Admin.DirectorioUpdateController']">
                                            <span id="status"
                                                :class="directorio.estatus_directorio ? 'bg-blue-600' : 'bg-gray-200'"
                                                aria-checked="false"
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:shadow-outline"
                                                role="checkbox" tabindex="0" @click="toggleDirectorioStatus(directorio)">
                                                <span
                                                    :class="directorio.estatus_directorio ? 'translate-x-5' : 'translate-x-0'"
                                                    aria-hidden="true"
                                                    class="inline-block h-5 w-5 rounded-full bg-white shadow transform transition ease-in-out duration-200"></span>
                                            </span>
                                        </div>

                                    </div>
                                </li>
                            </template>
                        </ul>
                    </template>
                    <template v-else-if="!loading">
                        <div class="h-full flex">
                            <div class="m-auto">
                                <div class="grid grid-cols-1 justify-items-center h-full w-full px-4 py-10">
                                    <div class="flex justify-center items-center">
                                        <svg-vue class="h-full h-auto w-64 mb-12" icon="undraw.browsing"></svg-vue>
                                    </div>
                                    <div class="flex justify-center items-center">
                                        <div class="w-full font-semibold text-2xl">{{ $t('No hay registros') }}</div>
                                    </div>
                                    <template v-if="search">
                                        <div class="flex justify-center items-center">
                                            <div>{{ $t('trata de cambiar los filtros o en su defecto revisa que tu busqueda este bien escrita') }}</div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                    <nav class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="hidden sm:block">
                            <p class="text-sm leading-5 text-gray-700">
                                {{ $t('Mostrando') }}
                                <span class="font-medium">{{ (pagination.perPage * pagination.currentPage) -
                                    pagination.perPage + 1 }}</span>
                                {{ $t('a') }}
                                <span class="font-medium">{{ pagination.perPage * pagination.currentPage <= pagination.total
                                    ? pagination.perPage * pagination.currentPage : pagination.total }}</span>
                                        {{ $t('de') }}
                                        <span class="font-medium">{{ pagination.total }}</span>
                                        {{ $t('resultados') }}
                            </p>
                        </div>
                        <div class="flex-1 flex justify-between sm:justify-end">
                            <button :class="pagination.currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : ''"
                                :disabled="pagination.currentPage <= 1" class="pagination-link" type="button"
                                @click="changePage(pagination.currentPage - 1)">
                                {{ $t('anterior') }}
                            </button>
                            <button
                                :class="pagination.currentPage >= pagination.totalPages ? 'opacity-50 cursor-not-allowed' : ''"
                                :disabled="pagination.currentPage >= pagination.totalPages" class="ml-3 pagination-link"
                                type="button" @click="changePage(pagination.currentPage + 1)">
                                {{ $t('siguiente') }}
                            </button>
                        </div>
                    </nav>
                </div>
            </div> 
        </div>
    </div> 
</template>

<script>
import { mixin as clickaway } from "vue-clickaway";

export default {
    name: "list",
    metaInfo() {
        return {
            title: this.$i18n.t('Directorio')
        }
    },
    mixins: [clickaway],
    data() {
        return {
            loading: true,
            filtersSidebar: false,
            filtersDeviceSidebar: false,


            filters: {
                searchEmpleado: '',
                correo: '',
                oficinasEmpleado: [],
                turnoEmpleado: [],

                NsModelo: '',
                oficinasEquipo: [],
                turnoEquipo: [],

                estatusDirectorio:1,

            },
            directorioList: [],
            page: 1,
            perPage: 10,
            pagination: {
                currentPage: 0,
                perPage: 0,
                total: 0,
                totalPages: 0
            },

            selectedStateEmpleado: '',
            oficinaListEmpleado: [],
            turnoList: [],
            DelegacionesList:[],
            selectedStateEquipo: '',
            oficinaListEquipo: [],
            oficinaList:[],
            EstatusEquipo: []

        }
    },

    computed: {
        anyFilter() {
            return this.filters.searchEmpleado !== ''
                || this.filters.correo !== ''
                || this.filters.oficinasEmpleado.length !== 0
                || this.filters.turnoEmpleado.length !== 0
                || this.filters.NsModelo !== ''
                || this.filters.oficinasEquipo.length !== 0
                || this.filters.turnoEquipo.length !== 0
                || this.filters.estatusDirectorio!==''
        }
    },

    filters: {
        momentFormatDateTimeAgo: function (value) {
            return moment(value).locale(window.app.app_date_locale).fromNow();
        },
    },
    mounted() {
        this.getDirectorio();
        this.getDatosEmpleado();
        this.getDelegaciones();
    },
    methods: {

        toggleDirectorioStatus(directorio) {
            const self = this;
            directorio.estatus_directorio = !directorio.estatus_directorio;
            console.log(directorio);
            axios.put('api/dashboard/admin/directorio/update/' + directorio.id, directorio).then(function () {
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data updated correctly').toString(),
                    type: 'success'
                });
                self.getDirectorio();

            }).catch(function () {

            });
        },
        verInactivos(){
            const self=this;
            if(self.filters.estatusDirectorio!==0){
                self.filters.estatusDirectorio=0
                self.getDirectorio();
            }else{
                self.filters.estatusDirectorio=1
                self.getDirectorio();
            }



        },
        openFiltersSidebar() {
            const self = this;
            setTimeout(function () {
                self.filtersSidebar = true;
            }, 100);
        },
        closeFiltersSidebar() {
            this.filtersSidebar = false;
        },

        openFiltersSidebarDevice() {
            const self = this;
            setTimeout(function () {
                self.filtersDeviceSidebar = true;
            }, 100);
        },
        closeFiltersSidebarDevice() {
            this.filtersDeviceSidebar = false;
        },
        getDelegaciones(){
            const self=this;
            self.animacionOficina=true;
            axios.get('api/dashboard/admin/delegaciones').then(function(response){
                // console.log(response.data);
                self.DelegacionesList=response.data;
            }).catch(function(){
                self.loading.form=false;
            });
        },

        getDirectorio() {
            const self = this;
            self.loading = true;
            const oficinasSeleccionadasIDs = self.filters.oficinasEmpleado;
            const TurnosSeleccionadosIDs =self.filters.turnoEmpleado;
            const oficinasSeleccionadasEquiposIDs=self.filters.oficinasEquipo;
            // Inicializa un arreglo para almacenar las descripciones de las oficinas seleccionadas
            const oficinasSeleccionadas = [];
            const turnosSeleccionados=[];
            const oficinasEquiposSeleccionadas=[];

            // Recorre los IDs y busca las descripciones correspondientes en oficinaListEmpleado
            for (const oficinaID of oficinasSeleccionadasIDs) {
                const oficina = self.oficinaListEmpleado.find(oficina => oficina.id === oficinaID);
                if (oficina) {
                    oficinasSeleccionadas.push(oficina.descripcion);
                }
            }

            for(const turnoID of TurnosSeleccionadosIDs){
                const turno=self.turnoList.find(turno=>turno.id===turnoID)
                if(turno){
                    turnosSeleccionados.push(turno.descripcion);
                }
            }


            const params = {
                page: self.page,
                sort: self.sort,
                perPage: self.perPage,
                searchEmpleado: self.filters.searchEmpleado,
                oficinasEmpleado: oficinasSeleccionadas,
                correo: self.filters.correo,
                turnoEmpleado: turnosSeleccionados,


                NsModelo: self.filters.NsModelo,
                oficinasEquipo: self.filters.oficinasEquipo,
                estatusDirectorio:self.filters.estatusDirectorio

            };

            
            axios.get('api/dashboard/admin/directorio', {
                params: params
            }).then(function (response) {
                self.directorioList = response.data.items;

                self.pagination = response.data.pagination;
                if (self.pagination.totalPages < self.pagination.currentPage) {
                    self.page = self.pagination.totalPages;
                    self.getDirectorio();
                } else {
                    self.loading = false;
                }
            }).catch(function () {
                self.loading = false;

            });

        },
        updateOficinas(){
            const self=this;
            console.log("UPDATE HECHO")
            axios.get('api/dashboard/admin/directorio/updateOficinasList/'+self.selectedStateEquipo.id).then(function(response){  
                self.oficinaListEquipo =response.data.oficinas;
            }).catch(function(){
                self.loading.form;
            });
        },
        updateOficinasEmpleado(){
            const self=this;
            axios.get('api/dashboard/admin/directorio/updateOficinasList/'+self.selectedStateEmpleado.id).then(function(response){
                // console.log(response.data);  
                self.oficinaListEmpleado =response.data.oficinas;
            }).catch(function(){
                self.loading.form=false;
            });
        },
        getDatosEmpleado() {
            const self = this;
            axios.get('api/dashboard/admin/directorio/datosEmpleado').then(function (response) {
                self.turnoList = response.data.turnos;
                self.oficinaListEmpleado = response.data.oficinas;
                //console.log(self.turnoList);
            }).catch(function () {
                self.loading.form = false;
            });
        },


    },




}


</script>

<style lang="scss">
.tickets-list {
    @apply bg-white w-full z-0 overflow-y-auto;
    height: calc(100vh - 270px);
}

@media (min-width: theme('screens.md')) {
    .tickets-list {
        height: calc(100vh - 216px);
    }
}

.filters-options {
    @apply rounded-md bg-white shadow-xs p-3 overflow-y-auto;
    height: calc(100vh - 270px);
    max-height: 360px;
}

@media (min-width: theme('screens.md')) {
    .filters-options {
        height: calc(100vh - 140px)
    }
}

.tickets-list-toolbar {
    @apply bg-white fixed flex rounded-md shadow-lg;
    left: 50px;
}

@media (min-width: theme('screens.md')) {
    .tickets-list-toolbar {
        left: 50%;
    }
}
</style>
