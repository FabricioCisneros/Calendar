<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <form @submit.prevent="saveOffice">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Agregar oficina') }}</h1>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-6 shadow sm:rounded-lg">
                    <loading :status="loading"/>
                    <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('Detalles de la Oficina') }}</h3>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="name">{{ $t('Nombre de la Oficina') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input
                                            id="name"
                                            v-model="oficina.name"
                                            :placeholder="$t('Nombre de la Oficina')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required
                                        >
                                    </div>
                                </div>
                                    <div class="col-span-3">
                                        <label class="block text-sm font-medium leading-5 text-gray-700" for="role">Estado</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <select
                                                v-model="selectedState"
                                                class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                                required
                                            >
                                            <option disabled value="">Selecciona un estado</option>
                                            <option v-for="state in states" :value="state">{{ state.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
                        <div class="inline-flex">
                            <router-link
                                class="btn btn-secondary shadow-sm rounded-md mr-4"
                                to="/dashboard/admin/oficinas"
                            >
                                {{ $t('Cancelar') }}
                            </router-link>
                            <button
                                class="btn btn-green shadow-sm rounded-md"
                                type="submit"
                            >
                                {{ $t('Crea la etiqueta') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
</template>

<script>
export default {
    name: "new",
    metaInfo() {
        return {
            title: this.$i18n.t('Añadir oficina'),

        }
    },
    data() {
        return {
            loading: false,
            selectedState: '',
            oficina:{
                name: null,
                estado:'',
            },
            states: [
        { name: 'Aguascalientes' },
        { name: 'Baja California' },
        { name: 'Baja California Sur' },
        { name: 'Campeche' },
        { name: 'Coahuila' },
        { name: 'Colima' },
        { name: 'Chiapas' },
        { name: 'Chihuahua' },
        { name: 'Ciudad de México' },
        { name: 'Durango' },
        { name: 'Guanajuato' },
        { name: 'Guerrero' },
        { name: 'Hidalgo' },
        { name: 'Jalisco' },
        { name: 'México' },
        { name: 'Michoacán' },
        { name: 'Morelos' },
        { name: 'Nayarit' },
        { name: 'Nuevo León' },
        { name: 'Oaxaca' },
        { name: 'Puebla' },
        { name: 'Querétaro' },
        { name: 'Quintana Roo' },
        { name: 'San Luis Potosí' },
        { name: 'Sinaloa' },
        { name: 'Sonora' },
        { name: 'Tabasco' },
        { name: 'Tamaulipas' },
        { name: 'Tlaxcala' },
        { name: 'Veracruz' },
        { name: 'Yucatán' },
        { name: 'Zacatecas' }
            ]
        }
    },
    methods: {
        saveOffice() {
            const self = this;
            self.loading = true;
            self.oficina.estado=self.selectedState.name;
            console.log(self.oficina)
             axios.post('api/dashboard/admin/oficinas', self.oficina).then(function (response) {
                self.loading = false;
                 self.$notify({
                     title: self.$i18n.t('Completado').toString(),
                     text: self.$i18n.t('Datos Almacenados con exito').toString(),
                     type: 'success'
                 });
                 self.$router.push('/dashboard/admin/oficinas/' + response.data.oficina.id + '/edit');
             }).catch(function () {
                 self.loading = false;
            });
        },
    }
}
</script>
