<template>
  <v-data-table 
    :headers="headers" 
    :items="clientes"
    :loading="loading" 
    :loading-text="loading_text" 
    :footer-props="footer_prop"></v-data-table>

  </v-simple-table>
</template>

<script>
import { eventbus } from '@/main.js'

export default {
  data() {
    return {
      headers: [
        { text: 'Nome', value: 'nome' },
        { text: 'Tipo', value: 'tipo_cliente' },
        { text: 'CPF/CNPJ', value: 'cpf_cnpj' },
      ],
      loading: true,
      loading_text: 'Carregando...',
      footer_prop: {
        'items-per-page-text':'Itens por página'
      },
      clientes: [],
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
          this.loading = !this.loading
        },
        err => {
          console.error(err)
          this.loading = !this.loading
          this.loading_text = 'Erro ao carregar as informações'
        },
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