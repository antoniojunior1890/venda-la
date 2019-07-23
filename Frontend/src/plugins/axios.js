import Vue from 'vue'
import axios from 'axios'

Vue.use({
    install(Vue){
        Vue.prototype.$http = axios.create({
            baseURL: 'http://backend-api.test/api/',
        })
        // Vue.prototype.$http.interceptors.request.use(config => {
        //     console.log(config.headers)
        //     return config
        // }, error => Promise.reject(error))

    }    
})