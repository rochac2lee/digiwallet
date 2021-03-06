import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    redirect: 'dashboard',
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    meta: {
      titulo: "Dashboard"
    },
    component: () => import('@/views/dashboard/Dashboard.vue'),
  },
  {
    path: '/usuarios',
    name: 'usuarios',
    meta: {
      titulo: "Usuários"
    },
    component: () => import('@/views/usuarios/Usuarios.vue'),
  },
  {
    path: '/clientes',
    name: 'clientes',
    meta: {
      titulo: "Clientes"
    },
    component: () => import('@/views/clientes/Clientes.vue'),
  },
  {
    path: '/lancamentos',
    name: 'lancamentos',
    meta: {
      titulo: "Lançamentos"
    },
    component: () => import('@/views/lancamentos/Lancamentos.vue'),
  },
  {
    path: '/configs',
    name: 'configs',
    meta: {
      titulo: "Configurações"
    },
    component: () => import('@/views/configs/Configs.vue'),
  },
  {
    path: '/typography',
    name: 'typography',
    component: () => import('@/views/typography/Typography.vue'),
  },
  {
    path: '/icons',
    name: 'icons',
    component: () => import('@/views/icons/Icons.vue'),
  },
  {
    path: '/contas',
    name: 'contas',
    meta: {
      titulo: "Contas"
    },
    component: () => import('@/views/contas/Contas.vue'),
  },
  {
    path: '/simple-table',
    name: 'simple-table',
    component: () => import('@/views/simple-table/SimpleTable.vue'),
  },
  {
    path: '/form-layouts',
    name: 'form-layouts',
    component: () => import('@/views/form-layouts/FormLayouts.vue'),
  },
  {
    path: '/pages/account-settings',
    name: 'pages-account-settings',
    component: () => import('@/views/pages/account-settings/AccountSettings.vue'),
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('@/views/Login.vue'),
    meta: {
      layout: 'blank',
    },
  },
  {
    path: '/pages/register',
    name: 'pages-register',
    component: () => import('@/views/pages/Register.vue'),
    meta: {
      layout: 'blank',
    },
  },
  {
    path: '/error-404',
    name: 'error-404',
    component: () => import('@/views/Error.vue'),
    meta: {
      layout: 'blank',
    },
  },
  {
    path: '*',
    redirect: 'error-404',
  },
]

const router = new VueRouter({
  mode: 'hash',
  base: process.env.BASE_URL,
  routes,
})

export default router
