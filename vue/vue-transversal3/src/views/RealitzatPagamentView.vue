<template>
  <button class="btn btn-secondary volver" label="Volver" @click="retroceder()">
    <i class="bi bi-arrow-left"></i> Atrás
  </button>
  <h1>Realitzat el Pagament</h1>
</template>
<script>
export default {
  methods: {
    retroceder() {
      window.history.back();
    },
  },
};
</script>
