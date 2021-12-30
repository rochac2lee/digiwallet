<template>
  <v-simple-table>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-center text-uppercase">Tipo</th>
          <th class="text-uppercase">Título</th>
          <th class="text-uppercase">Conta</th>
          <th class="text-uppercase text-center">Status</th>
          <th class="text-uppercase">Valor</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in fluxos" :key="item.fluxos" class="pointer" @click="editar(item)">
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
          <td class="text-center">
            <v-btn rounded small :color="item.status == 0 ? 'secondary' : item.status == 1 ? 'primary' : 'success'" dark> {{ item.status == 0 ? 'Pendente' : item.status == 1 ? 'Pago Parcial' : 'Pago Integral' }} </v-btn>
          </td>
          <td>{{ item.recorrencias.length > 0 ? item.recorrencias.length + "x de R$ " + item.valor : "R$ " + item.valor }}</td>
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
    editar(lancamento) {
      eventbus.editLancamentos(lancamento)
    },
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

<style scoped>
.pointer {
  cursor: pointer;
}
</style>
