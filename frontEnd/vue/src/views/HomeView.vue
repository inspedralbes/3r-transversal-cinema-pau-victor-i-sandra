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
    fetch("http://localhost:8000/sesiones")
      .then((response) => response.json())
      .then((data) => {
        this.basePeliculas = data.sesiones;
        this.sessioStore.setComprador();
        setTimeout(() => {
          this.cargando = 0;
        }, 2000);
        //alert(this.sessioStore.getAdmin);
      })
      .catch(() => {
        this.cargando = 0;
        router.push({ name: "error" });
      });
  },
};
</script>

<template>
  <main>
    <div v-if="this.basePeliculas != null && !this.cargando">
      <CardPeliDia :infoPelicula="basePeliculas[0]" />
      <ProximasPelis :peliculasInfo="basePeliculas.splice(1, 6)" />
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