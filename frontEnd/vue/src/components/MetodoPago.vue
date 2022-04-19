<script>
import { sessioStore } from "../stores/sessioStore";
import { mapStores } from "pinia";
export default {
  computed: {
    ...mapStores(sessioStore),
  },

  data() {
    return {
      datosPinia: null,
      mostrarIniciarSesion: true,
      bien: false,
      msgLogin: null,
      msgRegister: null,
      comprovando: false,
      popoverNombre:
        "El nombre solo puede contener letras (+1), nada de números ni símbolos",
      popoverApellidos:
        "Los apellidos solo pueden contener letras (+1), nada de números ni símbolos",
      popoverEmail: "El correo tiene que contener el símbolo '@'",
      popoverPassword:
        "La contraseña tiene que contener: una letra minúscula, una letra mayúscula, un número y uno de los siguientes símbolos: '@$!%*?&'",
    };
  },

  mounted() {
    this.datosPinia = this.sessioStore.get;

    var popoverTriggerList = [].slice.call(
      document.querySelectorAll('[data-bs-toggle="popover"]')
    );
    popoverTriggerList.map(function (popoverTriggerEl) {
      return new bootstrap.Popover(popoverTriggerEl);
    });
  },

  methods: {
    comprarEntradas: function () {
      let entradas = new FormData();
      let butacasReservadas = {};
      entradas.append("idUsuari", this.datosPinia.idUsuario);
      entradas.append("idSesion", this.datosPinia.idSesion);
      this.datosPinia.butacasSeleccionadas.forEach((butaca) => {
        butacasReservadas[butaca] = this.precioEntradas(butaca);
      });

      entradas.append("butacasReservadas", JSON.stringify(butacasReservadas));

      fetch("http://cinema1back.alumnes.inspedralbes.cat/entradas", {
        method: "POST",
        body: entradas,
      })
        .then((response) => response.json())
        .then((data) => {
          this.datosPinia.estadoCompra = data.status;
          this.datosPinia.msg = data.msg;
          this.sessioStore.set(this.datosPinia);
        });
    },

    precioEntradas: function (butaca) {
      let precio = 0;
      butaca = butaca.split("b")[1];

      if (this.datosPinia.diaEspectador) {
        // VIP & dia espectador
        if (this.datosPinia.vip) {
          if (butaca >= "51" && butaca <= "60") {
            // b51 - b60 => butacas entre las que se encuntran las VIP (ambas incluidas)
            precio += 6;
          } else {
            precio += 4;
          }
        } else {
          precio += 4;
        }
      } else {
        // VIP
        if (this.datosPinia.vip) {
          if (butaca >= "51" && butaca <= "60") {
            // b51 - b60 => butacas entre las que se encuntran las VIP (ambas incluidas)
            precio += 8;
          } else {
            precio += 6;
          }
        } 
        // Dia espectador
        else {
          precio += 6;
        }
      }

      return precio;
    },

    iniciarSesion: function () {
      this.mostrarIniciarSesion = true;
    },

    crearCuenta: function () {
      this.mostrarIniciarSesion = false;
    },

    // Registro usuario
    cuentaNuevaCompra() {
      this.comprovando = true;
      let crearCuenta = new FormData();
      crearCuenta.append("nombre", document.getElementById("nombre2").value);
      crearCuenta.append(
        "apellidos",
        document.getElementById("apellido2").value
      );
      crearCuenta.append("email", document.getElementById("email2").value);
      crearCuenta.append(
        "password",
        document.getElementById("password2").value
      );
      fetch("http://cinema1back.alumnes.inspedralbes.cat/registrar", {
        method: "POST",
        body: crearCuenta,
      })
        .then((response) => response.json())
        .then((data) => {
          this.comprovando = false;

          if (typeof data.chk !== "undefined") {
            this.msgRegister = "Errores de comprovacion de datos: <ul>";
            data.msg.forEach((c) => {
              this.msgRegister += "<li>" + c + "</li>";
            });

            this.msgRegister += "</ul>";
          } else {
            this.msgRegister = data.msg;
          }

          if (data.status == true) {
            this.bien = true;
            this.datosPinia = this.sessioStore.get;
            this.datosPinia.idUsuario = data.idUsuario;
            this.sessioStore.set(this.datosPinia);
          }
        });
    },

    iniciarSesionCompra() {
      this.comprovando = true;

      let iniciarSesion = new FormData();
      iniciarSesion.append("email", document.getElementById("email1").value);
      iniciarSesion.append(
        "password",
        document.getElementById("password1").value
      );
      fetch(
        "http://cinema1back.alumnes.inspedralbes.cat/loginComprarEntradas",
        {
          method: "POST",
          body: iniciarSesion,
        }
      )
        .then((response) => response.json())
        .then((data) => {
          this.comprovando = false;

          if (typeof data.chk !== "undefined") {
            this.msgLogin = "Errores de comprovacion de datos: <ul>";
            data.msg.forEach((c) => {
              this.msgLogin += "<li>" + c + "</li>";
            });

            this.msgLogin += "</ul>";
          } else {
            this.msgLogin = data.msg;
          }
          if (data.status == true) {
            this.datosPinia = this.sessioStore.get;
            this.datosPinia.idUsuario = data.idUsuario;
            this.sessioStore.set(this.datosPinia);
            this.bien = true;
          }
        });
    },
  },
};
</script>

