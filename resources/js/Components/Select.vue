<script setup>

import {initTE, Select} from "tw-elements";
import {onMounted, ref} from "vue";

defineProps({
    options: {
        type: Array,
        required: true
    },
    label: {
        type: String,
        default: 'select'
    },
    modelValue: {
        default: 'Select Option'
    }
})

defineEmits(['update:modelValue']);

const select = ref(null);

onMounted(function () {
    initTE({Select});
})

</script>

<template>
    <select @change="$emit('update:modelValue', $event.target.value)" ref="select"
            data-te-select-init data-te-select-auto-select="true" class="capitalize"
            :value="modelValue">
        <option v-for="option in options" :value="option.value">
            {{ option.name }}
        </option>
    </select>
    <label data-te-select-label-ref class="capitalize">{{ label }}</label>
</template>

<style scoped>

</style>
