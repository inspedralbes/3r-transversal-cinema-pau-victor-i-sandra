<script>
import { RouterLink, RouterView } from "vue-router";
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
          <div class="btn-group">
            <a class="nav-link active" aria-current="page" href="#"
              >Consultar entradas</a>
            <div class="vr"></div>
            <a class="nav-link active" aria-current="page" href="#"
              >Admin</a>
          </div>
        </div>
      </nav>
    </div>
  </header>
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

.nav-link {
  color: #13afed;
  font-weight: 550;
}

.nav-link:hover {
  color: #fdcb31;
}

.vr {
  border-left: 2px solid #4dcdff;
  position: absolute;
  left: 67%;
  height: 20px;
  top: 10px;
}
</style>
