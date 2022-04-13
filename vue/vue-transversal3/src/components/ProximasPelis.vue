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
};
</script>

<template>
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
</template>

<style>
.prox_sesiones {
  margin: 60px;
}

.card {
  margin: auto;
}

.titulo_css {
  font-variant: small-caps;
}
</style>
