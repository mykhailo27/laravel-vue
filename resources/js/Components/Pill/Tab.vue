<script setup>

import {computed} from "vue";

const props = defineProps({
    tab: {
        type: Object,
        required: true
    },
    disabled: {
        type: Boolean,
        default: false
    }
});

const tab_disabled_class = computed(() => {
    return {
        true: 'pointer-events-none bg-neutral-200 text-neutral-400 dark:bg-neutral-600 dark:text-neutral-500',
        false: 'bg-neutral-100 text-neutral-500 data-[te-nav-active]:!bg-primary-100 data-[te-nav-active]:text-primary-700 dark:bg-neutral-700 dark:text-white dark:data-[te-nav-active]:text-primary-700',
    }[props.disabled];
});

</script>

<template>
    <a
        :href="props.tab.content_href"
        class="my-2 block rounded px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight"
        :class="tab_disabled_class"
        :id="props.tab.id"
        data-te-toggle="pill"
        :data-te-target="props.tab.content_href"
        role="tab"
        :aria-controls="props.tab.content_id"
    >{{ props.tab.name }}</a
    >
</template>

<style scoped>

</style>
