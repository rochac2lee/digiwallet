<template>
  <div>
    <v-text-field
      v-model="cmpValue"
      v-bind:label="label"
      v-bind="properties"
      v-bind:maxlength="humanMask.length"
      v-on:keypress="keyPress"
      v-on:blur="$emit('blur')"
      v-on:change="$emit('change')"
      v-on:click="$emit('click')"
      v-on:focus="$emit('focus')"
      v-on:keydown="$emit('keydown')"
      v-on:mousedown="$emit('mousedown')"
      v-on:mouseup="$emit('mouseup')"
      ref="ref"
    ></v-text-field>
  </div>
</template>

<script>
export default {
  model: { prop: "value", event: "input" },
  props: {
    value: {
      type: [String, Number],
      default: "0",
    },
    label: {
      type: String,
      default: "",
    },
    focus: {
      type: Boolean,
      default: false,
    },
    properties: {
      type: Object,
      default: function() {
        return {};
      },
    },
    options: {
      type: Object,
      default: function() {
        return {
          machineMask: "########",
          empty: "",
          applyAfter: false,
        };
      },
    },
  },
  data: () => ({
    humanMask: "##.###-###",
  }),
  /*
   v-model="cmpValue": Dessa forma, ao digitar, o valor Ã© atualizado automaticamente no componente pai.
   O valor digitado entra pelo newValue do Set Ã© emitido para o componente pai, retorna pelo get e pÃ¡ra.
  */
  computed: {
    cmpValue: {
      get: function() {
        return this.humanFormat(this.value);
      },
      set: function(newValue) {
        this.$emit("input", this.machineFormat(newValue));
      },
    },
  },
  watch: {
    focus: {
      handler() {
        if (this.focus) {
          this.$nextTick(() => {
            setTimeout(() => {
              this.$refs.ref.focus();
            }, 300);
          });
        }
      },
      immediate: true,
    },
  },
  methods: {
    humanFormat: function(value) {
      if (value) {
        value = this.formatValue(value, this.humanMask);
      } else {
        value = this.options.empty;
      }
      return value;
    },

    machineFormat(value) {
      if (value) {
        value = this.formatValue(value, this.options.machineMask);
        if (value === "") {
          value = this.options.empty;
        }
        // Apply the mask only only after filling
        if (this.options.applyAfter) {
          if (value.length !== this.options.machineMask.length) {
            value = this.options.empty;
          } else {
            // Event sended after filling the mask
            this.$emit("masked");
          }
        }
      } else {
        value = this.options.empty;
      }
      return value;
    },

    formatValue: function(value, mask) {
      return this.formatCpf(value, mask);
    },

    formatCpf: function(value, mask) {
      value = this.clearValue(value);
      let result = "";
      let count = 0;
      if (value) {
        let arrayValue = value.toString().split("");
        let arrayMask = mask.toString().split("");
        for (var i = 0; i < arrayMask.length; i++) {
          if (i < arrayValue.length + count) {
            if (arrayMask[i] === "#") {
              result = result + arrayValue[i - count];
            } else {
              result = result + arrayMask[i];
              count++;
            }
          }
        }
      }
      return result;
    },

    keyPress($event) {
      // console.log($event.keyCode); //keyCodes value
      let keyCode = $event.keyCode ? $event.keyCode : $event.which;
      // if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) {
      if (keyCode < 48 || keyCode > 57) {
        // 46 is dot
        $event.preventDefault();
      }
    },

    clearValue: function(value) {
      let result = "";
      if (value) {
        let arrayValue = value.toString().split("");
        for (var i = 0; i < arrayValue.length; i++) {
          if (this.isInteger(arrayValue[i])) {
            result = result + arrayValue[i];
          }
        }
      }
      return result;
    },

    isInteger(value) {
      let result = false;
      if (Number.isInteger(parseInt(value))) {
        result = true;
      }
      return result;
    },
  },
};
</script>
