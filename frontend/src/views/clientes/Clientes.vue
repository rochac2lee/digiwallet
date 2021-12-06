<template>
  <v-row>
    <!-- basic -->
    <v-col cols="12">
      <v-card>
        <v-card-title>Clientes</v-card-title>
        <ClientesTable></ClientesTable>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import ClientesTable from './ClientesTable.vue'

export default {
  components: {
    ClientesTable
  },
  setup() {
    return {}
  },
}
</script>
