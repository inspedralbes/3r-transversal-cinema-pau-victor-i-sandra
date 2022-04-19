<script>
import CardPeliGeneral from "@/components/CardPeliGeneral.vue";
import { RouterLink, RouterView } from "vue-router";
import { sessioStore } from "../stores/sessioStore";
import { mapStores } from "pinia";
export default {
  computed: {
    ...mapStores(sessioStore),
  },

  components: {
    CardPeliGeneral,
    RouterLink,
    RouterView,
  },
  props: ["peliculasInfo"],
};
</script>

<template>
  <section>
    <br />
    <h1 class="titulo_css text-center" v-if="!this.sessioStore.getAdmin">Próximas sesiones</h1>
    <br />
    <div class="container">
      <div class="row gy-5">
        <div :key="index" v-for="(peliActual, index) in this.peliculasInfo" class="col col-lg-4">
          <CardPeliGeneral :peliInfo="peliActual">
            <RouterLink class="btn btn-primary" :to="'/seleccionarButacas/' + peliActual.idSesion">Comprar Entrades
            </RouterLink>
            <RouterView />
          </CardPeliGeneral>
        </div>
      </div>
    </div>
  </section>
</template>

<style>
.card {
  margin: auto;
}

.titulo_css {
  font-variant: small-caps;
}
</style>
