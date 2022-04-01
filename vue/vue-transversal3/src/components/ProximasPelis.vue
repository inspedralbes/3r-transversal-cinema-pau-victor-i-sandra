<script>
import CardPeliGeneral from "@/components/CardPeliGeneral.vue";
import { RouterLink, RouterView } from "vue-router";

export default {
  components: {
    CardPeliGeneral,
    RouterLink,
    RouterView,
  },
  props: ["peliculasInfo"],
  beforeUpdate() {
    //console.log(JSON.parse(JSON.stringify(this.peliculasInfo)));
  },
};
</script>

<template>
  <div>
    <h2>ESTO SON LAS PROXIMAS PELIS</h2>
    <section class="container">
      <div class="row gy-5">
        <div
          :key="index"
          v-for="(peliActual, index) in this.peliculasInfo"
          class="col col-lg-4"
        >
          <CardPeliGeneral :peliInfo="peliActual">
            <RouterLink
              class="btn btn-primary"
              :to="'/seleccionarButacas/' + peliActual.idSesion"
              >Comprar Entrades</RouterLink
            >
            <RouterView />
          </CardPeliGeneral>
        </div>
      </div>
    </section>
  </div>
</template>

<style>
.card {
  margin: auto;
}
</style>
