<template>
  <v-row>
    <!-- basic -->
    <v-col cols="12">
      <v-card>
        
        <LancamentosTable></LancamentosTable>
        
        <LancamentosForm :dialogLancamentos="dialogLancamentos" @closeFormLancamentos="dialogLancamentos = false"></LancamentosForm>
        <LancamentosEdit :dialogEditLancamentos="dialogEditLancamentos"  @openEditLancamentos="openEditLancamentos" @closeEditLancamentos="dialogEditLancamentos = false"></LancamentosEdit>
        
        <RecorrenciasEdit :dialogEditRecorrencias="dialogEditRecorrencias"  @openEditRecorrencias="openEditRecorrencias" @closeEditRecorrencias="dialogEditRecorrencias = false"></RecorrenciasEdit>
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
        <v-tooltip left>
          <template v-slot:activator="{ on, attrs }">
            <v-btn v-bind="attrs" v-on="on" @click="dialogLancamentos = true" v-model="fab" color="primary" fab>
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
import LancamentosEdit from './lancamentosEdit.vue'
import RecorrenciasEdit from './recorrenciasEdit.vue'

import { mdiPlus } from '@mdi/js'

export default {
  components: {
    LancamentosTable,
    LancamentosForm,
    LancamentosEdit,
    RecorrenciasEdit
  },
  setup() {
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

      dialogLancamentos: false,
      dialogEditLancamentos: false,
      dialogEditRecorrencias: false,
    }
  },
  methods: {
    openEditLancamentos() {
      this.dialogEditLancamentos = true
    },
    openEditRecorrencias() {
      this.dialogEditRecorrencias = true
    },
  }
}
</script>
