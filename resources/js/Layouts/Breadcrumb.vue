<script setup>

import Link from "@/Components/Link.vue";

defineProps({
    links: {
        type: Array,
    },
});

</script>

<template>
    <nav v-if="links.length > 0" class="bg-grey-light w-full rounded-md">
        <ol class="list-reset flex text-sm items-center capitalize">
            <li v-for="(link, index) in links">
                <Link :content-classes="null" v-if="links.length > index + 1" :href="route(link.route)">
                    {{ link.name }}
                    <span class="px-2 text-neutral-500 dark:text-neutral-400">/</span>
                </Link>
                <span v-else class="text-neutral-500 dark:text-neutral-400">{{ link.name }}</span>
            </li>
        </ol>
    </nav>
</template>

<style scoped>

</style>
