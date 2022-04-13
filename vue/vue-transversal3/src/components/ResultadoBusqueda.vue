<template>
  <div class="card" style="width: 18rem">
    <img class="card-img-top" :src="peliInfo.Poster" alt="Card image cap" />
    <div class="card-body">
      <h5 class="card-title">{{ peliInfo.Title }}</h5>
      <button
        type="button"
        @click="this.anadirPeli"
        :class="[this.animacion ? 'added' : '']"
        class="btn btn-primary"
        id="anadirPeli"
      >
        Añadir
      </button>
    </div>
  </div>
</template>
<script>
import { sessioStore } from "../stores/sessioStore";
import { mapStores } from "pinia";
export default {
  computed: {
    ...mapStores(sessioStore),
  },
  data() {
    return {
      animacion: false,
    };
  },
  props: ["peliInfo"],
  methods: {
    anadirPeli: function () {
      let pinia = this.sessioStore.get;
      pinia.peliInfo = this.peliInfo;
      this.sessioStore.set(pinia);
      this.animacion = true;
      setTimeout(this.cambiarAnimacion, 2000);
    },
    cambiarAnimacion() {
      this.animacion = false;
    },
  },
};
</script>
<style scoped>
.added {
  animation-name: add;
  animation-duration: 1.5s;
  animation-timing-function: ease-in-out;
  animation-fill-mode: forwards;
  transition: all 1s ease-in-out;
  background-color: brown;
}
@keyframes add {
  0%,
  100% {
    transform: scale(100%);
  }
  50% {
    transform: scale(0%);
  }
}
</style>
