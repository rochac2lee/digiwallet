<template>
  <v-row justify="center">
    <v-dialog v-model="dialogEditLancamentos" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="text-h5">Editar Lançamento</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col :cols="clientesHabilitado == false ? '6' : '4'">
                  <v-select
                    :rules="[v => !!v || 'Selecione um tipo de lançamento']"
                    @change="getCategorias()"
                    v-model="tipo_lancamento"
                    :items="['Entrada', 'Saída']"
                    label="Tipo"
                    dense
                  ></v-select>
                </v-col>
                <v-col cols="6" v-if="tipo_lancamento && clientesHabilitado == false">
                  <v-select
                    v-model="lancamento.cliente_id"
                    :items="clientes"
                    item-text="nome"
                    item-value="id"
                    label="Cliente"
                    dense
                  ></v-select>
                </v-col>
                <v-col :cols="clientesHabilitado == false ? '6' : '4'" v-if="tipo_lancamento">
                  <v-select
                    :rules="[v => !!v || 'Selecione uma conta']"
                    v-model="lancamento.conta_id"
                    :items="contas"
                    item-text="nome"
                    item-value="id"
                    label="Conta"
                    dense
                  ></v-select>
                </v-col>
                <v-col :cols="clientesHabilitado == false ? '6' : '4'" v-if="lancamento.conta_id">
                  <v-select
                    :rules="[v => !!v || 'Selecione uma categoria']"
                    :items="categorias"
                    v-model="lancamento.categoria_id"
                    item-text="categoria"
                    item-value="id"
                    label="Categoria"
                    dense
                  ></v-select>
                </v-col>
                <v-container v-if="tipo_lancamento && lancamento.conta_id && lancamento.categoria_id">
                  <v-row>
                    <v-col cols="8">
                      <v-text-field
                        :rules="[v => !!v || 'Informe um título']"
                        label="Título"
                        v-model="lancamento.titulo"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="4">
                      <v-text-field-money
                        v-model="lancamento.valor"
                        label="Saldo Inicial"
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
                      <v-switch v-model="lancamento.recorrencia" label="Recorrente"></v-switch>
                    </v-col>
                    <v-col cols="4">
                      <v-dialog
                        ref="dialogDataInicio"
                        v-model="modalDataInicio"
                        :return-value.sync="dataInicio"
                        persistent
                        width="290px"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <v-text-field
                            v-model="dataInicioFormatada"
                            :label="lancamento.recorrencia == true ? 'Data de Inicio' : 'Data de Referência'"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            @blur="dataInicio = parseDate(dataInicioFormatada)"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker locale="pt-br" v-model="dataInicio" scrollable>
                          <v-spacer></v-spacer>
                          <v-btn text color="primary" @click="modalDataInicio = false"> Cancelar </v-btn>
                          <v-btn text color="primary" @click="$refs.dialogDataInicio.save(dataInicio)"> OK </v-btn>
                        </v-date-picker>
                      </v-dialog>
                    </v-col>
                    <v-col cols="4" v-if="lancamento.recorrencia == true">
                      <v-dialog
                        ref="dialogDataTermino"
                        v-model="modalDataTermino"
                        :return-value.sync="dataTermino"
                        persistent
                        width="290px"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <v-text-field
                            v-model="dataTerminoFormatada"
                            label="Data de Término"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            @blur="dataTermino = parseDate(dataTerminoFormatada)"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker locale="pt-br" v-model="dataTermino" scrollable>
                          <v-spacer></v-spacer>
                          <v-btn text color="primary" @click="modalDataTermino = false"> Cancelar </v-btn>
                          <v-btn text color="primary" @click="$refs.dialogDataTermino.save(dataTermino)"> OK </v-btn>
                        </v-date-picker>
                      </v-dialog>
                    </v-col>
                    <v-col cols="4" v-if="lancamento.recorrencia == false">
                      <v-switch
                        v-model="lancamento.status"
                        :label="lancamento.status == 2 || lancamento.status == true ? 'Pago' : 'Pendente'"
                      ></v-switch>
                    </v-col>
                  </v-row>
                </v-container>
              </v-row>
            </v-form>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-row justify="space-between">
            <v-col>
              <v-btn color="error darken-1" text @click="excluir(), $emit('closeEditLancamentos')"> Excluir </v-btn>
            </v-col>
            <v-col align="end">
              <v-btn color="grey darken-1" text @click="$emit('closeEditLancamentos')"> Cancelar </v-btn>
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
    dialogEditLancamentos: { type: Boolean, default: false },
  },
  data() {
    return {
      lancamento: {
        status: null,
      },
      contas: {},
      clientes: {},
      categorias: [],
      tipo_lancamento: null,
      value: null,
      focus: false,
      disabled: false,
      clientesHabilitado: false,

      modalDataInicio: false,
      modalDataTermino: false,

      valid: true,

      dataInicio: new Date(Date.now() - new Date().getTimezoneOffset() * 60000).toISOString().substr(0, 10),
      dataTermino: new Date(Date.now() - new Date().getTimezoneOffset() * 60000).toISOString().substr(0, 10),
      dataInicioFormatada: this.formatDate(
        new Date(Date.now() - new Date().getTimezoneOffset() * 60000).toISOString().substr(0, 10),
      ),
      dataTerminoFormatada: this.formatDate(
        new Date(Date.now() - new Date().getTimezoneOffset() * 60000).toISOString().substr(0, 10),
      ),
    }
  },
  methods: {
    salvar() {
      if (this.$refs.form.validate() === true) {
        switch (this.tipo_lancamento) {
          case 'Entrada':
            this.lancamento.tipo_fluxo = 'entrada'
            break

          case 'Saída':
            this.lancamento.tipo_fluxo = 'saida'
            break
        }
        this.lancamento.status == true || this.lancamento.status == 2 ? (this.lancamento.status = 2) : (this.lancamento.status = 0)
        this.lancamento.data_inicio = this.dataInicio
        this.lancamento.data_fim = this.dataTermino

        this.$http.put(
          'fluxos',
          this.lancamento.id,
          this.lancamento,
          res => {
            eventbus.$emit('updateLancamentos')
            this.$emit('closeEditLancamentos')
            eventbus.$emit('makeSnackbar', {
              text: 'Lançamento editado com sucesso!',
              color: 'light-green darken-1 white--text',
            })
          },
          err => {
            eventbus.$emit('makeSnackbar', {
              text: 'Erro ao editar Lançamento!',
              color: 'error white--text',
            })
            console.error(err)
          },
        )
      }
    },
    excluir() {
      this.$http.delete(
        'fluxos',
        this.lancamento.id,
        res => {
          this.$emit('close')

          eventbus.$emit('updateLancamentos')
          this.$emit('closeEditLancamentos')
          eventbus.$emit('makeSnackbar', {
            text: 'Lançamento excluído com sucesso!',
            color: 'light-green darken-1 white--text',
          })
        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao excluir Lançamento!',
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
            text: 'Erro ao carregar Cliente!',
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
    computedDataInicioFormatada() {
      return this.formatDate(this.dataInicio)
    },
    computedDataTerminoFormatada() {
      return this.formatDate(this.dataTermino)
    },
  },

  watch: {
    dataInicio(val) {
      this.dataInicioFormatada = this.formatDate(this.dataInicio)
    },
    dataTermino(val) {
      this.dataTerminoFormatada = this.formatDate(this.dataTermino)
    },
  },
  mounted() {
    this.getContas()

    this.$cookies.get('habilitar_clientes') == false ? (this.clientesHabilitado = true) : this.getClientes()

    eventbus.$on('editLancamentos', lancamento => {
      switch (lancamento.tipo_fluxo) {
        case 'entrada':
          this.tipo_lancamento = 'Entrada'
          break

        case 'saida':
          this.tipo_lancamento = 'Saída'
          break
      }
      this.lancamento = lancamento
      this.dataInicio = this.lancamento.data_inicio
      this.dataTermino = this.lancamento.data_fim
      this.lancamento.status == 2 ? (this.lancamento.status = 2) : (this.lancamento.status = 0)
      this.getCategorias(lancamento.categoria_id)
      this.$emit('openEditLancamentos')
    })
  },
}
</script>
