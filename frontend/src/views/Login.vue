<template>
  <div class="auth-wrapper auth-v1">
    <Snackbar :snackbar="snackbar" @openSnackbar="openSnackbar" @closeSnackbar="snackbar = false"></Snackbar>

    <div class="auth-inner">
      <v-card class="auth-card">
        <!-- logo -->
        <v-card-title class="d-flex align-center justify-center py-7">
          <router-link to="/" class="d-flex align-center">
            <v-img
              :src="require('@/assets/images/logos/wallet-46.svg')"
              max-height="30px"
              max-width="30px"
              alt="logo"
              contain
              class="me-3"
            ></v-img>

            <h2 class="text-2xl font-weight-semibold">Digiwallet</h2>
          </router-link>
        </v-card-title>

        <!-- login form -->
        <v-card-text>
          <v-form>
            <v-text-field
              v-model="usuario.usuario"
              outlined
              label="Email"
              name="email"
              placeholder="john@example.com"
              hide-details
              class="mb-3"
            ></v-text-field>

            <v-text-field
              v-model="usuario.senha"
              outlined
              :type="isPasswordVisible ? 'text' : 'password'"
              label="Senha"
              name="password"
              placeholder="············"
              :append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
              hide-details
              @click:append="isPasswordVisible = !isPasswordVisible"
              @keypress.enter="efetuarLogin()"
            ></v-text-field>

            <v-btn block color="primary" class="mt-6" @click="efetuarLogin()"> Login </v-btn>
          </v-form>
        </v-card-text>
      </v-card>
    </div>

    <!-- background triangle shape  -->
    <img
      class="auth-mask-bg"
      height="173"
      :src="require(`@/assets/images/misc/mask-${$vuetify.theme.dark ? 'dark' : 'light'}.png`)"
    />

    <!-- tree -->
    <v-img class="auth-tree" width="247" height="185" src="@/assets/images/misc/tree.png"></v-img>

    <!-- tree  -->
    <v-img class="auth-tree-3" width="377" height="289" src="@/assets/images/misc/tree-3.png"></v-img>
  </div>
</template>

<script>
// eslint-disable-next-line object-curlfalsey-newline
import { mdiFacebook, mdiTwitter, mdiGithub, mdiGoogle, mdiEyeOutline, mdiEyeOffOutline } from '@mdi/js'
import { ref } from '@vue/composition-api'
import { eventbus } from '@/main.js'

import Snackbar from '@/layouts/components/Snackbar.vue'

export default {
  components: {
    Snackbar,
  },
  data() {
    const email = ref('')
    const password = ref('')

    return {
      isPasswordVisible: false,
      // usuario: {
      //   usuario: 'admin@digiwallet.com',
      //   senha: 'admin',
      // },
      usuario: {},

      snackConfigs: {},
      snackbar: false,

      icons: {
        mdiEyeOutline,
        mdiEyeOffOutline,
      },
    }
  },
  methods: {
    efetuarLogin() {
      ;(this.showSnackbar = true),
        this.$store
          .dispatch('efetuarLogin', this.usuario)
          .then(() => {
            this.$session.start()
            this.$session.set('jwt', this.$store.state.token)
            // this.$session.set("expire_time", this.$store.state.usuario.expire_time);
            eventbus.$emit('makeSnackbar', {
              text: 'Seja Bem Vindo!',
              color: 'light-green darken-1 white--text',
            })
            setTimeout(() => {
              this.$router.push({ name: 'dashboard' })
            }, 2100)
          })
          .catch(err => {
            eventbus.$emit('makeSnackbar', {
              text: 'Usuário ou Senha Inválidos!',
              color: 'error white--text',
            })
            this.usuario = {
              usuario: '',
              senha: '',
            }
          })
    },
    openSnackbar() {
      this.snackbar = true
    },
  },
  mounted() {
    if (this.$session.exists()) {
      this.$router.push('dashboard')
    }
  },
}
</script>

<style lang="scss">
@import '~@/plugins/vuetify/default-preset/preset/pages/auth.scss';
</style>
