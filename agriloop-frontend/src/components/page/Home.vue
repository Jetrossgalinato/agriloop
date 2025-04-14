<template>
  <v-card
    ><v-layout>
      <Navbar />
      <v-main style="height: 100vh">
        <v-card class="mx-auto mt-15 elevation-9" width="400">
          <template v-slot:title>
            <div class="font-weight-black text-center">Market Access</div>
          </template>
          <v-divider></v-divider>
          <v-list-item lines="two" :title="user.name" :subtitle="user.id">
            <template v-slot:prepend>
              <v-avatar size="80" rounded="0">
                <v-img :src="user.avatar || 'https://placehold.co/400'" />
              </v-avatar>
            </template>
          </v-list-item>
        </v-card>
      </v-main> </v-layout
  ></v-card>
</template>
<script setup>
import Navbar from "../Navigation/Navbar.vue"; // Import the Sidebar component
import { ref, reactive, onMounted } from "vue";
import { useRouter } from "vue-router"; // Import Vue Router
import axios from "axios";
const router = useRouter();

const user = ref({
  avatar: "",
  name: "",
  email: "",
});

const fetchUserData = async () => {
  try {
    const userId = localStorage.getItem("user_id") || 1;
    const response = await axios.get(
      `http://localhost:8000/api/user/${userId}`
    );
    const userData = response.data;

    console.log("User Data:", userData);

    user.value.id = userData.id;
    user.value.name = userData.name;
    user.value.avatar = userData.avatar || "";
    console.log("avatar data: ", user.value.avatar);
  } catch (error) {
    console.error("Error fetching user data:", error);
  }
};

onMounted(() => {
  fetchUserData();
});
</script>
<style scoped></style>
