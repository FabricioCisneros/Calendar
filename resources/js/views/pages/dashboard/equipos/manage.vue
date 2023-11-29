<template>
<div class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
    <loading :status="loading.form"/>
    <div class="flex relative">
        <div :style="{height: 'calc(100vh - 70px)'}" class="flex-auto min-w-0">
            <div class="w-full h:auto sm:h-14 border-b sm:px-3">
                <div class="sm:flex sm:justify-between">
                    <div class="flex">
                        <button class="btn p-4 rounded-none" type="button" @click="$router.push('/dashboard/equipos')">
                            <svg-vue class="h-5 w-5 text-gray-700" icon="font-awesome.chevron-left-regular"></svg-vue>
                        </button>
                        <button class="btn p-4 rounded-none" type="button" @click="deleteEquipoModal = true">
                            <svg-vue class="h-5 w-5 text-gray-700" icon="font-awesome.trash-alt-regular"></svg-vue>
                        </button>
                        <template>
                            <router-link
                            :to="'/dashboard/Equipos/' + equipo.uuid + '/edit'" 
                            class="btn p-4 rounded-none">
                            <svg-vue class="h-5 w-5 text-gray-700" icon="font-awesome.edit-regular"></svg-vue>
                            </router-link>
                        </template>
                    </div>
                    <div class="flex items-center justify-end m-3 sm:m-0">
                        <template>
                            <template v-if="equipo.numero_serie">
                                <div class="text-2xl font-semibold">{{ equipo.modelo }}</div>
                                <div class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-blue-100 text-blue-800">
                                    N/S:{{ equipo.numero_serie}}
                                </div>
                            </template>
                            <template v-else>
                                <div class="text-2xl font-semibold">{{ equipo.modelo }}</div>
                            </template>
                        </template>
                    </div>
                </div>
            </div>
            <div class="equipo-conversation">
                <div class="block">
                    <div class="sm:flex sm:items-center py-3 max-w-full border-b">
                        <div class="px-6 sm:pl-6 sm:pr-3 sm:flex-1 sm:w-3/4">
                            <div class="text-xl truncate">{{ equipo.subject }}</div>
                        </div>
                        <div  class="px-6 sm:pl-3 sm:pr-6 sm:flex-1 sm:w-1/4">
                            <div class="flex items-center sm:float-right mt-3 sm:mt-0">
                                <div class="text-sm sm:pr-2">{{ equipo.created_at | momentFormatDateTimeAgo }}</div>
                                <button class="flex items-center btn btn-white p-2 ml-3 sm:ml-0" type="button" @click="replyForm = true">
                                    <svg-vue class="h-4 w-4 mr-2" icon="font-awesome.update-regular"></svg-vue>
                                    {{ $t('Agregar detalle del equipo') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div v-show="replyForm" class="px-6 py-3 border-b">
                        <loading :status="loading.reply"/>
                        <form @submit.prevent="addReply">
                            <input-wysiwyg
                            id="equipo_body"
                            v-model="equipoReply.body"
                            :plugins="{images: true,attachment: true, shortCode: true}"
                            >
                                <template v-slot:top>
                                    <div :class="{'bg-gray-200': uploadingFileProgress > 0}" class="h-1 w-full">
                                        <div :style="{width: uploadingFileProgress + '%'}" class="bg-blue-500 py-0.5"></div>
                                    </div>
                                </template>
                                <template v-slot:bottom>
                                    <div class="flex justify-between border border-t-0">
                                        <button
                                            class="btn btn-secondary rounded-none"
                                            type="button"
                                            @click="discardReply"         
                                        >
                                            {{ $t('Cancelar') }}
                                        </button>
                                        <div class="flex">
                                            <select
                                                id="status"
                                                v-model="equipoReply.status_id"
                                                aria-label="ordenar por"
                                                class="block form-select pl-3 pr-9 py-2 border-l border-r-0 border-t-0 border-b-0 border-gray-400 rounded-none bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                            >
                                                <template v-for="status in statusList">
                                                    <option :value="status.id">{{ status.name }}</option>
                                                </template>
                                            </select>
                                            <button
                                                class="btn btn-green rounded-none"
                                                type="submit"
                                            >
                                                {{ $t('agregar detalle o descripcion del equipo') }}
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </input-wysiwyg>
                        </form>
                        <input ref="fileInput" hidden type="file" @change="uploadFile($event)">
                        <template v-if="equipoReply.attachments.length > 0">
                            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2">
                                <template v-for="(attachment, index) in equipoReply.attachments">
                                    <attachment :details="attachment" v-on:remove="removeAttachment(index)"/>
                                </template>
                            </div>
                        </template>
                    </div>
                    <template v-if="equipo.equipoReplies.length > 0">
                            <div class="block">
                                <template v-for="(equipoReply, index) in equipo.equipoReplies">
                                    <div :class="{'border-t' : index > 0}" class="flex p-6">
                                        <img
                                            :alt="$t('Avatar')"
                                            :src="equipoReply.user.avatar !== 'gravatar' ? equipoReply.user.avatar : equipoReply.user.gravatar"
                                            class="h-12 w-12 hidden sm:inline"
                                        />
                                        <div class="sm:pl-6 pb-2 w-full">
                                            <div class="md:flex md:items-center pb-1">
                                                <div class="md:flex-1 text-lg font-semibold text-gray-800">
                                                    {{ equipoReply.user.name }}
                                                </div>
                                                <div class="md:flex-1">
                                                    <div class="md:float-right text-sm">
                                                        {{ equipoReply.created_at | momentFormatDateTime }}
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-gray-700 equipo-reply-body" v-html="equipoReply.body"/>
                                            <template v-if="equipoReply.attachments.length > 0">
                                                <div class="mt-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2">
                                                    <template v-for="attachment in equipoReply.attachments">
                                                        <attachment :details="attachment" :remove-button="false"/>
                                                    </template>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    <template v-else>
                        <div class="h-full flex border-t">
                                <div class="m-auto">
                                    <div class="grid grid-cols-1 justify-items-center h-full w-full py-24">
                                        <div class="flex justify-center items-center">
                                            <svg-vue class="h-full h-auto w-48 mb-6" icon="undraw.task-list"></svg-vue>
                                        </div>
                                        <div class="flex justify-center items-center">
                                            <div class="w-full font-semibold text-2xl">{{ $t('Este Equipo no cuenta con detalles') }}</div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
        <div v-show="deleteEquipoModal" class="fixed z-20 inset-0 overflow-y-auto">
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
                    <div v-show="deleteEquipoModal" class="fixed inset-0 transition-opacity">
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
                        v-show="deleteEquipoModal"
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
                                        {{ $t('Eliminar Equipo') }}
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
                                @click="deleteEquipo"
                            >
                                {{ $t('Eliminar un equipo') }}
                            </button>
                            <button
                                class="btn btn-white mr-0 sm:mr-2"
                                type="button"
                                @click="deleteEquipoModal = false"
                            >
                                {{ $t('cancelar') }}
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
    name:"manage",
    mixins:[clickaway],

    metainfo(){
        return{
            tittle:this.$i18n.t('Gestion del equipo')
        }
    },

    mounted() {
            this.getEquipo();
            this.getFilters();
        },

    data(){
        return{
            loading:{
                form:true,
                reply:false,
                file:false,
            },
            deleteEquipoModal:false,
            replyForm:false,
            uploadingFileProgress:0,

            equipo: {
                modelo:null,
                numero_serie:null,
                created_at:null,
                equipoReplies:[],
            },
            equipoReply:{
                status_id: null,
                body: '',
                attachments: [],
            },
            statusList: []       
        }
    },
    filters:{
        momentFormatDateTime: function (value) {
            return moment(value).locale(window.app.app_date_locale).format(window.app.app_date_format + ' HH:mm');
        },
        momentFormatDateTimeAgo: function (value) {
            return moment(value).locale(window.app.app_date_locale).fromNow();
        },
    },

    methods:{
        getEquipo(){
            const self=this;
            self.loading.fomr=true;
            axios.get('api/dashboard/equipos/'+self.$route.params.uuid).then(function(response){
                //  .log(response.data);
                self.loading.form=false;
                self.equipo=response.data;
                self.equipoReply.status_id=response.data.status_id;
            }).catch(function(){
                self.$router.push('/dashboard/equipos/');
            });
        },
        getFilters() {
            const self = this;
            axios.get('api/dashboard/tickets/filters').then(function (response) {
                self.statusList = response.data.statuses;
            });
        },
        discardReply(){
            this.equipoReply.body='';
            this.equipoReply.attachments=[];
            this.replyForm= false;
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
                'api/dashboard/equipos/attachments',
                formData,
                {
                    headers: {'Content-Type': 'multipart/form-data'},
                    onUploadProgress: function (progressEvent) {
                        self.uploadingFileProgress = Math.round((progressEvent.loaded / progressEvent.total) * 100);
                    }.bind(this)
                }
            ).then(function (response) {
                self.loading.file = false;
                self.uploadingFileProgress = 0;
                self.$refs.fileInput.value = null;
                self.equipoReply.attachments.push(response.data);
            }).catch(function () {
                self.loading.file = false;
                self.uploadingFileProgress = 0;
                self.$refs.fileInput.value = null;
            });
        },

        removeAttachment(attachment) {
            this.equipoReply.attachments.splice(attachment, 1);
        },

        addReply(){
            const self = this;
            self.loading.reply =true;
            console.log(self.equipoReply);
            axios.post('api/dashboard/equipos/'+self.$route.params.uuid+'/reply',self.equipoReply).then(function (response){
                self.$notify({
                    tittle: self.$i18n.t('OK').toString(),
                    text:self.$i18n.t('Registro guardado'),
                    type:'success'
                });

                self.equipo=response.data.equipo;
                self.equipoReply.status_id=response.data.equipo.status_id;
                self.discardReply();
                self.loading.reply=false;
            }).catch(function(){
                self.loading=false
            });
        },
        deleteEquipo() {
            const self = this;
            axios.delete('api/dashboard/equipos/' + self.$route.params.uuid).then(function () {
                self.$notify({
                    title: self.$i18n.t('Success').toString(),
                    text: self.$i18n.t('Data deleted successfully').toString(),
                    type: 'success'
                });
                self.$router.push('/dashboard/equipos');
            }).catch(function () {
                self.deleteEquipoModal = false;
            });
        },

    },
}
</script>