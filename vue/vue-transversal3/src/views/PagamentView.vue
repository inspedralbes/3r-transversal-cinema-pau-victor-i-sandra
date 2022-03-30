<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>
<template>
  <main>
    <q-btn flat class="btn btn-secondary" label="Volver" @click="retroceder()"
      >Volver</q-btn
    >
    <h1>PAGAMENT</h1>
    <ResumenCompra />
    <RealitzarPagament />
    <RouterLink class="btn btn-primary" to="/realitzatpagament"
      >Pagar</RouterLink
    >
    <RouterView />
  </main>
</template>
<script>
import ResumenCompra from "@/components/ResumenCompra.vue";
import RealitzarPagament from "@/components/RealitzarPagament.vue";
export default {
  components: {
    ResumenCompra,
    RealitzarPagament,
  },
  methods: {
    retroceder() {
      window.history.back();
    },
  },
};
</script>
