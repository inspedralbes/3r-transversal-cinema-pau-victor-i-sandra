<script>
import { RouterView } from "vue-router";
import Header from "@/components/HeaderGeneral.vue";

export default {
  components: {
    RouterView,
    Header,
  },

  beforeCreate() {
    window.addEventListener("beforeunload", function (event) {
      event.returnValue = "";
    });
  },
};
</script>

<template>
  <Header />
  <RouterView />
</template>

<style>
.header {
  background-color: black !important;
  color: white;
}

.logo {
  width: 180px;
}

.grande {
  width: 290px;
}

.nav-link {
  color: #14b0ef;
  font-weight: 550;
  font-size: 16px;
}

.nav-link:hover {
  color: #fdcb31;
}

a {
  text-decoration: none;
}

.vr {
  border-left: 2px solid #4dcdff;
  position: absolute;
  left: 67%;
  height: 20px;
  top: 10px;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
    Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
}

.modal {
  color: black;
}

.ocultar {
  display: none;
}

.btn-primary {
  background-color: #14b0ef;
  border-color: #14b0ef;
  color: black;
}

.btn-primary:hover {
  background-color: rgb(253, 203, 49);
  border-color: #fdcb31;
  color: black;
}

.btn-primary:focus {
  box-shadow: 0 0 0 0.25rem rgba(253, 202, 49, 50%) !important;
  background-color: rgb(253, 203, 49);
  border-color: #fdcb31;
  color: black;
}

.btn-primary:active {
  box-shadow: 0 0 0 0.25rem rgba(253, 202, 49, 50%);
  background-color: rgb(253, 203, 49);
  border-color: #fdcb31;
  color: black;
}

h1,
h2,
h3,
h4,
h5,
h6 {
  font-variant: small-caps;
}
</style>
