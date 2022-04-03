<script>
export default {
  props: ["butacasOcupadas"],

  data() {
    return {
      ocupadas: null,
      seleccionadas: [],

      /* Imagenes tipo butacas */
      img_disponible: "../../src/assets/Butacas/butaca_disponible.png",
      img_ocupada: "../../src/assets/Butacas/butaca_ocupada.png",
      img_seleccionada: "../../src/assets/Butacas/butaca_seleccionada.png",
      img_vip: "../../src/assets/Butacas/butaca_vip.png",
    };
  },

  beforeMount() {
    if (this.butacasOcupadas) {
      this.ocupadas = this.butacasOcupadas.split(",");
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
      // si la butaca está ocupada
      if (this.ocupadas.includes(numButaca)) {
        alert("no puedes escoger una ocupada" + numButaca);
      }

      // Seleccionar butaca y añadirla al array "seleccionadas"
      // seleccionadas y modifica su imagen (seimpre que no hayan 10 butacas seleccionadas aún)
      else if (
        !this.ocupadas.includes(numButaca) &&
        !this.seleccionadas.includes(numButaca)
      ) {
        if (this.seleccionadas.length < 10) {
          this.seleccionadas.push(numButaca);
          event.target.src = this.img_seleccionada;
          this.stringButacas;
        } else {
          alert("No puedes seleccionar más de 10 butacas");
        }
      } else if (this.seleccionadas.includes(numButaca)) {
        /* Deseleccionar butacas */
        event.target.src = this.img_disponible;
        this.seleccionadas = this.seleccionadas.filter((butaca) => {
          return butaca != numButaca;
        });
      }
    },
  },
};
</script>

<template>
  <div>
    <h3 class="text-center">Cars</h3>
    <section class="seleccionarButacas">
      <div class="grid-seleccionarButacas">
        <div class="infoPeli-seleccionarButacas">
          <h2>PELI DIA - componente peli general</h2>
        </div>

        <div class="mallaButacas">
          <div :key="index" v-for="(butaca, index) in 120">
            <img
              v-if="estaocupada('b' + butaca)"
              :src="this.img_ocupada"
              @click="SeleccionarButaca('b' + butaca, $events)"
              :id="'b' + (index + 1)"
              class="img-fluid butaca"
            />
            <img
              v-if="estalibre('b' + butaca)"
              :src="this.img_disponible"
              @click="SeleccionarButaca('b' + butaca, $event)"
              :id="'b' + (index + 1)"
              class="img-fluid butaca"
            />
            <img
              v-if="estaseleccionada('b' + butaca)"
              :src="this.img_seleccionada"
              @click="SeleccionarButaca('b' + butaca, $event)"
              :id="'b' + (index + 1)"
              class="img-fluid butaca"
            />
          </div>
        </div>

        <div>
          <h5>
            Butaques seleccionades:
            <span
              >{{ this.seleccionadas.join(", ")
              }}{{ this.seleccionadas.length > 0 ? "." : "ninguna" }}</span
            >
          </h5>
          <h6>Total: {{ this.seleccionadas.length }} butacas</h6>
        </div>
      </div>
    </section>
  </div>
</template>

<style>
.mallaButacas {
  display: grid;
  justify-content: center;
  grid-template-columns: repeat(10, 70px);
  grid-template-rows: repeat(12, auto);
  margin: 50px 0;
  background-color: rgb(255, 255, 255);
}

.mallaButacas div {
  display: flex;
  justify-content: center;
}

.mallaButacas img {
  max-width: 55%;
}

.butacas-seleccionarButacas a {
  float: right;
}
</style>
