<template>
  <main class="flex-1 relative overflow-y-auto py-6 focus:outline-none" tabindex="0">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-5">
      <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
          <h1 class="py-0.5 text-2xl font-semibold text-gray-900">{{ $t('Agenda') }}</h1>
        </div>
        <div>
        <button @click="generatePDF" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
          Generar PDF
        </button>
      </div>
      </div>
    </div>

    <!-- modal -->
    <transition name="modal-fade">
      <div v-if="isModalVisible" class="modal">
        <div class="modal-content bg-white rounded shadow-md">
          <div class="modal-header bg-gray-800 text-white p-4 rounded-t">
            <h2 class="text-lg font-semibold">Agendar Actividad</h2>
          </div>
          <form @submit.prevent="handleSubmit" v-on-clickaway="closeModal" class="p-4">
            <div class="mb-4">
              <label for="dateAppointment" class="text-gray-800">Fecha</label>
              <h2>{{ calendario.dateAppointment }}</h2>
              <!-- <input type="text" id="dateAppointment" v-model="appointment.dateAppointment" class="border rounded p-2 w-full shadow-sm"  :disabled="isInput1Disabled"> -->
            </div>
            <div class="mb-4">
              <label for="input3" class="text-gray-800">Categoria</label>
              <input-select id="category" v-model="filterCategoryGetactivity" :options="categoryList" multiple
                option-label="name" @change="getActivity" />
            </div>
            <div class="mb-4">
              <div>
                <label for="category" class="text-gray-800">Actividad</label>
                <v-select v-model="dataAppointment.Activity" :options="activityList" label="tittle"
                  placeholder="Selecciona una actividad"></v-select>
              </div>
            </div>
            <div class="mb-4">
              <label for="input4" class="text-gray-800">Agente</label>
              <v-select v-model="dataAppointment.Agent" :options="userList" id="userList" label="nombre"
                placeholder="Selecciona una actividad"></v-select>
            </div>

            <button type="submit"
              class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-green-600 shadow-md">Enviar</button>
            <button @click="isModalVisible = false"
              class=" bg-gray-800 text-white px-4 py-2 rounded hover:bg-red-900 shadow-md">cancelar</button>

          </form>
        </div>
      </div>
    </transition>

    <transition name="modal-fade">
      <div v-if="isEditModalVisible" class="modal" >
        <div class="modal-content bg-white rounded shadow-md">
          <div class="modal-header bg-gray-800 text-white p-4 rounded-t flex justify-between items-center">
            <h2 class="text-lg font-semibold">Editar Actividad</h2>
            
          </div>
          <form @submit.prevent="updateEvent(editCalendario.id)" v-on-clickaway="closeEditModal" class="p-4">
            <div class="mb-4">
              <label for="dateAppointment" class="text-gray-800">Fecha</label>
              <h2>{{ calendario.dateAppointment }}</h2>
              <!-- <input type="text" id="dateAppointment" v-model="appointment.dateAppointment" class="border rounded p-2 w-full shadow-sm"  :disabled="isInput1Disabled"> -->
            </div>
            <div class="mb-4">
              <label for="input3" class="text-gray-800">Categoria</label>
              <!-- <input-select id="category" v-model="editCalendario.actividad.categoria" :options="categoryList" multiple
                option-label="name" @change="getActivity" /> -->
                <v-select v-model="editCalendario.actividad.categoria" :options="categoryList" label="name"
                  placeholder="Selecciona una actividad" @change="getActivity"></v-select>
            </div>
            <div class="mb-4">
              <div>
                <label for="category" class="text-gray-800">Actividad</label>
                <v-select v-model="editCalendario.actividad" :options="activityList" label="tittle"
                  placeholder="Selecciona una actividad"></v-select>
              </div>
            </div>
            <div class="mb-4">
              <label for="input4" class="text-gray-800">Agente</label>
              <v-select v-model="editCalendario.agent" :options="userList" id="userList" label="nombre"
                placeholder="Selecciona una actividad"></v-select>
            </div>
            <div class="mb-4">
              <label for="switch1" class="text-gray-800">Estatus de la actividad</label>
              <el-switch v-model="editCalendario.status_id" :active-value="1" :inactive-value="3" />
            </div>

            <button type="submit" 
              class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-green-600 shadow-md">Enviar</button>

            <button @click="isEditModalVisible = false"
              class=" bg-gray-800 text-white px-4 py-2 rounded hover:bg-red-900 shadow-md">cancelar</button>

              <div class="flex justify-center mt-10">
                <button v-if="isVisibleDelete" class="btn btn-red shadow-sm rounded-md w-full flex justify-center items-center" type="button" @click="deleteEvent(editCalendario.id)">
                  <svg-vue class="text-gray-200 h-4 w-4 mx-5" icon="font-awesome.trash-alt-regular"></svg-vue>
                </button>
            </div>

          </form>
        </div>
      </div>
    </transition>
    
    <transition name="modal-fade">
      <div v-if="isEventModalVisible" class="event-modal">
        <!-- Contenido del nuevo modal -->
        <div class="event-modal-content">
          <!-- Mostrar información específica del evento -->
          <div class="flex items-center  border-b-2 border-gray-200 pb-2">
            <svg-vue class="text-gray-200 h-3 w-3 mr-2" icon="font-awesome.info-regular"></svg-vue>
            <h2>{{ eventData.title }}</h2>
          </div>
          <div class="flex items-center mt-2">
            <svg-vue class="text-gray-200 h-3 w-3 mr-2" icon="font-awesome.user-regular"></svg-vue>
            <h3>{{ eventData.agent }}</h3>
          </div>
          <div class="flex items-center mt-2">
            <svg-vue class="text-gray-200 h-3 w-3 mr-2" icon="font-awesome.calendar-regular"></svg-vue>
            <h3>{{ eventData.date }}</h3>
          </div>
          <div class="flex items-center mt-2">
            <svg-vue class="text-gray-200 h-3 w-3 mr-2" icon="font-awesome.clock-regular"></svg-vue>
            <h3 :style="{ padding: '2px', borderRadius: '5px', backgroundColor: eventData.color }">{{ eventData.status }}
            </h3>
          </div>
          <div class="flex items-center mt-2">
            <span class="text-gray-100 mr-2"><span class="font-bold">Detalles del evento:</span> {{ eventData.desc
            }}</span>
          </div>

          <!-- Aquí puedes mostrar otros detalles del evento -->
        </div>
      </div>
    </transition>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="my-6 bg-white shadow overflow-hidden sm:rounded-md">
        <FullCalendar ref="fullCalendar" :options="calendarOptions" />
      </div>
    </div>

  </main>
