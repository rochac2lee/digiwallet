<template>
  <v-row>
    <!-- basic -->
    <v-col cols="12">
      <v-card>
        <v-card-title>Usuários</v-card-title>
        <UsuariosTable></UsuariosTable>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import UsuariosTable from './UsuariosTable.vue'

export default {
  components: {
    UsuariosTable
  },
  setup() {
    return {}
  },
}
</script>
