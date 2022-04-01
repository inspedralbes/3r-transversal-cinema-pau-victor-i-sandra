<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>
<template>
  <div>
    <q-btn flat class="btn btn-secondary" label="Volver" @click="retroceder()"
      >Volver</q-btn
    >
    <h1>COMPRAR ENTRADES DE LA SESION {{ $route.params.idSesion }}</h1>
    <CardPeliGeneral :peliInfo="peliSeleccionada" />
    <SeleccionarButaques />
    <RouterLink class="btn btn-primary" to="/pagament"
      >Comprar Entrades</RouterLink
    >
    <RouterView />
  </div>
</template>
<script>
import CardPeliGeneral from "@/components/CardPeliGeneral.vue";
import SeleccionarButaques from "@/components/SeleccionarButaques.vue";
import { sessioStore } from "../stores/sessioStore";
import { mapStores, mapActions } from "pinia";
export default {
  computed: {
    ...mapStores(sessioStore),
  },
  data() {
    return {
      peliSeleccionada: Object,
    };
  },
  components: {
    CardPeliGeneral,
    SeleccionarButaques,
  },
  beforeCreate() {
    console.log(window.location.href.split("/", 5)[4]);
    fetch(
      "http://192.168.210.161:8000/sesionEspecifica?idSesion=" +
        window.location.href.split("/", 5)[4]
    )
      .then((response) => response.json())
      .then((data) => {
        this.peliSeleccionada = data.sesiones;
        console.log(this.peliSeleccionada);
        this.sessioStore.set = this.peliSeleccionada;
        console.log(this.peliSeleccionada);
      });
  },
  methods: {
    ...mapActions(sessioStore, ["set"]),
    retroceder() {
      window.history.back();
    },
  },
};
</script>

<style></style>
