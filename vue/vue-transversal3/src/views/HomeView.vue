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

  components: {
    CardPeliDia,
    ProximasPelis,
  },

  beforeCreate() {
    fetch("http://cinema1back.alumnes.inspedralbes.cat/sesiones")
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        this.basePeliculas = data.sesiones;
      });
  },
};
</script>
<template>
  <main>
    <div v-if="typeof this.basePeliculas === 'object'">
      <CardPeliDia :infoPelicula="basePeliculas[0]" />
      <ProximasPelis :peliculasInfo="basePeliculas.splice(1, 6)" />
    </div>
  </main>
</template>
