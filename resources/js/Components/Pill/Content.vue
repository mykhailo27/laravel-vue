<script setup>

defineProps({
    content: {
        type: Object,
        required: true
    }
});

</script>

<template>
    <div
        class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
        :id="content.id"
        role="tabpanel"
        :aria-labelledby="content.tab_id">
        <slot />
    </div>
</template>

<style scoped>

</style>
