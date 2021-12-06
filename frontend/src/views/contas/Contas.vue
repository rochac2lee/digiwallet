<template>
  <v-row>
    <!-- basic -->
    <v-col cols="12">
      <v-card>
        <v-card-title>Contas</v-card-title>
        <ContasTable></ContasTable>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import ContasTable from './ContasTable.vue'

export default {
  components: {
    ContasTable
  },
  setup() {
    return {}
  },
}
</script>
