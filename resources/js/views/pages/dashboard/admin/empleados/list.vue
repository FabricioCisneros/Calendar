<template>
   <div class="relative flex-1">
        <div class="bg-white border-b border-gray-200 py-6 sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Empleados') }}</h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">                    
                    <div class="rounded-md shadow-sm mr-4">
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
                                                                    {{ $t('buscar por nombre') }}
                                                                </label>
                                                                <div class="relative flex-grow focus-within:z-10">
                                                                    <input
                                                                        id="search"
                                                                        v-model.lazy="filters.search"
                                                                        :placeholder="$t('Nombre o Nombres')"
                                                                        aria-label="Search"
                                                                        class="form-input block w-full rounded-l-md pl-10 text-sm transition ease-in-out duration-150"
                                                                        @change="getNomina"
                                                                    >
                                                                </div>
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
            </div>
            <template v-if="nominasList.length > 0">
                <div class="hidden sm:block">
                    <div class="align-middle inline-block min-w-full border-b border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="hidden lg:table-cell px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                                        {{ $t('Nombres') }}
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                        {{ $t('Numero de empleado') }}
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                        {{ $t('Oficina') }}
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider whitespace-no-wrap overflow-x-auto">
                                        {{ $t('Estado') }}
                                    </th>
                                </tr>
                            </thead>
                             <tbody class="bg-white divide-y divide-gray-100">
                                <template v-for="empleado in nominasList">
                                <tr>
                                        <td class="hidden lg:table-cell px-3 py-4 whitespace-no-wrap leading-5">
                                            <div class="flex items-center">
                                                <div class="ml-4">
                                                    <div class="text-sm leading-5 font-medium text-gray-900">
                                                        {{ empleado.nombre}}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                       <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                                <div class="w-full truncate">
                                                    {{ empleado.noempleado }}
                                                </div>
                                        </td>
                                    <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                        <div class="w-full truncate">
                                            {{ empleado.oficina }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-4 whitespace-no-wrap leading-5">
                                        <div class="w-full truncate">
                                            {{ empleado.edo }}
                                        </div>
                                    </td>
                                </tr> 
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
                                <div class="w-full font-semibold text-2xl">{{ $t('No se encontro ningun registro') }}</div>
                            </div>
                            <template v-if="anyFilter">
                                <div class="flex justify-center items-center">
                                    <div>{{ $t('Trata de cambiar los filtros') }}.</div>
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

            filters:{
                search: '',
            },

            sort: {
                order: 'asc',
            },

            page: 1,
            perPage: 10,

            pagination: {
                currentPage: 0,
                perPage: 0,
                total: 0,
                totalPages: 0
            },
            nominasList:[],
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
        this.getNomina();
        this.getFilters();
    },

    methods:{
        openFiltersSidebar() {
            const self = this;
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
                self.categoriaList=response.data.categorias;
                self.oficinaList=response.data.oficinas;
                self.statusList = response.data.statuses;
            });
        },
        getNomina(){
            const self = this;
            self.loading = true;

            const params = {
                page: self.page,
                sort: self.sort,
                perPage: self.perPage,
                search: self.filters.search,
            };

            console.log(params);

            axios.get('api/dashboard/admin/nomina',{
                params: params
            }).then(function (response){
  
                
                self.nominasList=response.data.items;
                self.pagination = response.data.pagination;

                if(self.pagination.totalPages < self.pagination.currentPage){
                    console.log(self.pagination.currentPage)
                    self.page = self.pagination.totalPages;
                    self.getNomina();
                }else{
                    self.loading = false;
                }
            }).catch(function (){
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
            self.getNomina();
        },
        changePage(page) {
            const self = this;
            if ((page > 0) && (page <= self.pagination.totalPages) && (page !== self.page)) {
                self.page = page;
                self.getNomina();
            }
        },
        
        changeSort() {
            const self = this;
            if (self.sort.order === 'asc') {
                self.sort.order = 'desc';
            } else if (self.sort.order === 'desc') {
                self.sort.order = 'asc';
            }
            self.getNomina();
        },

    }

}

</script>