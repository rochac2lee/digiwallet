<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="text-h5">Nova Conta</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="8">
                <v-text-field label="Nome da Conta" v-model="conta.nome" required></v-text-field>
              </v-col>
              <v-col cols="4">
                <v-text-field-money
                  v-model="conta.saldo"
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
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey darken-1" text @click="$emit('close')"> Cancelar </v-btn>
          <v-btn color="blue darken-1" text @click="salvar()"> Salvar </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import Money from '@/components/Money.vue'

export default {
  components: {
    'v-text-field-money': Money,
  },
  props: {
    dialog: { type: Boolean, default: false },
  },
  data() {
    return {
      conta: {},
      value: null,
      focus: false,
      disabled: false,
    }
  },
    methods: {
      salvar() {
        this.$http.post(
          'contas',
          this.conta,
          res => {
            console.log(res.data.data)
            this.$emit('close')
            this.$emit('update')
          },
          err => console.error(err),
        )
      },
    },
}
</script>