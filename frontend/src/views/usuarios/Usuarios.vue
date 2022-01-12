<template>
  <v-row>
    <!-- basic -->
    <v-col cols="12">
      <v-card>
        <v-card-title>Usuários</v-card-title>
        <UsuariosTable></UsuariosTable>

        <UsuariosForm :dialog="dialog" @closeForm="dialog = false"></UsuariosForm>

        <UsuariosEdit :dialogEdit="dialogEdit"  @openEditUsuarios="openEditUsuarios" @closeEdit="dialogEdit = false"></UsuariosEdit>
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
          <span>Novo Usuário</span>
        </v-tooltip>
      </template>
    </v-speed-dial>
  </v-row>
</template>

<script>
import UsuariosTable from './UsuariosTable.vue'
import UsuariosForm from './UsuariosForm.vue'
import UsuariosEdit from './UsuariosEdit.vue'

import { mdiPlus } from '@mdi/js'

export default {
  components: {
    UsuariosTable,
    UsuariosForm,
    UsuariosEdit,
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

      dialog: false,
      dialogEdit: false,
    }
  },
  methods: {
    openEditUsuarios() {
      this.dialogEdit = true
    },
  },
}
</script>
