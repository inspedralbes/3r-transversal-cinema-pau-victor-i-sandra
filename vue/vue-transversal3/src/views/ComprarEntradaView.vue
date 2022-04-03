<script>
import CardPeliGeneral from "@/components/CardPeliGeneral.vue";
import SeleccionarButaques from "@/components/SeleccionarButaques.vue";
import { sessioStore } from "../stores/sessioStore";
import { mapStores } from "pinia";
export default {
  computed: {
    ...mapStores(sessioStore),
  },

  data() {
    return {
      peliSeleccionada: 0,
    };
  },

  components: {
    CardPeliGeneral,
    SeleccionarButaques,
  },

  beforeCreate() {
    console.log("Pelisel" + this.peliSeleccionada);
    console.log(window.location.href.split("/", 5)[4]);
    fetch(
      "http://192.168.1.145:8000/sesionEspecifica?idSesion=" +
        window.location.href.split("/", 5)[4]
    )
      .then((response) => response.json())
      .then((data) => {
        this.peliSeleccionada = data.sesiones;
        console.log(this.peliSeleccionada);
        this.sessioStore.set(this.peliSeleccionada);
      });
  },

  methods: {
    retroceder() {
      window.history.back();
    },
  },
};
</script>

<template>
  <div>
    <button flat class="btn btn-secondary" label="Volver" @click="retroceder()">
      Volver
    </button>

    <h1>COMPRAR ENTRADES DE LA SESION {{ $route.params.idSesion }}</h1>

    <CardPeliGeneral
      :peliInfo="this.peliSeleccionada"
      v-if="typeof this.peliSeleccionada === 'object'"
    />
    <SeleccionarButaques
      :butacasOcupadas="this.peliSeleccionada.butacasOcupadas"
    />
    <RouterLink class="btn btn-primary" to="/pagament"
      >Comprar Entrades</RouterLink
    >
    <RouterView />
  </div>
</template>

<style></style>
