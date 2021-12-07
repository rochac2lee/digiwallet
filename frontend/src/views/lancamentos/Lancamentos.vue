<template>
  <v-row>
    <!-- basic -->
    <v-col cols="12">
      <v-card>
        <v-card-title>Lançamentos</v-card-title>
        <LancamentosTable></LancamentosTable>
        <LancamentosForm :dialog="dialog" @close="dialog = false"></LancamentosForm>
      </v-card>
    </v-col>
    <v-speed-dial
      v-model="fab"
      :top="top"
      :bottom="bottom"
      :right="right"
      :left="left"
      :direction="direction"
      :open-on-hover="hover"
      :transition="transition"
    >
      <template v-slot:activator>
        <v-tooltip left>
          <template v-slot:activator="{ on, attrs }">
            <v-btn v-bind="attrs" v-on="on" @click="dialog = true" v-model="fab" color="primary" fab>
              <v-icon> {{ mdiPlus }} </v-icon>
            </v-btn>
          </template>
          <span>Novo Lançamento</span>
        </v-tooltip>
      </template>
    </v-speed-dial>
  </v-row>
</template>

<script>
import LancamentosTable from './LancamentosTable.vue'
import LancamentosForm from './lancamentosForm.vue'

import { mdiPlus } from '@mdi/js'

export default {
  components: {
    LancamentosTable,
    LancamentosForm,
  },
  setup() {
    return {
      direction: 'top',
      fab: false,
      fling: false,
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
  },
}
</script>
<style scoped>
.v-speed-dial {
  position: absolute;
}

.v-btn--floating {
  position: relative;
}
</style>