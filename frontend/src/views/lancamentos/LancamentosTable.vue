<template>
  <div>
    <v-progress-linear v-if="loading" indeterminate color="primary"></v-progress-linear>
    <v-simple-table fixed-header>
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-center text-uppercase">Data</th>
            <th class="text-center text-uppercase">Tipo</th>
            <th class="text-uppercase">Título</th>
            <th class="text-uppercase">Cliente</th>
            <th class="text-uppercase text-center">Status</th>
            <th class="text-uppercase">Valor</th>
            <th class="text-uppercase"></th>
          </tr>
        </thead>
        <tbody>
          <div class="contents" v-for="item in fluxos" :key="item.fluxos">
            <tr>
              <span class="contents pointer" @click="editarLancamento(item)">
                <td class="text-center">{{ item.data_inicio_formatada }}</td>
                <td class="text-center" v-if="item.tipo_fluxo == 'entrada'">
                  <v-tooltip right>
                    <template v-slot:activator="{ on, attrs }">
                      <v-icon color="success" v-bind="attrs" v-on="on">{{ mdiCashPlus }}</v-icon>
                    </template>
                    <span>Entrada</span>
                  </v-tooltip>
                </td>
                <td class="text-center" v-else>
                  <v-tooltip right>
                    <template v-slot:activator="{ on, attrs }">
                      <v-icon color="warning" v-bind="attrs" v-on="on">{{ mdiCashMinus }}</v-icon>
                    </template>
                    <span>Saída</span>
                  </v-tooltip>
                </td>
                <td>{{ item.titulo }}</td>
                <td>{{ item.cliente }}</td>
                <td class="text-center">
                  <v-btn rounded small :class="
                    item.status == 0
                      ? 'grey lighten-2 black--text'
                      : item.status == 1
                        ? 'primary'
                        : 'light-green darken-1 white--text'
                  ">
                    {{ item.status == 0 ? 'Pendente' : item.status == 1 ? 'Recorrências em Aberto' : 'Pago Integral' }}
                  </v-btn>
                </td>
                <td>
                  {{
                      item.recorrencias.length > 0
                        ? item.recorrencias.length + 'x de R$ ' + item.valor
                        : 'R$ ' + item.valor
                  }}
                </td>
              </span>
              <td>
                <v-btn icon :disabled="item.recorrencia == false ? true : false" @click="verDetalhes(item.id)">
                  <v-icon> {{ !ocultarDetalhes && detalhes == item.id ? mdiChevronUp : mdiChevronDown }} </v-icon>
                </v-btn>
              </td>
            </tr>
            <tr>
              <td colspan="6" v-if="detalhes == item.id && ocultarDetalhes == false">
                <v-container fluid>
                  <v-row dense>
                    <v-col v-for="(recorrencia, index) in item.recorrencias" :key="index" cols="12" sm="6" md="3">
                      <v-list>
                        <v-list-item-group>
                          <v-list-item class="pointer" :class="recorrencia.status == true ? 'success' : 'secondary'"
                            @click="editarRecorrencia(recorrencia)">
                            <v-list-item-icon>
                              <v-avatar color="accent" size="48">
                                <span class="white--text text-h5">{{ recorrencia.parcela_numero }}</span>
                              </v-avatar>
                            </v-list-item-icon>
                            <v-list-item-content>
                              <v-list-item-title v-text="'R$ ' + recorrencia.valor"></v-list-item-title>
                              <v-list-item-subtitle v-text="recorrencia.data_referencia_formatada">
                              </v-list-item-subtitle>
                            </v-list-item-content>
                          </v-list-item>
                        </v-list-item-group>
                      </v-list>
                    </v-col>
                  </v-row>
                </v-container>
              </td>
            </tr>
          </div>
        </tbody>
      </template>
    </v-simple-table>
  </div>
</template>

<script>
import { mdiCashPlus, mdiCashMinus, mdiEye, mdiPencil, mdiChevronDown, mdiChevronUp } from '@mdi/js'

import { eventbus } from '@/main.js'

export default {
  props: {
    filtro: Object,
  },
  data() {
    return {
      fluxos: {},
      mdiCashPlus,
      mdiCashMinus,
      mdiEye,
      mdiPencil,
      mdiChevronDown,
      mdiChevronUp,
      detalhes: null,
      ocultarDetalhes: true,
      loading: true,
    }
  },
  methods: {
    editarLancamento(lancamento) {
      eventbus.editLancamentos(lancamento)
    },
    editarRecorrencia(recorrencia) {
      eventbus.editRecorrencias(recorrencia)
    },
    verDetalhes(id) {
      this.ocultarDetalhes = !this.ocultarDetalhes
      this.detalhes = id
    },
    baixarRecorrencia(recorrencia) {
      this.$http.path(
        'recorrencias',
        recorrencia,
        recorrencia.id,
        res => {
          console.log(res.data.data)
          eventbus.$emit('makeSnackbar', {
            text: 'Lançamento recorrente marcado como Pago!',
            color: 'light-green darken-1 white--text',
          })
        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao marcar Lançamento recorrente como Pago!',
            color: 'error white--text',
          })
          console.error(err)
        },
      )
    },
    getLancamentos() {
      this.loading = true
      this.$http.get(
        'fluxos',
        res => {
          console.log(res.data.data)
          this.fluxos = res.data.data
          this.loading = false
        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao carregar Lançamentos!',
            color: 'error white--text',
          })
          console.error(err)
        },
      )
    },
    getLancamentosFiltrados() {

      this.loading = true

      if (this.filtro.status) {
        if (this.filtro.status.includes("1")) {
          if (!this.filtro.status.includes("2")) {
            this.filtro.status.push("2")
          }
          console.log(true);
        } else {
          if (this.filtro.status.includes("2")) {
            var index = this.filtro.status.indexOf("2");
            this.filtro.status.pop(index, 1)
          }
          console.log(false);
        }
      }
      this.$http.post(
        'fluxos/filter',
        this.filtro,
        res => {
          console.log(res.data.data)
          this.fluxos = res.data.data
          this.loading = false
        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao filtrar Lançamentos!',
            color: 'error white--text',
          })
          console.error(err)
        },
      )
    }
  },
  mounted() {
    this.getLancamentos()

    eventbus.$on('filtrarLancamentos', () => {
      this.getLancamentosFiltrados()
    })

    eventbus.$on('updateLancamentos', () => {
      this.getLancamentos()
    })

    eventbus.$on('updateRecorrencias', () => {
      this.getLancamentos()
    })
  },
}
</script>

<style scoped>
.pointer {
  cursor: pointer;
}

.contents {
  display: contents;
}
</style>
