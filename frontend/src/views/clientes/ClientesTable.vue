<template>
  <v-simple-table>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-uppercase">Nome</th>
          <th class="text-center text-uppercase">Tipo</th>
          <th class="text-center text-uppercase">CPF/CNPJ</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in clientes" :key="item.clientes" class="pointer" @click="editar(item)">
          <td>{{ item.nome }}</td>
          <td class="text-center">
            {{ item.tipo_cliente }}
          </td>
          <td class="text-center">
            {{ item.cpf_cnpj }}
          </td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>
</template>

<script>

import { eventbus } from '@/main.js'

export default {
  data() {
    return {
      clientes: {},
    }
  },
  methods: {
    editar(cliente) {
      eventbus.editClientes(cliente)
    },
    getClientes() {
      this.$http.get(
        'clientes',
        res => {
          console.log(res.data.data)
          this.clientes = res.data.data
        },
        err => console.error(err),
      )
    },
  },
  mounted() {
    this.getClientes()
    eventbus.$on('updateClientes', () => {
      this.getClientes()
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