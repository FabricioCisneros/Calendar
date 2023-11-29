 <template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <form @submit.prevent="savePersonal">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">Agregar nuevo Desingnado</h1>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-6 shadow sm:rounded-lg">
                    <!-- <loading :status="loading"/> -->
                    <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Informacion del personal</h3>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-3 gap-6">
                                
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="name">Nombre</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="name"
                                            v-model="personal.nombre"
                                            :placeholder="$t('nombre')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="email">Correo</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="email"
                                            v-model="personal.correo"
                                            :placeholder="$t('Correo')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                            type="email"
                                        >
                                    </div>
                                </div>   
                            </div>
                        </div>    
                    </div>
                    <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
                        <span class="inline-flex">
                            <router-link
                                class="btn btn-secondary shadow-sm rounded-md mr-4"
                                to="/dashboard/admin/users"
                            >
                                {{ $t('cancelar') }}
                            </router-link>
                            <button
                                class="btn btn-green shadow-sm rounded-md"
                                type="submit"
                            >
                                {{ $t('Añadir usuario') }}
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </main>
</template>

<script>
export default {
    name: "new-user",
    metaInfo() {
        return {
            title: this.$i18n.t('Create user')
        }
    },
    data() {
        return {
            loading: true,
            personal: {
                nombre: null,
                correo: null,
            },
        }
    },
    methods: {
        savePersonal() {
            const self = this;
            self.loading = true;
            axios.post('api/dashboard/admin/personal', self.personal).then(function (response) {
                self.loading = false;
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Personal agregado con exito').toString(),
                    type: 'success'
                });
                // self.$router.push('/dashboard/personal/users/' + response.data.user.id + '/edit');
            }).catch(function () {
                self.loading = false;
            });
        },

    }
}
</script>
