<template>
  <q-btn flat class="btn btn-secondary" label="Volver" @click="retroceder()"
    >Volver</q-btn
  >
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
