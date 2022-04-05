<script>
import { RouterLink, RouterView } from "vue-router";
export default {
  components: {
    RouterLink,
    RouterView,
  },
};
</script>

<template>
  <header>
    <div class="wrapper">
      <nav class="navbar navbar-expand-lg navbar-light bg-light header">
        <div class="container-fluid header">
          <RouterLink class="navbar-brand" to="/">
            <img
              class="logo"
              src="./assets/logo.png"
              alt="logo del Pedralbes Cinema"
            />
          </RouterLink>
          <div class="btn-group" role="group">
            <a class="nav-link link" aria-current="page" href="#">Consultar entradas</a>
            <div class="vr"></div>
            <RouterLink class="" to="/admin">
              <a class="nav-link link">Admin</a>
            </RouterLink>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <RouterView/>
</template>

<style>
.header {
  background-color: black !important;
  color: white;
}

.logo {
  width: 180px;
}

.nav-link {
  color: #13afed;
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
</style>
