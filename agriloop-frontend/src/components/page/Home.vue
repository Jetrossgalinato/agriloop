<template>
  <v-card
    ><v-layout>
      <Navbar />
      <v-main style="height: 100vh">
        <v-card class="mx-auto mt-15 elevation-9" width="400">
          <template v-slot:title>
            <div class="font-weight-black text-center">Market Access</div>
          </template>
          <v-divider class="bg-grey-darken-10"></v-divider>
          <v-list-item>
            <template v-slot:prepend>
              <v-avatar size="80" rounded="0">
                <v-img :src="user.avatar || 'https://placehold.co/400'" />
              </v-avatar>
            </template>

            <template v-slot:default>
              <v-row class="w-100" align="center">
                <v-spacer></v-spacer>

                <v-col cols="auto" class="text-right">
                  <div class="font-weight-bold text-sm text-grey">Name:</div>
                  <div class="text-subtitle-1 font-weight-bold">
                    {{ user.name }}
                  </div>

                  <div class="font-weight-bold text-sm text-grey mt-2">
                    Membership ID:
                  </div>
                  <div class="text-subtitle-2 font-weight-bold">
                    {{ user.id }}
                  </div>

                  <div class="font-weight-bold text-sm text-grey mt-2">
                    Location:
                  </div>
                  <div class="text-subtitle-2 font-weight-bold">
                    {{ user.location }}
                  </div>

                  <div class="font-weight-bold text-sm text-grey mt-2">
                    Membership Status:
                  </div>
                  <div
                    class="text-subtitle-2 font-weight-bold mb-3"
                    :class="{
                      'text-green':
                        user.membership_status?.toLowerCase() === 'active',
                      'text-red':
                        user.membership_status?.toLowerCase() === 'inactive',
                      'text-uppercase': true,
                    }"
                  >
                    {{ user.membership_status }}
                  </div>
                </v-col>
              </v-row>
            </template>
          </v-list-item>
          <v-divider class="bg-grey-darken-10"></v-divider>
          <v-col cols="auto" class="text-left">
            <div
              class="font-weight-bold text-sm text-dark"
              style="font-size: larger"
            >
              Marketable Buyers:
            </div>
          </v-col>
        </v-card>
      </v-main>
    </v-layout></v-card
  >
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
  location: "",
  membership_status: "",
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
    user.value.location = userData.location;
    user.value.membership_status = userData.membership_status;
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
