<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
  <header>
    <div class="wrapper">
      <nav>
        <RouterLink class="btn btn-primary" to="/">Home</RouterLink>
      </nav>
    </div>
    <RouterView />
  </header>
</template>

<style></style>
