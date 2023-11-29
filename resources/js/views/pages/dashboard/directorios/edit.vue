<template>
    <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
        <form @submit.prevent="saveTicket">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Agregar equipo') }}</h1>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mt-6 shadow sm:rounded-lg">
                    <loading :status="loading.form" />
                    <div class="bg-white md:grid md:grid-cols-3 md:gap-6 px-4 py-5 sm:p-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $t('Detalles del equipo') }}</h3>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="grid grid-cols-3 gap-6">



                                <!-- INPUT DE OFICINA EN LA QUE PERTENECE EL EQUIPO -->
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="department">{{
                                        $t('Oficina') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input-select id="department" v-model="ticket.oficina_id" :options="oficinaList"
                                            option-label="name"  />
                                    </div>
                                </div>
                                <!-- FIN DEL BLOQUE -->

                                <!-- INPUT DEL MODELO -->
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="modelo">{{
                                        $t('Modelo') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input id="modelo" v-model="ticket.modelo"
                                            :placeholder="$t('modelo del equipo incluyendo marca')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            required>
                                    </div>
                                </div>
                                <!-- FIN DEL BLOQEU -->

                                <!-- INPUT DEL NUMERO DE SERIE -->
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="numero_serie">{{
                                        $t('Numero de serie del equipo') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input id="numero_serie" v-model="ticket.numero_serie"
                                            :placeholder="$t('Numero de serie o codigo del equipo')"
                                            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                            >
                                    </div>
                                </div>
                                <!-- FIN DEL BLOQUE -->


                                <!-- INPUT DE CATEGORIA -->
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="categoria">{{
                                        $t('Categoria') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input-select id="categoria" v-model="ticket.categoria_id" :options="categoriaList"
                                            option-label="name"  />
                                    </div>
                                </div>
                                <!-- FIN DEL BLOQUE -->


                                <!-- INPUT DE ESTATUS DEL EQUIPO -->
                                <div class="col-span-3">
                                    <label class="block text-sm font-medium leading-5 text-gray-700" for="status">{{
                                        $t('Estatus o condiciones del equipo') }}</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input-select id="status" v-model="ticket.status_id" :options="statusList"
                                            option-label="name"  />
                                    </div>
                                </div>

                                <!-- FIN DEL BLOQUE -->

                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 text-right px-4 py-3 sm:px-6">
                        <div class="inline-flex">
                            <router-link class="btn btn-secondary shadow-sm rounded-md mr-4" to="/dashboard/equipos">
                                {{ $t('Cancelar') }}
                            </router-link>
                            <button class="btn btn-green shadow-sm rounded-md" type="submit">
                                {{ $t('Guardar cambios') }}
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
            title: this.$i18n.t('Create ticket')
        }
    },
    data() {
        return {
            loading: {
                form: true,
                file: false,
            },


            uploadingFileProgress: 0,
            ticket: {
                oficina_id: null,
                modelo: null,
                numero_serie: null,
                categoria_id: null,
                status_id: null,
                attachments: []

            },
            userList: [],
            statusList: [],
            categoriaList: [],
            oficinaList: []
        }
    },

    mounted() {
        this.getFilters();
        this.getTicket();
    },
    methods: {
        getFilters() {
            const self = this;
            self.loading.form = true;
            axios.get('api/dashboard/tickets/filters').then(function (response) {
                self.userList = response.data.customers;
                self.oficinaList = response.data.oficinas;
                self.statusList = response.data.statuses;
                self.categoriaList = response.data.categorias;
                self.loading.form = false;
            }).catch(function () {
                self.loading.form = false;
            })
        },
        getTicket() {
            const self = this;
            self.loading.form = true;
            axios.get('api/dashboard/tickets/' + self.$route.params.uuid).then(function (response) {
                self.loading.form = false;
                self.ticket = response.data;
                self.ticketReply.status_id = response.data.status_id;
            }).catch(function () {
                
            });
        },
        saveTicket() {
            const self = this;
            self.loading.form = true;
            console.log(self.ticket);
            axios.put('api/dashboard/tickets/' + self.$route.params.uuid, self.ticket).then(function () {
                self.loading = false;
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    type: 'success'
                });
                self.$router.push('/dashboard/equipos');
            }).catch(function () {
                self.loading = false;
            });
        },
        selectUploadFile() {
            if (!this.loading.file) {
                this.$refs.fileInput.click();
            } else {
                this.$notify({
                    title: this.$i18n.t('Error').toString(),
                    text: this.$i18n.t('A file is being uploaded').toString(),
                    type: 'warning'
                });
            }
        },

        uploadFile(e) {
            const self = this;
            const formData = new FormData();
            self.loading.file = true;
            formData.append('file', e.target.files[0]);
            axios.post(
                'api/dashboard/tickets/attachments',
                formData,
                {
                    headers: { 'Content-Type': 'multipart/form-data' },
                    onUploadProgress: function (progressEvent) {
                        self.uploadingFileProgress = Math.round((progressEvent.loaded / progressEvent.total) * 100);
                    }.bind(this)
                }
            ).then(function (response) {
                self.loading.file = false;
                self.uploadingFileProgress = 0;
                self.$refs.fileInput.value = null;
                self.ticket.attachments.push(response.data);
            }).catch(function () {
                self.loading.file = false;
                self.uploadingFileProgress = 0;
                self.$refs.fileInput.value = null;
            });
        },
        removeAttachment(attachment) {
            this.ticket.attachments.splice(attachment, 1);
        }
    },
}
</script>

