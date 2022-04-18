<script>
export default {
  data() {
    return {
      butacasOcupadas: 0,
    };
  },
  props: ["peliInfo"],
  mounted() {
    this.contarButacasOcupadas();
  },
  methods: {
    contarButacasOcupadas: function () {
      if (this.peliInfo.butacasOcupadas != null) {
        this.butacasOcupadas = this.peliInfo.butacasOcupadas.split(",").length;
      }
    },
  },
};
</script>

<template>
  <div class="card shadow-sm bg-white rounded" style="width: 18rem">
    <img class="card-img-top" :src="this.peliInfo.peli.imgPeli" alt="Card image cap" />
    <div class="card-body text-center">
      <h4 class="card-title bold">{{ this.peliInfo.peli.nombrePeli }}</h4>
      <h6 class="card-text">{{ this.peliInfo.fecha }}</h6>
      <h6 class="card-text">{{ this.peliInfo.hora }}</h6>
      <h6 class="card-text">{{ this.butacasOcupadas }}/120</h6>
      <br />

      <RouterLink class="btn btn-primary" v-if="this.$route.name != 'butacas' && this.$route.name != 'admin'"
        :to="'/seleccionarButacas/' + this.peliInfo.idSesion">Comprar entradas</RouterLink>
      <RouterLink class="btn btn-primary" v-if="this.$route.name == 'admin'"
        :to="'/seleccionarButacas/' + this.peliInfo.idSesion">Ver</RouterLink>
      <RouterView />
    </div>
  </div>
</template>

<style>
@media only screen and (max-width: 350px)  {
  .card{
    width: 16rem !important
  }
}



</style>
