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
    <div class="flex items-start">
        <ul
            class="mr-4 flex list-none flex-col flex-wrap pl-0"
            role="tablist"
            data-te-nav-ref>
            <slot name="pill-tabs"/>
        </ul>

        <!--Pills content-->
        <div class="my-2">
            <slot name="pill-contents" />
        </div>
    </div>
</template>

<style scoped>

</style>
