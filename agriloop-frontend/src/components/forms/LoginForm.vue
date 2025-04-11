<template>
  <v-card
    class="d-flex justify-center align-center"
    style="height: 100vh; width: 100vw"
  >
    <v-card
      class="mx-auto elevation-5"
      prepend-icon="$vuetify"
      subtitle="LoginForm"
      width="350"
    >
      <template v-slot:title>
        <span class="font-weight-black">Welcome to AgriLoop</span>
      </template>

      <v-sheet class="mx-auto" width="300">
        <v-form @submit.prevent="handleLogin">
          <v-text-field
            v-model="email"
            :rules="rules"
            label="E-mail"
          ></v-text-field>
          <v-text-field
            v-model="password"
            :rules="rules"
            :type="showPassword ? 'text' : 'password'"
            label="Password"
          >
            <template v-slot:append-inner>
              <v-icon
                @click.stop="togglePasswordVisibility"
                class="cursor-pointer"
              >
                {{ showPassword ? "mdi-eye-off" : "mdi-eye" }}
              </v-icon>
            </template>
          </v-text-field>
          <v-btn class="mt-2" type="submit" block>Login</v-btn>
        </v-form>
        <div class="text-center mt-2 mb-3">
          <span>
            Don't have an account?
            <router-link to="/register">Register</router-link>
          </span>
        </div>
      </v-sheet>
    </v-card>
  </v-card>
</template>
<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const email = ref("");
const password = ref("");
const showPassword = ref(false);
const router = useRouter();

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};

const handleLogin = async () => {
  if (email.value && password.value) {
    try {
      const response = await axios.post("http://localhost:8000/api/login", {
        email: email.value,
        password: password.value,
      });

      console.log("Login Response:", response.data); // Debug the response

      const { token, user } = response.data;

      // Save the token and user info in localStorage
      localStorage.setItem("auth_token", token);
      localStorage.setItem("user_id", user.id);
      localStorage.setItem("is_admin", user.is_admin); // Save is_admin status

      alert("Login successful!");

      // Redirect based on user role
      if (user.is_admin === true) {
        // Explicitly check if is_admin is 1
        router.push("/admin/dashboard"); // Redirect admin to AdminDashboard
      } else {
        router.push("/home"); // Redirect regular users to the homepage
      }
    } catch (error) {
      console.error("Login Error:", error); // Debug the error
      if (error.response && error.response.status === 401) {
        alert("Invalid credentials. Please try again.");
      } else {
        alert("An error occurred. Please try again later.");
      }
    }
  } else {
    alert("Please fill in all fields.");
  }
};
</script>
<style></style>
