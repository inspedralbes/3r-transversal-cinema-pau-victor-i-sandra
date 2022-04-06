<template>
  <div>
    <div class="input-group d-flex justify-content-center ">
      <div class="form-outline">
        <input type="search" id="search" class="form-control" size="50" placeholder="Cercar pel·lícula" v-model="search"/>
      </div>


      <a class="btn" @click="buscarPeli" id="btn_search">
        <i class="bi bi-search"></i>
      </a>

      <a class="btn" @click="ocultarPelis" id="btn_ocultar">
        <i class="bi bi-caret-down-square"></i>
      </a>
      
    </div>
    <div id="mostrarAdminPelis" :class="{ ocultar: !mostrarbusqueda }" class="row">
      <div class="col-md-3" :key="index" v-for="(peliAnadir, index) in arrayPeliculas">
        <ResultadoBusqueda
          v-if="typeof this.arrayPeliculas === 'object'"
          :peliInfo="peliAnadir"
        />
      </div>
    </div>
  </div>
</template>


<script>
import ResultadoBusqueda from "@/components/ResultadoBusqueda.vue";
export default {
  data() {
    return {
      search: "",
      arrayPeliculas: 0,
      mostrarbusqueda: true,
    };
  },
  methods: {
    buscarPeli() {
      fetch("https://www.omdbapi.com/?apikey=5149518a&s=" + this.search)
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          this.arrayPeliculas = data.Search;
          this.mostrarbusqueda = true;
        });
    },
    ocultarPelis() {
      this.mostrarbusqueda = false;
      console.log("hola");
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
