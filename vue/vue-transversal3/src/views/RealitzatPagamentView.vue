<script>
import { sessioStore } from "../stores/sessioStore";
import { mapStores } from "pinia";
export default {
  computed: {
    ...mapStores(sessioStore),
  },

  data() {
    return {
      piniaData: 0,
    };
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
    <div class="container d-flex align-items-center justify-content-center">
      <div class="row resum">
        <div class="col-12 alert alert-dark text-center" role="alert">
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
            <p>Ya has comprado entradas para esta sesion...</p>
            <p>¿Quieres verlas? Haz click <a href=".">aquí!</a></p>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped>

.container {
  height: 75vh;
}

.resum {
  width: 50%;
}

</style>
