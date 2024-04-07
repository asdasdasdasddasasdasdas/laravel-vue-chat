<script setup lang="ts">
import { useStore } from "vuex";
import { onMounted, ref } from "vue";

onMounted(() => {
  console.log(123);
  globalThis.Echo.channel("chats").listen("Chat\\ChatCreated", (e) => {
    console.log(e);
    store.state.chats.push(e);
  });
});
const store = useStore();

store.state.test = "test";
</script>

<template>
  <div class="container">
    <div class="nav_content">
      <ul class="menu">
        <li class="menu__item">
          <router-link class="route-link" to="/about">about</router-link>
        </li>
        <li class="menu__item">
          <router-link class="route-link" to="/login">login</router-link>
        </li>
        <li class="menu__item">
          <router-link class="route-link" to="/register">register</router-link>
        </li>
        <li class="menu__item">
          <router-link class="route-link" to="/chat">chat</router-link>
        </li>
      </ul>
      <router-view></router-view>
    </div>
  </div>
</template>

<style scoped>
.route-link {
  position: relative;
  color: whitesmoke;
  text-decoration: none;
  font-size: 18px;
  text-transform: uppercase;
  font-family: sans-serif;
  font-weight: 600;
  font-family: "Raleway", sans-serif;
}
.route-link::after {
  position: absolute;
  display: block;
  left: 50%;
  width: 0px;
  height: 2px;
  background: whitesmoke;
}
.route-link:hover:after {
  width: 50%;
}
.route-link:before {
  display: block;
  right: 50%;
  width: 0px;
  height: 2px;
  background: whitesmoke;
}
.nav_content {
  display: flex;
  flex-direction: column;
  gap: 30px;
}
.container {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}
.menu {
  margin: 0;
  padding: 0;
  list-style-type: none;
  display: flex;
  justify-content: space-around;
  gap: 20px;
}
</style>
