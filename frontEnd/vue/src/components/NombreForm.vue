<script>
export default {
  props: ["id"],
  data() {
    return {
      popoverNombre:
        "El nombre solo puede contener letras (>1), nada de números ni símbolos",
    };
  },
};
</script>

<template>
  <label :for="this.id" class="form-label text-left"
    >Nombre
    <span
      class="d-inline-block"
      tabindex="0"
      data-bs-toggle="popover"
      data-bs-trigger="hover focus"
      :data-bs-content="this.popoverNombre"
      ><i class="bi bi-info-circle"></i></span
  ></label>
  <input type="text" class="form-control" :id="this.id" />
</template>
