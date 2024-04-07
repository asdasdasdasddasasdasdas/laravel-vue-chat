import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
import axios from 'axios'
// This assumes you have already saved your bearer token in your browsers local storage
const token = localStorage.getItem('auth_token')

const options = {
  cluster:'mt1',
  broadcaster: 'pusher',
  key: '123',
  wsHost: '127.0.0.1',
    //authEndpoint: 'http://127.0.0.1:8000/api/broadcasting/auth',
  encrypted: true,
  forceTLS: false,
  wsPort: 6001,
  wssPort: 6001,
  disableStats: true,
  enabledTransports: ['ws'],
  auth: {
    headers: {
      authorization: 'Bearer ' + token,
  
    }
  }
}

// This assumes you have already saved your bearer token in your browsers local storage
globalThis.Pusher = Pusher



globalThis.Echo = new Echo(options)

axios.interceptors.request.use((config) => {
  config.headers['X-Socket-ID'] = globalThis.Echo.socketId() // Echo instance
  // the function socketId () returns the id of the socket connection
  return config
})