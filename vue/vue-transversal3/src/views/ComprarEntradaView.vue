<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>
<template>
  <div>
    <q-btn flat class="btn btn-secondary" label="Volver" @click="retroceder()"
      >Volver</q-btn
    >
    <h1>COMPRAR ENTRADES DE LA SESION {{ $route.params.id }}</h1>
    <CardPeliGeneral />
    <SeleccionarButaques />
    <RouterLink class="btn btn-primary" to="/pagament"
      >Comprar Entrades</RouterLink
    >
    <RouterView />
  </div>
</template>
<script>
import CardPeliGeneral from "@/components/CardPeliGeneral.vue";
import SeleccionarButaques from "@/components/SeleccionarButaques.vue";
export default {
  components: {
    CardPeliGeneral,
    SeleccionarButaques,
  },
  methods: {
    retroceder() {
      window.history.back();
    },
  },
};
</script>

<style></style>
