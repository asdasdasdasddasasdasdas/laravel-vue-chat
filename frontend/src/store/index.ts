

import Vuex from 'vuex'



export const store = new Vuex.Store({
    state:{
        messages: [],
        chats:[],
        test:'awdawdwa',
        user:JSON.parse(localStorage.auth_user ? localStorage.auth_user : '{}'),
        token:localStorage.auth_token
    },
    mutations:{
        setUser(state, user){
            state.user = user
        },
        setToken(state, token){
            state.token = token
        }
    }
  })

;