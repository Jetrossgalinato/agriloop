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
                  class="text-none font-weight-regular mt-2"
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
                      <v-text-field
                        v-model="user.name"
                        label="Full Name*"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4" sm="6">
                      <v-text-field
                        v-model="user.email"
                        label="Email*"
                        required
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="4" sm="6">
                      <v-text-field
                        v-model="passwords.current_password"
                        label="Current Password"
                        :type="showPassword ? 'text' : 'password'"
                        :append-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                        @click:append="togglePasswordVisibility"
                        outlined
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="4" sm="6">
                      <v-text-field
                        v-model="passwords.new_password"
                        label="New Password"
                        :type="showPassword ? 'text' : 'password'"
                        :append-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                        @click:append="togglePasswordVisibility"
                        outlined
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4" sm="6">
                      <v-text-field
                        v-model="passwords.confirm_password"
                        label="Confirm Password"
                        :type="showPassword ? 'text' : 'password'"
                        :append-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                        @click:append="togglePasswordVisibility"
                        outlined
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4" sm="6">
                      <v-file-input
                        v-model="user.avatar"
                        label="Upload Avatar"
                        accept="image/*"
                        @change="previewAvatar"
                      ></v-file-input>
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
                    @click="updateProfile"
                    :disabled="!valid"
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
import { ref, reactive, onMounted } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

const router = useRouter();
const dialog = ref(false);

const user = ref({
  avatar: "",
  name: "",
  email: "",
});

const passwords = reactive({
  current_password: "",
  new_password: "",
  confirm_password: "",
});

const showPassword = ref(false); // Toggle password visibility
const preview = ref("");

// Validation rules
const rules = {
  required: (value) => !!value || "This field is required.",
  email: (value) => /.+@.+\..+/.test(value) || "E-mail must be valid.",
};

const fetchUserData = async () => {
  try {
    const userId = localStorage.getItem("user_id") || 1;
    const response = await axios.get(
      `http://localhost:8000/api/user/${userId}`
    );
    const userData = response.data;

    console.log("User Data:", userData);

    user.value.name = userData.name;
    user.value.avatar = userData.avatar || "";
    console.log("avatar data: ", user.value.avatar);
  } catch (error) {
    console.error("Error fetching user data:", error);
  }
};

const updateProfile = async () => {
  try {
    const userId = localStorage.getItem("user_id");
    const formData = new FormData();
    formData.append("name", user.name);
    formData.append("email", user.email);
    if (user.avatar) {
      formData.append("avatar", user.avatar);
    }

    // Validate and include password fields
    if (
      passwords.current_password ||
      passwords.new_password ||
      passwords.confirm_password
    ) {
      if (!passwords.current_password) {
        alert("Current password is required.");
        return;
      }
      if (passwords.new_password !== passwords.confirm_password) {
        alert("New password and confirm password do not match.");
        return;
      }
      formData.append("current_password", passwords.current_password);
      formData.append("new_password", passwords.new_password);
    }

    await axios.post(
      `http://localhost:8000/api/user/${userId}/update`,
      formData,
      {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      }
    );

    alert("Profile updated successfully!");
    router.push("/home"); // Redirect to home after saving
  } catch (error) {
    console.error("Error updating profile:", error);
    alert("Failed to update profile.");
  }
};

// Preview the selected avatar
const previewAvatar = (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      preview.value = e.target.result;
    };
    reader.readAsDataURL(file);
  }
};

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};
const logout = () => {
  localStorage.removeItem("auth_token");
  localStorage.removeItem("user_id");
  alert("You have been logged out successfully.");
  router.push("/");
};

onMounted(() => {
  fetchUserData();
});
</script>
<style></style>
