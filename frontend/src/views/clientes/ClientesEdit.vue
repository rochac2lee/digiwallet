<template>
  <v-row justify="center">
    <v-dialog v-model="dialogEdit" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="text-h5">Novo Cliente</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col cols="2">
                  <v-select
                    :rules="[v => !!v || 'Tipo de Cliente']"
                    v-model="cliente.tipo_cliente"
                    :items="['PJ', 'PF']"
                    label="Tipo"
                  ></v-select>
                </v-col>
                <v-col cols="4" v-if="cliente.tipo_cliente === 'PF'">
                  <v-text-field-cpf
                    v-model="cliente.cpf_cnpj"
                    label="CPF"
                    v-bind:properties="{
                      readonly: false,
                      disabled: false,
                      outlined: false,
                      clearable: false,
                      placeholder: '',
                    }"
                    v-bind:options="{
                      outputMask: '###########',
                      empty: null,
                      applyAfter: false,
                    }"
                  />
                </v-col>
                <v-col cols="4" v-if="cliente.tipo_cliente === 'PJ'">
                  <v-text-field-cnpj
                    v-model="cliente.cpf_cnpj"
                    label="CNPJ"
                    v-bind:properties="{
                      readonly: false,
                      disabled: false,
                      outlined: false,
                      clearable: false,
                    }"
                    v-bind:options="{
                      outputMask: '##############',
                      empty: null,
                      applyAfter: false,
                    }"
                  />
                </v-col>
                <v-col cols="6" v-if="cliente.tipo_cliente">
                  <v-text-field
                    :rules="[v => !!v || 'Informe um nome']"
                    label="Nome Completo"
                    v-model="cliente.nome"
                    required
                  ></v-text-field>
                </v-col>
                <v-container v-if="cliente.tipo_cliente">
                  <v-row>
                    <v-col cols="6">
                      <v-text-field-simplemask v-model="cliente.telefone" label="Telefone"
                        v-bind:properties="phone_properties" v-bind:options="phone_options" />
                    </v-col>
                    <v-col cols="6">
                      <v-text-field :rules="[v => !!v || 'Informe um email']" label="Email"
                        v-model="cliente.email" required></v-text-field>
                    </v-col>
                    <v-col cols="4">
                      <v-text-field-cep
                        v-model="cliente.cep"
                        @change="getEndereco()"
                        label="CEP"
                        v-bind:properties="{
                          disabled: false,
                          outlined: false,
                        }"
                        v-bind:options="{
                          machineMask: '########',
                          empty: null,
                          applyAfter: false,
                        }"
                      />
                    </v-col>
                    <v-col cols="5">
                      <v-text-field
                        :rules="[v => !!v || 'Informe um endereço']"
                        label="Endereço"
                        v-model="cliente.logradouro"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="3">
                      <v-text-field
                        :rules="[v => !!v || 'Informe um número']"
                        label="Número"
                        v-model="cliente.numero"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="4">
                      <v-text-field
                        :rules="[v => !!v || 'Informe um bairro']"
                        label="Bairro"
                        v-model="cliente.bairro"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="2">
                      <v-text-field
                        :rules="[v => !!v || 'Informe um estado']"
                        label="Estado"
                        v-model="cliente.estado_uf"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="6">
                      <v-text-field
                        :rules="[v => !!v || 'Informe uma cidade']"
                        label="Cidade"
                        v-model="cliente.cidade"
                        required
                      ></v-text-field>
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
              <v-btn color="grey darken-1" text @click="$emit('closeEdit')"> Cancelar </v-btn>
              <v-btn color="primary" text @click="salvar()"> Salvar </v-btn>
            </v-col>
          </v-row>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import Cep from '@/components/Cep.vue'
import Cpf from '@/components/Cpf.vue'
import Cnpj from '@/components/Cnpj.vue'
import SimpleMask from '@/components/SimpleMask.vue'

import { eventbus } from '@/main.js'

import axios from 'axios'

export default {
  components: {
    'v-text-field-cep': Cep,
    'v-text-field-cpf': Cpf,
    'v-text-field-cnpj': Cnpj,
    'v-text-field-simplemask': SimpleMask,
  },
  props: {
    dialogEdit: { type: Boolean, default: false },
  },
  data() {
    return {
      cliente: {
        cep: null,
        cpf_cnpj: null,
        logradouro: '',
        telefone: "",
        email: "",
      },
        phone_properties: {
        prefix: '',
        suffix: '',
        readonly: false,
        disabled: false,
        outlined: false,
        clearable: false,
        placeholder: '',
      },
      phone_options: {
        humanMask: '(##) #####-####',
        machineMask: '(##) #####-####',
        empty: null,
        applyAfter: false,
        alphanumeric: true,
        lowerCase: false,
      },
      value: null,
      focus: false,
      disabled: false,

      modal: false,

      valid: true,
    }
  },
  methods: {
    salvar() {
      if (this.$refs.form.validate() === true) {
        this.$http.put(
          'clientes',
          this.cliente.id,
          this.cliente,
          res => {
            eventbus.$emit('updateClientes')
            eventbus.$emit('makeSnackbar', {
              text: 'Cliente editado com sucesso!',
              color: 'light-green darken-1 white--text',
            })
            this.$emit('closeEdit')
          },
          err => {
            eventbus.$emit('makeSnackbar', {
              text: 'Erro ao editar Cliente!',
              color: 'error white--text',
            })
            console.error(err)
          },
        )
      }
    },
    excluir() {
      this.$http.delete(
        'clientes',
        this.cliente.id,
        res => {
          eventbus.$emit('updateClientes')
          eventbus.$emit('makeSnackbar', {
            text: 'Cliente excluído com sucesso!',
            color: 'light-green darken-1 white--text',
          })
          this.$emit('closeEdit')
        },
        err => {
          eventbus.$emit('makeSnackbar', {
            text: 'Erro ao excluir Cliente!',
            color: 'error white--text',
          })
          console.error(err)
        },
      )
    },
    getEndereco() {
      axios.get(`https://viacep.com.br/ws/${this.cliente.cep}/json/unicode/`).then(res => {
        console.log(res.data)

        this.cliente.logradouro = null
        this.cliente.bairro = null
        this.cliente.estado_uf = null
        this.cliente.cidade = null

        this.cliente.logradouro = res.data.logradouro
        this.cliente.bairro = res.data.bairro
        this.cliente.estado_uf = res.data.uf
        this.cliente.cidade = res.data.localidade
      })
    },
  },
  mounted() {
    eventbus.$on('editClientes', cliente => {
      switch (cliente.tipo_cliente) {
        case "Pessoa Física":
          cliente.tipo_cliente = "PF"
          break;
        case "Pessoa Jurídica":
          cliente.tipo_cliente = "PJ"
          break;
      }
      this.cliente = cliente
      this.$emit('openEdit')
    })
  },
}
</script>
