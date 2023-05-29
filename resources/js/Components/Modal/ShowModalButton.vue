<script setup>
import {initTE, Ripple} from "tw-elements";
import {onMounted} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

onMounted(function () {
    initTE({Ripple});
})
</script>

<template>
    <PrimaryButton
        type="button"
        data-te-toggle="modal"
        data-te-ripple-init
        data-te-ripple-color="light">
        <slot/>
    </PrimaryButton>
</template>

<style scoped>

</style>
