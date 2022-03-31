<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>
<template>
  <div>
    <h2>ESTO ES LA PELI DEL DIA</h2>
    <div class="card" style="width: 18rem">
      <img
        class="card-img-top"
        :src="this.infoPelicula.peli.imgPeli"
        alt="Card image cap"
      />
      <div class="card-body">
        <h5 class="card-title">{{ this.infoPelicula.peli.nombrePeli }}</h5>
      </div>
    </div>
    <div>
      <h5>{{ this.infoPelicula.fecha }}</h5>
      <h5>{{ this.infoPelicula.hora }}</h5>
    </div>

    <a class="btn btn-primary" :href="'/seleccionarButacas' + this.idSesion"
      >COMPRAR</a
    >

    <RouterLink class="btn btn-primary" to="/seleccionarButacas"
      >Comprar Entrades</RouterLink
    >
    <RouterView />
  </div>
</template>
<script>
export default {
  props: ["infoPelicula"],
  // beforeCreate() {
  //   console.log(this.infoPelicula);
  // },
};
</script>
