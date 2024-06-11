<template>
  <v-row>
    <!-- basic -->
    <v-col cols="12">
      <v-card>
        <v-col cols="12">
          <v-row>
            <v-expansion-panels>
              <v-expansion-panel>
                <v-expansion-panel-header @click="verFiltro = !verFiltro" hide-actions>
                  <span class="">
                    <v-icon>{{ verFiltro == true ? icons.mdiFilterVariantRemove : icons.mdiFilterVariant
                    }}</v-icon> <span>Filtro</span>
                  </span>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                  <v-row>
                    <v-col cols="12" md="2">
                      <v-menu ref="menu" v-model="menu" :close-on-content-click="false"
                        :return-value.sync="filtro.periodo" transition="scale-transition" offset-y min-width="auto">
                        <template v-slot:activator="{ on, attrs }">
                          <v-text-field v-model="dateRangeText" v-bind="attrs" v-on="on" readonly label="Período"
                            :prepend-icon="icons.mdiCalendar"></v-text-field>
                        </template>
                        <v-date-picker v-model="filtro.periodo" locale="pt-br" range no-title scrollable>
                          <v-spacer></v-spacer>
                          <v-btn text color="primary" @click="menu = false">
                            Cancelar
                          </v-btn>
                          <v-btn text color="primary" @click="$refs.menu.save(filtro.periodo), formatDate()">
                            OK
                          </v-btn>
                        </v-date-picker>
                      </v-menu>
                    </v-col>
                    <v-col cols="3">
                      <v-text-field v-model="filtro.titulo" :items="tipo_fluxo" label="Título" />
                    </v-col>
                    <v-col cols="2">
                      <v-select v-model="filtro.tipo_fluxo" :items="tipo_fluxo" multiple label="Tipo de Lançamento">
                      </v-select>
                    </v-col>
                    <v-col cols="2">
                      <v-select v-model="filtro.forma_pagamento" :items="forma_pagamento" multiple
                        label="Forma de Pagamento"></v-select>
                    </v-col>

                    <v-col cols="2">
                      <v-select v-model="filtro.status" :items="filtro_status" multiple label="Status">
                      </v-select>
                    </v-col>
                    <v-col cols="1">
                      <v-btn color="primary" v-if="!filtrando" @click="filtrarLancamentos()" class="ma-1" fab>
                        <v-icon>{{ icons.mdiMagnify }}</v-icon>
                      </v-btn>
                      <v-btn color="error" v-else @click="limparFiltro()" class="ma-1" fab>
                        <v-icon>{{ icons.mdiClose }}</v-icon>
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-expansion-panel-content>
              </v-expansion-panel>
            </v-expansion-panels>
          </v-row>
        </v-col>

        <LancamentosTable ref="tableLancamentos" :filtro="filtro"></LancamentosTable>

        <LancamentosForm :dialogLancamentos="dialogLancamentos" @closeFormLancamentos="dialogLancamentos = false">
        </LancamentosForm>
        <LancamentosEdit :dialogEditLancamentos="dialogEditLancamentos" @openEditLancamentos="openEditLancamentos"
          @closeEditLancamentos="dialogEditLancamentos = false"></LancamentosEdit>

        <RecorrenciasEdit :dialogEditRecorrencias="dialogEditRecorrencias" @openEditRecorrencias="openEditRecorrencias"
          @closeEditRecorrencias="dialogEditRecorrencias = false"></RecorrenciasEdit>
      </v-card>
    </v-col>
    <v-speed-dial v-model="fab" :top="top" :fixed="fixed" :bottom="bottom" :right="right" :left="left"
      :direction="direction" :open-on-hover="hover" :transition="transition">
      <template v-slot:activator>
        <v-tooltip left>
          <template v-slot:activator="{ on, attrs }">
            <v-btn v-bind="attrs" v-on="on" @click="dialogLancamentos = true" v-model="fab" color="primary" fab>
              <v-icon> {{ icons.mdiPlus }} </v-icon>
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

import { eventbus } from '@/main.js'

import { mdiPlus, mdiFilterVariant, mdiFilterVariantRemove, mdiCalendar, mdiMagnify, mdiClose } from '@mdi/js'

export default {
  components: {
    LancamentosTable,
    LancamentosForm,
    LancamentosEdit,
    RecorrenciasEdit
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
      verFiltro: false,
      filtrando: false,
      menu: false,
      menu_data_fim: null,
      transition: 'slide-y-reverse-transition',
      icons: {
        mdiPlus,
        mdiFilterVariant,
        mdiFilterVariantRemove,
        mdiCalendar,
        mdiMagnify,
        mdiClose
      },
      tipo_fluxo: [
        { text: 'Entrada', value: "entrada" },
        { text: 'Saída', value: "saida" }
      ],
      forma_pagamento: [
        { text: 'Recorrente', value: true },
        { text: 'Avulso', value: false }
      ],
      filtro_status: [
        { text: 'Pago', value: '1' },
        { text: 'Pendente', value: '0' }
      ],
      filtro: {
        periodo: [],
        periodo_formatado: [],
      },
      dialogLancamentos: false,
      dialogEditLancamentos: false,
      dialogEditRecorrencias: false,
    }
  },
  computed: {
    dateRangeText() {
      return this.filtro.periodo_formatado.join(' - ')
    },
  },
  methods: {
    filtrarLancamentos() {
      this.filtrando = true
      eventbus.$emit('filtrarLancamentos')
    },
    limparFiltro() {
      this.filtrando = false
      this.filtro = {
        periodo: [],
        periodo_formatado: []
      }
      this.$refs.tableLancamentos.getLancamentos()
    },
    openEditLancamentos() {
      this.dialogEditLancamentos = true
    },
    openEditRecorrencias() {
      this.dialogEditRecorrencias = true
    },
    formatDate() {
      this.filtro.periodo.forEach(element => {
        let date = element.split('-').reverse().join('/')
        this.filtro.periodo_formatado.push(date)
      });
    },
  }
}
</script>
