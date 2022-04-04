<template>
  <div>
    <RouterLink
      to="/adminEditarPeli"
      type="button"
      @click="anadirPeli"
      class="btn btn-success"
      id="anadirPeli"
      :peliEditar="this.botonPelicula"
    >
      Añadir
    </RouterLink>
    <RouterView />
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
