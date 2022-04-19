<script>
export default {
  props: ['id'],

  data() {
    return {
      popoverEmail: "El correo tiene que contener el símbolo '@'",
    };
  },
};
</script>

<template>
  <label :for="this.id" class="form-label"
    >Email
    <span
      class="d-inline-block"
      tabindex="0"
      data-bs-toggle="popover"
      data-bs-trigger="hover focus"
      :data-bs-content="this.popoverEmail"
      ><i class="bi bi-info-circle"></i></span
  ></label>
  <input type="email" class="form-control" :id="this.id" />
</template>

