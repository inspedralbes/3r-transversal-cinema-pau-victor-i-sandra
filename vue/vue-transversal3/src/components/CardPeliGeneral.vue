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
    </div>
  </div>
</template>
<script>
export default {
  props: {
    peliInfo: Object,
  },
};
</script>

<style></style>
