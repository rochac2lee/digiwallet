<template>
  <v-simple-table>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-center text-uppercase">Perfil</th>
          <th class="text-center text-uppercase">Nome</th>
          <th class="text-center text-uppercase">Email</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in usuarios" :key="item.id" class="pointer" @click="editar(item)">
          <td class="text-center">
            {{ item.perfil }}
          </td>
          <td class="text-center">{{ item.nome }}</td>
          <td class="text-center">
            {{ item.usuario }}
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
      usuarios: {},
    }
  },
  methods: {
    getUsuarios() {
      this.$http.get(
        'usuarios',
        res => {
          this.usuarios = res.data.data
        },
        err => console.error(err),
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