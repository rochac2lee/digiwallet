import '@/plugins/vue-composition-api'
import '@/styles/styles.scss'
import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import router from './router'
import store from './store'

//Importando o axios para todo o projeto
import http from "@/http";

//Importando o axios para todo o projeto
import settings from "@/settings";

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

    updateRecorrencias() {
      this.$emit('updateRecorrencias')
    },

    editLancamentos(lancamento) {
      this.$emit('editLancamentos', lancamento)
    },

    editRecorrencias(recorrencia) {
      this.$emit('editRecorrencias', recorrencia)
    },

    updateClientes() {
      this.$emit('updateClientes')
    },

    editClientes(cliente) {
      this.$emit('editClientes', cliente)
    }

  }
})

Vue.prototype.$http = http
Vue.prototype.$settings = settings

Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App),
}).$mount('#app')