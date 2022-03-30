<template>
  <main>
    <CardPeliDia />
    <CardPeliGeneral />
  </main>
</template>
<script>
import CardPeliGeneral from "@/components/CardPeliGeneral.vue";
import CardPeliDia from "@/components/CardPeliDia.vue";
export default {
  components: {
    CardPeliGeneral,
    CardPeliDia,
  },
};
</script>
