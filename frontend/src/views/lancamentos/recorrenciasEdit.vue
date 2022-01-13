<template>
  <v-row justify="center">
    <v-dialog v-model="dialogEditRecorrencias" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="text-h5">Editar Recorrência</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col cols="4">
                  <v-text-field-money
                    v-model="recorrencia.valor"
                    label="Valor"
                    v-bind:properties="{
                      prefix: 'R$',
                      readonly: false,
                      disabled: disabled,
                      outlined: false,
                      clearable: true,
                      placeholder: ' ',
                    }"
                    v-bind:options="{
                      humanMask: '###.###.##0,00',
                      machineMask: '########0.00',
                      empty: null,
                    }"
                    v-bind:focus="focus"
                    v-on:focus="focus = false"
                  />
                </v-col>
                <v-col cols="4">
                  <v-dialog
                    ref="dialogDataReferencia"
                    v-model="modalDataReferencia"
                    :return-value.sync="dataReferencia"
                    persistent
                    width="290px"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        v-model="dataReferenciaFormatada"
                        :label="recorrencia.recorrencia == true ? 'Data de Inicio' : 'Data de Referência'"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        @blur="dataReferencia = parseDate(dataReferenciaFormatada)"
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker locale="pt-br" v-model="dataReferencia" scrollable>
                      <v-spacer></v-spacer>
                      <v-btn text color="primary" @click="modalDataReferencia = false"> Cancelar </v-btn>
                      <v-btn text color="primary" @click="$refs.dialogDataReferencia.save(dataReferencia)"> OK </v-btn>
                    </v-date-picker>
                  </v-dialog>
                </v-col>
                <v-col cols="4">
                  <v-switch
                    v-model="recorrencia.status"
                    :label="recorrencia.status == true ? 'Pago' : 'Pendente'"
                  ></v-switch>
                </v-col>
              </v-row>
            </v-form>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-row justify="space-between">
            <v-col>
              <v-btn color="error darken-1" text @click="excluir(), $emit('closeEditRecorrencias')"> Excluir </v-btn>
            </v-col>
            <v-col align="end">
              <v-btn color="grey darken-1" text @click="$emit('closeEditRecorrencias')"> Cancelar </v-btn>
              <v-btn color="primary" text @click="salvar()"> Salvar </v-btn>
            </v-col>
          </v-row>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import Money from '@/components/Money.vue'

import { eventbus } from '@/main.js'

export default {
  components: {
    'v-text-field-money': Money,
  },
  props: {
    dialogEditRecorrencias: { type: Boolean, default: false },
  },
  data() {
    return {
      recorrencia: {},
      contas: {},
      clientes: {},
      categorias: [],
      value: null,
      focus: false,
      disabled: false,

      modalDataReferencia: false,

      valid: true,

      dataReferencia: new Date(Date.now() - new Date().getTimezoneOffset() * 60000).toISOString().substr(0, 10),
      dataReferenciaFormatada: this.formatDate(
        new Date(Date.now() - new Date().getTimezoneOffset() * 60000).toISOString().substr(0, 10),
      ),
    }
  },
  methods: {
    salvar() {
      if (this.$refs.form.validate() === true) {
        this.recorrencia.data_referencia = this.dataReferencia

        this.$http.put(
          'recorrencias',
          this.recorrencia.id,
          this.recorrencia,
          res => {
            this.$emit('closeEditRecorrencias')
            eventbus.$emit('updateRecorrencias')
            eventbus.$emit('makeSnackbar', {
              text: 'Lançamento recorrente editado com sucesso!',
              color: 'light-green darken-1 white--text',
            })
          },
          err => {
            eventbus.$emit('makeSnackbar', {
              text: 'Erro ao editar Lançamento Recorrente!',
              color: 'error white--text',
            })
            console.error(err)
          },
        )
      }
    },
    excluir() {
      this.$http.delete(
        'recorrencias',
        this.recorrencia.id,
        res => {
          eventbus.$emit('updateRecorrencias')
          this.$emit('closeEditRecorrenciasRecorrencias')
          eventbus.$emit('makeSnackbar', {
            text: 'Lançamento recorrente excluído com sucesso!',
            color: 'light-green darken-1 white--text',
          })
        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao editar Lançamento recorrente!',
            color: 'error white--text',
          })
          console.error(err)
        },
      )
    },
    getContas() {
      this.$http.get(
        'contas',
        res => {
          this.contas = res.data.data
        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao carregar Contas!',
            color: 'error white--text',
          })
          console.error(err)
        },
      )
    },
    getClientes() {
      this.$http.get(
        'clientes',
        res => {
          this.clientes = res.data.data
        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao carregar Clientes!',
            color: 'error white--text',
          })
          console.error(err)
        },
      )
    },
    getCategorias(id) {
      this.$http.get(
        `categorias/${id}`,
        res => {
          this.categorias = res.data.data
        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao carregar Categorias!',
            color: 'error white--text',
          })
          console.error(err)
        },
      )
    },
    formatDate(date) {
      if (!date) return null

      const [year, month, day] = date.split('-')
      return `${day}/${month}/${year}`
    },
    parseDate(date) {
      if (!date) return null

      const [day, month, year] = date.split('/')
      return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
    },
  },

  computed: {
    computedDataReferenciaFormatada() {
      return this.formatDate(this.dataReferencia)
    },
  },

  watch: {
    dataReferencia(val) {
      this.dataReferenciaFormatada = this.formatDate(this.dataReferencia)
    },
  },
  mounted() {
    this.getContas()
    this.getClientes()

    eventbus.$on('editRecorrencias', recorrencia => {
      this.recorrencia.id = recorrencia.id
      this.recorrencia.valor = recorrencia.valor
      this.recorrencia.data_referencia = recorrencia.data_referencia
      this.recorrencia.status = recorrencia.status
      this.dataReferencia = this.recorrencia.data_referencia
      console.log(recorrencia)
      this.$emit('openEditRecorrencias')
    })
  },
}
</script>