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
        <nav aria-label="page navigation" v-if="links.length > 3">
            <ul class="list-style-none flex gap-1">
                <li v-for="(link, key) in links" :key="key" :aria-current="{'page': link.active}">
                    <a v-if="link.url === null" v-html="link.label"
                       class="pointer-events-none relative block rounded bg-transparent px-3 py-1.5 text-sm text-neutral-500 transition-all duration-300 dark:text-neutral-400"
                    />

                    <Link v-else :href="link.url" v-html="link.label"
                          class="relative block rounded-full bg-transparent text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100 dark:text-white dark:hover:bg-neutral-700 dark:hover:text-white"
                          :class="{'bg-primary-100 font-medium text-primary-700': link.active}"
                          content-classes="px-3 py-1.5"/>
                </li>
            </ul>
        </nav>
    </div>
</template>
