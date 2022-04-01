<template>
  <div>

    <h3 class="text-center">Cars</h3>
    <section class="seleccionarButacas">
      <div class="grid-seleccionarButacas">
        <div class="infoPeli-seleccionarButacas">
          <h2>PELI DIA - componente peli general</h2>
          <div class="card" style="width: 25rem">
            <img
              src="https://pics.filmaffinity.com/Cars-746710621-mmed.jpg"
              class="card-img-top"
              alt="..."
            />
            <div class="card-body">
              <h5 class="card-title">Cars</h5>
              <p class="card-text">Demà a les 16:00h</p>
            </div>
          </div>
        </div>

        <div class="butacas-seleccionarButacas">
          <div class="mallaButacas">
            <div :key="index" v-for="(butaca, index) in 120">
              
                  <img v-if="estaocupada(butaca)" :src="this.img_ocupada" @click="SeleccionarButaca(butaca,$events)" :id="'b' + (index + 1)" class="img-fluid butaca"/>                         
                  <img v-if="estalibre(butaca)" :src="this.img_disponible" @click="SeleccionarButaca(butaca,$event)" :id="'b' + (index + 1)" class="img-fluid butaca"/> 
                  <img v-if="estaseleccionada(butaca)" :src="this.img_seleccionada" @click="SeleccionarButaca(butaca,$event)" :id="'b' + (index + 1)" class="img-fluid butaca"/>             
            
            </div>
          </div> 
        </div>

        <div>
          <h5>Butaques seleccionades</h5>
        </div>
      </div>
    </section>
  </div>
</template>




<script>
export default {
  components: {

  },
  data() {
    return {
      ocupadas: [4, 5, 6, 7, 8, 57],
      seleccionadas: [1,15],

      /* Imagenes tipo butacas */
      img_disponible: "../../src/assets/Butacas/butaca_disponible.png",
      img_ocupada: "../../src/assets/Butacas/butaca_ocupada.png",
      img_seleccionada: "../../src/assets/Butacas/butaca_seleccionada.png",
      img_vip: "../../src/assets/Butacas/butaca_vip.png",
    };
  },
  methods: {
    // Comprueba si la butaca está ocupada
    estaocupada: function(n){
      return this.ocupadas.includes(n);
    },

    // Comprueba si la butaca está disponible
    estalibre: function(n){
      return !this.ocupadas.includes(n)&& !(this.seleccionadas.includes(n));
    },

    // Comprueba si la butaca está seleccionada
    estaseleccionada: function(n){
      return this.seleccionadas.includes(n);
    },

    SeleccionarButaca: function (numButaca, event) {
        // si la butaca está ocupada
        if (this.ocupadas.includes(numButaca)){
          alert("no puedes escoger una ocupada" + numButaca)
        }

        // Seleccionar butaca y añadirla al array "seleccionadas" 
        // seleccionadas y modifica su imagen (seimpre que no hayan 10 butacas seleccionadas aún)
        if (!this.ocupadas.includes(numButaca)&& !(this.seleccionadas.includes(numButaca))) {

          if (this.seleccionadas.length<10) 
            {
              this.seleccionadas.push(numButaca);
              event.target.src=this.img_seleccionada;
          }else {
            alert("No puedes seleccionar más de 10 butacas");
          } 
        }

        /* Des-seleccionar butacas */
        if(this.seleccionadas.includes(numButaca)) {
         
           

        }
    },


  },
};
</script>


<style scoped>
main {
  width: 80%;
  margin: 40px auto;
}

section {
  height: auto;
  border: 1px solid black;
}

@media only screen and (min-width: 1480px) {
  .grid-seleccionarButacas {
    display: grid;
    grid-template-columns: 30% 70%;
  }

  .infoPeli-seleccionarButacas {
    width: 100vw;
  }
}

/*
@media only screen and (max-width: 1480px) {

    .infoPeli-seleccionarButacas {
      
    }

}*/

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
