<script>
export default {
  data() {
    return {};
  },
  props: ["peliEditar"],
  methods: {
    verarray() {
      console.log(this.peliEditar);
    },
  },
};
</script>
<template>
  <main>
    <h1>{{ this.peliEditar.Title }}</h1>
  </main>
</template>
