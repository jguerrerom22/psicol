<template>
  <div>

    <h4 class="font-weight-bold py-3 mb-4">
      VENTA DE BOLETAS
    </h4>

    <div class="d-flex flex-wrap justify-content-between px-3 pt-3 mb-4">
      <div>
        <b-btn variant="outline-primary" v-b-modal.modals-default><span class="ion ion-md-add"></span>&nbsp; Agregar Cliente</b-btn>
      </div>

      <!-- Modal Registro -->
      <b-modal ref="cliente-modal" id="modals-default" :size="defaultModalSize" hide-footer>
        <div slot="modal-title">
          <span class="font-weight-light">Creación de clientes</span><br>
          <small class="text-muted">Ingrese los siguientes datos para dar de alta al cliente.</small>
        </div>

        <b-form-row>
          <b-form-group label="Nro. Documento" class="col">
            <b-input v-model="datosCliente.documento"/>
          </b-form-group>
        </b-form-row>
        <b-form-row>
          <b-form-group label="Nombres" class="col mb-0">
            <b-input v-model="datosCliente.nombre" />
          </b-form-group>
          <b-form-group label="Apellidos" class="col mb-0">
            <b-input v-model="datosCliente.apellido" />
          </b-form-group>
        </b-form-row>
        <b-form-row>
          <b-form-group label="Género:" class="col mb-0">
            <b-select placeholder="Seleccione rol" v-model="datosCliente.genero" >
              <option value="M">Hombre</option>
              <option value="F">Mujer</option>
            </b-select>
          </b-form-group>
          <b-form-group label="Email" class="col mb-0">
            <b-input v-model="datosCliente.email" />
          </b-form-group>
        </b-form-row>

        <b-form-row class="mt-3">
          <b-btn variant="secondary" v-on:click="hideModal()">Cancelar</b-btn>
          <b-btn variant="primary" v-on:click="saveClient()" class="ml-2">Guardar</b-btn>
        </b-form-row>
      </b-modal>

      <!-- Modal Asignacion -->
      <b-modal ref="asignacion-modal" id="modals-asignacion" :size="defaultModalSize" hide-footer>
        <div slot="modal-title">
          <span class="font-weight-light">Asignación de boletas a clientes</span><br>
          <small class="text-muted">Ingrese el número de documento del cliente:</small>
        </div>

        <b-form-row>
          <b-form-group class="col-9">
            <b-input v-model="clienteBusqueda" placeholder="Nro. de documento"/>
          </b-form-group>
          <b-form-group class="col-2">
            <b-btn variant="success rounded-pill" v-on:click="validateClient()" class="ml-2">Validar</b-btn>
          </b-form-group>
        </b-form-row>

        <div v-if="showInfoCliente">
          <div class="row">
            <div class="col">
              <label class="text-muted">Nombre:</label>
              <label class="text-body">{{datosCliente.nombre}} {{datosCliente.apellido}}</label>
            </div>
          </div>

          <div class="row">
            <div class="col">
              <label class="text-muted">Email:</label>
              <label class="text-body">{{datosCliente.email}}</label>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col">
              <label class="text-muted">Evento:</label>
              <label class="text-body">{{ticketAsignacion.nombre}}</label>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label class="text-muted">Fecha Evento:</label>
              <label class="text-body">{{ticketAsignacion.fecha_evento}}</label>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label class="text-muted">Lugar:</label>
              <label class="text-body">{{ticketAsignacion.lugar}}</label>
            </div>
          </div>

          <hr>

          <div class="row">
            <b-btn variant="primary" v-on:click="asignarTicket()">Asignar boleta</b-btn>
          </div>
        </div>
      </b-modal>
    </div>

    <!-- Set `.contacts-col-view` or '.contacts-row-view' to control view mode -->
    <div class="row" :class="`contacts-${viewMode}-view`">
      <div class="col">
        <div class="row">
          <div v-for="ticket in tickets" :key="ticket.id" class="contacts-col col-12">

            <b-card class="mb-4">
              <div class="contact-content">
                <div class="contact-content-about">
                  <h5 class="contact-content-name mb-1"><a href="javascript:void(0)" class="text-body">{{ticket.nombre}}</a></h5>
                  <div class="contact-content-user text-muted small mb-2"><span class="ion ion-md-pin"></span>&nbsp; {{ticket.lugar}}</div>
                  <div class="small">
                    <div>{{ticket.fecha_evento}}</div>
                    <div>Disponible: <strong>{{ticket.disponible}}</strong></div>
                  </div>
                  <hr class="border-light">
                  <div>
                    <b-btn variant="primary" size="sm" class="mb-0" v-on:click="showModalAsignacion(ticket)">Comprar</b-btn>
                  </div>
                </div>
              </div>
            </b-card>

          </div>
        </div>
      </div>

    </div><!-- / .row -->

  </div>
