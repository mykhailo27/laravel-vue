<script setup>

import { Select, initTE } from "tw-elements";
import {onMounted} from "vue";

defineProps({
    options: {
        type: Array,
        required: true
    },
    label: {
        type: String,
        default: 'select'
    }
})

onMounted(function () {
    initTE({ Select });
})

</script>

<template>
    <select data-te-select-init data-te-select-auto-select="true" class="capitalize">
        <option v-for="option in options" value="{{ option.value }}">{{ option.name }}</option>
    </select>
    <label data-te-select-label-ref class="capitalize">{{ label }}</label>
</template>

<style scoped>

</style>
