<script setup>

defineProps({
    name: {
        type: String,
        required: true
    }
})

</script>

<template>
    <a
        class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
        data-te-sidenav-link-ref data-te-ripple-init data-te-ripple-color="primary">
        <i class="mr-2 fa-solid fa-file-invoice-dollar"></i>
        <span
            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
            data-te-sidenav-slim="false">{{ name}}</span>
        <span
            class="absolute right-0 ml-auto mr-[0.5rem] transition-transform duration-300 ease-linear motion-reduce:transition-none [&>svg]:text-gray-600 dark:[&>svg]:text-gray-300"
            data-te-sidenav-rotate-icon-ref>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                class="h-5 w-5">
            <path
                fill-rule="evenodd"
                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                clip-rule="evenodd"/>
            </svg>
        </span>
    </a>

    <ul
        class="!visible relative m-0 hidden list-none p-0 data-[te-collapse-show]:block "
        data-te-sidenav-collapse-ref>
        <slot name="items"/>
    </ul>
</template>

<style scoped>

</style>
