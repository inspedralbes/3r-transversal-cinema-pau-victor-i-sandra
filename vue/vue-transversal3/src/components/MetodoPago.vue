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
    };
  },

  mounted() {
    this.datosPinia = this.sessioStore.get;
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

      fetch("http://192.168.210.161:8000/entradas", {
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
        if (this.datosPinia.vip) {
          if (butaca >= "51" && butaca <= "60") {
            // b51 - b60 => butacas entre las que se encuntran las VIP (ambas incluidas)
            precio += 8;
          } else {
            precio += 6;
          }
        } else {
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

    cuentaNuevaCompra() {
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
      fetch("http://192.168.210.161:8000/registrar", {
        method: "POST",
        body: crearCuenta,
      })
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          this.msgRegister = data.msg;
          if (data.status == true) {
            this.bien = true;
            this.datosPinia = this.sessioStore.get;
            this.datosPinia.idUsuario = data.idUsuario;
            this.sessioStore.set(this.datosPinia);
          }
        });
    },

    iniciarSesionCompra() {
      let iniciarSesion = new FormData();
      iniciarSesion.append("email", document.getElementById("email1").value);
      iniciarSesion.append(
        "password",
        document.getElementById("password1").value
      );
      fetch("http://192.168.210.161:8000/login", {
        method: "POST",
        body: iniciarSesion,
      })
        .then((response) => response.json())
        .then((data) => {
          this.msgLogin = data.msg;
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
  <div class="justify-content-center align-items-center margin15">
    <!-- FORMULARIO INICIAR SESIÓN -->
    <div id="iniciar_sesion " :class="{ ocultar: !mostrarIniciarSesion }">
      <div class="col-md-10 text-center">
        <h2>Inicia sesión</h2>
      </div>

      <div class="row g-3 margin15">
        <div class="col-md-12" v-if="this.msgLogin != null">
          <div class="alert alert-primary" role="alert">
            {{ this.msgLogin }}
          </div>
        </div>
        <div class="col-md-10">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email1" />
        </div>
        <div class="col-md-5">
          <label for="inputPassword4" class="form-label">Contraseña</label>
          <input type="password" class="form-control" id="password1" />
        </div>

        <div class="col-md-10 text-center">
          <button
            type="button"
            class="btn btn-primary margin10"
            @click="iniciarSesionCompra"
            :class="{ ocultar: bien }"
          >
            Iniciar Sesion
          </button>
          <RouterLink
            class="btn btn-primary margin10"
            @click.native="this.comprarEntradas"
            :class="{ ocultar: !bien }"
            to="/realitzatpagament"
            >Comprar</RouterLink
          >
          <RouterView />
          <br />
          <br />
          <hr />
        </div>
      </div>

      <div class="col-md-10 text-center margin20">
        <h4>¿No tienes usuario?</h4>
        <br />
        <a href="#" @click="crearCuenta" class="link_crear_cuenta">
          Crea tu cuenta
          <br />y compra ahora
        </a>
      </div>
    </div>

    <!-- FORMULARIO CREAR USUARIO-->
    <div id="crear_cuenta" :class="{ ocultar: mostrarIniciarSesion }">
      <div class="col-md-10 text-center">
        <h2>Crear cuenta</h2>
      </div>

      <div class="row g-3 margin15">
        <div class="col-md-12" v-if="this.msgRegister != null">
          <div class="alert alert-primary" role="alert">
            {{ this.msgRegister }}
          </div>
        </div>
        <div class="col-md-5">
          <label for="titular" class="form-label text-left">Nombre</label>
          <input type="text" class="form-control" id="nombre2" />
        </div>
        <div class="col-md-5">
          <label for="titular" class="form-label">Apellido</label>
          <input type="text" class="form-control" id="apellido2" />
        </div>
        <div class="col-md-10">
          <label for="titular" class="form-label">Email</label>
          <input type="email" class="form-control" id="email2" />
        </div>
        <div class="col-md-5">
          <label for="inputPassword4" class="form-label">Contraseña</label>
          <input type="password" class="form-control" id="password2" />
        </div>

        <div class="col-md-10 text-center">
          <button
            type="button"
            class="btn btn-primary margin10"
            @click="cuentaNuevaCompra"
            :class="{ ocultar: bien }"
          >
            Crear Cuenta
          </button>
          <RouterLink
            class="btn btn-primary margin10"
            @click.native="this.comprarEntradas"
            :class="{ ocultar: !bien }"
            to="/realitzatpagament"
            >Comprar</RouterLink
          >
          <RouterView />

          <br />
          <br />
          <hr />
        </div>
      </div>

      <div class="col-md-10 text-center margin20">
        <h4>¿Ya eres usuario?</h4>
        <br />
        <a href="#" @click="iniciarSesion" class="link_iniciar_sesion">
          Inicia sesión
          <br />y compra ahora
        </a>
      </div>
    </div>
  </div>
</template>

<style>
.margin10 {
  margin: 10px;
}

.margin15 {
  margin: 15px;
}

.margin15 {
  margin: 20px;
}

.iniciar_sesion {
  display: none;
}

.ocultar {
  display: none;
}
</style>