<template>
  <div class="justify-content-center align-items-center">
    <!-- FORMULARIO INICIAR SESIÓN -->
    <div id="iniciar_sesion " :class="{ ocultar: !mostrarIniciarSesion }">
      <div class="row g-3">
        <div class="col-md-12 text-center">
          <h2>Inicia sesión</h2>
        </div>
        <div class="col-md-12" v-if="this.msgLogin != null">
          <div
            class="alert alert-primary"
            role="alert"
            v-html="this.msgLogin"
          ></div>
        </div>
        <div class="col-md-7">
          <label for="email" class="form-label"
            >Email
            <span
              class="d-inline-block"
              tabindex="0"
              data-bs-toggle="popover"
              data-bs-trigger="hover focus"
              :data-bs-content="this.popoverEmail"
              ><i class="bi bi-info-circle"></i></span
          ></label>
          <input type="email" class="form-control" id="email1" />
        </div>
        <div class="col-md-5">
          <label for="inputPassword4" class="form-label"
            >Contraseña
            <span
              class="d-inline-block"
              tabindex="0"
              data-bs-toggle="popover"
              data-bs-trigger="hover focus"
              :data-bs-content="this.popoverPassword"
              ><i class="bi bi-info-circle"></i></span
          ></label>
          <input type="password" class="form-control" id="password1" />
        </div>

        <div class="col-md-12 text-center gy-4">
          <button
            type="button"
            class="btn btn-primary"
            @click="iniciarSesionCompra"
            :class="{ ocultar: bien }"
          >
            Iniciar Sesion
            <span
              class="spinner-border spinner-border-sm"
              role="status"
              aria-hidden="true"
              v-if="this.comprovando"
            ></span>
          </button>
          <RouterLink
            class="btn btn-primary margin10"
            @click.native="this.comprarEntradas"
            :class="{ ocultar: !bien }"
            to="/realitzatpagament"
            >Comprar</RouterLink
          >
          <RouterView />
        </div>

        <div class="col-12">
          <hr />
        </div>

        <div class="col-md-12 text-center">
          <h4>¿No tienes usuario?</h4>
          <p>
            <a href="#" @click="crearCuenta" class="link_crear_cuenta">
              Crea tu cuenta
              <br />y compra ahora
            </a>
          </p>
        </div>
      </div>
    </div>

    <!-- FORMULARIO CREAR USUARIO-->
    <div id="crear_cuenta" :class="{ ocultar: mostrarIniciarSesion }">
      <div class="row g-3">
        <div class="col-md-12 text-center">
          <h2>Crear cuenta</h2>
        </div>

        <div class="col-md-12" v-if="this.msgRegister != null">
          <div
            class="alert alert-primary"
            role="alert"
            v-html="this.msgRegister"
          ></div>
        </div>

        <div class="col-md-6">
          <label for="titular" class="form-label text-left"
            >Nombre
            <span
              class="d-inline-block"
              tabindex="0"
              data-bs-toggle="popover"
              data-bs-trigger="hover focus"
              :data-bs-content="this.popoverNombre"
              ><i class="bi bi-info-circle"></i></span
          ></label>
          <input type="text" class="form-control" id="nombre2" />
        </div>

        <div class="col-md-6">
          <label for="titular" class="form-label"
            >Apellidos
            <span
              class="d-inline-block"
              tabindex="0"
              data-bs-toggle="popover"
              data-bs-trigger="hover focus"
              :data-bs-content="this.popoverApellidos"
              ><i class="bi bi-info-circle"></i></span
          ></label>
          <input type="text" class="form-control" id="apellido2" />
        </div>

        <div class="col-md-7">
          <label for="titular" class="form-label"
            >Email
            <span
              class="d-inline-block"
              tabindex="0"
              data-bs-toggle="popover"
              data-bs-trigger="hover focus"
              data-bs-content="this.popoverEmail"
              ><i class="bi bi-info-circle"></i></span
          ></label>
          <input type="email" class="form-control" id="email2" />
        </div>

        <div class="col-md-5">
          <label for="inputPassword4" class="form-label"
            >Contraseña
            <span
              class="d-inline-block"
              tabindex="0"
              data-bs-toggle="popover"
              data-bs-trigger="hover focus"
              :data-bs-content="this.popoverPassword"
              ><i class="bi bi-info-circle"></i></span
          ></label>
          <input type="text" class="form-control" id="password2" />
        </div>

        <div class="col-md-12 text-center gy-4">
          <button
            type="button"
            class="btn btn-primary"
            @click="cuentaNuevaCompra"
            :class="{ ocultar: bien }"
          >
            Crear Cuenta
            <span
              class="spinner-border spinner-border-sm"
              role="status"
              aria-hidden="true"
              v-if="this.comprovando"
            ></span>
          </button>
          <RouterLink
            class="btn btn-primary"
            @click.native="this.comprarEntradas"
            :class="{ ocultar: !bien }"
            to="/realitzatpagament"
            >Comprar</RouterLink
          >
          <RouterView />
        </div>

        <div class="col-12">
          <hr />
        </div>

        <div class="col-md-12 text-center">
          <h4>¿Ya eres usuario?</h4>
          <p>
            <a href="#" @click="iniciarSesion" class="link_iniciar_sesion">
              Inicia sesión
              <br />y compra ahora
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.iniciar_sesion {
  display: none;
}

.ocultar {
  display: none;
}

.alert ul {
  margin: 0;
}

.alert-primary {
  background-color: #fdca315b;
  border-color: #fdcb31;
  color: black;
}
</style>
