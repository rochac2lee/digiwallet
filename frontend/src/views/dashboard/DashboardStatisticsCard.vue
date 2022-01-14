<template>
  <v-card>
    <v-card-title class="align-start">
      <span class="font-weight-semibold">Indicadores Gerais</span>
      <v-spacer></v-spacer>
      <v-btn icon small class="me-n3 mt-n2">
        <v-icon>
          {{ icons.mdiDotsVertical }}
        </v-icon>
      </v-btn>
    </v-card-title>
    <v-card-text>
      <v-row>
        <v-col
          v-for="data in indicadoresGerais"
          :key="data.title"
          cols="6"
          :md="indicadoresGerais.length == 4 ? 3 : 4"
          class="d-flex align-center"
        >
          <v-avatar size="44" :color="resolveStatisticsIconVariation(data.title).color" rounded class="elevation-1">
            <v-icon dark color="white" size="30">
              {{ resolveStatisticsIconVariation(data.title).icon }}
            </v-icon>
          </v-avatar>
          <div class="ms-3">
            <p class="text-xs mb-0">
              {{ data.title }}
            </p>
            <h3 class="text-xl font-weight-semibold">
              {{ data.total }}
            </h3>
          </div>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import {
  mdiAccountOutline,
  mdiAccount,
  mdiCashPlus,
  mdiCashMinus,
  mdiCurrencyUsd,
  mdiTrendingUp,
  mdiDotsVertical,
  mdiLabelOutline,
} from '@mdi/js'

import { eventbus } from '@/main.js'

export default {
  data() {
    const resolveStatisticsIconVariation = data => {
      if (data === 'Usuários') return { icon: mdiAccount, color: 'info' }
      if (data === 'Clientes') return { icon: mdiAccountOutline, color: 'primary' }
      if (data === 'Entradas') return { icon: mdiCashPlus, color: 'success' }
      if (data === 'Saídas') return { icon: mdiCashMinus, color: 'warning' }

      return { icon: mdiAccountOutline, color: 'success' }
    }

    return {
      indicadoresGerais: {},
      resolveStatisticsIconVariation,

      // icons
      icons: {
        mdiDotsVertical,
        mdiTrendingUp,
        mdiAccount,
        mdiAccountOutline,
        mdiCashPlus,
        mdiCashMinus,
        mdiCurrencyUsd,
      },
    }
  },
  methods: {
    getDashboard() {
      this.$http.get(
        'dashboard',
        res => {
          this.indicadoresGerais = res.data.indicadoresGerais
        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao carregar Indicadores!',
            color: 'error white--text',
          })
          console.error(err)
        },
      )
    },
  },
  mounted() {
    this.getDashboard()
  },
}
</script>
