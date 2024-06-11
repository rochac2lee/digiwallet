<template>
  <v-card>
    <div class="d-flex flex-sm-row flex-column">
      <div class="flex-grow-1">
        <v-card-title>
          <span class="me-3">Entradas</span>
        </v-card-title>

        <v-card-text>
          <v-list>
            <v-list-item v-for="(entrada, index) in entradas" :key="index" class="d-flex px-0 mt-4">
              <v-tooltip left>
                <template v-slot:activator="{ on, attrs }">
                  <v-avatar class="me-2" color="success" size="40">
                    <v-icon class="white--text text-h5" v-bind="attrs" v-on="on">{{ mdiPlus }}</v-icon>
                  </v-avatar>
                </template>
                <span>Entrada</span>
              </v-tooltip>
              <div class="d-flex align-center flex-grow-1 flex-wrap">
                <div class="me-auto pe-2">
                  <h4 class="font-weight-semibold">
                    {{ entrada.titulo }}
                  </h4>
                  <span class="text-xs">{{ entrada.recorrencia == true ? 'Recorrente' : 'Avulso' }}</span>
                </div>

                <span class="font-weight-semibold success--text">R$ {{ entrada.valor }}</span>
              </div>
            </v-list-item>
          </v-list>
        </v-card-text>
      </div>

      <v-divider class="my-sm-5 mx-5" :vertical="$vuetify.breakpoint.smAndUp"></v-divider>

      <div class="flex-grow-1 teste">
        <v-card-title>
          <span class="me-3">Saídas</span>
        </v-card-title>

        <v-card-text>
          <v-list>
            <v-list-item v-for="saida in saidas" :key="saida.id" class="d-flex px-0 mt-4">
              <v-tooltip right>
                <template v-slot:activator="{ on, attrs }">
                  <v-avatar class="me-2" color="warning" size="40">
                    <v-icon class="white--text text-h5" v-bind="attrs" v-on="on">{{ mdiMinus }}</v-icon>
                  </v-avatar>
                </template>
                <span>Saída</span>
              </v-tooltip>

              <div class="d-flex align-center flex-grow-1 flex-wrap">
                <div class="me-auto pe-2">
                  <h4 class="font-weight-semibold">
                    {{ saida.titulo }}
                  </h4>
                  <span class="text-xs">{{ saida.recorrencia == true ? 'Recorrente' : 'Avulso' }}</span>
                </div>

                <span class="font-weight-semibold error--text">- R$ {{ saida.valor }}</span>
              </div>
            </v-list-item>
          </v-list>
        </v-card-text>
      </div>
    </div>
  </v-card>
</template>

<script>
import { mdiPlus, mdiMinus } from '@mdi/js'

import { eventbus } from '@/main.js'

export default {
  data() {
    return {
      entradas: [],
      saidas: [],
      mdiPlus,
      mdiMinus,
    }
  },
  methods: {
    getDashboard() {
      this.$http.get(
        'dashboard',
        res => {
          this.entradas = res.data.entradas
          this.saidas = res.data.saidas
        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao carregar Entradas e Saídas!',
            color: 'error white--text',
          })
          console.error(err)
        },
      )
    },
  },
  mounted() {
    this.getDashboard()
  },
}
</script>
