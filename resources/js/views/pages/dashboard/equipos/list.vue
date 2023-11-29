<template>
    <div class="relative flex-1">
        <div class="bg-white border-b border-gray-200 py-6 sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Equipos Registrados') }}</h1>
                </div>
                <div class="mt-5 flex md:mt-0 md:ml-4">
                    <div class="mt-10">
                        <router-link 
                            class="btn btn-blue shadow-sm rounded-md mr-4 "
                            to="/dashboard/Equipos/new"
                            >{{ $t('Agregar nuevo equipo') }}
                        </router-link>
                    </div>

                    <div class="rounded-md shadow-sm mr-4">
                        <button 
                            id="export-button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-400 px-4 py-2 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150"
                            type="button"
                            @click="exportEquipos"
                        >
                        <svg-vue class="self-center mr-3 h-4 w-4" icon="font-awesome.export-regular"></svg-vue>                   
                        </button>

                        <button
                            id="filter-button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-400 px-4 py-2 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150"
                            type="button"
                            @click="openFiltersSidebar"
                        >
                            <svg-vue class="self-center mr-3 h-4 w-4" icon="font-awesome.filter-regular"></svg-vue>
                            {{ $t('Filtros') }}
                            <svg-vue class="self-center ml-2.5 -mr-1.5 h-3 w-3" icon="font-awesome.chevron-right-solid"></svg-vue>
                        </button>

                        <div v-show="filtersSidebar" class="fixed inset-0 overflow-hidden z-30">
                            <div class="absolute inset-0 overflow-hidden">
                                <section v-on-clickaway="closeFiltersSidebar" :style="{top: '65px'}" class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
                                    <transition
                                        duration="500"
                                        enter-active-class="transform transition ease-in-out duration-500"
                                        enter-class="translate-x-full"
                                        enter-to-class="translate-x-0"
                                        leave-active-class="transform transition ease-in-out duration-500"
                                        leave-class="translate-x-0"
                                        leave-to-class="translate-x-full"
                                    >
                                        <div v-show="filtersSidebar" class="w-screen max-w-xs">
                                            <div class="h-full flex flex-col space-y-4 bg-white shadow-xl">
                                                <header class="px-4 pt-4 sm:px-6">
                                                    <div class="flex items-start justify-between space-x-3">
                                                        <h2 class="text-lg leading-7 font-medium text-gray-900">
                                                            {{ $t('Filtros') }}
                                                        </h2>
                                                        <div class="h-7 flex items-center">
                                                            <button aria-label="Close panel" class="text-gray-400 hover:text-gray-500 transition ease-in-out duration-150" type="button" @click="closeFiltersSidebar">
                                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </header>
                                                 <div class="relative flex-1 px-4 sm:px-6 h-full border-t overflow-y-scroll">
                                                    <div class="absolute inset-0 px-4 sm:px-6">
                                                        <div class="grid grid-cols-3 py-3">
                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Numero de serie') }}
                                                                </label>
                                                                <div class="relative flex-grow focus-within:z-10">
                                                                    <input
                                                                        id="search"
                                                                        v-model.lazy="filters.search"
                                                                        :placeholder="$t('Numero de serie')"
                                                                        aria-label="Search"
                                                                        class="form-input block w-full rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                                                        @change="getEquipos"
                                                                    >
                                                                </div>
                                                            </div>
                                                             <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Modelo') }}
                                                                </label>
                                                                <div class="relative flex-grow focus-within:z-10">
                                                                    <input
                                                                        id="modelo"
                                                                        v-model="filters.modelo"
                                                                        :placeholder="$t('modelo')"
                                                                        aria-label="modelo"
                                                                        class="form-input block w-full rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                                                        @change="getEquipos"
                                                                    >
                                                                </div>
                                                            </div>

                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Categoria') }}
                                                                </label>
                                                                <input-select
                                                                    id="categoria"
                                                                    v-model="filters.categorias"
                                                                    :options="categoriaList"
                                                                    multiple
                                                                    option-label="name"
                                                                    @change="getEquipos"
                                                                >
                                                                </input-select>
                                                            </div>

                                                           <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Oficina') }}
                                                                </label>
                                                                <input-select
                                                                    id="oficina"
                                                                    v-model="filters.oficinas"
                                                                    :options="oficinaList"
                                                                    multiple
                                                                    option-label="descripcion"
                                                                    @change="getEquipos"
                                                                />
                                                            </div>

                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Estatus del equipo') }}
                                                                </label>
                                                                <input-select
                                                                    id="status"
                                                                    v-model="filters.statuses"
                                                                    :options="statusList"
                                                                    multiple
                                                                    option-label="name"
                                                                    @change="getEquipos"
                                                                />
                                                            </div>
                                                             <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('Ordenar por:') }}
                                                                </label>
                                                                <div class="relative inline-flex w-full">
                                                                    <button
                                                                        class="relative -ml-px inline-flex items-center px-4 py-2 rounded-l-md border border-gray-400 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700"
                                                                        type="button"
                                                                        @click="changeSort"
                                                                    >
                                                                        <svg-vue
                                                                            v-show="sort.order === 'asc'"
                                                                            class="h-5 w-5 text-gray-400"
                                                                            icon="font-awesome.sort-amount-down-alt-regular"
                                                                        />
                                                                        <svg-vue
                                                                            v-show="sort.order === 'desc'"
                                                                            class="h-5 w-5 text-gray-400"
                                                                            icon="font-awesome.sort-amount-up-alt-regular"
                                                                        />
                                                                        <template>
                                                                            <template v-if="sort.order==='asc'">
                                                                                <span class="ml-2">{{ $t('ascendente') }}</span>
                                                                            </template>
                                                                            <template v-else>
                                                                                <span class="ml-2">{{ $t('descente') }}</span>
                                                                            </template>
                                                                        </template>

                                                                        
                                                                    </button>
                                                                    <select
                                                                        id="sort.column"
                                                                        v-model="sort.column"
                                                                        aria-label="Sort by"
                                                                        class="-ml-px block form-select w-full pl-3 pr-9 py-2 rounded-l-none rounded-r-md border border-gray-400 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                                                        @change="changeSort"
                                                                    >
                                                                        <option value="status_id">{{ $t('Status') }}</option>
                                                                        <option value="oficina_id">{{ $t('oficina') }}</option>
                                                                        <option value="categoria_id">{{ $t('categoria') }}</option>
                                                                        <option value="numero_serie">{{ $t('numero de serie') }}</option>
                                                                        <option value="modelo">{{ $t('modelo') }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-span-3 mb-2">
                                                                <label class="block text-sm font-medium leading-5 text-gray-700" for="label">
                                                                    {{ $t('items por pagina') }}
                                                                </label>
                                                                <input-select
                                                                    id="per_page"
                                                                    v-model="perPage"
                                                                    :options="[{id: 5, name: 5}, {id: 10, name: 10}, {id: 25, name: 25}, {id: 50, name: 50}]"
                                                                    option-label="name"
                                                                    required
                                                                />
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
        </div>
        <loading :status="loading"/>
        <div class="equipos-list">
            <div class="hidden sm:block">
                <div v-show="selectedRows.length > 0" v-on-clickaway="closeQuickActionDropdown" class="equipos-list-toolbar">
                    <button class="btn hover:bg-gray-100 p-4 border-r border-gray-200 rounded-none" type="button" @click="toggleQuickActionDropdown('delete')">
                        <svg-vue class="h-6 w-6 text-gray-700" icon="font-awesome.trash-alt-regular"></svg-vue>
                    </button>
                </div>
            </div>
            <template v-if="equipoList.length > 0">
                <div class="hidden sm:block">
                    <div class="align-middle inline-block min-w-full border-b border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-3 pt-2 pb-3">
                                        <input
                                            id="select-all-equipos"
                                            v-model="selectAll"
                                            aria-label="Checkbox"
                                            class="form-checkbox cursor-pointer h-4 w-4 text-blue-600 transition duration-150 ease-in-out"
                                            type="checkbox"
                                            @change="selectAllEquipos"
                                        >
                                    </th>
                                    <th class="hidden lg:table-cell px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                                        {{ $t('Modelo') }}
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                        {{ $t('Numero de serie') }}
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                        {{ $t('Categoria') }}
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                        {{ $t('Oficina que pertenece') }}
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                        {{ $t('Estado actual') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                <template v-for="equipo in equipoList">
                                    <router-link
                                        :to="'/dashboard/Equipos/' + equipo.uuid + '/manage'"
                                        class="cursor-pointer hover:bg-gray-100"
                                        tag="tr"
                                    >
                        
                                        <td class="px-3 py-4 whitespace-no-wrap text-center text-sm leading-5 font-medium">
                                            <input
                                                :id="'equipo-' + equipo.id"
                                                v-model="selectedRows"
                                                :value="equipo.id"
                                                aria-label="Checkbox"
                                                class="form-checkbox cursor-pointer h-4 w-4 text-blue-600 transition duration-150 ease-in-out"
                                                type="checkbox"
                                                @change="selectEquipo"
                                                @click.stop
                                            >
                                        </td>
                                        <td class="hidden lg:table-cell px-3 py-4 whitespace-no-wrap leading-5">
                                            <div class="flex items-center">
                                                <div class="ml-4">
                                                    <div class="text-sm leading-5 font-medium text-gray-900">
                                                        {{ equipo.modelo}}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                                <div class="w-full truncate">
                                                    {{ equipo.numero_serie }}
                                                </div>
                                        </td>
                                    <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                        <div class="w-full truncate">
                                            {{ equipo.categoria.name }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                        <div class="w-full truncate">
                                            {{ equipo.oficina.descripcion }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                        <div class="text-sm leading-5 text-gray-900">
                                            {{equipo.status.name}}
                                        </div>
                                    </td>
                                </router-link>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </template>
            <template v-else-if="!loading">
                <div class="h-full flex">
                    <div class="m-auto">
                        <div class="grid grid-cols-1 justify-items-center h-full w-full p-4">
                            <div class="flex justify-center items-center">
                                <svg-vue class="h-full h-auto w-48 mb-6" icon="undraw.task-list"></svg-vue>
                            </div>
                            <div class="flex justify-center items-center">
                                <div class="w-full font-semibold text-2xl">{{ $t('No records found') }}</div>
                            </div>
                            <template v-if="anyFilter">
                                <div class="flex justify-center items-center">
                                    <div>{{ $t('Try changing the filters, or rephrasing your search') }}.</div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <nav class="bg-white absolute bottom-0 left-0 w-full px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="hidden sm:block">
                <p class="text-sm leading-5 text-gray-700">
                    {{ $t('Showing') }}
                    <span class="font-medium">{{ (pagination.perPage * pagination.currentPage) - pagination.perPage + 1 }}</span>
                    {{ $t('to') }}
                    <span class="font-medium">{{ pagination.perPage * pagination.currentPage <= pagination.total ? pagination.perPage * pagination.currentPage : pagination.total }}</span>
                    {{ $t('of') }}
                    <span class="font-medium">{{ pagination.total }}</span>
                    {{ $t('results') }}
                </p>
            </div>
            <div class="flex-1 flex justify-between sm:justify-end">
                <button
                    :class="pagination.currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : ''"
                    :disabled="pagination.currentPage <= 1"
                    class="pagination-link"
                    type="button"
                    @click="changePage(pagination.currentPage - 1)"
                >
                    {{ $t('Previous') }}
                </button>
                <button
                    :class="pagination.currentPage >= pagination.totalPages ? 'opacity-50 cursor-not-allowed' : ''"
                    :disabled="pagination.currentPage >= pagination.totalPages"
                    class="ml-3 pagination-link"
                    type="button"
                    @click="changePage(pagination.currentPage + 1)"
                >
                    {{ $t('Next') }}
                </button>
            </div>
        </nav>
        <div v-show="quickActions.delete" class="fixed z-20 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <transition
                    duration="300"
                    enter-active-class="ease-out duration-300"
                    enter-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div v-show="quickActions.delete" class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                </transition>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
                <transition
                    enter-active-class="ease-out duration-300"
                    enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div
                        v-show="quickActions.delete"
                        aria-labelledby="modal-headline"
                        aria-modal="true"
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                        role="dialog"
                    >
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg-vue class="h-6 w-6 pb-1 text-red-600" icon="font-awesome.exclamation-triangle-light"></svg-vue>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 id="modal-headline" class="text-lg leading-6 font-medium text-gray-900">
                                        {{ $t('Borrar el equipo') }}
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm leading-5 text-gray-500">
                                            {{ $t('Estas seguro de eliminar este equipo?') }}
                                            {{ $t('todos los datos seran eliminados permanentemente') }}.
                                            {{ $t('se eliminaran todos los datos, relacionados con el') }}.
                                            {{ $t('esta accion no se podra reveertir') }}.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-100 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                class="btn btn-red mr-2 sm:mr-0"
                                type="button"
                                @click="quickAction('delete')"
                            >
                                {{ $t('Eliminar equipo') }}
                            </button>
                            <button
                                class="btn btn-white mr-0 sm:mr-2"
                                type="button"
                                @click="quickActions.delete = false"
                            >
                                {{ $t('Cancelar') }}
                            </button>
                        </div>
                    </div>
                </transition>
            </div>
        </div> 
    </div>
</template>

<script>
import {mixin as clickaway} from "vue-clickaway";

export default{
    name: "list",
    metaInfo() {
        return {
            title: this.$i18n.t('equipos')
        }
    },

    mixins: [clickaway],

    data(){
        return{
            loading: true,
            filtersSidebar: false,

            filters: {
                search: '',
                modelo:'',
                numero_serie: '',
                categorias:[],
                statuses: [],
                oficinas:[]
            },
            quickActions: {
                delete: false,
            },

            sort: {
                order: 'desc',
            },

            page: 1,
            perPage: 10,

            pagination: {
                currentPage: 0,
                perPage: 0,
                total: 0,
                totalPages: 0
            },
            estadoList:[],
            statusList:[],
            categoriaList:[],
            oficinaList:[],
            equipoList:[],
            statusList:[],
            selectAll: false,
            selectedRows: [],
        }
    },

    computed:{
        anyFilter() {
            return this.filters.search !== ''
        }
    },
    filters:{
        momentFormatDateTimeAgo: function (value) {
            return moment(value).locale(window.app.app_date_locale).fromNow();
        },
    },

    mounted(){
        this.getEquipos();
        this.getFilters();
    },

    methods:{
        openFiltersSidebar() {
            const self = this;
            self.selectedRows = [];
            self.selectEquipo();
            setTimeout(function () {
                self.filtersSidebar = true;
            }, 100);
        },
        closeFiltersSidebar() {
            this.filtersSidebar = false;
        },
        getFilters() {
            const self = this;
            axios.get('api/dashboard/equipos/filters').then(function (response) {
                console.log(response.data);
                self.categoriaList=response.data.categorias;
                self.oficinaList=response.data.oficinas;
                self.statusList = response.data.statuses;
            });
        },
        getEquipos(){
            const self = this;
            self.selectAll = false;
            self.selectedRows = [];
            self.loading = true;

            const params = {
                page: self.page,
                sort: self.sort,
                perPage: self.perPage,

                search: self.filters.search,
                statuses: self.filters.statuses,
                categorias: self.filters.categorias,
                oficinas: self.filters.oficinas,
                // Agrega las propiedades del filtro de modelo y número de serie
                modelo: self.filters.modelo,
                numero_serie: self.filters.numero_serie
            };

            axios.get('api/dashboard/equipos', {
                params: params
            }).then(function (response) {
                console.log(response.data.items);
                self.equipoList = response.data.items;
                self.pagination = response.data.pagination;
                
                if (self.pagination.totalPages < self.pagination.currentPage) {
                    self.page = self.pagination.totalPages;
                    self.getEquipos();
                } else {
                    if (self.equipoList.length === 0) {
                        self.selectAll = false;
                        self.selectedRows = [];
                    }
                    self.loading = false;
                }
            }).catch(function () {
                self.loading = false;
            });
        },
        changeSort() {
            const self = this;
            if (self.sort.order === 'asc') {
                self.sort.order = 'desc';
            } else if (self.sort.order === 'desc') {
                self.sort.order = 'asc';
            }
            self.getEquipos();
        },
        selectEquipo() {
            this.closeQuickActionDropdown();
            this.selectAll = Object.keys(this.selectedRows).length === Object.keys(this.equipoList).length;
        },
        selectAllEquipos() {
            this.selectedRows = [];
            this.closeQuickActionDropdown();
            if (this.selectAll) {
                for (let equipo in this.equipoList) {
                    this.selectedRows.push(this.equipoList[equipo].id);
                }
            }
        },
        
        closeQuickActionDropdown() {
            this.quickActions.delete = false;
        },
        toggleQuickActionDropdown(quickAction) {
            if (quickAction === 'delete') {
                this.quickActions.delete = !this.quickActions.delete;
            }
        },
        quickAction(param, value) {
            const self = this;
            console.log(self.selectedRows)
            axios.post('api/dashboard/equipos/quick-actions', {
                action: param,
                value: value,
                equipos: self.selectedRows,
            }).then(function (response) {
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: response.data.message,
                    type: 'success'
                });
                self.getEquipos();
            }).catch(function () {
                self.closeQuickActionDropdown();
            });
        },

        changePage(page) {
            const self = this;
            if ((page > 0) && (page <= self.pagination.totalPages) && (page !== self.page)) {
                self.page = page;
                self.getEquipos();
            }
        },
        
        changeSort() {
            const self = this;
            if (self.sort.order === 'asc') {
                self.sort.order = 'desc';
            } else if (self.sort.order === 'desc') {
                self.sort.order = 'asc';
            }
            self.getEquipos();
        },

        exportEquipos() {
             axios.get('api/dashboard/exportar-equipos', { responseType: 'blob' })
                .then(response => {
                // Crea un enlace temporal para descargar el archivo
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', 'equipos.xlsx');
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
        })
        .catch(error => {
            console.error(error);
        });
}
        

    }
}
</script>

<style lang="scss">
.equipos-list {
    @apply bg-white w-full z-0 overflow-y-auto;
    height: calc(100vh - 270px);
}

@media (min-width: theme('screens.md')) {
    .equipos-list {
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

.equipos-list-toolbar {
    @apply bg-white fixed flex rounded-md shadow-lg;
    left: 50px;
}

@media (min-width: theme('screens.md')) {
    .equipos-list-toolbar {
        left: 50%;
    }
}
</style>