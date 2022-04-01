<template>
  <div>
    <h2>ESTO SON LAS PROXIMAS PELIS</h2>
    <div :key="index" v-for="(peliActual, index) in this.peliculasInfo">
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
</template>
<script>
import CardPeliGeneral from "@/components/CardPeliGeneral.vue";
export default {
  components: {
    CardPeliGeneral,
  },
  props: ["peliculasInfo"],
  beforeUpdate() {
    //console.log(JSON.parse(JSON.stringify(this.peliculasInfo)));
  },
};
</script>
