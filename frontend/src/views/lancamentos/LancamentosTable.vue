<template>
  <v-simple-table>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-center text-uppercase">Tipo</th>
          <th class="text-uppercase">Título</th>
          <th class="text-uppercase">Conta</th>
          <th class="text-uppercase">Valor</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in fluxos" :key="item.fluxos">
          <td class="text-center" v-if="item.tipo_fluxo == 'entrada'">
            <v-tooltip right>
              <template v-slot:activator="{ on, attrs }">
                <v-icon v-bind="attrs" v-on="on">{{ mdiCashPlus }}</v-icon>
              </template>
              <span>Entrada</span>
            </v-tooltip>
          </td>
          <td class="text-center" v-else>
            <v-tooltip right>
              <template v-slot:activator="{ on, attrs }">
                <v-icon v-bind="attrs" v-on="on">{{ mdiCashMinus }}</v-icon>
              </template>
              <span>Saída</span>
            </v-tooltip>
          </td>
          <td>{{ item.titulo }}</td>
          <td>{{ item.conta }}</td>
          <td>{{ item.valor }}</td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>
</template>

<script>
import { mdiCashPlus, mdiCashMinus } from '@mdi/js'

import { eventbus } from '@/main.js'

export default {
  data() {
    return {
      fluxos: {},
      mdiCashPlus,
      mdiCashMinus,
    }
  },
  methods: {
    getFluxos() {
      this.$http.get(
        'fluxos',
        res => {
          console.log(res.data.data)
          this.fluxos = res.data.data
        },
        err => console.error(err),
      )
    },
  },
  mounted() {
    this.getFluxos()
    eventbus.$on('updateLancamentos', () => {
      this.getFluxos()
      console.log('evento disparado')
    })
  },
}
</script>
