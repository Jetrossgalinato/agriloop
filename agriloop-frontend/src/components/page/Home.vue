<template>
  <v-card
    ><v-layout>
      <Navbar />
      <v-main style="height: 100vh; overflow-y: auto">
        <v-dialog max-width="500">
          <template v-slot:activator="{ props: activatorProps }">
            <v-btn icon v-bind="activatorProps" class="notification-btn">
              <v-icon>mdi-bell</v-icon>
            </v-btn>
          </template>
          <template v-slot:default="{ isActive }">
            <v-card title="Notifications">
              <v-list>
                <v-list-item
                  v-for="(notification, index) in notifications"
                  :key="index"
                >
                  <v-list-item-content>
                    <v-list-item-title>{{
                      notification.title
                    }}</v-list-item-title>
                    <v-list-item-subtitle>{{
                      notification.message
                    }}</v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
              </v-list>
              <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn
                  text="Close Dialog"
                  @click="isActive.value = false"
                ></v-btn>
              </v-card-actions>
            </v-card>
          </template>
        </v-dialog>
        <v-card class="mx-auto mt-15 elevation-9" width="600">
          <template v-slot:title>
            <div class="font-weight-black text-center mb-4 mt-4">
              Market Access
            </div>
            <v-spacer></v-spacer>
          </template>
          <v-divider class="bg-grey-darken-10"></v-divider>
          <v-list-item>
            <template v-slot:prepend>
              <v-avatar size="150" rounded="0" class="avatar-outline">
                <v-img :src="user.avatar || 'https://placehold.co/400'" />
              </v-avatar>
            </template>

            <template v-slot:default>
              <v-row class="w-100" align="center">
                <v-spacer></v-spacer>

                <v-col cols="auto" class="text-right">
                  <div class="font-weight-bold text-sm text-grey">Name:</div>
                  <div class="text-subtitle-1 font-weight-dark">
                    {{ user.name }}
                  </div>

                  <div class="font-weight-bold text-sm text-grey mt-2">
                    Membership ID:
                  </div>
                  <div class="text-subtitle-2 font-weight-dark">
                    {{ user.id }}
                  </div>

                  <div class="font-weight-bold text-sm text-grey mt-2">
                    Location:
                  </div>
                  <div class="text-subtitle-2 font-weight-dark">
                    {{ user.location }}
                  </div>

                  <div class="font-weight-bold text-sm text-grey mt-2">
                    Membership Status:
                  </div>
                  <div
                    class="text-subtitle-2 font-weight-dark mb-3"
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
            <div class="text-sm text-dark font-weight-regular">
              <v-list-item
                v-for="(buyer, index) in buyers"
                :key="index"
                class="mt-2"
              >
                <v-avatar size="50" rounded="0" class="mr-2 avatar-outline">
                  <v-img :src="buyer.avatar" contain />
                </v-avatar>
                <v-list-item-content>
                  <v-list-item-title class="font-weight-bold">
                    {{ buyer.name }}
                  </v-list-item-title>
                  <v-list-item-subtitle>{{ buyer.email }}</v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
            </div>
          </v-col>
          <v-divider class="bg-grey-darken-10"></v-divider>
          <v-col cols="auto" class="text-left">
            <div
              class="font-weight-bold text-sm text-dark mb-0"
              style="font-size: larger; margin-bottom: 0"
            >
              Supply & Product Demand:
            </div>
            <v-carousel show-arrows="hover" class="mt-0">
              <v-carousel-item v-for="crop in crops" :key="crop.id">
                <v-card
                  class="mx-auto customcard"
                  max-width="400"
                  elevation="10"
                >
                  <v-img
                    :src="crop.image || 'https://placehold.co/400'"
                    alt="Crop Image"
                    height="200px"
                    cover
                  ></v-img>
                  <v-card-title>{{ crop.name }}</v-card-title>
                  <v-card-text>
                    <p>{{ crop.description }}</p>
                  </v-card-text>
                </v-card>
              </v-carousel-item>
            </v-carousel>
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

//images for avatars
import aliceAvatar from "@/assets/alice.jpg";
import bobAvatar from "@/assets/bob.jpg";
import charlieAvatar from "@/assets/charlie.jpg";

const router = useRouter();
const crops = ref([]);

const user = ref({
  avatar: "",
  name: "",
  email: "",
  location: "",
  membership_status: "",
});

const buyers = ref([
  {
    name: "Alice Johnson",
    email: "alice.johnson@gmail.com",
    avatar: aliceAvatar,
  },
  {
    name: "Bob Smith",
    email: "bob.smith@gmail.com",
    avatar: bobAvatar,
  },
  {
    name: "Charlie Brown",
    email: "charlie.brown@gmail.com",
    avatar: charlieAvatar,
  },
]);

const notifications = ref([
  { title: "New Message", message: "You have received a new message." },
  { title: "Update Available", message: "A new version is available." },
]);

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

const fetchCrops = async () => {
  try {
    const response = await fetch("http://localhost:8000/api/crops");
    const data = await response.json();
    crops.value = data.map((crops) => ({
      ...crops,
      image: crops.image || "default-image-path.jpg",
    }));
  } catch (error) {
    console.error("Error fetching crops:", error);
  }
};

onMounted(() => {
  fetchUserData();
  fetchCrops();
});
</script>
<style scoped>
.avatar-outline {
  border: 1px solid #151515; /* Change the color as needed */
  border-radius: 50%; /* Ensures the border follows the circular shape */
}
.customcard {
  margin-top: 100px;
}
.notification-btn {
  position: absolute;
  top: 16px;
  right: 16px;
}
</style>
