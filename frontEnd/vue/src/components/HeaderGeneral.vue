<script>
import { RouterLink } from "vue-router";
import router from "@/router";
import EmailForm from "@/components/EmailForm.vue";
import PasswordForm from "@/components/PasswordForm.vue";

export default {
  components: {
    RouterLink,
    EmailForm,
    PasswordForm
  },

  data() {
    return {
      mostrarFormUsr: true,
      datosEntrada: 0,
      msgConsultar: null,
      msgAdmin: null,
    };
  },

  mounted() {
    var popoverTriggerList = [].slice.call(
      document.querySelectorAll('[data-bs-toggle="popover"]')
    );
    popoverTriggerList.map(function (popoverTriggerEl) {
      return new bootstrap.Popover(popoverTriggerEl);
    });
  },

  methods: {
    consultarEntradas: function () {
      let ConsultarLogin = new FormData();
      ConsultarLogin.append(
        "email",
        document.getElementById("emailConsultar").value
      );
      ConsultarLogin.append(
        "password",
        document.getElementById("contrasenaConsultar").value
      );

      fetch("http://cinema1back.alumnes.inspedralbes.cat/loginConsultar", {
        method: "POST",
        body: ConsultarLogin,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status == true) {
            this.datosEntrada = data.msg;
            this.mostrarFormUsr = false;
          } else {
            if (typeof data.chk !== "undefined") {
              this.msgConsultar = "Errores de comprovacion de datos: <ul>";
              data.msg.forEach((c) => {
                this.msgConsultar += "<li>" + c + "</li>";
              });

              this.msgConsultar += "</ul> <br> Para más informacion, revisa las condiciones de cada campo";
            } else {
              this.msgConsultar = data.msg;
            }
          }
        });
    },

    comprobarSesion() {
      this.msgAdmin = null;
      let adminLogin = new FormData();
      adminLogin.append("email", document.getElementById("emailAdmin").value);
      adminLogin.append(
        "password",
        document.getElementById("contrasenaAdmin").value
      );
      fetch("http://cinema1back.alumnes.inspedralbes.cat/loginAdmin", {
        method: "POST",
        body: adminLogin,
      }).then((response) => response.json())
        .then((data) => {

          // simular el tecleo de "ESC" para cerrar el modal 
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
          } else {
            if (typeof data.chk !== "undefined") {
              this.msgAdmin = "Errores de comprovacion de datos: <ul>";
              data.msg.forEach((c) => {
                this.msgAdmin += "<li>" + c + "</li>";
              });

              this.msgAdmin += "</ul> <br> Para más informacion, revisa las condiciones de cada campo";
            } else {
              this.msgAdmin = data.msg;
            }
          }
        });
    },
    reiniciarModales: function () {
      this.mostrarFormUsr = true;
      this.msgConsultar = null;
      document.querySelectorAll("input").forEach((e) => {
        e.value = "";
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
            <img class="logo" src="@/../public/img/logo.png" alt="logo del Pedralbes Cinema" />
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                      @click="this.reiniciarModales()"></button>
                  </div>
                  <div class="modal-body">
                    <div class="container">
                      <!-- From usuario -->
                      <div id="form_usr" class="row" :class="{ ocultar: !mostrarFormUsr }">
                        <!-- Mensajes de error -->
                        <div class="col-12">
                          <div :class="{ ocultar: this.msgConsultar == null }" class="alert alert-primary" role="alert"
                            v-html="this.msgConsultar">
                          </div>
                        </div>
                        <div class="col-12 gy-2">
                          <EmailForm :id="'emailConsultar'" />
                        </div>

                        <div class="col-12 gy-2">
                          <PasswordForm :id="'contrasenaConsultar'" />
                        </div>

                        <div class="col-12 gy-3 text-center">
                          <button type="button" @click="this.consultarEntradas" class="btn btn-primary">
                            Aceptar
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Fin Form usuario -->

                  <!-- Entradas  -->
                  <div id="entradas" :class="{ ocultar: mostrarFormUsr }">
                    <div class="card text-center">
                      <div class="card-body" v-if="this.datosEntrada != 0">
                        <h5 class="card-title">
                          {{ this.datosEntrada.sesion[0].nombre_peli }}
                        </h5>
                        <img :src="this.datosEntrada.sesion[0].img_peli" class="img-fluid rounded-start poster_peli"
                          alt="..." />
                        <br />
                        <p class="card-text">
                          {{ this.datosEntrada.sesion[0].fecha }}
                        </p>
                        <p class="card-text">
                          {{ this.datosEntrada.sesion[0].hora }}
                        </p>
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">Nº Entrada</th>
                              <th scope="col">Butaca</th>
                              <th scope="col">Precio</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr :key="index" v-for="(entradas, index) in this.datosEntrada
                            .entradas">
                              <th scope="row">{{ index + 1 }}</th>
                              <td>{{ entradas.butaca }}</td>
                              <td>{{ entradas.precio }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <!-- Fin entradas  -->

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                      @click="this.reiniciarModales()">
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                      @click="this.reiniciarModales()"></button>
                  </div>
                  <div class="modal-body">
                    <div id="form_admin" class="container">
                      <div class="row">
                        <div class="col-12">
                          <div :class="{ ocultar: this.msgAdmin == null }" class="alert alert-primary" role="alert"
                            v-html="this.msgAdmin"></div>
                        </div>

                        <div class="col-12 gy-2">
                          <EmailForm :id="'emailAdmin'" />
                        </div>

                        <div class="col-12 gy-2">
                          <PasswordForm :id="'contrasenaAdmin'" />
                        </div>

                        <div class="col-12 gy-3 text-center">
                          <button type="button" @click="comprobarSesion" class="btn btn-primary">
                            Aceptar
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                      @click="this.reiniciarModales()">
                      Cerrar
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
</template>

<style scoped>
.ocultar {
  display: none;
}

#mostrarAdminPelis {
  margin-top: 30px;
}
</style>
