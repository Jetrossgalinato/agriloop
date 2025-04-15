<template>
  <v-card>
    <v-layout>
      <v-navigation-drawer
        v-model="drawer"
        :permanent="$vuetify.display.mdAndUp"
        :temporary="!$vuetify.display.mdAndUp"
        location="right"
      >
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
                        @input="checkChanges"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4" sm="6">
                      <v-text-field
                        v-model="user.email"
                        label="Email*"
                        required
                        @input="checkChanges"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4" sm="6">
                      <v-text-field
                        v-model="user.location"
                        label="Location*"
                        required
                        @input="checkChanges"
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
                        @input="checkChanges"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="4" sm="6">
                      <v-file-input
                        v-model="user.avatar"
                        label="Upload Avatar"
                        accept="image/*"
                        @change="previewAvatar"
                        @input="checkChanges"
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
                    :disabled="!isFormValid"
                  ></v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-list-item>
        </div>

        <v-divider></v-divider>

        <v-list color="transparent">
          <v-list-item
            prepend-icon="mdi-message-text"
            title="Messages"
            @click="messageDialog = true"
          ></v-list-item>

          <v-dialog v-model="messageDialog" max-width="600">
            <v-card>
              <v-card-title class="text-h6 font-weight-bold"
                >Messages</v-card-title
              >
              <v-divider></v-divider>
              <v-card-text>
                <!-- Example message content -->
                <v-list>
                  <v-list-item v-for="(msg, index) in messages" :key="index">
                    <v-list-item-content>
                      <v-list-item-title class="font-weight-bold">
                        {{ msg.sender }}
                      </v-list-item-title>
                      <v-list-item-subtitle>{{
                        msg.text
                      }}</v-list-item-subtitle>
                    </v-list-item-content>
                    <v-divider></v-divider>
                  </v-list-item>
                </v-list>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="messageDialog = false"
                  >Close</v-btn
                >
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-list-item
            prepend-icon="mdi-cart-check"
            title="Order Confirmation"
            @click="orderDialog = true"
          ></v-list-item>

          <v-dialog v-model="orderDialog" max-width="600" max-height="800">
            <v-card>
              <v-card-title class="text-h6 font-weight-bold">
                Order Confirmations
              </v-card-title>
              <v-divider></v-divider>
              <v-card-text>
                <!-- Sample order confirmations -->
                <v-list>
                  <v-list-item v-for="(order, index) in orders" :key="index">
                    <v-list-item-content>
                      <v-list-item-title class="font-weight-bold">
                        Order #{{ order.id }} - {{ order.product }}
                      </v-list-item-title>
                      <div class="text-body-2" style="white-space: normal">
                        <strong>Buyer:</strong> {{ order.buyer }} <br />
                        <strong>Quantity:</strong> {{ order.quantity }} <br />
                        <strong>Status:</strong>
                        <span
                          :class="
                            order.status === 'Confirmed'
                              ? 'text-green'
                              : 'text-red'
                          "
                          class="font-weight-medium"
                        >
                          {{ order.status }}
                        </span>
                      </div>
                    </v-list-item-content>
                    <v-divider></v-divider>
                  </v-list-item>
                </v-list>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="orderDialog = false"
                  >Close</v-btn
                >
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-list-item prepend-icon="mdi-gavel" title="Admin"></v-list-item>
        </v-list>

        <template v-slot:append>
          <div class="pa-2" @click="logout">
            <v-btn block elevation="6"> Logout </v-btn>
          </div>
        </template>
      </v-navigation-drawer>
      <v-main style="height: 100vh"></v-main>
    </v-layout>
  </v-card>
</template>
<script setup>
import { ref, reactive, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

const router = useRouter();
const dialog = ref(false);
const drawer = ref(true);
const messageDialog = ref(false);
const orderDialog = ref(false);

const user = ref({
  avatar: "",
  name: "",
  email: "",
  location: "",
});

const messages = ref([
  { sender: "Alice", text: "Hello! I’m interested in your products." },
  { sender: "Bob", text: "Can we discuss pricing?" },
  { sender: "Charlie", text: "When is the next delivery?" },
]);

const orders = ref([
  {
    id: 101,
    product: "Fresh Mangoes",
    buyer: "Maria Lopez",
    quantity: "25 kg",
    status: "Confirmed",
  },
  {
    id: 102,
    product: "Organic Rice",
    buyer: "Daniel Reyes",
    quantity: "100 kg",
    status: "Confirmed",
  },
  {
    id: 103,
    product: "Banana Chips",
    buyer: "Sofia Cruz",
    quantity: "50 packs",
    status: "Confirmed",
  },
]);

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

const isFormValid = computed(() => {
  return (
    user.value.name &&
    user.value.email &&
    user.value.location &&
    (user.value.avatar ||
      passwords.current_password ||
      passwords.new_password ||
      passwords.confirm_password)
  );
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
    user.value.location = userData.location;
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
    formData.append("name", user.value.name); // Use user.value
    formData.append("email", user.value.email);
    formData.append("location", user.value.location);
    if (user.value.avatar) {
      formData.append("avatar", user.value.avatar);
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

    const response = await axios.post(
      `http://localhost:8000/api/user/${userId}/update`,
      formData,
      {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      }
    );

    console.log("Response from API:", response.data); // Log the response
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
<style>
.v-list-item-subtitle {
  white-space: normal !important;
}
</style>
