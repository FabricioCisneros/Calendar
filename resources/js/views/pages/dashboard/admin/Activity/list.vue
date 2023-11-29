<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="py-0.5 text-2xl font-semibold text-gray-900">Actividades</h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    {{ $t('Filtrar por categoria') }}

                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <input-select id="category" v-model="filters.categoria" :options="categoryList" multiple
                        option-label="name" @change="getActivity" />
                </div>

                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <router-link class="btn btn-blue shadow-sm rounded-md" to="/dashboard/admin/activity/new">
                        {{ $t('Agregar nueva actividad') }}
                    </router-link>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="my-6 bg-white shadow overflow-hidden sm:rounded-md">
                <loading :status="loading" />
                <template v-if="actividadesList.length > 0">
                    <ul>
                        <template v-for="(activity, index) in actividadesList">
                            <router-link :to="'/dashboard/admin/activity/' + activity.id + '/edit'"
                                class="block hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                <li :class="{ 'border-t border-gray-200': index !== 0 }">
                                    <div class="flex px-4 py-4 sm:px-6">
                                        <div class="flex-shrink-0">
                                            <svg-vue :style="{ color: activity.categoria.color }" class=" h-5 w-5"
                                                icon="font-awesome.circle-solid"></svg-vue>
                                        </div>
                                        <div class="min-w-0 flex-1 flex items-center">

                                            <div class="min-w-0 flex-1 px-4 lg:grid lg:grid-cols-3 lg:gap-4">

                                                <div class="flex">
                                                    <div
                                                        class="inline-block align-middle text-sm font-medium leading-5 text-gray-900">
                                                        {{ activity.tittle }}</div>
                                                </div>
                                                <div class="flex">
                                                    <div
                                                        class="inline-block align-middle text-sm font-medium leading-5 text-gray-900">
                                                        {{ activity.Desc }}</div>
                                                </div>
                                            </div>

                                        </div>
                                        <div>
                                            <svg-vue class="h-5 w-5 text-gray-400"
                                                icon="font-awesome.angle-right-regular"></svg-vue>
                                        </div>
                                    </div>
                                </li>
                            </router-link>
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
                            </div>
                        </div>
                    </div>
                </template>

            </div>
        </div>

        <nav
                        class="bg-white absolute bottom-0 left-0 w-full px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="hidden sm:block">
                            <p class="text-sm leading-5 text-gray-700">
                                {{ $t('Showing') }}
                                <span class="font-medium">{{ (pagination.perPage * pagination.currentPage) -
                                    pagination.perPage + 1 }}</span>
                                {{ $t('to') }}
                                <span class="font-medium">{{ pagination.perPage * pagination.currentPage <= pagination.total
                                    ? pagination.perPage * pagination.currentPage : pagination.total }}</span>
                                        {{ $t('of') }}
                                        <span class="font-medium">{{ pagination.total }}</span>
                                        {{ $t('results') }}
                            </p>
                        </div>
                        <div class="flex-1 flex justify-between sm:justify-end">
                            <button :class="pagination.currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : ''"
                                :disabled="pagination.currentPage <= 1" class="pagination-link" type="button"
                                @click="changePage(pagination.currentPage - 1)">
                                {{ $t('Previous') }}
                            </button>
                            <button
                                :class="pagination.currentPage >= pagination.totalPages ? 'opacity-50 cursor-not-allowed' : ''"
                                :disabled="pagination.currentPage >= pagination.totalPages" class="ml-3 pagination-link"
                                type="button" @click="changePage(pagination.currentPage + 1)">
                                {{ $t('Next') }}
                            </button>
                        </div>
                    </nav>
    </main>
</template>

<script>
export default {
    name: "list",
    metaInfo() {
        return {
            title: this.$i18n.t('Actividades')
        }
    },
    data() {
        return {
            loading: true,
            actividadesList: [],
            categoryList: [],



            filters: {
                categoria: []
            },

            page: 1,
            perPage: 10,
            pagination: {
                currentPage: 0,
                perPage: 0,
                total: 0,
                totalPages: 0
            },
        }
    },

    computed: {
        anyFilter() {
            return this.filters.categoria.length !== ''
        }
    },
    mounted() {
        this.getActivity();
        this.getCategories();
    },
    methods: {
        getActivity() {
            const self = this;
            self.loading = true;

            const params = {
                page: self.page,
                sort: self.sort,
                perPage: self.perPage,
                categoria: self.filters.categoria,
            };

            console.log(params);
            
            axios.get('api/dashboard/admin/activity', {
                params: params
            }).then(function (response) {
                console.log(response.data.items);
                self.actividadesList = response.data.items;
                self.pagination = response.data.pagination;
                if (self.pagination.totalPages < self.pagination.currentPage) {

                    self.page = self.pagination.totalPages;
                    self.getActivity();
                } else {

                    self.loading = false;
                }
            }).catch(function () {
                self.loading = false;
            });
        },


        getCategories() {
            const self = this;
            self.loading = true;
            axios.get('api/dashboard/admin/categorias').then(function (response) {
                console.log(response.data);
                self.categoryList = response.data;
                self.loading = false;
            }).catch(function () {
                self.loading = false;
            });
        }
    }
}
</script>
