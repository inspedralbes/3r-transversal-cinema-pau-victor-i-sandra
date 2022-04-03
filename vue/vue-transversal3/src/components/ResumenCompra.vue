<script>
import { sessioStore } from "../stores/sessioStore";
import { mapStores } from "pinia";
export default {
  data() {
    return {
      dataSesion: null,
      precioButacas: 0
    }
  },

  computed: {
    ...mapStores(sessioStore),
  },

  mounted() {
    this.dataSesion = this.sessioStore.get;
  },
}
</script>



<template>
  <div v-if="this.dataSesion !== null">
    <div class="alert alert-dark" role="alert">
      <h2 class="alert-heading text-center">Resumen de la compra</h2>
      <hr />
      <p>
        <span class="bold">Sesi'on reservada:</span>
        {{ this.dataSesion.idSesion }}
      </p>
      <p>
        <span class="bold">Pel'icula:</span>
        {{ this.dataSesion.peli.nombrePeli }}
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
        <span class="bold">Butacas seleccionadas:</span>
        {{ this.dataSesion.butacasSeleccionadas.join(', ') }}
      </p>
      <hr />
      <p class="mb-0">
        <span class="bold">Precio a pagar:</span>
        {{ this.dataSesion.precioButacas }}€
      </p>
    </div>
  </div>
</template>

<style>
.bold {
  font-weight: bold;
}
</style>
