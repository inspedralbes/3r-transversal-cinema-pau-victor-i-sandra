<template>
  <div>
    <button
      type="button"
      @click="$emit('peli')"
      class="btn btn-success"
      id="anadirPeli"
    >
      Añadir
    </button>
  </div>
</template>
<script>
export default {
  data() {
    return {};
  },
  props: ["botonPelicula"],
  methods: {
    anadirPeli() {
      console.log(this.botonPelicula);
    },
  },
};
</script>
