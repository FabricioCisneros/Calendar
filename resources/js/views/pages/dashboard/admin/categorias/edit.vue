<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <form @submit.prevent="saveCategory">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Editar la categoria') }}</h1>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <button class="btn btn-red shadow-sm rounded-md" type="button" @click="deleteCategoryModal
         = true">
                            {{ $t('Borrar categoria') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-6 shadow sm:rounded-lg">
                    <loading :status="loading" />
                    <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('Informacion de la categoria') }}
                            </h3>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="name">{{
                                        $t('Nombre de la categoria') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input id="name" v-model="categoria.name"
                                            :placeholder="$t('Nombre de la categoria')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required>
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <input-color id="color" v-model="categoria.color" :label="$t('Color')" :placeholder="$t('Elige un color')" required></input-color>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
                        <span class="inline-flex">
                            <router-link class="btn btn-secondary shadow-sm rounded-md mr-4"
                                to="/dashboard/admin/categorias">
                                {{ $t('cancelar') }}
                            </router-link>
                            <button class="btn btn-green shadow-sm rounded-md" type="submit">
                                {{ $t('Guardar cambios') }}
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
        <div v-show="deleteCategoryModal" class="fixed z-20 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <transition duration="300" enter-active-class="ease-out duration-300" enter-class="opacity-0"
                    enter-to-class="opacity-100" leave-active-class="ease-in duration-200" leave-class="opacity-100"
                    leave-to-class="opacity-0">
                    <div v-show="deleteCategoryModal
                        " class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                </transition>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
                <transition enter-active-class="ease-out duration-300"
                    enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200"
                    leave-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div v-show="deleteCategoryModal
                        " aria-labelledby="modal-headline" aria-modal="true"
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                        role="dialog">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg-vue class="h-6 w-6 pb-1 text-red-600"
                                        icon="font-awesome.exclamation-triangle-light"></svg-vue>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 id="modal-headline" class="text-lg leading-6 font-medium text-gray-900">
                                        {{ $t('Borrar categoria') }}
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm leading-5 text-gray-500">
                                            {{ $t('Estas seguro de eliminar esta categoria?') }}
                                            {{ $t('Todos los datos seran eliminados') }}.
                                            {{ $t('Toda la informacion relacionada con esta categoria sera eliminada') }}.
                                            {{ $t('Esta accion no se puede revertir') }}.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-100 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                             <button
                                class="btn btn-red mr-2 sm:mr-0"
                                type="button"
                                @click="deleteCategory"
                            >
                                {{ $t('Borrar oficina') }}
                            </button> 
                            <button class="btn btn-white mr-0 sm:mr-2" type="button" @click="deleteCategoryModal= false">
                                {{ $t('Cancelar') }}
                            </button>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    name: "edit",
    metaInfo() {
        return {
            title: this.$i18n.t('Modificacion de categorias')
        }
    },
    data() {
        return {
            loading: true,
            deleteCategoryModal: false,
            categoria: {
                name: null,
                color: ''
            }
        }
    },
    mounted() {
        this.getCategory();
    },
    methods: {
        saveCategory() {
            const self = this;
            self.loading = true;
            axios.put('api/dashboard/admin/categorias/' + self.$route.params.id, self.categoria).then(function () {
                self.loading = false;
                self.$notify({
                    title: self.$i18n.t('Completado').toString(),
                    text: self.$i18n.t('Categoria actualizada').toString(),
                    type: 'success'
                });
            }).catch(function () {
                self.loading = false;
            });
        },
        getCategory() {
            const self = this;
            self.loading = true;
            axios.get('api/dashboard/admin/categorias/' + self.$route.params.id).then(function (response) {
                self.categoria = response.data;
                self.loading = false;
            }).catch(function () {
                self.loading = false;
            });
        },
        deleteCategory() {
            const self = this;
            axios.delete('api/dashboard/admin/categorias/' + self.$route.params.id).then(function () {
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data deleted successfully').toString(),
                    type: 'success'
                });
                self.$router.push('/dashboard/admin/categorias');
            }).catch(function () {
                self.deleteCategoryModal
 = false;
            });
        },
    }
}
</script>
