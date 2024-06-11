<template>
  <v-row>
    <!-- basic -->
    <v-col cols="12">
      <v-card>
        <v-card-title>Configurações</v-card-title>
        <v-row>
          <v-col cols="6">
            <v-col cols="12">
              <v-switch
                v-model="configs.habilitar_clientes"
                @change="setConfigs()"
                label="Habilitar Clientes"
                hide-details
              ></v-switch>
            </v-col>
          </v-col>
        </v-row>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>

import { eventbus } from '@/main.js'

export default {
  components: {},
  data() {
    return {
      configs: {
        habilitar_clientes: false,
      },
    }
  },
  methods: {
    getConfigs() {
      this.$http.get(
        'configs',
        res => {
          this.configs = res.data.data[0]

          this.$cookies.set('habilitar_clientes', this.configs.habilitar_clientes)
        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao carregar Configurações!',
            color: 'error white--text',
          })
          console.error(err)
        },
      )
    },
    setConfigs() {
      this.$http.put(
        'configs',
        this.configs.id,
        this.configs,
        res => {
          eventbus.$emit('makeSnackbar', {
            text: 'Configurações salvas com sucesso!',
            color: 'light-green darken-1 white--text',
          })
          this.configs = res.data.data
          console.log(this.configs.habilitar_clientes)
          this.$cookies.set('habilitar_clientes', this.configs.habilitar_clientes)
          this.$router.go()
        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao salvar Configurações!',
            color: 'error white--text',
          })
          console.error(err)
        },
      )
    },
  },
  mounted() {
    this.getConfigs()
  },
}
</script>
