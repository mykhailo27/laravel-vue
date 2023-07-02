<script setup>

import {Collapse, initTE,} from "tw-elements";
import {onMounted} from "vue";

onMounted(() => {
    initTE({Collapse});
})

</script>

<template>
    <div>
        <slot />
    </div>
</template>

<style scoped>

</style>
