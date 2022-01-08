<template>
  <v-card>
    <v-card-title class="align-start">
      <span>Lucro Líquido</span>
    </v-card-title>

    <v-card-subtitle>
      <span class="font-weight-semibold text--primary me-1">Últimos 6 Meses</span>
    </v-card-subtitle>

    <v-card-text>
      <vue-apex-charts :options="chartOptions" :series="series" height="210" />
      <div class="d-flex align-center">
        <h3 class="text-2xl font-weight-semibold me-4">{{ percentualLucroLiquido }}%</h3>
        <span
          >Parabéns! Nos últimos 6 meses você teve um Lucro Líquido de {{ percentualLucroLiquido }}% 🤩 Continue
          assim!</span
        >
      </div>

      <!-- <v-btn block color="primary" class="mt-6" outlined> Ver mais </v-btn> -->
    </v-card-text>
  </v-card>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
// eslint-disable-next-line object-curly-newline
import { mdiDotsVertical, mdiTrendingUp, mdiCurrencyUsd } from '@mdi/js'
import { getCurrentInstance } from '@vue/composition-api'

export default {
  components: {
    VueApexCharts,
  },
  data() {
    // const ins = getCurrentInstance()?.proxy
    // const $vuetify = ins && ins.$vuetify ? ins.$vuetify : null
    // const customChartColor = $vuetify.theme.isDark ? '#3b3559' : '#f5f5f5'

    return {
      chartOptions: {
        chart: {
          type: 'area',
          toolbar: {
            show: false,
          },
          offsetX: -15,
        },
        dataLabels: {
          enabled: false,
        },
        legend: {
          show: false,
        },
        xaxis: {
          type: 'category',
          categories: this.getLastMonths(),
          axisBorder: {
            show: true,
          },
          axisTicks: {
            show: false,
          },
          tickPlacement: 'on',
          labels: {
            show: true,
            style: {
              fontSize: '12px',
            },
          },
        },
        yaxis: {
          show: true,
          tickAmount: 4,
          labels: {
            offsetY: 3,
            formatter: value => `R$ ${value}`,
          },
        },
        stroke: {
          width: [2, 2],
        },
        grid: {
          strokeDashArray: 12,
          padding: {
            right: 0,
          },
        },
      },
      series: [
        {
          name: 'Lucro Líquido',
          data: [],
        },
      ],
      percentualLucroLiquido: null,

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
          this.lucroLiquidoUltimos6Meses = res.data.lucroLiquidoUltimos6Meses

          var data = []

          var percentual = 0

          this.lucroLiquidoUltimos6Meses.forEach(saldo => {
            data.push(saldo.total)

            percentual = percentual + parseFloat(saldo.total)
          })

          if (this.lucroLiquidoUltimos6Meses && this.lucroLiquidoUltimos6Meses.length)
            percentual = percentual / this.lucroLiquidoUltimos6Meses.length

          this.series[0].data = data
          this.percentualLucroLiquido = parseInt(percentual)
        },
        err => console.error(err),
      )
    },
    getLastMonths() {
      var monthNames = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']

      var today = new Date()
      var d
      var month
      var year

      var periodo = []

      for (var i = 6; i > 0; i -= 1) {
        d = new Date(today.getFullYear(), today.getMonth() - i, 1)
        month = monthNames[d.getMonth()]
        year = d.getFullYear().toString().substr(-2)
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
