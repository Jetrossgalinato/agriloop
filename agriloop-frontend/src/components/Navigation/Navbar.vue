<template>
  <v-card>
    <v-layout>
      <v-navigation-drawer location="right" permanent>
        <div>
          <v-list-item
            lines="two"
            :prepend-avatar="user.avatar || 'https://placehold.co/400'"
            subtitle="Logged in"
            :title="user.name"
          >
            <v-dialog v-model="dialog" max-width="600">
              <template v-slot:activator="{ props: activatorProps }">
                <v-btn
                  class="text-none font-weight-regular"
                  prepend-icon="mdi-account"
                  text="Edit Profile"
                  variant="tonal"
                  v-bind="activatorProps"
                ></v-btn>
              </template>

              <v-card prepend-icon="mdi-account" title="User Profile">
                <v-card-text>
                  <v-row dense>
                    <v-col cols="12" md="4" sm="6">
                      <v-text-field label="First name*" required></v-text-field>
                    </v-col>

                    <v-col cols="12" md="4" sm="6">
                      <v-text-field
                        hint="example of helper text only on focus"
                        label="Middle name"
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="4" sm="6">
                      <v-text-field
                        hint="example of persistent helper text"
                        label="Last name*"
                        persistent-hint
                        required
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="4" sm="6">
                      <v-text-field label="Email*" required></v-text-field>
                    </v-col>

                    <v-col cols="12" md="4" sm="6">
                      <v-text-field
                        label="Password*"
                        type="password"
                        required
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="4" sm="6">
                      <v-text-field
                        label="Confirm Password*"
                        type="password"
                        required
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="6">
                      <v-select
                        :items="['0-17', '18-29', '30-54', '54+']"
                        label="Age*"
                        required
                      ></v-select>
                    </v-col>

                    <v-col cols="12" sm="6">
                      <v-autocomplete
                        :items="[
                          'Skiing',
                          'Ice hockey',
                          'Soccer',
                          'Basketball',
                          'Hockey',
                          'Reading',
                          'Writing',
                          'Coding',
                          'Basejump',
                        ]"
                        label="Interests"
                        auto-select-first
                        multiple
                      ></v-autocomplete>
                    </v-col>
                  </v-row>

                  <small class="text-caption text-medium-emphasis"
                    >*indicates required field</small
                  >
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                  <v-spacer></v-spacer>

                  <v-btn
                    text="Close"
                    variant="plain"
                    @click="dialog = false"
                  ></v-btn>

                  <v-btn
                    color="primary"
                    text="Save"
                    variant="tonal"
                    @click="dialog = false"
                  ></v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-list-item>
        </div>

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
          <div class="pa-2" @click="logout">
            <v-btn block> Logout </v-btn>
          </div>
        </template>
      </v-navigation-drawer>
      <v-main style="height: 100vh"></v-main>
    </v-layout>
  </v-card>
</template>
<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
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

    user.value.name = userData.name;
    user.value.email = userData.email;
    user.value.avatar = userData.avatar || "";
  } catch (error) {
    console.error("Error fetching user data:", error);
  }
};

const logout = () => {
  localStorage.removeItem("auth_token");
  localStorage.removeItem("user_id");
  router.push("/");
};

onMounted(() => {
  fetchUserData();
});
</script>
<style></style>
