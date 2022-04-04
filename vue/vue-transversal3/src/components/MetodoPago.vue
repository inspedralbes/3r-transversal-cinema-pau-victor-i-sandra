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
    };
  },

  mounted() {
    this.datosPinia = this.sessioStore.get;
  },

  methods: {
    comprarEntradas: function () {
      let entradas = new FormData();
      let butacasReservadas = {};
      entradas.append("idUsuari", 1);
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
      butaca = butaca.split('b')[1];

      if (this.datosPinia.diaEspectador) {
        if (this.datosPinia.vip) {
          if (butaca >= "51" && butaca <= "60") {
            // b51 - b60 => butacas entre las que se encuntran las VIP (ambos incluidos)
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
            // b51 - b60 => butacas entre las que se encuntran las VIP (ambos incluidos)
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
  },
};
</script>

<template>
  <div class="justify-content-center align-items-center">
    <div class="col-md-10 text-center">
      <h2>Inicia sesión</h2>
    </div>
    
    <form class="row g-3 margin15">
      <div class="col-md-5">
        <label for="titular" class="form-label text-left">Nombre</label>
        <input type="text" class="form-control" id="titular" />
      </div>
      <div class="col-md-5">
        <label for="titular" class="form-label">Apellido</label>
        <input type="text" class="form-control" id="titular" />
      </div>
      <div class="col-md-10">
        <label for="titular" class="form-label">Email</label>
        <input type="email" class="form-control" id="titular" />
      </div>
      <div class="col-md-5">
        <label for="inputPassword4" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="inputPassword4" />
      </div>

      <div class="col-md-10 text-center">
        <RouterLink
          class="btn btn-primary margin10"
          @click.native="this.comprarEntradas"
          to="/realitzatpagament"
          >Comprar</RouterLink
        >
        <RouterView />
        <br><br>
        <hr>
        </div>
      </form>


        <div class="col-md-10 text-center margin20">
          <h4>¿No tienes usuario?</h4>
          <br>
          <RouterLink
            @click.native="this.comprarEntradas"
            to="/registro"
            >Crea tu cuenta</RouterLink
          >
          <RouterView />

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


</style>
