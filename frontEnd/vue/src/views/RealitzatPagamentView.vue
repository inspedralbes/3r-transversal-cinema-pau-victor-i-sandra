<script>
import { sessioStore } from "../stores/sessioStore";
import { mapStores } from "pinia";
import SpinnerCargando from '@/components/SpinnerCargando.vue';
export default {
  computed: {
    ...mapStores(sessioStore),
  },

  data() {
    return {
      piniaData: 0,
      entradasData: null,
      cargando: 1
    };
  },

  components: {
    SpinnerCargando
  },

  created() {
    this.piniaData = this.sessioStore.get;

    fetch(
      `http://192.168.1.140:8000/entradasUsuario?idUsuario=${this.piniaData.idUsuario}&idSesion=${this.piniaData.idSesion}`
    )
      .then((response) => response.json())
      .then((data) => {
        this.cargando = 0;
        this.entradasData = data;
      });
  },

  methods: {
    goHome: function () {
      window.location.href = ".";
    },
  },
};
</script>

<template>
  <main>
    <div v-if="!this.cargando">
      <button class="btn btn-secondary home" label="Home" @click="goHome()">
        <i class="bi bi-house"></i> Inicio
      </button>
      <div class="container" v-if="this.entradasData != null">
        <div class="row resum">
          <div class="col-12 alert alert-dark" role="alert">
            <h2 class="alert-heading text-center">Resumen de la compra</h2>
            <hr />

            <div class="row">
              <div class="col-12 col-md-8">
                <p>{{ this.piniaData.msg }}</p>
                <p>Te hemos enviado tus entradas a tu correo...</p>
                <p>
                  Si no, puedes descargarte tus entradas clicando
                  <a :href="this.entradasData.pdf" target="_blank">aquí</a> o
                  escanenando el siguiente código QR
                </p>
              </div>
              <div class="col-12 col-md-4 qr">
                <img src="http://cinema1back.alumnes.inspedralbes.cat/QR/Entradas_aaaa.png" class="img-fluid" alt />
              </div>

              <div class="col-12">
                <h2>Tus entradas</h2>
                <div class="accordion accordion-flush" id="accordionFlushExample">
                  <div class="accordion-item" v-for="(entrada, index) in this.entradasData.entradas" :key="index">
                    <h2 class="accordion-header" id="flush-headingOne">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        :data-bs-target="'#flush-collapse' + index" aria-expanded="false"
                        aria-controls="flush-collapseOne">
                        Entrada #{{ index }}
                      </button>
                    </h2>
                    <div :id="'flush-collapse' + index" class="accordion-collapse collapse"
                      aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                      <div class="accordion-body">
                        <div class="row align-items-center">
                          <div class="col-4">
                            <img :src="this.piniaData.peli.imgPeli" alt class="img-fluid" />
                          </div>
                          <div class="col-8">
                            <p>
                              <span class="bold">Usuario:</span>
                              {{ entrada.idUsuario }}
                            </p>
                            <p>
                              <span class="bold">Sesion:</span>
                              {{ entrada.idSesion }}
                            </p>
                            <p>
                              <span class="bold">Butaca:</span>
                              {{ entrada.butaca }}
                            </p>
                            <p>
                              <span class="bold">Precio:</span>
                              {{ entrada.precio }}€
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <SpinnerCargando v-if="this.cargando" />
  </main>
</template>

<style scoped>
main {
  position: relative;
}

.resum {
  width: 95%;
  margin: auto;
}

.container {
  margin-top: 20px;
  height: 84vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.home {
  position: relative;
  top: 10px;
  left: 10px;
  margin-bottom: 10px;
}

.qr img {
  max-height: 200px !important;
}

.qr {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
}

@media only screen and (min-width: 768px) {
  .resum {
    width: 80%;
  }
}

@media only screen and (min-width: 992px) {
  .resum {
    width: 70%;
  }
}

@media only screen and (min-width: 1200px) {
  .resum {
    width: 60%;
  }
}

@media only screen and (min-width: 1400px) {
  .resum {
    width: 50%;
  }
}
</style>
