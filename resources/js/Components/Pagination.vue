<script setup>

import Link from "@/Components/Link.vue";

defineProps({
    links: {
        type: Array,
        required: true
    },
    from: {
        type: Number,
    },
    to: {
        type: Number
    },
    total: {
        type: Number
    },
})

</script>

<template>
    <div class="grid justify-items-center">
        <span class="text-sm text-gray-700 dark:text-gray-400">
              Showing
           <span class="font-semibold text-gray-900 dark:text-white">{{ from }}</span>
              to
           <span class="font-semibold text-gray-900 dark:text-white">{{ to }}</span>
              of
           <span class="font-semibold text-gray-900 dark:text-white">{{ total }}</span>
              Entries
        </span>
        <nav aria-label="table pagination">
            <ul class="list-style-none flex items-center">
                <li v-for="(link, key) in links" :key="key" :aria-current="link.active ? 'page' : null">
                    <a v-if="link.url === null" v-html="link.label"
                       class="pointer-events-none relative block rounded-full bg-transparent px-3 py-1.5 text-sm text-neutral-500 transition-all duration-300 dark:text-neutral-400"
                    />
                    <Link v-else-if="link.active" :href="link.url" content-classes="px-3 py-1.5"
                          class="relative block rounded-full bg-primary-100 px-3 py-1.5 text-sm font-medium text-primary-700 transition-all duration-300">
                        {{ link.label }}
                        <span
                            class="absolute -m-px h-px w-px overflow-hidden whitespace-nowrap border-0 p-0 [clip:rect(0,0,0,0)]">
                            (current)
                        </span>
                    </Link>
                    <Link v-else :href="link.url" v-html="link.label" content-classes="px-3 py-1.5"
                          class="relative block rounded-full bg-transparent px-3 py-1.5 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100  dark:text-white dark:hover:bg-neutral-700 dark:hover:text-white"
                    />
                </li>
            </ul>
        </nav>
    </div>
</template>

