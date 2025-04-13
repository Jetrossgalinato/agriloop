<template>
  <v-card
    ><v-layout> <Navbar /> <v-main style="height: 100vh"> </v-main> </v-layout
  ></v-card>
</template>
<script setup>
import Navbar from "../Navigation/Navbar.vue"; // Import the Sidebar component
import { useRouter } from "vue-router"; // Import Vue Router
</script>
<style scoped></style>
