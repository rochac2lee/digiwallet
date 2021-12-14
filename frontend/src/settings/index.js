import axios from "axios"
import Vue from "vue"
import VueCookies from "vue-cookies"

//Importando o axios para todo o projeto
import http from "@/http";

var global_configs = {}

http.get(
    'configs',
    res => {
        global_configs = res.data.data[0]
    },
    err => {
        console.error(err);
    }
)

export default {
    global_configs
}