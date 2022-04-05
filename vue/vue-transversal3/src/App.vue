<script>
import { RouterLink, RouterView } from "vue-router";
export default {
  components: {
    RouterLink,
    RouterView,
  },
  
  data() {
    return {
      mostrarFormUsr: true,
    }
  },

  methods: {
    consultarEntradas: function(){
      this.mostrarFormUsr=false;
    }
  }
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
            <a class="nav-link link" aria-current="page" data-bs-toggle="modal" data-bs-target="#exampleModal">Consultar entradas</a>

            <!-- MODAL -->
            <div class="modal fade " id="exampleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered  modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title " id="exampleModalLabel">Consulta tus entradas</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body align-self-center grande">

                    <!-- From usuario -->
                    <div id="form_usr" :class="{ocultar : !mostrarFormUsr}">
                     <div class="col ">
                        <div class="col">
                          <label for="email" class="form-label text-left">Email</label>
                          <input type="email" class="form-control" id="email" />
                        </div>

                        <div class="col">
                          <label for="contraseña" class="form-label">Contraseña</label>
                          <input type="password" class="form-control" id="contraseña" />
                        </div>
                        <br>
                        <div class="col text-center">
                          <button type="button" @click="consultarEntradas" class="btn btn-primary">Aceptar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Fin Form usuario -->

                  <!-- Entradas  -->
                  <div id="entradas" :class="{ocultar : mostrarFormUsr}">
                    <p>Poner grid con las entradas</p>
                  </div>
                  
                  
                  <!-- Fin entradas  -->

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- FIN MODAL -->


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

  .grande {
    width: 290px;
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

  .modal {
    color: black;
  }

  .ocultar {
    display: none;
  }

</style>
