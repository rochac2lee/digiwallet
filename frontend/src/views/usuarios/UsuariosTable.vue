<template>
  <v-data-table
    :headers="headers"
    :items="usuarios"
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
        { text: 'Perfil', value: 'perfil' },
        { text: 'Nome', value: 'nome' },
        { text: 'Email', value: 'usuario' },
      ],
      loading: true,
      loading_text: 'Carregando...',
      footer_prop: {
        'items-per-page-text': 'Itens por página',
      },
      usuarios: [],
    }
  },
  methods: {
    getUsuarios() {
      this.$http.get(
        'usuarios',
        res => {
          this.usuarios = res.data.data
          this.loading = !this.loading
        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao carregar Usuários!',
            color: 'error white--text',
          })
          console.error(err)
          this.loading = !this.loading
          this.loading_text = 'Erro ao carregar as informações'
        },
      )
    },
    editar(usuario) {
      eventbus.editUsuarios(usuario)
    },
  },
  mounted() {
    this.getUsuarios()
    eventbus.$on('updateUsuarios', () => {
      this.getUsuarios()
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