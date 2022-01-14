<template>
  <v-data-table
    :headers="headers"
    :items="contas"
    :search="termo"
    :loading="loading"
    :loading-text="loading_text"
    :footer-props="footer_prop"
  ></v-data-table>
</template>

<script>
import { eventbus } from '@/main.js'

export default {
  props: {
    termo: { type: String, default: '' },
  },
  data() {
    return {
      headers: [
        { text: 'Nome', value: 'nome' },
        { text: 'Saldo', value: 'saldo' },
      ],
      loading: true,
      loading_text: 'Carregando...',
      footer_prop: {
        'items-per-page-text': 'Itens por página',
      },
      contas: [],
    }
  },
  methods: {
    getContas() {
      this.$http.get(
        'contas',
        res => {
          console.log(res.data.data)
          this.contas = res.data.data

          this.contas.forEach(conta => {
            conta.saldo = 'R$ ' + conta.saldo
          })

          this.loading = !this.loading
        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao carregar Contas!',
            color: 'error white--text',
          })
          console.error(err)
          this.loading = !this.loading
          this.loading_text = 'Erro ao carregar as informações'
        },
      )
    },
  },
  mounted() {
    this.getContas()
  },
}
</script>
