<script setup>

import {Link} from '@inertiajs/vue3';

defineProps({
    route_path: {
        type: String,
        required: true
    },
    name: {
        type: String,
        required: true
    }
})

</script>

<template>
    <Link :href="route_path" :class="{'bg-slate-100 text-inherit outline-none active:bg-white/10': $page.url.startsWith(route_path)}"
          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 gap-2 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
          data-te-sidenav-link-ref data-te-ripple-init data-te-ripple-color="primary">
        <slot name="icon"/>
        <span
            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden capitalize"
            data-te-sidenav-slim="false">{{ name }}</span>
    </Link>
</template>

<style scoped>

</style>
