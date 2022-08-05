<template>
  <v-data-table
    :headers="headers"
    :items="clientes"
    :search="termo"
    :loading="loading"
    :loading-text="loading_text"
    :footer-props="footer_prop"
    @click:row="handleClick"
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
        { text: 'CPF/CNPJ', value: 'cpf_cnpj' },
        { text: 'Nome', value: 'nome' },
        { text: 'Tipo', value: 'tipo_cliente' },
        { text: 'Telefone', value: 'telefone' },
        { text: 'email', value: 'email' },
      ],
      loading: true,
      loading_text: 'Carregando...',
      footer_prop: {
        'items-per-page-text': 'Itens por página',
      },
      clientes: [],
    }
  },
  methods: {
    handleClick(value) {
      this.editar(value)
    },
    editar(cliente) {
      console.log(cliente)
      eventbus.editClientes(cliente)
    },
    tipoCliente(tipo) {
      tipo == 'PF' ? (tipo = 'Pessoa Física') : (tipo = 'Pessoa Jurídica')
      return tipo
    },
    getClientes() {
      this.$http.get(
        'clientes',
        res => {
          this.clientes = res.data.data
          this.clientes.forEach(cliente => {
            cliente.tipo_cliente = this.tipoCliente(cliente.tipo_cliente)
          })
          this.loading = false
        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao carregar Clientes!',
            color: 'error white--text',
          })
          console.error(err)
          this.loading = false
          this.loading_text = 'Erro ao carregar as informações'
        },
      )
    },
  },
  mounted() {
    this.getClientes()
    eventbus.$on('updateClientes', () => {
      this.getClientes()
    })
  },
}
</script>
<style scoped>
.pointer {
  cursor: pointer;
}
</style>
