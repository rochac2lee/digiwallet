<template>
  <div class="text-center">
    <v-snackbar v-model="snackbar" right top :color="color" multi-line>
      {{ text }}
    </v-snackbar>
  </div>
</template>
<script>

import { eventbus } from '@/main.js'

export default {
  props: {
    snackbar: { type: Boolean, default: false },
  },
  data() {
    return {
      text: null,
      color: null,
    }
  },
  mounted() {
      eventbus.$on('makeSnackbar', configs => {
      this.text = configs.text
      this.color = configs.color
      this.$emit('openSnackbar')

      setTimeout(() => {
          this.$emit('closeSnackbar')
      }, 2000);
    })
  }
}
</script>