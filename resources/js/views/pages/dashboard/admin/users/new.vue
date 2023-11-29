 <template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <form @submit.prevent="saveUser">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">Añadir nuevo usuario</h1>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-6 shadow sm:rounded-lg">
                    <loading :status="loading"/>
                    <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Informacion del usuario</h3>
                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                Esta informacion sera mostrada publicamente.
                            </p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-3 gap-6">
                                
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="name">Nombre</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="name"
                                            v-model="user.name"
                                            :placeholder="Nombre"
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
                                            v-model="user.email"
                                            :placeholder="Correo"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                            type="email"
                                        >
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="username">Username</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="username"
                                            v-model="user.username"
                                            :placeholder="username"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                            type="username"
                                        >
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="password">contraseña</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="password"
                                            v-model="user.password"
                                            :placeholder="contraseña"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                            type="password"
                                        >
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="md:col-span-3">
                            <div class="py-3">
                                <div class="border-t border-gray-200"></div>
                            </div>
                        </div>
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Configuracion de usuario</h3>
                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                Accessos y permisos del usuario.
                            </p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="role">Area</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <select
                                            id="role"
                                            v-model="user.role_id"
                                            class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                            <option :value="null" disabled>Selecciona una opcion</option>
                                            <option v-for="userRole in userRoles" :value="userRole.id">{{ userRole.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="status">Estatus de usuario</label>
                                    <input-switch
                                        id="status"
                                        v-model="user.status"
                                        :disabled-label="$t('el usuario esta deshabilitado')"
                                        :enabled-label="$t('el usuario esta habilitado')"
                                    ></input-switch>
                                    <div class="mt-2 relative text-xs text-gray-500">
                                        {{ $t('Cuando se desactiva el usuario, se crea el registro en el sistema, por lo que el correo electrónico se reserva, pero no puede iniciar sesión hasta que se active nuevamente.') }}.
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
            userRoles: [],
            user: {
                name: null,
                email: null,
                role_id: null,
                username: null,
                status: true,
                password: null,
            },
        }
    },
    mounted() {
        this.getUserRoles();
    },
    methods: {
        saveUser() {
            const self = this;
            self.loading = true;
            axios.post('api/dashboard/admin/users', self.user).then(function (response) {
                self.loading = false;
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data saved correctly').toString(),
                    type: 'success'
                });
                self.$router.push('/dashboard/admin/users/' + response.data.user.id + '/edit');
            }).catch(function () {
                self.loading = false;
            });
        },
        getUserRoles() {
            const self = this;
            self.loading = true;
            axios.get('api/dashboard/admin/users/user-roles').then(function (response) {
                self.userRoles = response.data;
                self.loading = false;
            }).catch(function () {
                self.loading = false;
            });
        },
    }
}
</script>
