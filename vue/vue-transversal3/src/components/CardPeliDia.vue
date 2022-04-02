<script>
import { RouterLink, RouterView } from "vue-router";
import moment from 'moment';

export default {
  props: ["infoPelicula"],
  components: {
    RouterLink,
    RouterView
  },

  beforeMount() {
    setInterval(() => {
      let ahora = moment()
      let horaPeli = moment(this.infoPelicula.hora, "HH:mm:ss")
      let finPeli = moment(this.infoPelicula.hora, "HH:mm:ss").add(2, 'h') // Add 2h despues de que empieze la peli
      this.tiempo = (horaPeli > ahora) ? "Faltan " + moment(horaPeli.subtract(1, 'h').valueOf() - ahora.valueOf()).format("HH:mm:ss") : (ahora > horaPeli && finPeli > ahora) ? "En directo" : "Ya vista";
    }, 1000);
  },

  data() {
    return {
      tiempo: null
    }
  },

  methods: {
    tiempoRestante: function () {

    }
  }
};
</script>

<template>
  <h2 class="text-center">La peli del dia</h2>

  <div class="card-horizontal d-none d-md-block">
    <div class="card mb-3">
      <div class="tiempoRestante">
        <span>{{ this.tiempo }}</span>
      </div>
      <div class="row g-0">
        <div class="col-md-4">
          <img :src="this.infoPelicula.peli.imgPeli" class="img-fluid rounded-start" alt="..." />
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h3 class="card-title">{{ this.infoPelicula.peli.nombrePeli }}</h3>
            <div class="card-text">
              <p><span class="underlined">Sinopsis:</span></p>
              <p><span class="underlined">Duración:</span></p>
            </div>
            <RouterLink
              class="btn btn-primary"
              :to="'/seleccionarButacas/' + this.infoPelicula.idSesion"
            >Comprar entradas</RouterLink>
            <RouterView />
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="d-block d-md-none">
    <div class="card" style="width: 18rem">
      <div class="tiempoRestante">
        <span>{{ this.tiempo }}</span>
      </div>
      <img class="card-img-top" :src="this.infoPelicula.peli.imgPeli" salt="Card image cap" />
      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <h4 class="card-title">{{ this.infoPelicula.peli.nombrePeli }}</h4>
          </div>
          <div class="col-3">
            <button
              class="btn btn-outline-danger"
              data-bs-toggle="modal"
              data-bs-target="#exampleModal"
            >
              <i class="bi bi-info-circle"></i>
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <RouterLink
              class="btn btn-primary"
              :to="'/seleccionarButacas/' + this.infoPelicula.idSesion"
            >Comprar entradas</RouterLink>
            <RouterView />
          </div>
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Más información sobre esta pelicula</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Sinopsis:</p>
            <p>Duración:</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.tiempoRestante {
  width: 100%;
  position: absolute;
  top: 25px;
  text-align: center;
}

.tiempoRestante span {
  font-size: 1.5rem;
  font-weight: bold;
  border: 2px solid white;
  padding: 5px 10px;
  border-radius: 10px;
  background-color: white;
}

@media only screen and (min-width: 768px) {
  .tiempoRestante {
    position: absolute;
    top: -18px;
    right: -40px;
    width: auto;
  }

  .tiempoRestante span {
    font-size: 1.5rem;
    font-weight: bold;
    border: 1px solid rgba(0, 0, 0, 0.125);
    padding: 5px 10px;
    border-radius: 10px;
    background-color: rgb(255, 255, 255);
  }

  .card-horizontal {
    width: 80%;
    margin: auto
  }
}

@media only screen and (min-width: 992px) {
  .card-horizontal {
    width: 73%;
    margin: auto
  }
}

@media only screen and (min-width: 1200px) {
  .card-horizontal {
    width: 63%;
    margin: auto
  }
}

@media only screen and (min-width: 1400px) {
  .card-horizontal {
    width: 53%;
    margin: auto
  }
}

@media only screen and (min-width: 1800px) {
  .card-horizontal {
    width: 43%;
    margin: auto
  }
}

.underlined {
  text-decoration: underline;
}
</style>