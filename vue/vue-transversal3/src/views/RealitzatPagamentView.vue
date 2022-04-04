<script>
import { sessioStore } from "../stores/sessioStore";
import { mapStores } from "pinia";
export default {
  computed: {
    ...mapStores(sessioStore),
  },

  data() {
    return {
      piniaData: 0
    }
  },

  mounted() {
    this.piniaData = this.sessioStore.get;
  },


  methods: {
    goHome() {
      window.href = ".";
    },
  },
};
</script>

<template>
  <main>
    <button class="btn btn-secondary volver" label="Volver" @click="goHome()">
      <i class="bi bi-arrow-left"></i> Atrás
    </button>
    <div class="container">
      <div class="row">
        <div class="col-12 alert alert-dark" role="alert">
          <h2 class="alert-heading text-center">Resumen de la compra</h2>
          <hr />
          <p>{{ this.piniaData.msg }}</p>
          <div v-if="this.piniaData.estadoCompra">
            <p>Te hemos enviado tus entradas a tu correo...</p>
            <p>
              Si no, puedes descargarte tus entradas clicando
              <a href=".">aquí</a>
            </p>
          </div>
          <div v-else>
            <p>Ya has comprado entradas para esta sesion... </p>
            <p>¿Quieres verlas? Haz click <a href=".">aquí!</a></p>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>