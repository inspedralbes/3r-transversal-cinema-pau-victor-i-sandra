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
    fetch("http://192.168.210.161:8000/sesiones")
      .then((response) => response.json())
      .then((data) => {
        this.basePeliculas = data.sesiones;
        console.log(this.basePeliculas);
      });
  },
};
</script>
<template>
  <main>
    <div v-if="typeof this.basePeliculas === 'object'">
      <CardPeliDia :infoPelicula="basePeliculas[0]" />

      <div class="prox_sesiones">
        <br />
        <h1 class="titulo_css">Próximas sesiones</h1>
        <br />
        <ProximasPelis :peliculasInfo="basePeliculas.splice(1, 6)" />
      </div>
    </div>
  </main>
</template>
