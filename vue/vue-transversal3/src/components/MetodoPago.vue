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
          console.log(data);
        });
    },

    precioEntradas: function (butaca) {
      let precio = 0;

      if (this.datosPinia.diaEspectador) {
        if (this.datosPinia.vip) {
          if (butaca >= "b51" && butaca <= "b60") {
            // b51 - b60 => butacas entre las que se encuntran las VIP (ambos incluidos)
            precio += 6;
            console.log();
          } else {
            precio += 4;
          }
        } else {
          precio += 4;
        }
      } else {
        if (this.datosPinia.vip) {
          if (butaca >= "b51" && butaca <= "b60") {
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
  <h2>Pagar</h2>
  <form class="row g-3">
    <div class="col-md-6">
      <label for="titular" class="form-label">Nombre del titular</label>
      <input type="text" class="form-control" id="titular" />
    </div>
    <div class="col-md-6">
      <label for="inputPassword4" class="form-label">Password</label>
      <input type="password" class="form-control" id="inputPassword4" />
    </div>
    <div class="col-6 col-md-4">
      <label for="inputCity" class="form-label">Fecha de caducidad</label>
      <input
        type="text"
        class="form-control"
        id="inputCity"
        placeholder="mm / yy"
      />
    </div>
    <div class="col-6 col-md-2">
      <label for="cvv" class="form-label">CVV</label>
      <input type="text" class="form-control" id="cvv" maxlength="3" />
    </div>
    <div class="col-12">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="condiciones" />
        <label class="form-check-label" for="condiciones"
          >Acepto les condiciones de compra</label
        >
      </div>
    </div>
    <div class="col-12">
      <RouterLink
        class="btn btn-primary"
        @click.native="this.comprarEntradas"
        to="/realitzatpagament"
        >Pagar</RouterLink
      >
      <RouterView />
      <a @click="this.comprarEntradas" class="btn btn-danger paypal">PayPal</a>
    </div>
  </form>
</template>

<style>
.paypal {
  margin-left: 10px;
}
</style>
