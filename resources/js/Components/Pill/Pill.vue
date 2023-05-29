<script setup>
// Initialization for ES Users
import {Tab, initTE} from "tw-elements";
import {onMounted} from "vue";

onMounted(function () {
    initTE({ Tab });
})

</script>

<template>
    <!--Pills navigation-->
    <ul
        class="mb-4 flex list-none flex-col flex-wrap gap-0 md:gap-2 md:flex-row"
        id="pills-tab"
        role="tablist"
        data-te-nav-ref>
        <slot name="pill-tabs"/>
    </ul>

    <!--Pills content-->
    <slot name="pill-contents" />
</template>

<style scoped>

</style>
