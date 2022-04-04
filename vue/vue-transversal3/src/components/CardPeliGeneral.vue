<template>
  <div class="card" style="width: 18rem">
    <img
      class="card-img-top"
      :src="this.peliInfo.peli.imgPeli"
      alt="Card image cap"
    />
    <div class="card-body">
      <h5 class="card-title">{{ this.peliInfo.peli.nombrePeli }}</h5>
      <h5 class="card-title">{{ this.peliInfo.fecha }}</h5>
      <h5 class="card-title">{{ this.peliInfo.hora }}</h5>
      <RouterLink
        class="btn btn-primary"
        v-if="this.$route.name != 'butacas'"
        :to="'/seleccionarButacas/' + this.peliInfo.idSesion"
        >Comprar entradas</RouterLink
      >
      <RouterView />
    </div>
  </div>
</template>
<script>
export default {
  props: ["peliInfo"],
};
</script>

<style></style>
