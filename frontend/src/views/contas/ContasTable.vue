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
        <tr v-for="item in contas" :key="item.contas">
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
export default {
  data() {
    return {
      contas: {},
    }
  },
  methods: {
    getContas() {
      this.$http.get(
        'contas',
        res => {
          console.log(res.data.data)
          this.contas = res.data.data
        },
        err => console.error(err),
      )
    },
  },
  mounted() {
    this.getContas()
  }
}
</script>
