import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store =  new Vuex.Store({
    state: {
        token: localStorage.token || ''
        
    },
    getters:{
        getToken(state){
            return state.token
        },
    },
    mutations:{
        resetToken(state){
            state.token = ''
        }
    }
})

export default store