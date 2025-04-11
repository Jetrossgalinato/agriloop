<template>
  <v-card
    class="d-flex justify-center align-center"
    style="height: 100vh; width: 100vw"
  >
    <v-card
      class="mx-auto"
      prepend-icon="$vuetify"
      subtitle="LoginForm"
      width="350"
    >
      <template v-slot:title>
        <span class="font-weight-black">Welcome to AgriLoop</span>
      </template>

      <v-card-text class="bg-surface-light pt-4">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi,
        ratione debitis quis est labore voluptatibus! Eaque cupiditate minima,
        at placeat totam, magni doloremque veniam neque porro libero rerum unde
        voluptatem!
      </v-card-text>
    </v-card>
  </v-card>
</template>
<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
</script>
<style></style>
