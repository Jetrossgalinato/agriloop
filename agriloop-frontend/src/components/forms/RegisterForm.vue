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
<script setup></script>
<style></style>
