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
      boton: 'Añadir'
    };
  },

  props: ["peliInfo"],
  emits: ['seleccionada', 'habilitarGuardar'],

  methods: {
    anadirPeli: function () {
      this.cambiarAnimacion();
      this.$emit('habilitarGuardar');
      let pinia = this.sessioStore.get;
      pinia.peliInfo = this.peliInfo;
      this.sessioStore.set(pinia);
      this.animacion = true;
      setTimeout(() => {
        this.boton = 'Añadida ✓';
      }, 1000);
      setTimeout(() => {
        this.$emit('seleccionada');
        this.boton = 'Añadir';
      }, 3000);
    },
    cambiarAnimacion() {
      this.animacion = false;
    },
  },
};
</script>

<template>
  <div class="card" style="width: 18rem">
    <img class="card-img-top" :src="peliInfo.Poster" alt="Card image cap" />
    <div class="card-body">
      <h5 class="card-title">{{ peliInfo.Title }}</h5>
      <button type="button" @click="this.anadirPeli" :class="[this.animacion ? 'added' : '']" class="btn btn-primary"
        id="anadirPeli">
        {{ this.boton }}
      </button>
    </div>
  </div>
</template>

<style scoped>
.added {
  animation-name: add;
  animation-duration: 2s;
  animation-timing-function: ease-in-out;
  transition: all 2s ease-in-out;
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
