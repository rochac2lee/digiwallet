import '@/plugins/vue-composition-api'
import '@/styles/styles.scss'
import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import router from './router'
import store from './store'

//Importando o axios para todo o projeto
import http from "@/http";

import VueSession from 'vue-session'
Vue.use(VueSession)

import VueCookies from 'vue-cookies'
Vue.use(VueCookies)

import VuetifyMask from "vuetify-mask";  
Vue.use(VuetifyMask)

export const eventbus = new Vue({
  methods: {
      updateLancamentos() {
          this.$emit('updateLancamentos')
      },
      editLancamentos(lancamento) {
        console.log("teste", lancamento);
          this.$emit('editLancamentos', lancamento)
      }
      
  }
})

Vue.prototype.$http = http

Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App),
}).$mount('#app')