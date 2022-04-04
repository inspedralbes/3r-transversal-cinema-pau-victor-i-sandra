import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import ComprarEntradaView from "../views/ComprarEntradaView.vue";
import PagamentView from "../views/PagamentView.vue";
import RealitzatPagamentView from "../views/RealitzatPagamentView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/seleccionarButacas/:idSesion",
      name: "butacas",
      component: ComprarEntradaView,
    },
    {
      path: "/pagament",
      name: "pagament",
      component: PagamentView,
    },
    {
      path: "/realitzatpagament",
      name: "realitzatpagament",
      component: RealitzatPagamentView,
    },
    {
      path: "/registro",
      name: "registro",
      /*component: ,*/

    }

  ],
});

export default router;
