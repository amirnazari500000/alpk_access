<script setup>
import { useTheme } from 'vuetify'
import { hexToRgb } from '@layouts/utils'


const { global } = useTheme()
</script>

<template>
  <VApp :style="`--v-global-theme-primary: ${hexToRgb(global.current.value.colors.primary)}`">
    <RouterView/>
  </VApp>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    computed: {
        ...mapGetters({user: 'USER'}) // access using this.user
    },
    mounted() {
        this.$store.dispatch('fetchData');
    },
}
</script>



