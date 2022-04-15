<script>
import { RouterLink, RouterView } from "vue-router";
import router from "@/router";
import Header from '@/components/Header.vue';

export default {
  components: {
    RouterLink,
    RouterView,
    Header
  },

  data() {
    return {
      mostrarFormUsr: true,
    };
  },

  beforeCreate() {
    window.addEventListener("beforeunload", function (event) {
      event.returnValue = "";
    });
  },

  methods: {
    consultarEntradas: function () {
      this.mostrarFormUsr = false;
    },

    comprobarSesion() {
      let adminLogin = new FormData();
      adminLogin.append("email", document.getElementById("emailAdmin").value);
      adminLogin.append(
        "password",
        document.getElementById("contrasenaAdmin").value
      );
      fetch("http://192.168.1.140:8000/loginAdmin", {
        method: "POST",
        body: adminLogin,
      })
        .then((response) => response.json())
        .then((data) => {
          alert(data.msg);
          if (data.status == true) {
            document.getElementById("staticBackdrop").dispatchEvent(
              new KeyboardEvent("keydown", {
                altKey: false,
                bubbles: true,
                code: "Escape",
                ctrlKey: false,
                isComposing: false,
                key: "Escape",
                location: 0,
                metaKey: false,
                repeat: false,
                shiftKey: false,
                which: 27,
                charCode: 0,
                keyCode: 27,
              })
            );
            router.push({ name: "admin" });
          }
        });
    },
  },
};
</script>

<template>
  <Header />
</template>

<style>
.header {
  background-color: black !important;
  color: white;
}

.logo {
  width: 180px;
}

.grande {
  width: 290px;
}

.nav-link {
  color: #13afed;
  font-weight: 550;
  font-size: 16px;
}

.nav-link:hover {
  color: #fdcb31;
}

a {
  text-decoration: none;
}

.vr {
  border-left: 2px solid #4dcdff;
  position: absolute;
  left: 67%;
  height: 20px;
  top: 10px;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
    Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
}

.modal {
  color: black;
}

.ocultar {
  display: none;
}

.btn-primary {
  background-color: #4dcdff;
  border-color: #4dcdff;
  color: black
}

.btn-primary:hover {
  background-color: rgb(253, 203, 49);
  border-color: #fdcb31;
  color: black
}

.btn-primary:focus {
  box-shadow: 0 0 0 .25rem rgba(253, 202, 49, 50%) !important;
  background-color: rgb(253, 203, 49);
  border-color: #fdcb31;
  color: black
}

.btn-primary:active {
  box-shadow: 0 0 0 .25rem rgba(253, 202, 49, 50%);
  background-color: rgb(253, 203, 49);
  border-color: #fdcb31;
  color: black
}

h1,
h2,
h3,
h4,
h5,
h6 {
  font-variant: small-caps;
}
</style>
