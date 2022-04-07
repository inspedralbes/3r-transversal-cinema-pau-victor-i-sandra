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
      mostrarConsultarSesion: false,
      mostrarCrearSesion: false,
    };
  },
  components: {
    AdminBuscador,
    ProximasPelis,
  },

  beforeCreate() {
    fetch("http://192.168.210.161:8000/sesiones")
      .then((response) => response.json())
      .then((data) => {
        this.basePeliculas = data.sesiones;
        console.log("este es");
        console.log(this.basePeliculas);
        this.sessioStore.set(this.basePeliculas);
        this.sessioStore.setAdmin();
        //alert(this.sessioStore.getAdmin);
      });
  },

  mounted() {
    this.peli = this.sessioStore.get;
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
      fetch("http://192.168.210.161:8000/sesion", {
        method: "POST",
        body: nuevaSesion,
      })
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
        });
    },

    // mostrarCrearSesion: function () {
    //   console.log("hshs");
    // },

    // mostrarConsultarSesion: function () {
    //   console.log("aaa");
    //   this.mostrarConsultarSesion = true;
    // },
  },
};
</script>
<template>
  <main>
    <div class="container1">
      <h1 class="text-center titulo" @click="mostrarConsultarSesion">
        Consultar sesiones
      </h1>
      <br />
      <div
        id="consultar_entradas"
        :class="{ ocultar: mostrarConsultarSesion }"
        v-if="typeof this.basePeliculas === 'object'"
      >
        <ProximasPelis :peliculasInfo="basePeliculas" />
      </div>
      <hr />
    </div>

    <div class="container2 justify-content-center">
      <h1 class="text-center">Crear una sesión</h1>

      <div class="crear_sesion">
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
          <AdminBuscador />
        </div>
        <div class="d-flex justify-content-center">
          <a class="btn btn-dark" @click="GuardarSesion" id="btn_guardar"
            >Guardar Sesión</a
          >
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped>
.form-select {
  width: 100px;
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
  margin-top: 40px;
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
</style>