</template>

<!-- Page -->
<style src="@/vendor/styles/pages/contacts.scss" lang="scss"></style>
<style src="@/vendor/libs/sweet-modal-vue/sweet-modal-vue.scss" lang="scss"></style>

<script>
import axios from 'axios'

export default {
  name: 'pages-tickets',
  metaInfo: {
    title: 'Lista de Tickets'
  },

  created () {
    this.listarTickets()
  },

  data: () => ({
    viewMode: 'col',

    defaultModalSize: null,

    tickets: [],
    ticketAsignacion: {
      id: '',
      nombre: '',
      fecha_evento: '',
      lugar: ''
    },
    datosCliente: {
      id: '',
      documento: '',
      nombre: '',
      apellido: '',
      genero: '',
      email: ''
    },
    clienteBusqueda: '',
    showInfoCliente: false
  }),

  methods: {
    showBs4Toast (title, text, variant) {
      this.$bvToast.toast(text, {
        title: title,
        autoHideDelay: 4000,
        appendToast: true,
        toastClass: variant ? `bs4-toast bg-${variant}` : 'bs4-toast'
      })
    },

    listarTickets () {
      this.tickets = [];
      axios.get(`${this.apiUrl}ticket`, {
        headers: { 'Content-Type': 'application/json' }
      }).then(response => {
        const d = response.data
        for (var x in d) {
          this.tickets.push({
            id: d[x].id,
            nombre: d[x].nombre,
            lugar: d[x].lugar,
            disponible: d[x].disponible,
            fecha_evento: d[x].fecha_evento
          })
        }
      }).catch(e => {
        console.log(e)
      })
    },

    saveClient () {
      if (this.datosCliente.documento === '') {
        this.showBs4Toast('Error', 'Ingrese el documento del cliente', 'warning')
        return
      }
      if (this.datosCliente.nombre === '') {
        this.showBs4Toast('Error', 'Ingrese el nombre del cliente', 'warning')
        return
      }
      if (this.datosCliente.apellido === '') {
        this.showBs4Toast('Error', 'Ingrese el apellido del cliente', 'warning')
        return
      }
      if (this.datosCliente.email === '') {
        this.showBs4Toast('Error', 'Ingrese el email del cliente', 'warning')
        return
      }
      if (!this.datosCliente.genero) {
        this.showBs4Toast('Error', 'Seleccione el género del cliente', 'warning')
        return
      }
      axios({
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        url: `${this.apiUrl}comprador`,
        data: this.datosCliente,
        validateStatus: () => true
      }).then(response => {
        if (response.status === 201) {
          this.showBs4Toast('Exitoso', 'Cliente registrado con éxito.', 'success')
          this.hideModal()
        } else {
          this.showBs4Toast('Error', 'Ha ocurrido un error y el cliente no puedo ser creado.', 'danger')
        }
      })
    },

    validateClient () {
      if (this.clienteBusqueda === '') {
        this.showBs4Toast('Error', 'Debe ingresar un número de documento', 'warning')
        return
      }

      axios.get(`${this.apiUrl}comprador/${this.clienteBusqueda}`, {
        headers: { 'Content-Type': 'application/json' }
      }).then(response => {
        if (response.status === 404) {
          this.showBs4Toast('No existe', 'El cliente con el número de documento ingresado no existe.', 'danger')
          return
        }

        this.showInfoCliente = true
        this.datosCliente = response.data
      }).catch(e => {
        this.showBs4Toast('No existe', 'El cliente con el número de documento ingresado no existe.', 'danger')
      })
    },

    asignarTicket () {
      axios({
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        url: `${this.apiUrl}comprador/${this.datosCliente.documento}/ticket`,
        data: { ticket: this.ticketAsignacion.id },
        validateStatus: () => true
      }).then(response => {
        if (response.status === 201) {
          this.showBs4Toast('Confirmado', 'La boleta ha sido confirmada!', 'success')
          this.listarTickets()
          this.hideModalAsignacion()
        } else {
          this.showBs4Toast('Error', 'Ha ocurrido un error y no se pudo asignar el ticket al cliente.', 'danger')
        }
      })
    },

    showModal () {
      this.$refs['cliente-modal'].show()
    },

    showModalAsignacion (ticket) {
      this.ticketAsignacion = ticket
      this.showInfoCliente = false
      this.$refs['asignacion-modal'].show()
    },

    hideModal () {
      this.limpiarDatosCliente()
      this.$refs['cliente-modal'].hide()
    },

    hideModalAsignacion () {
      this.limpiarDatosCliente()
      this.$refs['asignacion-modal'].hide()
    },

    limpiarDatosCliente () {
      this.datosCliente = {
        documento: '',
        nombre: '',
        apellido: '',
        genero: '',
        email: ''
      }
    }
  }
}
</script>
