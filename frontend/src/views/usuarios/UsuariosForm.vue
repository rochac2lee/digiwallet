<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="text-h5">Novo Usuário</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col cols="4">
                  <v-select
                    :rules="[v => !!v || 'Campo Obrigatório']"
                    v-model="usuario.perfil"
                    :items="perfis"
                    item-text="text"
                    item-value="value"
                    label="Perfil de Acesso"
                  ></v-select>
                </v-col>
                <v-col cols="4" v-if="usuario.perfil === 'cliente'">
                  <v-select
                    v-model="usuario.cliente_id"
                    :items="clientes"
                    item-text="nome"
                    item-value="id"
                    label="Vincular Cliente"
                  ></v-select>
                </v-col>
                <v-col :cols="usuario.perfil === 'cliente' ? '4' : '8'">
                  <v-text-field
                    :rules="[v => !!v || 'Campo Obrigatório']"
                    label="Nome Completo"
                    v-model="usuario.nome"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="4">
                  <v-text-field
                    :rules="[
                      v => !!v || 'Campo Obrigatório',
                      v => !v || /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail inválido!',
                    ]"
                    label="Email"
                    v-model="usuario.usuario"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="4">
                  <v-text-field
                    :append-icon="mostrarSenha ? mdiEye : mdiEyeOff"
                    :rules="[rules.required, rules.min]"
                    :type="mostrarSenha ? 'text' : 'password'"
                    name="input-10-2"
                    label="Senha"
                    hint="Min 8 caracteres"
                    v-model="usuario.senha"
                    class="input-group--focused"
                    @click:append="mostrarSenha = !mostrarSenha"
                  ></v-text-field>
                </v-col>
                <v-col cols="4">
                  <v-text-field
                    :append-icon="mostrarConfirmarSenha ? mdiEye : mdiEyeOff"
                    :rules="[rules.required, rules.min, rules.confirmPassword]"
                    :type="mostrarConfirmarSenha ? 'text' : 'password'"
                    name="input-10-2"
                    label="Confirmar Senha"
                    hint="Min 8 caracteres"
                    v-model="confirmarSenha"
                    class="input-group--focused"
                    @click:append="mostrarConfirmarSenha = !mostrarConfirmarSenha"
                  ></v-text-field>
                </v-col>
                <!-- <v-container v-if="usuario.perfil">
                  <v-row> </v-row>
                </v-container> -->
              </v-row>
            </v-form>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-1" text @click="$emit('closeForm')"> Cancelar </v-btn>
          <v-btn
            color="blue darken-1"
            :disabled="
              usuario.senha == null ||
              usuario.senha != confirmarSenha ||
              usuario.senha.length < 8 ||
              confirmarSenha == null ||
              confirmarSenha.length < 8 ||
              usuario.nome == null ||
              usuario.usuario == null ||
              usuario.perfil == null
            "
            text
            @click="salvar()"
          >
            Salvar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import { eventbus } from '@/main.js'

import { mdiEye, mdiEyeOff } from '@mdi/js'

export default {
  props: {
    dialog: { type: Boolean, default: false },
  },
  data() {
    return {
      usuario: {
        senha: null,
      },
      perfis: [
        { text: 'Administrador', value: 'administrador' },
        { text: 'Usuario', value: 'usuario' },
        { text: 'Cliente', value: 'cliente' },
      ],
      clientes: {},
      value: null,
      focus: false,
      disabled: false,
      mdiEye,
      mdiEyeOff,
      mostrarSenha: false,
      mostrarConfirmarSenha: false,

      rules: {
        required: value => !!value || 'Campo Obrigatório',
        min: v => v.length >= 8 || 'Min 8 caracteres',
        confirmPassword: v => v === this.usuario.senha || 'Senhas não conferem',
      },

      confirmarSenha: null,

      modal: false,

      valid: true,
    }
  },
  methods: {
    salvar() {
      if (this.$refs.form.validate() === true) {
        if (this.usuario.senha === this.confirmarSenha)
          this.$http.post(
            'usuarios',
            this.usuario,
            res => {
              eventbus.$emit('updateUsuarios')
              this.$emit('closeForm')
              eventbus.$emit('makeSnackbar', {
                text: 'Usuário cadastrado com sucesso!',
                color: 'light-green darken-1 white--text',
              })
            },
            err => {
              eventbus.$emit('makeSnackbar', {
                text: 'Erro ao cadastrar Usuário!',
                color: 'error white--text',
              })
              console.error(err)
            },
          )
      }
    },
    getClientes() {
      this.$http.get(
        'clientes',
        res => {
          this.clientes = res.data.data
        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao carregar Clientes!',
            color: 'error white--text',
          })
          console.error(err)
        },
      )
    },
  },
  computed: {},
  mounted() {
    this.getClientes()

    this.$settings.global_configs.forEach(config => {
      if (config.habilitar_clientes == false) {
        this.perfis = [
          { text: 'Administrador', value: 'administrador' },
          { text: 'Usuario', value: 'usuario' },
        ]
      }
    })
  },
}
</script>