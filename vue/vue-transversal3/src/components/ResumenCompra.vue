<script>
import { sessioStore } from "../stores/sessioStore";
import { mapStores } from "pinia";
export default {
  data() {
    return {
      dataSesion: null,
      precioButacas: 0,
    };
  },

  computed: {
    ...mapStores(sessioStore),
  },

  mounted() {
    this.dataSesion = this.sessioStore.get;
  },
};
</script>

<template>
  <div v-if="this.dataSesion !== null">

    <div class="resumen alert alert-dark justify-content-center align-items-center text-center" role="alert">
      <h2 class="alert-heading text-center bold">{{ this.dataSesion.peli.nombrePeli }}</h2>
      <hr />

      <img class="poster_resumen" :src="this.dataSesion.peli.imgPeli" alt="Poster de la pelicula"/>
      <br><br>

          <p>
            <span class="bold">Sesión 
            {{ this.dataSesion.idSesion }}</span>
          </p>
          <p>
            <span class="bold">Fecha:</span>
            {{ this.dataSesion.fecha }}
          </p>
          <p>
            <span class="bold">Hora:</span>
            {{ this.dataSesion.hora }}
          </p>
          <p>
            <span class="bold">Butacas:</span>
            {{ this.dataSesion.butacasSeleccionadas.join(", ") }}
          </p>
          <hr />
          <p class="mb-0">
            <span class="bold">Total:</span>
            {{ this.dataSesion.precioButacas }},00€
          </p>
      </div>
  </div>
</template>

<style>

.bold {
  font-weight: bold;
}


  .poster_resumen {
    width: 230px;
    height: auto;
  }

  .resumen {
    width: 80%;
  }



</style>