</template>

<script>
import { mixin as clickaway } from "vue-clickaway";
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import timeGridPlugin from '@fullcalendar/timegrid';
import esLocale from '@fullcalendar/core/locales/es';
import moment from 'moment';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import html2pdf from 'html2pdf.js';

export default {
  components: {
    vSelect,
    FullCalendar,
    ElSwitch: ElementUI.Switch, // make the <FullCalendar> tag available
  },
  mixins: [clickaway],
  data: function () {
    return {
      filterCategoryGetactivity: [],

      isEventModalVisible: false,
      isVisibleDelete: false,
      activityList: [],
      userList: [],
      titleAppointment: '',
      isModalVisible: false,
      isEditModalVisible:false,
      isInput1Disabled: true,
      editCalendario: {

      },
      switchValue: '',

      currentDate: moment().format('YYYY-MM-DD'),

      dataAppointment: {
        Agent: [],
        Activity: [],
        date: '',
      },

      calendario: {
        agent_id: null,
        actividad_id: null,
        dateAppointment: '',
        title: null,
        color: null,
      },

      editCalendario:[],

      updateEventObject:{
        agent_id: null,
        status_id:null,
        actividad_id: null,
        fecha_appointment: '',
        title: null,
      },

      EventsList: [],
      
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin,timeGridPlugin],
        initialView: 'dayGridMonth',
        locale: esLocale,
        dateClick: this.handleDateClick,
        eventMouseEnter: this.handleEventMouseEnter,
        eventMouseLeave: this.handleEventMouseLeave,
        eventClick: this.handleEventClick,
        events: [

        ],


      }
    }
  },
  mounted() {
    this.getCategorias();
    this.getActivity();
    this.getPersonal();
    this.getEvent();
  },
  methods: {
    handleEventClick: async function (info) {
      const self=this;
      const clickedEventDate = info.event.startStr;
      try{
        await this.getSingleEvent(info.event.extendedProps.idEvent);
        
      }catch{
        console.error(error);
      }
      // this.getSingleEvent(info.event.extendedProps.idEvent);
      this.showEditModal(clickedEventDate);
      this.isEditModalVisible = true; // Pasar solo la fecha a tu función showModal
    },

    handleDateClick: function (arg) {

      if (arg.dateStr < this.currentDate) {
        alert('No puedes seleccionar una fecha a la actual: ' + this.currentDate);
      } else {
        this.calendario = {};

        this.showModal(arg.dateStr);
      }

    },
    handleEventMouseEnter: function (info) {
      this.eventData = {
        title: info.event.title,
        agent: info.event.extendedProps.agent,
        date: info.event.startStr,
        desc: info.event.extendedProps.desc,
        status: info.event.extendedProps.status,
        color: info.event.backgroundColor

      };

      // Muestra el nuevo modal para información del evento
      this.isEventModalVisible = true; // Aquí puedes acceder a los detalles del evento

    },
    handleEventMouseLeave: function () {
      this.isEventModalVisible = false;
    },


    collectAppointment(apData) {
      const self = this;
      self.calendario.agent_id = apData.Agent.id;
      self.calendario.actividad_id = apData.Activity.id;
      self.calendario.title = apData.Activity.tittle;
      self.calendario.desc = apData.Activity.Desc
      self.submitAppointment();
    },
    submitAppointment() {
      const self = this;
      
      axios.post('api/dashboard/admin/calendario', self.calendario).then(function (response) {
        self.$notify({
          title: self.$i18n.t('Completado').toString(),
          text: self.$i18n.t('Actividad agendada').toString(),
          type: 'success'
        });
        self.getEvent();
        self.isModalVisible = false;
        self.calendario = {};
        self.dataAppointment = {};
      }).catch(function () {
        self.loading.form = false;
      });

    },
    fetchUpdateEvent(){
      const self=this;

      self.updateEventObject.actividad_id=self.editCalendario.actividad.id;
      self.updateEventObject.agent_id=self.editCalendario.agent.id;
      self.updateEventObject.fecha_appointment=self.editCalendario.fecha_appointment;
      self.updateEventObject.title=self.editCalendario.actividad.tittle;
      self.updateEventObject.color=self.editCalendario.actividad.categoria.color;
      self.updateEventObject.status_id=self.editCalendario.status_id;
    },  
    getEvent() {
      const self = this;
      axios.get('api/dashboard/admin/calendario', {
      }).then(function (response) {
        self.EventsList = response.data;
        self.updateCalendarEvents();
      }).catch(function () {
        self.loading = false;
      });
    },
    getSingleEvent(id){
      return new Promise((resolve, reject) => {
        axios.get('api/dashboard/admin/calendario/' + id)
          .then(response => {
            this.editCalendario = response.data;
            resolve(); // Resuelve la promesa cuando se obtienen los datos
          })
          .catch(error => {
            reject(error); // Rechaza la promesa si hay un error
          });
      });
    },
    deleteEvent(id){
      const self = this;
            axios.delete('api/dashboard/admin/calendario/' +id).then(function () {
                self.$notify({
                    title: self.$i18n.t('completado').toString(),
                    text: self.$i18n.t('evento eliminado').toString(),
                    type: 'success'
                });
                self.calendario = {};
                self.dataAppointment = {};
                self.getEvent();
            }).catch(function () {
                
            });
    },

    updateEvent(id){
      const self=this;
          self.fetchUpdateEvent();
          this.updateEventObject.status_id = this.editCalendario.status_id;
            axios.put('api/dashboard/admin/calendario/'+id, self.updateEventObject).then(function (){
                self.$notify({
                    title: self.$i18n.t('completado').toString(),
                    text: self.$i18n.t('turno actualizado').toString(),
                    type: 'success'
                    
                });
                self.closeEditModal();
                self.getEvent();
            }).catch(function (){
                self.loading=false;
            })
    },
    updateCalendarEvents() {

      const eventsData = this.EventsList.map(eventItem => {
        let color = eventItem.color; // Color predeterminado
        
        if (eventItem.status.id !== 3) {
          if (eventItem.status.id === 1) {
            console.log(eventItem.status.id);
            color = '#5cb85c'; // Cambiar el color si el status.id no es igual a 3
          }
          if (eventItem.status_id === 2) {
            color = '#F20000'
          }
          return {
          idEvent: eventItem.id,
          title: eventItem.actividad.tittle,
          start: eventItem.fecha_appointment,
          color: color,
          agent: eventItem.agent.nombre,
          desc: eventItem.actividad.Desc,
          status: eventItem.status.name
        };
          
        }else{
          return {
          idEvent: eventItem.id,
          title: eventItem.actividad.tittle,
          start: eventItem.fecha_appointment,
          color: eventItem.actividad.categoria.color,
          agent: eventItem.agent.nombre,
          desc: eventItem.actividad.Desc,
          status: eventItem.status.name
        };
        }
      });

      this.calendarOptions.events = eventsData;
    },

    handleSubmit() {
      const self = this;
      this.collectAppointment(self.dataAppointment)

    },


    dateAppointmentHandle(event) {
      event.preventDefault();
      event.target.value = this.appointment.dateAppointment;
    },

    getCurrentDate() {
      const currentDateGet = new Date();
      return currentDateGet.toISOString;
    },


    // GET EXTERNAL CONTENT
    getCategorias() {
      const self = this;
      
      axios.get('api/dashboard/admin/categorias').then(function (response) {
        self.categoryList = response.data;
        self.loading = false;
      }).catch(function () {
        self.loading = false;
      });
    },

    getActivity() {
      const self = this;
     

      const params = {
        categoria: this.filterCategoryGetactivity
      };
      axios.get('api/dashboard/admin/activity', {
        params: params
      }).then(function (response) {
        self.activityList = response.data.items;
      }).catch(function () {
        self.loading = false;
      });

    },

    getPersonal() {
      const self = this;
      
      axios.get('api/dashboard/admin/personal', {
      }).then(function (response) {
        self.userList = response.data.items;
      }).catch(function () {
        self.loading = false;
      });
    },

////MODALS
    showEditModal(dateStr){
      this.isVisibleDelete=true;
      this.isEditModalVisible=true;
      this.calendario.dateAppointment = dateStr;
    },
    closeEditModal(){
      this.isEditModalVisible=false;
      this.isVisibleDelete = false;
      this.switchValue=''
    },
    showModal(dateStr) {
      this.isModalVisible = true;
      this.calendario.dateAppointment = dateStr;
    },
    closeModal() {

      this.isModalVisible = false;
      this.isVisibleDelete = false;
      self.dataAppointment = {}
      },

      generatePDF() {
          const calendarEl = this.$refs.fullCalendar.$el;
          

          const opt = {
            margin: 1,
            filename: 'calendario.pdf',
            image: { type: 'jpeg', quality: 1 },
            html2canvas: { scale: 1 }, // Puedes ajustar esto según sea necesario
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' },
          };

          html2pdf().from(calendarEl).set(opt).save();
        }
 
  }
}

</script>

<style>
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.5s;
}

.modal-fade-enter,
.modal-fade-leave-to {
  opacity: 0;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 999;
}

.modal-content {
  border-radius: 8px;
  width: 100%;
  max-width: 400px;
}

.modal-header {
  border-radius: 8px 8px 0 0;
}

/* Estilos para el nuevo modal */
.event-modal {
  position: fixed;
  max-width: 270px;
  max-height: 250px;
  top: 8%;
  left: 14%;
  right: 0;
  bottom: 0;
  background: rgba(69, 69, 95, 0.7);
  display: flex;
  border-radius: 5px;
  z-index: 999;
  /* Ajusta el tamaño y estilos según tu diseño */
}

.event-modal-content {

  padding: 10px;
}

.event-modal h2 {
  position: sticky;
  font-weight: bold;
  color: rgb(254, 255, 255)
}

.event-modal h3 {
  color: rgb(254, 255, 255);
}
</style>