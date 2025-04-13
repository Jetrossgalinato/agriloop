<template>
  <v-card>
    <v-layout>
      <v-navigation-drawer location="right" permanent>
        <template v-slot:prepend>
          <v-list-item
            lines="two"
            prepend-avatar="user.avatar || 'https://placehold.co/400'"
            subtitle="Logged in"
            title="user.name"
          >
            <span
              style="cursor: pointer; font-size: 0.875rem; color: #1976d2"
              class="edit-profile-link"
              @click="editProfile"
            >
              Edit Profile
            </span></v-list-item
          >
        </template>

        <v-divider></v-divider>

        <v-list color="transparent">
          <v-list-item
            prepend-icon="mdi-view-dashboard"
            title="Dashboard"
          ></v-list-item>
          <v-list-item
            prepend-icon="mdi-account-box"
            title="Account"
          ></v-list-item>
          <v-list-item prepend-icon="mdi-gavel" title="Admin"></v-list-item>
        </v-list>

        <template v-slot:append>
          <div class="pa-2">
            <v-btn block> Logout </v-btn>
          </div>
        </template>
      </v-navigation-drawer>
      <v-main style="height: 100vh"></v-main>
    </v-layout>
  </v-card>
</template>
<script>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

export default {
  data() {
    return {
      drawer: true,
      rail: true,
      isAdmin: false, // Track if the user is an admin
    };
  },
  setup() {
    const router = useRouter();

    // User data
    const user = ref({
      avatar: "", // Initially blank
      name: "", // Will be fetched from the database
      email: "", // Will be fetched from the database
    });

    // Fetch user data from the API
    const fetchUserData = async () => {
      try {
        const userId = localStorage.getItem("user_id") || 1;
        const response = await axios.get(
          `http://localhost:8000/api/user/${userId}`
        );
        const userData = response.data;

        console.log("User Data:", userData); // Debugging: Log the response

        user.value.name = userData.name;
        user.value.email = userData.email;
        user.value.avatar = userData.avatar || ""; // Set avatar
      } catch (error) {
        console.error("Error fetching user data:", error);
      }
    };

    // Check if the user is an admin
    const isAdmin = ref(localStorage.getItem("is_admin") === "true");

    // Navigate to the Edit Profile page
    const editProfile = () => {
      router.push("/edit-profile");
    };

    // Navigate to the Profile page
    const goToProfile = () => {
      router.push("/profile");
    };

    // Navigate to the Home page
    const goToHome = () => {
      router.push("/home");
    };

    // Navigate to the Cart page
    const goToCart = () => {
      router.push("/cart");
    };

    // Navigate to the Admin Dashboard
    const goToDashboard = () => {
      router.push("/admin/dashboard");
    };

    const logout = () => {
      localStorage.removeItem("auth_token"); // Clear the token
      localStorage.removeItem("user_id"); // Clear the user ID
      localStorage.removeItem("is_admin"); // Clear the admin status
      router.push("/"); // Redirect to login
    };

    // Call fetchUserData when the component is mounted
    onMounted(() => {
      fetchUserData();
    });

    return {
      user,
      isAdmin,
      editProfile,
      goToProfile,
      goToHome,
      goToCart,
      goToDashboard,
      logout,
    };
  },
};
</script>
<style></style>
