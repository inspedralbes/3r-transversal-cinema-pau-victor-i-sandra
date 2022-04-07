<script>
import CardPeliGeneral from "@/components/CardPeliGeneral.vue";
import SeleccionarButaques from "@/components/SeleccionarButaques.vue";
import { sessioStore } from "../stores/sessioStore";
import { mapStores } from "pinia";
export default {
  computed: {
    ...mapStores(sessioStore),
  },

  data() {
    return {
      peliSeleccionada: null,
    };
  },

  components: {
    CardPeliGeneral,
    SeleccionarButaques,
  },

  beforeCreate() {
    console.log(window.location.href.split("/", 5)[4]);
    fetch(
      "http://192.168.210.161:8000/sesionEspecifica?idSesion=" +
      window.location.href.split("/", 5)[4]
    )
      .then((response) => response.json())
      .then((data) => {
        this.peliSeleccionada = data.sesiones[0]; // Porque solo se pasa una sesion
        this.sessioStore.set(this.peliSeleccionada);
      });
  },

  methods: {
    retroceder() {
      window.history.back();
    },
  },
};
</script>

<template>
  <main>
    <button class="btn btn-secondary volver" label="Volver" @click="retroceder()">
      <i class="bi bi-arrow-left"></i> Atrás
    </button>
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <h1>Sesión {{ $route.params.idSesion }}</h1>
        </div>

        <div class="col-12 col-md-5 cardInfo align-self-center">
          <CardPeliGeneral v-if="this.peliSeleccionada != null" :peliInfo="this.peliSeleccionada" />
        </div>

        <div class="col-12 col-md-7 butacasInfo">
          <SeleccionarButaques
            v-if="this.peliSeleccionada != null"
            :butacasOcupadas="this.peliSeleccionada.butacasOcupadas"
          />
        </div>
      </div>
    </div>
  </main>
</template>

<style>
.butacasInfo {
  margin: 30px 0 0 0;
}

.cardInfo {
  margin: 10px 0 0 0;
}

.botonComprarEntradas {
  margin: 20px 0 25px 0;
}

.volver {
  position: relative;
  top: 10px;
  left: 10px;
  margin: 0 0 25px 0;
}

h1 {
  font-variant: small-caps;
}

@media only screen and (min-width: 768px) {
  .cardInfo {
    margin: 30px 0 0 0;
  }
}
</style>
