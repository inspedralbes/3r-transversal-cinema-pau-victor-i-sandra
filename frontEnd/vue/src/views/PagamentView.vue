<script>
import ResumenCompra from "@/components/ResumenCompra.vue";
import FormularioPago from "@/components/FormularioPago.vue";
export default {
  components: {
    ResumenCompra,
    FormularioPago,
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
        <div class="col-12 text-center gy-4">
          <h1>Compra tus entradas</h1>
        </div>

        <div class="col-12 col-md-5 gy-4">
          <ResumenCompra />
        </div>

        <div class="col-12 col-md-7 gy-4">
          <FormularioPago />
        </div>
      </div>
    </div>
  </main>
</template>

<style></style>
