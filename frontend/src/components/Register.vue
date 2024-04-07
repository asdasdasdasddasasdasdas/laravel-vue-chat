<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";
import { useStore } from "vuex";
const store = useStore();
const login = ref();
const password = ref();
onMounted(() => {});

function send() {
  axios
    .post("http://127.0.0.1:8000/api/register", {
      login: login.value,
      password: password.value,
    })
    .then((r) => {
      localStorage.auth_user = JSON.stringify(r.data.user);
      store.commit("setUser", r.data.user);
      localStorage.auth_token = r.data.token;
      store.commit("setToken", r.data.token);
      axios.defaults.headers.common["Authorization"] = "Bearer " + r.data.token;
      console.log(r);
    });
}
</script>

<template>
  <form @submit.prevent="send" class="form" action="">
    <h1 class="mb-10 text-white">Register</h1>
    <v-text-field
      class="text-white"
      v-model="login"
      label="Login"
      hide-details
      required
      variant="outlined"
      type="text" /><br />

    <v-text-field
      class="text-white"
      v-model="password"
      label="Password"
      hide-details
      required
      variant="outlined"
      type="text" /><br />
    <v-btn type="submit" class="text-white" variant="outlined"> Sign Up </v-btn>
  </form>
</template>

<style scoped>
.form {
  padding: 20px;
  width: 350px;
  height: 400px;
  backdrop-filter: blur(1.5rem);
  border: 2px solid rgba(255, 255, 255, 0.3);
}
.read-the-docs {
  color: #888;
}
</style>
