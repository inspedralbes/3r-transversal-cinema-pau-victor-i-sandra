<script>
import { sessioStore } from "../stores/sessioStore";
import { mapStores } from "pinia";
export default {
  computed: {
    ...mapStores(sessioStore),
  },
    
  props: ["butacasOcupadas"],
  
  data() {
    return {
      ocupadas: [],
      seleccionadas: [],
      precioButacas: 0,
      infoPeli: 0,
      /* Imagenes tipo butacas */
      img_disponible: "@/../public/img/butaca_disponible.png",
      img_ocupada: "@/../public/img/butaca_ocupada.png",
      img_seleccionada: "@/../public/img/img/butaca_seleccionada.png",
      img_vip: "@/../public/img/butaca_vip.png",
    };
  },


  created() {
    this.infoPeli = this.sessioStore.get;
    if (this.butacasOcupadas != null) {
      this.ocupadas = this.butacasOcupadas.split(",");
      this.precioEntradas(this.infoPeli);
    }
  },

  methods: {
    // Comprueba si la butaca está ocupada
    estaocupada: function (n) {
      return this.ocupadas.includes(n);
    },

    // Comprueba si la butaca está disponible
    estalibre: function (n) {
      return !this.ocupadas.includes(n) && !this.seleccionadas.includes(n);
    },

    // Comprueba si la butaca está seleccionada
    estaseleccionada: function (n) {
      return this.seleccionadas.includes(n);
    },

    SeleccionarButaca: function (numButaca, event) {
      if (this.sessioStore.getAdmin == 0) {
        if (this.ocupadas.includes(numButaca)) {
          // si la butaca está ocupada
          alert("¡¡No puedes escoger una butaca ocupada!!");
        }

        // Añade las butacas seleccionadas al array "seleccionadas"
        // y modifica su imagen (siempre que no hayan 10 butacas seleccionadas)
        else if (
          !this.ocupadas.includes(numButaca) &&
          !this.seleccionadas.includes(numButaca)
        ) {
          if (this.seleccionadas.length < 10) {
            this.seleccionadas.push(numButaca);
            event.target.src = "@/../public/img/img/butaca_seleccionada.png";
            this.stringButacas;
          } else {
            alert("No puedes seleccionar más de 10 butacas");
          }
        } else if (this.seleccionadas.includes(numButaca)) {
          /* Deseleccionar butacas */
          event.target.src = "@/../public/img/butaca_disponiblepng";
          this.seleccionadas = this.seleccionadas.filter((butaca) => {
            return butaca != numButaca;
          });
        }

        let piniaData = this.sessioStore.get;
        this.precioEntradas(piniaData);
        piniaData.butacasSeleccionadas = this.seleccionadas;
        piniaData.precioButacas = this.precioButacas;
        this.sessioStore.set(piniaData);
      }
    },

    precioEntradas: function (piniaData) {
      let precio = 0;
      let array = null;

      array = !this.sessioStore.getAdmin ? this.seleccionadas : this.ocupadas;

      array.forEach((butaca) => {
        butaca = butaca.split("b")[1];
        if (piniaData.diaEspectador) {
          // VIP && dia espectador
          if (piniaData.vip) {
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
          // VIP
          if (piniaData.vip) {
            if (butaca >= "51" && butaca <= "60") {
              // b51 - b60 => butacas entre las que se encuntran las VIP (ambos incluidos)
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
      });

      this.precioButacas = precio;
    },
  },
};
</script>

<template>
  <div>
    <section class="seleccionarButacas">
      <div class="tituloSeleccionarButacas">
        <h3 class="text-center">Selecciona las butacas</h3>
      </div>

      <div class="container text-center">
        <img src="@/../public/img/pantalla.png" class="pantalla" />
        <div class="mallaButacas">
          <div :key="index" v-for="(butaca, index) in 120">
            <!-- Butaca ocupada img -->
            <img
              v-if="estaocupada('b' + butaca)"
              :src="this.img_ocupada"
              @click="SeleccionarButaca('b' + butaca, $events)"
              :id="'b' + (index + 1)"
              class="img-fluid butaca"
            />
            <!-- Butaca disponible img -->
            <img
              v-if="estalibre('b' + butaca)"
              src="this.infoPeli.vip && butaca >= '51' && butaca <= '60' ? '@/../public/img/butaca_vip.png' : '@/../public/img/butaca_disponible.png'"
              @click="SeleccionarButaca('b' + butaca, $event)"
              :id="'b' + (index + 1)"
              class="img-fluid butaca"
            />
            <!-- Butaca selecconada img -->
            <img
              v-if="estaseleccionada('b' + butaca)"
              src="@/../public/img/butaca_seleccionada.png"
              @click="SeleccionarButaca('b' + butaca, $event)"
              :id="'b' + (index + 1)"
              class="img-fluid butaca"
            />
          </div>
        </div>
        <div class="resultado">
          <p v-if="this.sessioStore.getAdmin == 0">
            Butacas:
            <span>
              {{ this.seleccionadas.join(", ")
              }}{{ this.seleccionadas.length > 0 ? "." : "ninguna" }}
            </span>
          </p>
          <p>
            Total:
            <span>{{ this.precioButacas }},00€</span>
          </p>
        </div>
      </div>

      <div class="col-12 text-center botonComprarEntradas">
        <RouterLink
          class="btn btn-primary"
          :class="[!this.seleccionadas.length ? 'isDisabled' : '']"
          v-if="this.sessioStore.getAdmin == 0"
          to="/pagament"
          >Comprar entradas</RouterLink
        >
        <RouterView />
      </div>
    </section>
  </div>
</template>

<style>
.mallaButacas {
  display: grid;
  grid-template-columns: repeat(10, 9.8%);
  grid-template-rows: repeat(12, auto);
  justify-content: center;
  margin: 10px 0 15px 0;
}

.container {
  width: 90%;
}

.mallaButacas div {
  display: flex;
  justify-content: center;
}

.mallaButacas img {
  max-width: 70%;
}

.butacas-seleccionarButacas a {
  float: right;
}

.resultado {
  margin-left: 3%;
}

.resultado p:nth-child(1) {
  font-size: 1.3rem;
}

.resultado p:nth-child(2) {
  font-size: 1.1rem;
}

.resultado p {
  margin: 5px 0;
  font-weight: bold;
}

.resultado span {
  font-weight: lighter;
}

.tituloSeleccionarButacas {
  margin: 0 0 20px 0;
}

.pantalla {
  width: 90%;
  margin-bottom: 8px;
}

@media only screen and (min-width: 992px) {
  .card {
    width: 80% !important;
    margin: auto;
  }

  .mallaButacas {
    grid-template-columns: repeat(10, 9%);
  }

  .mallaButacas img {
    max-width: 70%;
  }
}

@media only screen and (min-width: 1200px) {
  .mallaButacas {
    grid-template-columns: repeat(10, 8.5%);
  }

  .mallaButacas img {
    max-width: 70%;
  }
}
</style>
