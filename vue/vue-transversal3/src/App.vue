<script>
import { RouterLink, RouterView } from "vue-router";
import router from "@/router";

export default {
  components: {
    RouterLink,
    RouterView,
  },

  data() {
    return {
      mostrarFormUsr: true,
    };
  },

  beforeCreate() {
    window.addEventListener("beforeunload", function (event) {
      event.returnValue = "";
    });
  },

  methods: {
    consultarEntradas: function () {
      this.mostrarFormUsr = false;
    },

    comprobarSesion() {
      let adminLogin = new FormData();
      adminLogin.append("email", document.getElementById("emailAdmin").value);
      adminLogin.append(
        "password",
        document.getElementById("contrasenaAdmin").value
      );
      fetch("http://192.168.1.140:8000/loginAdmin", {
        method: "POST",
        body: adminLogin,
      })
        .then((response) => response.json())
        .then((data) => {
          alert(data.msg);
          if (data.status == true) {
            document.getElementById("staticBackdrop").dispatchEvent(
              new KeyboardEvent("keydown", {
                altKey: false,
                bubbles: true,
                code: "Escape",
                ctrlKey: false,
                isComposing: false,
                key: "Escape",
                location: 0,
                metaKey: false,
                repeat: false,
                shiftKey: false,
                which: 27,
                charCode: 0,
                keyCode: 27,
              })
            );
            router.push({ name: "admin" });
          }
        });
    },
  },
};
</script>

<template>
  <header>
    <div class="wrapper">
      <nav class="navbar navbar-expand-lg navbar-light bg-light header">
        <div class="container-fluid header">
          <RouterLink class="navbar-brand" to="/">
            <img class="logo" src="./assets/logo.png" alt="logo del Pedralbes Cinema" />
          </RouterLink>
          <div class="btn-group" role="group">
            <!-- Trigger consultar entradas -->
            <a class="nav-link link" aria-current="page" data-bs-toggle="modal"
              data-bs-target="#entradasModal">Consultar entradas</a>

            <!-- Trigger modal admin -->
            <a type="button" class="nav-link link" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Admin</a>

            <!-- MODAL CONSULTAR ENTRADAS -->
            <div class="modal fade" id="entradasModal" data-bs-backdrop="static" tabindex="-1"
              aria-labelledby="entradasModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="entradasModalLabel">
                      Consulta tus entradas
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body align-self-center grande">
                    <!-- From usuario -->
                    <div id="form_usr" :class="{ ocultar: !mostrarFormUsr }">
                      <div class="col">
                        <div class="col">
                          <label for="email" class="form-label text-left">Email</label>
                          <input type="email" class="form-control" id="emailConsultar" />
                        </div>

                        <div class="col">
                          <label for="contrasena" class="form-label">Contraseña</label>
                          <input type="password" class="form-control" id="contrasenaConsultar" />
                        </div>
                        <br />
                        <div class="col text-center">
                          <button type="button" @click="consultarEntradas" class="btn btn-primary">
                            Aceptar
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Fin Form usuario -->

                  <!-- Entradas  -->
                  <div id="entradas" :class="{ ocultar: mostrarFormUsr }">
                    <p>Poner grid con las entradas</p>
                  </div>

                  <!-- Fin entradas  -->

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                      Cerrar
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <!-- FIN MODAL CONSULTAR ENTRADAS -->

            <!-- MODAL ADMIN -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
              aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="adminModalLabel">
                      Identificate como admin
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="modal-body align-self-center">
                      <div id="form_admin">
                        <div class="col">
                          <div class="col">
                            <label for="email" class="form-label text-left">Email</label>
                            <input type="text" class="form-control" id="emailAdmin" />
                          </div>

                          <div class="col">
                            <label for="contrasenaAdmin" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contrasenaAdmin" />
                          </div>

                          <br />

                          <div class="col text-center">
                            <button type="button" @click="comprobarSesion" class="btn btn-primary">
                              Aceptar
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                      Close
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <!-- FIN MODAL ADMIN -->
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
