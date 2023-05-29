<script setup>

defineProps({
    tab: {
        type: Object,
        required: true
    },
});

</script>

<template>
    <a
        :href="tab.content_href"
        class="my-2 block rounded bg-neutral-100 px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 data-[te-nav-active]:!bg-primary-100 data-[te-nav-active]:text-primary-700 dark:bg-neutral-700 dark:text-white dark:data-[te-nav-active]:text-primary-700"
        :id="tab.id"
        data-te-toggle="pill"
        :data-te-target="tab.content_href"
        role="tab"
        :aria-controls="tab.content_id"
        :aria-selected="tab.false"
    >{{ tab.name }}</a
    >
</template>

<style scoped>

</style>
