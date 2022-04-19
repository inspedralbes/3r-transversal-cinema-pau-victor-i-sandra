<script>
export default {
  props: ['id'],
  data() {
    return {
      popoverPassword:
        "La contraseña tiene que contener: una letra minúscula, una letra mayúscula, un número y uno de los siguientes símbolos: '@$!%*?&'",
    };
  },

}
</script>

<template>
  <label :for="this.id" class="form-label"
    >Contraseña
    <span
      class="d-inline-block"
      tabindex="0"
      data-bs-toggle="popover"
      data-bs-trigger="hover focus"
      :data-bs-content="this.popoverPassword"
      ><i class="bi bi-info-circle"></i></span
  ></label>
  <input type="password" class="form-control" :id="this.id" />
</template>
