<script setup>

import {Link} from '@inertiajs/vue3';

defineProps({
    href: {
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
    <Link :href="href"
          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 gap-2 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
          data-te-sidenav-link-ref data-te-ripple-init data-te-ripple-color="primary">
        <slot name="icon"/>
        <span
            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
            data-te-sidenav-slim="false">{{ name }}</span>
    </Link>
</template>

<style scoped>

</style>
