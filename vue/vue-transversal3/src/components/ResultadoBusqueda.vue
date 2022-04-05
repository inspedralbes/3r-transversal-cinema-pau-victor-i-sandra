<template>
  <div class="card" style="width: 18rem">
    <img class="card-img-top" :src="peliInfo.Poster" alt="Card image cap" />
    <div class="card-body">
      <h5 class="card-title">{{ peliInfo.Title }}</h5>
      <button
        type="button"
        @click="anadirPeli"
        class="btn btn-success"
        id="anadirPeli"
      >
        Añadir
      </button>
    </div>
  </div>
</template>
<script>
import { sessioStore } from "../stores/sessioStore";
import { mapStores } from "pinia";
export default {
  computed: {
    ...mapStores(sessioStore),
  },
  data() {
    return {};
  },
  props: ["peliInfo"],
  methods: {
    anadirPeli() {
      let pinia = this.sessioStore.get;
      pinia.peliInfo = this.peliInfo;
      this.sessioStore.set(pinia);
    },
  },
};
</script>
