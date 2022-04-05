<script>
import AdminBuscador from "@/components/AdminBuscador.vue";
import { sessioStore } from "../stores/sessioStore";
import { mapStores } from "pinia";
export default {
  computed: {
    ...mapStores(sessioStore),
  },
  data() {
    return {
      peli: "",
    };
  },
  components: {
    AdminBuscador,
  },
  mounted() {
    this.peli = this.sessioStore.get;
  },
  methods: {
    GuardarSesion() {
      let nuevaSesion = new FormData();
      nuevaSesion.append("fecha", document.getElementById("date").value);
      nuevaSesion.append("hora", document.getElementById("hora").value);
      nuevaSesion.append("vip", document.getElementById("vip").value);
      nuevaSesion.append(
        "diaEspectador",
        document.getElementById("espectador").value
      );
      nuevaSesion.append("idPeli", this.peli.peliInfo.imdbID);
      nuevaSesion.append("nombrePeli", this.peli.peliInfo.Title);
      nuevaSesion.append("imgPeli", this.peli.peliInfo.Poster);
      nuevaSesion.append("anoPeli", this.peli.peliInfo.Year);
      fetch("http://192.168.210.161:8000/sesion", {
        method: "POST",
        body: nuevaSesion,
      })
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
        });
    },
  },
};
</script>
<template>
  <main>
    <h1>Crear una sesion</h1>
    <label>Data: </label>
    <input type="date" id="date" name="trip-start" value="2022-04-01" />

    <label for="hora">Hora: </label>
    <select name="hora" id="hora">
      <option value="20:00:00">20:00:00</option>
      <option value="18:00:00">18:00:00</option>
      <option value="16:00:00">16:00:00</option>
    </select>

    <label for="vip">VIP: </label>
    <select name="vip" id="vip">
      <option value="0">No</option>
      <option value="1">Si</option>
    </select>

    <label for="espectador">Dia del espectador: </label>
    <select name="espectador" id="espectador">
      <option value="0">No</option>
      <option value="1">Si</option>
    </select>
    <AdminBuscador />
    <a class="btn btn-warning" @click="GuardarSesion" id="btn_guardar"
      >Guardar Sesion</a
    >
  </main>
</template>
