<script>
import ResumenCompra from "@/components/ResumenCompra.vue";
import MetodoPago from "@/components/MetodoPago.vue";
export default {
  components: {
    ResumenCompra,
    MetodoPago,
  },
  methods: {
    retroceder() {
      window.history.back();
    },
  },
};
</script>

<template>
  <main>
    <button
      class="btn btn-secondary volver"
      label="Volver"
      @click="retroceder()"
    >
      <i class="bi bi-arrow-left"></i> Atrás
    </button>
    <div class="container">
      <div class="row gx-5">
        <div class="col-12 text-center titulo-pagament gy-4">
          <h1>Compra tus entradas</h1>
        </div>

        <div class="col-12 col-md-5 gy-4">
          <ResumenCompra />
        </div>

        <div class="col-12 col-md-7 gy-4">
          <MetodoPago />
        </div>
      </div>
    </div>
  </main>
</template>

<style>
.titulo-pagament {
  margin-bottom: 20px;
}
</style>
