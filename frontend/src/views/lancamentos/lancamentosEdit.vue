<template>
  <v-row justify="center">
    <v-dialog v-model="dialogEdit" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="text-h5">Novo Lançamento</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col cols="6">
                  <v-select
                    :rules="[v => !!v || 'Selecione um tipo de lançamento']"
                    @change="getCategorias()"
                    v-model="tipo_lancamento"
                    :items="['Entrada', 'Saída']"
                    label="Tipo"
                    dense
                  ></v-select>
                </v-col>
                <v-col cols="6" v-if="tipo_lancamento">
                  <v-select
                    v-model="lancamento.cliente_id"
                    :items="clientes"
                    item-text="nome"
                    item-value="id"
                    label="Cliente"
                    dense
                  ></v-select>
                </v-col>
                <v-col cols="6" v-if="tipo_lancamento">
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
                <v-col cols="6" v-if="lancamento.conta_id">
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
                    <v-col cols="4" v-if="lancamento.recorrencia == true">
                      <v-text-field
                        type="number"
                        min="0"
                        label="Parcelas"
                        v-model="lancamento.parcelas"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="4">
                      <v-dialog ref="dialog" v-model="modal" :return-value.sync="date" persistent width="290px">
                        <template v-slot:activator="{ on, attrs }">
                          <v-text-field
                            v-model="dateFormatted"
                            label="Data de Referência"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            @blur="date = parseDate(dateFormatted)"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker locale="pt-br" v-model="date">
                          <v-spacer></v-spacer>
                          <v-btn text color="primary" @click="modal = false"> Cancelar </v-btn>
                          <v-btn text color="primary" @click="$refs.dialog.save(date)"> OK </v-btn>
                        </v-date-picker>
                      </v-dialog>
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
                <v-btn color="error darken-1" text @click="excluir(), $emit('closeEdit')"> Excluir </v-btn>
              </v-col>
              <v-col align="end">
                <v-btn color="blue darken-1" text @click="$emit('closeEdit')"> Cancelar </v-btn>
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
    dialogEdit: { type: Boolean, default: false },
  },
  data() {
    return {
      lancamento: {},
      contas: {},
      clientes: {},
      categorias: [],
      tipo_lancamento: null,
      value: null,
      focus: false,
      disabled: false,

      modal: false,

      valid: true,

      date: new Date(Date.now() - new Date().getTimezoneOffset() * 60000).toISOString().substr(0, 10),
      dateFormatted: this.formatDate(
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
        this.lancamento.data_referencia = this.date
        this.lancamento.parcelas = parseInt(this.lancamento.parcelas)
        this.$http.put(
          'fluxos',
          this.lancamento.id,
          this.lancamento,
          res => {
            this.$emit('closeEdit')

            eventbus.$emit('updateLancamentos')
            
          },
          err => console.error(err),
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
          this.$emit('closeEdit')
        },
        err => console.error(err),
      )
    },
    getContas() {
      this.$http.get(
        'contas',
        res => {
          this.contas = res.data.data
        },
        err => console.error(err),
      )
    },
    getClientes() {
      this.$http.get(
        'clientes',
        res => {
          this.clientes = res.data.data
        },
        err => console.error(err),
      )
    },
    getCategorias(id) {
      this.$http.get(
        `categorias/${id}`,
        res => {
          this.categorias = res.data.data
        },
        err => console.error(err),
      )
    },
    formatDate(date) {
      if (!date) return null

      const [year, month, day] = date.split('-')
      return `${day}/${month}/${year}`
    },
    parseDate(date) {
      if (!date) return null

      const [month, day, year] = date.split('/')
      return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
    },
  },

  computed: {
    computedDateFormatted() {
      return this.formatDate(this.date)
    },
  },

  watch: {
    date(val) {
      this.dateFormatted = this.formatDate(this.date)
    },
  },
  mounted() {
    this.getContas()
    this.getClientes()

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
      this.getCategorias(lancamento.categoria_id)
      this.$emit('openEdit')
    })
  },
}
</script>