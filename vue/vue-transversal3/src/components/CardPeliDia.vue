<script>
import { RouterLink, RouterView } from "vue-router";
import moment from "moment";

export default {
  props: ["infoPelicula"],
  data() {
    return {
      tiempo: null,
      disabled: 0,
      masInfoPeli: 0,
      butacasOcupadas: 0,
    };
  },

  components: {
    RouterLink,
    RouterView,
  },

  beforeMount() {
    setInterval(() => {
      let ahora = moment();
      let horaPeli = moment(this.infoPelicula.hora, "HH:mm:ss");
      let finPeli = moment(this.infoPelicula.hora, "HH:mm:ss").add(2, "h"); // Add 2h despues de que empieze la peli
      this.tiempo =
        horaPeli > ahora
          ? "Faltan " +
            moment(
              horaPeli.subtract(1, "h").valueOf() - ahora.valueOf()
            ).format("HH:mm:ss") +
            "h!"
          : ahora > horaPeli && finPeli > ahora
          ? "En directo"
          : "Ya proyectada";
      this.disabled = ahora > finPeli ? 1 : 0; //Si la peli ya se ha visto, no se pueden comprar entradas...
    }, 1000);
    this.contarButacasOcupadas();
  },

  beforeCreate() {
    fetch(
      "https://www.omdbapi.com/?apikey=5149518a&i=" +
        this.infoPelicula.peli.idPeli
    )
      .then((response) => response.json())
      .then((data) => {
        this.masInfoPeli = data;

        fetch(
          `https://api-free.deepl.com/v2/translate?auth_key=73c517ac-93c5-6ebf-27e2-3e49b82f8c4f:fx&text=${this.masInfoPeli.Plot}&target_lang=ES`,
          {
            method: "POST",
          }
        )
          .then((response) => response.json())
          .then((traduccion) => {
            this.masInfoPeli.Plot = traduccion.translations[0].text;
          });
      });
  },

  methods: {
    contarButacasOcupadas: function () {
      console.log("aaaaaaaaaaaa");
      console.log(this.infoPelicula.butacasOcupadas);
      if (this.infoPelicula.butacasOcupadas != null) {
        console.log("no");
        this.butacasOcupadas =
          this.infoPelicula.butacasOcupadas.split(",").length;
      } else {
        this.butacasOcupadas = 0;
      }
    },
  },
};
</script>

<template>
  <div class="sesion_hoy">
    <h1 class="text-center titulo_css">Sesión de hoy</h1>
    <br />

    <div class="card-horizontal d-none d-md-block">
      <div class="card mb-3 shadow bg-white rounded">
        <div class="tiempoRestante">
          <span>{{ this.tiempo }}</span>
        </div>
        <div class="row g-0">
          <div class="col-md-4">
            <img
              :src="this.infoPelicula.peli.imgPeli"
              class="img-fluid rounded-start poster_peli"
              alt="..."
            />
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h3 class="card-title">
                {{ this.infoPelicula.peli.nombrePeli }}
              </h3>
              <br />
              <div
                v-if="typeof this.masInfoPeli === 'object'"
                class="card-text"
              >
                <p>
                  <span class="bold">Sinopsis:</span>
                  {{ this.masInfoPeli.Plot }}
                </p>
                <p>
                  <span class="bold">Duración:</span>
                  {{ this.masInfoPeli.Runtime }}
                </p>
                <p>
                  <span class="bold">Ocupació de la sala:</span>
                  {{ this.butacasOcupadas }}/120
                </p>
              </div>

              <div class="text-center">
                <RouterLink
                  class="btn btn-primary"
                  :class="[this.disabled ? 'isDisabled' : '']"
                  :to="'/seleccionarButacas/' + this.infoPelicula.idSesion"
                  >Comprar entradas</RouterLink
                >
                <RouterView />
              </div>
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
        <img
          class="card-img-top"
          :src="this.infoPelicula.peli.imgPeli"
          salt="Card image cap"
        />
        <div class="card-body">
          <div class="row">
            <div class="col-9">
              <h4 class="card-title">
                {{ this.infoPelicula.peli.nombrePeli }}
              </h4>
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
                :class="[this.disabled ? 'isDisabled' : '']"
                :to="'/seleccionarButacas/' + this.infoPelicula.idSesion"
                >Comprar entradas</RouterLink
              >
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
              <h5 class="modal-title" id="exampleModalLabel">
                Más información sobre esta pelicula
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.sesion_hoy {
  margin: 30px;
}

.titulo_css {
  font-variant: small-caps;
}

.tiempoRestante {
  width: 100%;
  position: absolute;
  top: 25px;
  text-align: center;
}

.poster_peli {
  height: 100%;
}

.tiempoRestante span {
  font-size: 1.5rem;
  font-weight: bold;
  padding: 5px 10px;
  border-radius: 10px;
  background-color: #fdcb31;
}

.isDisabled {
  opacity: 0.5;
  pointer-events: none;
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
    background-color: fdcb31;
  }

  .card-horizontal {
    width: 80%;
    margin: auto;
  }
}

@media only screen and (min-width: 992px) {
  .card-horizontal {
    width: 73%;
    margin: auto;
  }
}

@media only screen and (min-width: 1200px) {
  .card-horizontal {
    width: 63%;
    margin: auto;
  }
}

@media only screen and (min-width: 1400px) {
  .card-horizontal {
    width: 53%;
    margin: auto;
  }
}

@media only screen and (min-width: 1800px) {
  .card-horizontal {
    width: 43%;
    margin: auto;
  }
}

.underlined {
  text-decoration: underline;
}
</style>
