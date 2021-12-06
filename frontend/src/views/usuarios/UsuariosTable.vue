<template>
  <v-simple-table>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-uppercase">Nome</th>
          <th class="text-center text-uppercase">Email</th>
          <th class="text-center text-uppercase">Perfil</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in usuarios" :key="item.usuarios">
          <td>{{ item.nome }}</td>
          <td class="text-center">
            {{ item.usuario }}
          </td>
          <td class="text-center">
            {{ item.perfil }}
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
      usuarios: {},
    }
  },
  methods: {
    getUsuarios() {
      this.$http.get(
        'usuarios',
        res => {
          console.log(res.data.data)
          this.usuarios = res.data.data
        },
        err => console.error(err),
      )
    },
  },
  mounted() {
    this.getUsuarios()
  }
}
</script>
