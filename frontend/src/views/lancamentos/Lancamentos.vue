<template>
  <v-row>
    <!-- basic -->
    <v-col cols="12">
      <v-card>
        <v-card-title>Lançamentos</v-card-title>
        <LancamentosTable></LancamentosTable>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import LancamentosTable from './LancamentosTable.vue'

export default {
  components: {
    LancamentosTable
  },
  setup() {
    return {}
  },
}
</script>
