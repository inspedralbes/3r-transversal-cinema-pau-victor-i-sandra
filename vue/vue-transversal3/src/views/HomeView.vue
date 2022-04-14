<script>
import ProximasPelis from "@/components/ProximasPelis.vue";
import CardPeliDia from "@/components/CardPeliDia.vue";
import SpinnerCargando from '@/components/SpinnerCargando.vue';

import { sessioStore } from "../stores/sessioStore";
import { mapStores } from "pinia";
import router from "@/router";

export default {
  computed: {
    ...mapStores(sessioStore),
  },
  data() {
    return {
      basePeliculas: null,
      cargando: 1
    };
  },

  components: {
    CardPeliDia,
    ProximasPelis,
    SpinnerCargando
  },

  beforeCreate() {
    // fetch("http://192.168.210.161:8000/sesiones")
    fetch("http://192.168.1.140:8000/sesiones")
      .then((response) => response.json())
      .then((data) => {
        this.basePeliculas = data.sesiones;
        this.sessioStore.setComprador();
        setTimeout(() => {
          this.cargando = 0;
        }, 1000);
        //alert(this.sessioStore.getAdmin);
      }).catch(() => {
        this.cargando = 0;
        router.push({ name: "error" });
      }
      );
  },
};
</script>
<template>
  <main>
    <div v-if="this.basePeliculas != null && !this.cargando">
      <CardPeliDia :infoPelicula="basePeliculas[0]" />

      <div class="prox_sesiones">
        <br />
        <h1 class="titulo_css">Próximas sesiones</h1>
        <br />
        <ProximasPelis :peliculasInfo="basePeliculas.splice(1, 6)" />
      </div>
    </div>

    <div class="cargando d-flex align-items-center justify-content-center" v-if="!this.cargando">
      <div>
        <h1>Cargando contenido...</h1>
      </div>
      <br>
      <div>
        <div class="spinner-border ms-auto" role="status" style="width: 7rem; height: 7rem;" aria-hidden="true"></div>
      </div>
    </div>

    <SpinnerCargando v-if="this.cargando" />

  </main>
</template>

<style>
.cargando {
  flex-direction: column;
  min-height: 86vh;
}
</style>