<template>
  <v-row>
    <!-- basic -->
    <v-col cols="12">
      <v-card>
        <v-col cols="4">
          <v-text-field
            rounded
            dense
            outlined
            v-model="termo"
            :prepend-inner-icon="mdiMagnify"
            class="app-bar-search flex-grow-0"
            hide-details
          ></v-text-field>
        </v-col>
        <ClientesTable :termo="termo"></ClientesTable>
        <ClientesForm :dialog="dialog" @closeForm="dialog = false"></ClientesForm>
        <ClientesEdit :dialogEdit="dialogEdit" @openEdit="openEdit" @closeEdit="dialogEdit = false"></ClientesEdit>
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
            <v-btn v-bind="attrs" v-on="on" @click="dialog = true" v-model="fab" color="primary" fab>
              <v-icon> {{ mdiPlus }} </v-icon>
            </v-btn>
          </template>
          <span>Novo Cliente</span>
        </v-tooltip>
      </template>
    </v-speed-dial>
  </v-row>
</template>

<script>
import ClientesTable from './ClientesTable.vue'
import ClientesForm from './ClientesForm.vue'
import ClientesEdit from './ClientesEdit.vue'

import { mdiPlus, mdiMagnify } from '@mdi/js'

export default {
  components: {
    ClientesTable,
    ClientesForm,
    ClientesEdit,
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
      mdiMagnify,

      termo: "",

      dialog: false,
      dialogEdit: false,
    }
  },
  methods: {
    openEdit() {
      this.dialogEdit = true
    },
  },
}
</script>
