<template>
  <div>
    <div class="input-group">
      <div class="form-outline">
        <input
          type="search"
          id="search"
          class="form-control"
          size="50"
          placeholder="Cercar pel·lícula"
          v-model="search"
        />
      </div>
      <a class="btn" @click="buscarPeli" id="btn_search">
        <i class="bi bi-search"></i
      ></a>
    </div>
    <div class="row">
      <div
        class="col-md-3"
        :key="index"
        v-for="(peliAnadir, index) in arrayPeliculas"
      >
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
    };
  },
  methods: {
    buscarPeli() {
      fetch("https://www.omdbapi.com/?apikey=5149518a&s=" + this.search)
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          this.arrayPeliculas = data.Search;
        });
    },
  },
  components: {
    ResultadoBusqueda,
  },
};
</script>
