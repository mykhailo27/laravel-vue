<script setup>

defineProps({
    tab: {
        type: Object,
        required: true
    }
});

</script>

<template>
    <div
        class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
        :id="tab.content_id"
        role="tabpanel"
        :aria-labelledby="tab.id">
        <slot />
    </div>
</template>

<style scoped>

</style>
