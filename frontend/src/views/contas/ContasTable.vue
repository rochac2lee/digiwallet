<template>
  <v-simple-table>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-uppercase">Nome</th>
          <th class="text-uppercase">Saldo</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in contas" :key="item.contas">
          <td>{{ item.nome }}</td>
          <td>{{ item.saldo }}</td>
        </tr>
      </tbody>
    </template>
  </v-simple-table>
</template>

<script>
export default {
  props: {
    update: { type: Boolean, default: false },
  },
  data() {
    return {
      contas: {}
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
  },
}
</script>
