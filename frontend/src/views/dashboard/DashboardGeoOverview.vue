<template>
  <v-card>
    <v-card-title class="align-start">
      <span>Clientes por Estado</span>
    </v-card-title>

    <v-card-subtitle>
      <span class="font-weight-semibold text--primary me-1">Brasil</span>
    </v-card-subtitle>

    <v-card-text>
      <GChart :type="type" :data="totalClientesporEstado" :options="options" :settings="settings" />
      <!-- <div class="d-flex align-center">
        <h3 class="text-2xl font-weight-semibold me-4">{{ percentualLucroLiquido }}%</h3>
        <span v-if="percentualLucroLiquido > 0">Parabéns! Nos últimos 6 meses você teve um Lucro Líquido de {{
            percentualLucroLiquido
        }}% 🤩 Continue
          assim!</span>
        <span v-else>Precisamos melhorar! Nos últimos 6 meses você teve um Prejuízo Líquido de {{ percentualLucroLiquido
        }}%</span>
      </div> -->

      <!-- <v-btn block color="primary" class="mt-6" outlined> Ver mais </v-btn> -->
    </v-card-text>
  </v-card>
</template>

<script>
import { GChart } from 'vue-google-charts/legacy'
// eslint-disable-next-line object-curly-newline
import { mdiDotsVertical, mdiTrendingUp, mdiCurrencyUsd } from '@mdi/js'

import { eventbus } from '@/main.js'

export default {
  components: {
    GChart,
  },
  data() {
    return {

      type: "GeoChart",
      totalClientesporEstado: [
        ['Estado', 'Quantidade'],
      ],
      options: {
        region: 'BR',
        resolution: 'provinces',
        width: 650,
        height: 308,
      },
      settings: {
        packages: ['geochart'],
      },

      icons: {
        mdiDotsVertical,
        mdiTrendingUp,
        mdiCurrencyUsd,
      },
    }
  },
  methods: {
    getDashboard() {
      this.$http.get(
        'dashboard',
        res => {

          var data = []

          for (let index = 0; index < res.data.totalClientesporEstado.length; index++) {
            const element = res.data.totalClientesporEstado[index];
            this.totalClientesporEstado.push(["BR-" + element.estado_uf, element.quantidade])
          }

          console.log(this.totalClientesporEstado);

        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao carregar Gráfico!',
            color: 'error white--text',
          })
          console.error(err)
        },
      )
    },
    getLastMonths() {
      var monthNames = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']

      var today = new Date()
      var d
      var month
      var year

      var periodo = []

      for (var i = 5; i >= 0; i -= 1) {
        d = new Date(today.getFullYear(), today.getMonth() - i, 1)
        month = monthNames[d.getMonth()]
        year = d.getFullYear().toString().substr(-2)
        console.log(month + '/' + year)
        periodo[i] = month + '/' + year
      }

      periodo = periodo.reverse()

      // this.chartOptions.xaxis.categories = periodo
      return periodo
    },
  },
  mounted() {
    this.getDashboard()
  },
}
</script>
