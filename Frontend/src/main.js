import '@babel/polyfill'
import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

import './plugins/bootstrap-vue'
import './plugins/axios'


Vue.config.productionTip = false


new Vue({
  store,
  router,
  render: h => h(App),
}).$mount('#app')
