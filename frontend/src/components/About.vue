<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";
import { useStore } from "vuex";
const store = useStore();

onMounted(() => {});

function sendCORS() {
  axios.get("http://127.0.0.1:8000/api/test").then((r) => {
    console.log(r);
  });
}
function send() {
  globalThis.Echo.channel("testchannel").listen("Test", (e) => {
    console.log("2314431123423142");
    console.log("test successful " + e);
  });
}
</script>

<template>
  <v-btn @click="send">send ws</v-btn>
  <v-btn @click="sendCORS">send cors</v-btn>
</template>

<style scoped>
.read-the-docs {
  color: #888;
}
</style>
