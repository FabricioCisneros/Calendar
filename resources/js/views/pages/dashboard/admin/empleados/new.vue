<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <form @submit.prevent="saveEmpleado">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Agregar nuevo empleado') }}</h1>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-6 shadow sm:rounded-lg">
                    <loading :status="loading.form" />
                    <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('Detalles del empleado') }}</h3>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-3 gap-6">

                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="name">{{
                                        $t('Nombre') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input id="name" v-model="empleado.name"
                                            :placeholder="$t('nombre del empleado')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required>
                                    </div>
                                </div>

                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="apellidos">{{
                                        $t('Apellidos') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input id="apellidos" v-model="empleado.apellidos"
                                            :placeholder="$t('Apellidos del empleado')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required>
                                    </div>
                                </div>

                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="email">{{
                                        $t('email') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input id="email" v-model="empleado.email"
                                            :placeholder="$t('Email del empleado')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            >
                                    </div>
                                </div>

                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="telefono">{{
                                        $t('telefono') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input id="telefono" v-model="empleado.telefono"
                                            :placeholder="$t('Telefono del empleado')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            >
                                    </div>
                                </div>

                                <!-- INPUT DE OFICINA EN LA QUE PERTENECE EL EQUIPO -->
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="department">{{
                                        $t('Oficina') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input-select id="department" v-model="empleado.oficina_id" :options="oficinaList"
                                            option-label="name" required />
                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="role">Turno</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <select
                                            id="role"
                                            v-model="empleado.turno_id"
                                            class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                            <option :value="null" disabled>Selecciona una opcion</option>
                                            <option v-for="turno in turnoList" :value="turno.id">{{ turno.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- FIN DEL BLOQUE -->


                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
                        <div class="inline-flex">
                            <router-link class="btn btn-secondary shadow-sm rounded-md mr-4" to="/dashboard/admin/empleados">
                                {{ $t('Cancelar') }}
                            </router-link>
                            <button class="btn btn-green shadow-sm rounded-md" type="submit">
                                {{ $t('Agregar empleado') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <input ref="fileInput" hidden type="file" @change="uploadFile($event)">
    </main>
</template>

<script>


export default {
    name: "new",
    metaInfo() {
        return {
            title: this.$i18n.t('Agregar nuevo empleado')
        }
    },
    data() {
        return {
            loading: {
                form: true,
                file: false,
            },


            uploadingFileProgress: 0,
            empleado:{
                oficina_id:null,
                turno_id:null,
                name:null,
                apellidos:null,
                email:null,
                telefono:null
            },
            oficinaList: [],
            turnoList:[],
        }
    },

    mounted() {
        this.getFilters();
    },
    methods: {
        getFilters() {
            const self = this;
            self.loading.form = true;
            axios.get('api/dashboard/admin/empleados/filters').then(function (response) {
                self.oficinaList = response.data.oficinas;
                self.turnoList = response.data.turnos
                console.log(self.turnoList)
                self.loading.form = false;
            }).catch(function () {
                self.loading.form = false;
            })
        },

        saveEmpleado() {
            const self = this;
            self.loading.form = true;
            console.log(self.empleado);
             axios.post('api/dashboard/admin/empleados', self.empleado).then(function (response) {
                 self.$notify({
                     title: self.$i18n.t('Completado').toString(),
                     type: 'success'
                 });
                  self.$router.push('/dashboard/admin/empleados');
             }).catch(function () {
                 self.loading.form = false;
             });
        },
    },
}
</script>

