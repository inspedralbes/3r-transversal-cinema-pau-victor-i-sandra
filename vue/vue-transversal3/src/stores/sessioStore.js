import { defineStore } from "pinia";

export const sessioStore = defineStore("sessio", {
  state: () => ({
    sessio: {},
    admin: 0,
  }),
  getters: {
    get() {
      return this.sessio;
    },

    getAdmin() {
      return this.admin;
    },
  },
  actions: {
    set(s) {
      this.sessio = s;
    },

    setAdmin() {
      this.admin = 1;
    },

    setComprador() {
      this.admin = 0;
    },
  },
});
