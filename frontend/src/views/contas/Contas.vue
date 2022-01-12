<template>
  <v-row>
    <!-- basic -->
    <v-col cols="12">
      <v-card>
        <v-card-title>Contas</v-card-title>
        <ContasTable></ContasTable>
        <ContasForm :dialog="dialog" @close="dialog = false"></ContasForm>
      </v-card>
    </v-col>
    <v-speed-dial
      v-model="fab"
      :top="top"
      :fixed="fixed"
      :bottom="bottom"
      :right="right"
      :left="left"
      :direction="direction"
      :open-on-hover="hover"
      :transition="transition"
    >
      <template v-slot:activator>
        <v-btn @click="dialog = true" v-model="fab" color="primary" fab>
          <v-icon> {{ mdiPlus }} </v-icon>
        </v-btn>
      </template>
    </v-speed-dial>
  </v-row>
</template>

<script>
import ContasTable from './ContasTable.vue'
import ContasForm from './ContasForm.vue'

import { mdiPlus } from '@mdi/js'

export default {
  components: {
    ContasTable,
    ContasForm,
  },
  data() {
    return {
      direction: 'top',
      fab: true,
      fling: false,
      fixed: true,
      hover: false,
      tabs: null,
      top: false,
      right: true,
      bottom: true,
      left: false,
      transition: 'slide-y-reverse-transition',
      mdiPlus,

      dialog: false,
    }
  }
}
</script>

