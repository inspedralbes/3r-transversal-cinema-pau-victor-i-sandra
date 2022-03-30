<template>
  <main>
    <h1>HOMEPAGE</h1>
    <CardPeliDia :infoPelicula="basePeliculas[0]" />
    <ProximasPelis />
  </main>
</template>
<script>
import ProximasPelis from "@/components/ProximasPelis.vue";
import CardPeliDia from "@/components/CardPeliDia.vue";
import BD from "../../../../back/End Points/home.json";
export default {
  data() {
    return {
      basePeliculas: [],
    };
  },
  components: {
    ProximasPelis,
    CardPeliDia,
  },
  mounted() {
    console.log(BD.sesiones[0]);
    this.basePeliculas = BD.sesiones;
  },
};
</script>
