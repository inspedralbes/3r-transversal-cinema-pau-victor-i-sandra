<template>
  <div class="card shadow-sm bg-white rounded" style="width: 18rem">
    <img
      class="card-img-top"
      :src="this.peliInfo.peli.imgPeli"
      alt="Card image cap"
    />
    <div class="card-body">
      <h4 class="card-title">{{ this.peliInfo.peli.nombrePeli }}</h4>
      <h6 class="card-text">{{ this.peliInfo.fecha }}</h6>
      <h6 class="card-text">{{ this.peliInfo.hora }}</h6>
    </div>
  </div>
</template>



<script>
  export default {
    props: ["peliInfo"],
  };
</script>

<style></style>
