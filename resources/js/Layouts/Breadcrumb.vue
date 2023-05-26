<script setup>

import Link from "@/Components/Link.vue";
import {onMounted, ref} from "vue";
import {router} from "@inertiajs/vue3";

const links = ref([])

function updateVisitedLinks() {
    let current_link = '';

    return location.pathname.split('/')
        .filter(crumb => crumb !== '')
        .map(crumb => {
            current_link += `${crumb}`;

            return {
                name: crumb,
                route: current_link
            }
        })
}

onMounted(function () {
    links.value = updateVisitedLinks();
})

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
