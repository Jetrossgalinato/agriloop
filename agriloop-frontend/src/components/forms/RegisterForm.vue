<template>
  <v-card
    class="d-flex justify-center align-center"
    style="height: 100vh; width: 100vw"
  >
    <v-card
      class="mx-auto elevation-5"
      prepend-icon="$vuetify"
      subtitle="RegisterForm"
      width="350"
    >
      <template v-slot:title>
        <span class="font-weight-black">Welcome to AgriLoop</span>
      </template>

      <v-sheet class="mx-auto" width="300" style="background-color: white">
        <v-form @submit.prevent="handleRegister">
          <v-text-field
            v-model="fullname"
            :rules="[rules.required]"
            label="Fullname"
          ></v-text-field>
          <v-text-field
            v-model="email"
            :rules="[rules.required, rules.email]"
            label="E-mail"
          ></v-text-field>
          <v-text-field
            v-model="password"
            :rules="[rules.required, rules.minLength(6)]"
            label="Password"
            type="password"
          ></v-text-field>
          <v-text-field
            v-model="confirmPassword"
            :rules="[rules.required, rules.matchPassword]"
            label="Confirm Password"
            type="password"
          ></v-text-field>
          <v-btn class="mt-2" type="submit" block>Register</v-btn>
        </v-form>
        <div class="text-center mt-2 mb-3">
          <span>
            Already have an account?
            <router-link to="/">Login</router-link>
          </span>
        </div>
      </v-sheet>
    </v-card>
  </v-card>
</template>
<script setup>
import { ref } from "vue";
import axios from "axios";

const fullname = ref("");
const email = ref("");
const password = ref("");
const confirmPassword = ref("");

const rules = {
  required: (value) => !!value || "This field is required.",
  email: (value) => /.+@.+\..+/.test(value) || "E-mail must be valid.",
  minLength: (min) => (value) =>
    value.length >= min || `Minimum ${min} characters required.`,
  matchPassword: (value) => value === password.value || "Passwords must match.",
};

const handleRegister = async () => {
  if (
    fullname.value &&
    email.value &&
    password.value &&
    confirmPassword.value
  ) {
    try {
      const response = await axios.post("http://localhost:8000/api/register", {
        fullname: fullname.value,
        email: email.value,
        password: password.value,
        password_confirmation: confirmPassword.value,
      });

      alert(response.data.message);
    } catch (error) {
      if (error.response && error.response.data) {
        alert(error.response.data.message || "Registration failed.");
      } else {
        alert("An error occurred. Please try again.");
      }
    }
  } else {
    alert("Please fill in all fields.");
  }
};
</script>
<style></style>
