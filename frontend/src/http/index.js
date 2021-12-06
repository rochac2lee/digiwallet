import axios from "axios"
import Vue from "vue"
import VueCookies from "vue-cookies"

Vue.use(VueCookies)

// const API_HOST = "45.82.72.105"

const API_HOST = window.location.hostname + ":8000";

console.log(window.location);

const API_REST = "api"

const api = axios.create({
    baseURL: `http://${API_HOST}/${API_REST}`
})

const config = () => ({
    headers: {
        Authorization: `Bearer ${Vue.$cookies.get('token')}`
    }
})

const httpGet = (endpoint, response, reject) =>
    api.get(
        endpoint,
        config()
    )
    .then(response)
    .catch(reject)

const httpPost = (endpoint, payload, response, reject) =>
    api.post(
        endpoint,
        payload,
        config()
    )
    .then(response)
    .catch(reject)

const httpPut = (endpoint, id, payload, response, reject) =>
    api.put(
        `${endpoint}/${id}`,
        payload,
        config()
    )
    .then(response)
    .catch(reject)

const httpPatch = (endpoint, id, payload, response, reject) =>
    api.patch(
        `${endpoint}/${id}`,
        payload,
        config()
    )
    .then(response)
    .catch(reject)

const httpDelete = (endpoint, id, response, reject) =>
    api.delete(
        `${endpoint}/${id}`,
        config()
    )
    .then(response)
    .catch(reject)

export default {
    baseUrl: `http://${API_HOST}/${API_REST}`,
    post: httpPost,
    get: httpGet,
    put: httpPut,
    patch: httpPatch,
    delete: httpDelete
}