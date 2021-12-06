<template>
  <v-simple-table>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-uppercase">Tipo</th>
          <th class="text-uppercase">Título</th>
          <th class="text-uppercase">Conta</th>
          <th class="text-uppercase">Valor</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in fluxos" :key="item.fluxos">
          <td v-if="item.tipo_fluxo == 'entrada'">
            <v-icon>{{ mdiCashPlus }}</v-icon>
          </td>
          <td v-else>
            <v-icon>{{ mdiCashPlus }}</v-icon>
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
  },
}
</script>
