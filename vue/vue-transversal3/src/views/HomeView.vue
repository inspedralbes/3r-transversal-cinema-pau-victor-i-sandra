<script>
import ProximasPelis from "@/components/ProximasPelis.vue";
import CardPeliDia from "@/components/CardPeliDia.vue";
//import BD from "../../../../back/End Points/home.json";
export default {
  data() {
    return {
      basePeliculas: 0,
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
  // beforeCreate() {
  //   this.basePeliculas = BD;
  //   console.log(BD);
  // },
  components: {
    CardPeliDia,
    ProximasPelis,
  },
};
</script>
<template>
  <main>
    <h1>HOMEPAGE</h1>
    <div v-if="typeof this.basePeliculas === 'object'">
      <CardPeliDia :infoPelicula="basePeliculas[0]" />
      <ProximasPelis :peliculasInfo="basePeliculas.splice(1, 6)" />
    </div>
  </main>
</template>
