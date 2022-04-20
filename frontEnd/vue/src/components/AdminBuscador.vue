<template>
  <div>
    <div class="input-group d-flex justify-content-center">
      <div class="form-outline">
        <input type="search" id="search" class="form-control" size="50" placeholder="Cercar pel·lícula"
          v-model="search" />
      </div>

      <a class="btn" @click="buscarPeli" id="btn_search">
        <i class="bi bi-search"></i>
      </a>
    </div>

    <br>
    <div class="alert alert-primary" role="alert" v-if="this.msgError">¡Error! No se ha encontrado la película</div>

    <div class="container">
      <div id="mostrarAdminPelis" :class="{ ocultar: !mostrarbusqueda }" class="row">
        <div class="col-12 col-md-6 col-lg-3 gy-3" :key="index" v-for="(peliAnadir, index) in arrayPeliculas">
          <ResultadoBusqueda @seleccionada="this.ocultarPelis()" @habilitarGuardar="this.$emit('habilitarGuardar')"
            v-if="typeof this.arrayPeliculas === 'object'" :peliInfo="peliAnadir" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ResultadoBusqueda from "@/components/ResultadoBusqueda.vue";
export default {
  emits: ['habilitarGuardar'],

  data() {
    return {
      search: "",
      arrayPeliculas: 0,
      mostrarbusqueda: true,
      msgError: 0 
    };
  },

  methods: {
    buscarPeli() {
      fetch("https://www.omdbapi.com/?apikey=5149518a&s=" + this.search)
        .then((response) => response.json())
        .then((data) => {
          if (data.Response === 'True') {
            this.msgError = 0;
            this.arrayPeliculas = data.Search;
            this.mostrarbusqueda = true;
          } else {
            this.msgError = data.Error
          }
        });
    },
    ocultarPelis() {
      this.mostrarbusqueda = false;
    },
  },
  components: {
    ResultadoBusqueda,
  },
};
</script>

<style scoped>
.ocultar {
  display: none;
}

#mostrarAdminPelis {
  margin-top: 30px;
}
</style>
