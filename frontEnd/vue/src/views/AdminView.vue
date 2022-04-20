<script>
import AdminBuscador from "@/components/AdminBuscador.vue";
import ProximasPelis from "@/components/ProximasPelis.vue";
import { sessioStore } from "../stores/sessioStore";
import { mapStores } from "pinia";

export default {
  computed: {
    ...mapStores(sessioStore),
  },
  data() {
    return {
      peli: "",
      basePeliculas: 0,
      mostrarConsultar: 0,
      mostrarAnadir: 0,
      animacion: 0,
      white: 1,
      guardarSesion: 0,
      msgError: 0,
    };
  },

  components: {
    AdminBuscador,
    ProximasPelis,
  },

  // datos sobre las sesiones
  beforeCreate() {
    fetch("http://cinema1back.alumnes.inspedralbes.cat/sesiones")
      .then((response) => response.json())
      .then((data) => {
        this.basePeliculas = data.sesiones;
        this.sessioStore.setAdmin();
      });
  },

  mounted() {
    this.peli = this.sessioStore.get;
    setTimeout(() => {
      this.white = 0;
    }, 850);
  },

  methods: {
    GuardarSesion() {
      let nuevaSesion = new FormData();
      nuevaSesion.append("fecha", document.getElementById("date").value);
      nuevaSesion.append("hora", document.getElementById("hora").value);
      nuevaSesion.append("vip", document.getElementById("vip").value);
      nuevaSesion.append(
        "diaEspectador",
        document.getElementById("espectador").value
      );
      nuevaSesion.append("idPeli", this.peli.peliInfo.imdbID);
      nuevaSesion.append("nombrePeli", this.peli.peliInfo.Title);
      nuevaSesion.append("imgPeli", this.peli.peliInfo.Poster);
      nuevaSesion.append("anoPeli", this.peli.peliInfo.Year);
      fetch("http://cinema1back.alumnes.inspedralbes.cat/sesion", {
        method: "POST",
        body: nuevaSesion,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status) {
            let n = 3;
            this.msgError = data.msg + " Refrescando en " + n;
            let idInterval = setInterval(() => {
              n--;
              this.msgError += ", " + n;
            }, 1000);
            setTimeout(() => {
              this.msgError += ".";
              clearInterval(idInterval);
              window.location.reload();
            }, 2500);
          } else {
            this.msgError = data.msg;
          }
        });
    },

    mostrarConsultarSesion: function () {
      this.animacion = this.animacion ? 0 : 1;
      setTimeout(() => {
        this.mostrarConsultar = this.mostrarConsultar ? 0 : 1;
        this.mostrarAnadir = false;
      }, 800);
    },

    mostrarAnadirSesion: function () {
      this.animacion = this.animacion ? 0 : 1;
      setTimeout(() => {
        this.mostrarAnadir = this.mostrarAnadir ? 0 : 1;
        this.mostrarConsultar = false;
      }, 800);
    },
  },
};
</script>

<template>
  <main class="admin" :class="{ colorWhite: this.white }">
    <div
      class="row"
      :class="{ fadeIn: this.animacion, fadeOut: !this.animacion }"
    >
      <div class="col-12 gy-4">
        <div @click="this.mostrarConsultarSesion">
          <h1 class="text-center hoverable">Consultar sesiones</h1>
        </div>
        <div v-if="this.mostrarConsultar">
          <div
            id="consultar_entradas"
            v-if="typeof this.basePeliculas === 'object'"
          >
            <ProximasPelis :peliculasInfo="basePeliculas" />
          </div>
        </div>
      </div>

      <div class="col-12 gy-2">
        <hr />
      </div>

      <div class="justify-content-center col-12 gy-2">
        <div @click="this.mostrarAnadirSesion">
          <h1 class="text-center hoverable">Crear una sesión</h1>
        </div>

        <div class="crear_sesion" v-if="this.mostrarAnadir">
          <div
            class="form_sesion input-group row g-4 d-flex justify-content-center"
          >
            <div class="col-auto col-form-label">
              <label><i class="bi bi-calendar-event"></i> Fecha: </label>
            </div>
            <div class="col-auto">
              <input
                class="form-control picker__inputdatepicker"
                type="date"
                id="date"
                name="trip-start"
                value="2022-04-01"
              />
            </div>

            <div class="col-auto col-form-label">
              <label for="hora"><i class="bi bi-clock"></i> Hora: </label>
            </div>
            <div class="col-auto">
              <select
                class="form-select"
                aria-label="selectHora"
                name="hora"
                id="hora"
              >
                <option value="16:00:00">16:00h</option>
                <option value="18:00:00">18:00h</option>
                <option value="20:00:00">20:00h</option>
              </select>
            </div>

            <div class="col-auto col-form-label">
              <label for="vip"><i class="bi bi-star"></i> VIP: </label>
            </div>
            <div class="col-auto">
              <select class="form-select" name="vip" id="vip">
                <option value="0">No</option>
                <option value="1">Si</option>
              </select>
            </div>

            <div class="col-auto col-form-label">
              <label for="espectador"
                ><i class="bi bi-people"></i> Dia del <br class="screen" />
                espectador:
              </label>
            </div>
            <div class="col-auto">
              <select class="form-select" name="espectador" id="espectador">
                <option value="0">No</option>
                <option value="1">Si</option>
              </select>
            </div>
          </div>

          <div class="d-flex justify-content-center">
            <AdminBuscador @habilitarGuardar="this.guardarSesion = 1" />
          </div>

          <div class="d-flex justify-content-center">
            <div class="alert alert-primary" role="alert" v-if="this.msgError">
              {{ this.msgError }}
            </div>
          </div>

          <div class="d-flex justify-content-center">
            <a
              class="btn btn-dark"
              :class="{ isDisabled: !this.guardarSesion }"
              @click="GuardarSesion"
              id="btn_guardar"
              >Guardar Sesión</a
            >
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped>
.form-select {
  width: 100px;
}

.colorWhite {
  color: white;
}

.admin {
  min-height: 86vh;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

.form_sesion {
  margin-top: 30px;
  margin-bottom: 40px;
}

hr {
  width: 60%;
  margin-left: 20%;
}

.container1,
.container2 {
  padding-top: 40px;
}

@media only screen and (max-width: 500px) {
  .container2 {
    width: 260px;
    margin-left: 20%;
  }
}

@media only screen and (min-width: 600px) {
  .screen {
    display: none;
  }
}

.titulo {
  padding-top: 30px;
  padding-bottom: 30px;
}

i {
  color: #dfaa22;
}

#btn_guardar {
  margin: 20px;
}

.fadeIn {
  animation-name: fadeIn;
  animation-iteration-count: 1;
  animation-direction: alternate;
  animation-duration: 2s;
}

@keyframes fadeIn {
  from {
    opacity: 100%;
  }

  50% {
    opacity: 0%;
  }

  to {
    opacity: 100%;
  }
}

.fadeOut {
  animation-name: fadeOut;
  animation-iteration-count: 1;
  animation-direction: alternate;
  animation-duration: 2s;
}

@keyframes fadeOut {
  from {
    opacity: 100%;
  }

  50% {
    opacity: 0%;
  }

  to {
    opacity: 100%;
  }
}

.admin .hoverable:hover {
  color: #14b0ef;
}
</style>
