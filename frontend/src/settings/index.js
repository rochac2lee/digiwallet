import axios from "axios"
import Vue from "vue"
import VueCookies from "vue-cookies"

//Importando o axios para todo o projeto
import http from "@/http";

var global_configs = []


function Configs() {
    http.get(
        'configs',
        res => {
            this.global_configs = res.data.data
        },
        err => {
            console.error(err);
        })
}

const configs = new Configs();

export default configs