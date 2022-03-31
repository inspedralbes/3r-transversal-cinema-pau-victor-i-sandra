<script>
import ProximasPelis from "@/components/ProximasPelis.vue";
import CardPeliDia from "@/components/CardPeliDia.vue";
export default {
  data() {
    return {
      basePeliculas: {},
    };
  },
  beforeCreate() {
    fetch("http://192.168.210.161:8000/sesiones")
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        this.basePeliculas = data.sesiones;
      });
  },
  components: {
    CardPeliDia,
    ProximasPelis,
  },
};
</script>
<template>
  <main>
    <h1>HOMEPAGE</h1>
    <CardPeliDia :infoPelicula="basePeliculas[0]" />
    <ProximasPelis :infoPeliculas="basePeliculas" />
  </main>
</template>
