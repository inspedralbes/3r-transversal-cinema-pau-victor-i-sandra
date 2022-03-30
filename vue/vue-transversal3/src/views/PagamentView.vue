<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>
<template>
  <main>
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
};
</script>
