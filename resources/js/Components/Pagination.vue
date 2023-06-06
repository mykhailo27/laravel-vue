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
        <div v-if="links.length > 3" class="flex flex-wrap -mb-1">
            <template v-for="(link, key) in links" :key="key">
                <div v-if="link.url === null" class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                     v-html="link.label"/>
                <Link v-else
                      class="mb-1 mr-1 px-4 py-3 focus:text-indigo-500 text-sm leading-4 hover:bg-red border focus:border-indigo-500 rounded"
                      :class="{ 'bg-white': link.active }" :href="link.url" v-html="link.label"/>
            </template>
        </div>
    </div>
</template>
