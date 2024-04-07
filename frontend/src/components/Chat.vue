<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";
import { useStore } from "vuex";
const store = useStore();
const messages = ref([]);
const chats = ref([]);
const selected_chat = ref(null);
const locked = ref(true);
const user_message = ref();
onMounted(() => {
  axios.get("http://127.0.0.1:8000/api/chats", {}).then((r) => {
    chats.value = r.data.chats;
  });
  // axios.post("http://127.0.0.1:8000/api/chat", {}).then((r) => {
  //   console.log(r);
  // });
});
function selectChat(chat) {
  locked.value = false;
  selected_chat.value = chat;

  globalThis.Echo.channel("chat." + chat.id).listen(
    "Chat\\MessageSent",
    (e) => {
      console.log(e);
      selected_chat.value.messages.push({
        text: e.message.text,
        user: e.user,
      });
    }
  );
}
function send() {
  axios
    .post("http://127.0.0.1:8000/api/message", {
      text: user_message.value,
      user: store.state.user,
      chat_id: selected_chat.value.id,
    })
    .then((r) => {
      selected_chat.value.messages.push({
        text: user_message.value,
        user: store.state.user,
      });
    });
}
</script>

<template>
  <div class="chat__wrapper">
    <h1 class="chat__header">chat</h1>
    <div class="chat__another-wrapper">
      <div class="chats">
        <div
          @click="selectChat(item)"
          v-for="item in chats"
          :class="{
            'chats__item-active': selected_chat && item.id === selected_chat.id,
          }"
          class="chats__item">
          {{ item.name }}
        </div>
      </div>
      <div class="chat">
        <div class="locked" v-if="locked"></div>
        <div class="message-content">
          <div class="message" v-for="message in selected_chat?.messages">
            <div class="fit">
              <div class="message__login">{{ message.user.login }}:</div>
              <div class="message__text">{{ message.text }}</div>
            </div>
          </div>
        </div>
        <div class="chat__control" v-if="!locked">
          <v-text-field
            class="text-white"
            v-model="user_message"
            label="Message"
            hide-details
            required
            variant="outlined"
            type="text" /><br />
          <v-btn @click="send" class="text-white test" variant="outlined">
            Send
          </v-btn>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.chats__item {
  color: white;
  height: 40px;
  display: flex;
  padding: 10px;
  align-items: center;
}
.chats__item-active {
  background: rgba(255, 255, 255, 0.2);
}
.chats__item:hover {
  background: rgba(255, 255, 255, 0.2);
}
.locked {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.4);
}
.chat__another-wrapper {
  display: flex;
  width: 100%;
}
.test {
  height: 55px;
}
.chat__wrapper {
  border-radius: 10px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  display: flex;
  flex-direction: column;
  backdrop-filter: blur(1.5rem);
  width: 500px;
}
.chats {
  flex-grow: 1;
  border-right: 2px solid rgba(255, 255, 255, 0.3);
  width: 100px;
}

.chat {
  position: relative;
  flex-grow: 4;
  overflow: hidden;
  /* -webkit-box-shadow: 2px 2px 25px 3px rgba(0, 0, 0, 0.75);
  -moz-box-shadow: 2px 2px 2px 3px rgba(0, 0, 0, 0.75);
  box-shadow: 2px 2px 10px 3px rgba(0, 0, 0, 0.5); */
}

.fit {
  width: fit-content;
}
.message__login {
  color: white;
  margin-bottom: 10px;
  width: fit-content;
}
.inline {
  display: inline-block;
}
.chat__header {
  margin: 0;
  height: 60px;
  padding: 10px;
  color: whitesmoke;
  text-transform: uppercase;
  line-height: 40px;

  border-bottom: 2px solid rgba(255, 255, 255, 0.3);
  font-size: 20px;
  /* background: rgb(122, 52, 245);
  background: linear-gradient(
    90deg,
    rgba(122, 52, 245, 1) 0%,
    rgba(219, 0, 218, 1) 90%
  ); */
}
.read-the-docs {
  color: #888;
}
.message__text {
  -webkit-box-shadow: 2px 2px 25px 3px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: 2px 2px 2px 3px rgba(0, 0, 0, 0.2);
  box-shadow: 2px 2px 10px 3px rgba(0, 0, 0, 0.2);
  word-break: break-all;
  background: whitesmoke;
  border-radius: 10px;
  padding: 10px;
  width: fit-content;
}
.message-content {
  padding: 20px;
  box-sizing: border-box;
  gap: 10px;
  scrollbar-color: white transparent;
  flex-direction: column;

  height: 300px;
  display: flex;
  width: 100%;
  overflow-y: scroll;
}
.message {
  width: 100%;

  word-wrap: break-word;
}
.chat__control {
  background: rgba(0, 0, 0, 0.2);
  box-sizing: border-box;
  padding: 20px;
  display: flex;
  gap: 10px;
  align-items: center;
  width: 100%;
}
.input {
  padding-left: 10px;
  flex-grow: 1;
  flex-basis: 3;
  height: 40px;
  border-radius: 0;
  outline: none;
  border-top-right-radius: 0px;
  border-bottom-right-radius: 0px;
  border-top-left-radius: 10px;
  border-bottom-left-radius: 10px;

  border: 1px solid #c3c3c3;
}
.button {
  border-radius: 0px;
  border: none;
  background: rgb(21, 93, 226);
  color: whitesmoke;
  font-weight: 600;
  text-transform: uppercase;
  flex-grow: 1;
  flex-basis: 1;
}
</style>
