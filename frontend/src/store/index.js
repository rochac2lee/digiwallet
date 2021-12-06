import Vue from "vue"

import Vuex from 'vuex'
Vue.use(Vuex)

var md5 = require("md5")

import http from "@/http"

import VueCookies from 'vue-cookies'
Vue.use(VueCookies)

const state = {
    token: Vue.$cookies.get('token') || '',
    usuario: ""
}

const mutations = {

    DEFINIR_USUARIO_LOGADO(state, { token, usuario }) {
        state.token = token
        state.usuario = usuario
    },
    DESLOGAR_USUARIO(state) {
        state.usuario = {}
        Vue.$cookies.set('usuario_id', "")
    },
    SITE(state, { service }) {
        state.service = service
    }

}

const actions = {
    efetuarLogin({ commit }, usuario) {
        return new Promise((resolve, reject) => {
            http.post(
                "auth/login",
                usuario,
                res => {
                    if (res.status === 200 && res.data.token) {
                        this.usuario = res.data.usuario
                        Vue.$cookies.set('usuario_id', this.usuario.id)
                        Vue.$cookies.set('cliente_id', this.usuario.cliente_id)
                        Vue.$cookies.set('nome', this.usuario.nome)
                        Vue.$cookies.set('perfil', this.usuario.perfil)
                        Vue.$cookies.set('token', res.data.token)
                        resolve(res.data)

                        commit('DEFINIR_USUARIO_LOGADO', {
                            token: res.data.token,
                            usuario: res.data.usuario
                        })
                    }
                },
                err => {
                    console.error(err)
                    reject(err)
                }
            )
        })
    }
}

const getters = {
    usuarioEstaLogado: state => Boolean(state.token)
}

export default new Vuex.Store({

    state,
    mutations,
    actions,
    getters

})