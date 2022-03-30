<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>
<template>
  <div>
    <h2>ESTO ES LA PELI DEL DIA</h2>
    <RouterLink class="btn btn-primary" to="/seleccionarButacas"
      >Comprar Entrades</RouterLink
    >
    <RouterView />
  </div>
</template>
