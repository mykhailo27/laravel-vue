<script setup>

import {initTE, Select} from "tw-elements";
import {onMounted} from "vue";

defineProps({
    options: {
        type: Array,
        required: true
    },
    label: {
        type: String,
        default: 'select'
    },
    default_option: {
        type: Object
    }
})

onMounted(function () {
    initTE({Select});
})

</script>

<template>
    <select data-te-select-init data-te-select-auto-select="true" class="capitalize"
            v-model="default_option.value">
        <option v-for="option in options" value="{{ option.value }}">
            {{ option.name }}
        </option>
    </select>
    <label data-te-select-label-ref class="capitalize">{{ label }}</label>
</template>

<style scoped>

</style>
