<script>
import ProximasPelis from "@/components/ProximasPelis.vue";
import CardPeliDia from "@/components/CardPeliDia.vue";
//import BD from "../../../../back/End Points/home.json";
import { sessioStore } from "../stores/sessioStore";
import { mapStores } from "pinia";
import router from "@/router";

export default {
  computed: {
    ...mapStores(sessioStore),
  },
  data() {
    return {
      basePeliculas: null,
    };
  },

  components: {
    CardPeliDia,
    ProximasPelis,
  },

  beforeCreate() {
    // fetch("http://192.168.210.161:8000/sesiones")
    fetch("http://192.168.1.140:8000/sesiones")
      .then((response) => response.json())
      .then((data) => {
        this.basePeliculas = data.sesiones;
        console.log(this.basePeliculas);
        this.sessioStore.setComprador();
        //alert(this.sessioStore.getAdmin);
      }).catch( () => {
        router.push({ name: "error" });
      }
      );
  },
};
</script>
<template>
  <main>
    <div v-if="this.basePeliculas != null">
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
