<script>
import router from "@/router";

export default {
  methods: {
    goHome() {
      router.push({ name: "home" });
    },
  },
};
</script>

<template>
  <main class="error">
    <div>
      <h1>La pagina está teniendo problemas...</h1>
      <h2>Vuelve a intentarlo mas tarde :)</h2>
      <button type="button" @click="this.goHome()" class="btn btn-primary">
        ¡Volver a probar!
      </button>
    </div>
  </main>
</template>

<style>
.error {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 86vh;
}
</style>
