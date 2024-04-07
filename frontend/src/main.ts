import { createApp } from 'vue'

import App from './App.vue'

import { createVuetify } from 'vuetify';
import 'vuetify/styles'

import './assets/main.css'

import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

import {createRouter, createWebHistory} from 'vue-router'
import About from './components/About.vue'

import axios from 'axios'

const vuetify = createVuetify({
  components,
  directives
})
const token = localStorage.getItem('auth_token')

axios.defaults.withCredentials = true
axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

import Login from './components/Login.vue'
import Register from './components/Register.vue'
import './websockets'
import {store} from './store/index';
import Chat from './components/Chat.vue'


 
const routes = [
    { path: '/about', component: About },
    {path:'/login', component: Login},
    {path:'/register', component: Register},
    {path:'/chat', component: Chat}
  
  ]


const router = createRouter({
   
    history: createWebHistory(),
    routes, // short for `routes: routes`
  })


createApp(App).use(store).use(router).use(vuetify,{}).mount('#app')
