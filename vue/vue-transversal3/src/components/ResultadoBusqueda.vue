<template>
  <div class="card" style="width: 18rem">
    <img class="card-img-top" :src="peliInfo.Poster" alt="Card image cap" />
    <div class="card-body">
      <h5 class="card-title">{{ peliInfo.Title }}</h5>
      <BotonAnadir :botonPelicula="peliInfo" />
    </div>
  </div>
</template>
<script>
import BotonAnadir from "@/components/BotonAnadir.vue";
export default {
  data() {
    return {};
  },
  components: {
    BotonAnadir,
  },
  props: ["peliInfo"],
};
</script>
