<template>
  <main>
    <h1>HOMEPAGE</h1>
    <CardPeliDia />
    <ProximasPelis />
  </main>
</template>
<script>
import ProximasPelis from "@/components/ProximasPelis.vue";
import CardPeliDia from "@/components/CardPeliDia.vue";
export default {
  components: {
    ProximasPelis,
    CardPeliDia,
  },
};
</script>
