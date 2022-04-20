<script>
export default {
  props: ["id"],

  data() {
    return {
      popoverApellidos:
        "Los apellidos solo pueden contener letras (>1), nada de números ni símbolos",
    };
  },
};
</script>

<template>
  <label :for="this.id" class="form-label"
    >Apellidos
    <span
      class="d-inline-block"
      tabindex="0"
      data-bs-toggle="popover"
      data-bs-trigger="hover focus"
      :data-bs-content="this.popoverApellidos"
      ><i class="bi bi-info-circle"></i></span
  ></label>
  <input type="text" class="form-control" :id="this.id" />
</template>
