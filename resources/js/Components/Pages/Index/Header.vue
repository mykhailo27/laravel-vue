<script setup>

import TextInput from "@/Components/TextInput.vue";
import Link from "@/Components/Link.vue";
import {router} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import debounce from "lodash/debounce";

const props = defineProps({
    link: {
        type: Object,
    },
    filters: {
        type: Object
    },
    can_create: {
        type: Boolean
    }
})

const search = ref(props.filters.search ?? '')

watch(search, debounce(value => {
    router.get(location.href, {
        search: value
    }, {
        preserveState: true,
        onError: (error => console.log(error)),
    })
}, 300))

</script>

<template>
    <div class="flex justify-between">
        <!-- table search  -->
        <TextInput type="search" v-model="search" id="search-input" class="focus:border-0" placeholder="Search . . ." autofocus/>

        <div class="flex gap-1">
            <!-- extra actions  -->
            <slot name="actions"/>

            <Link v-if="can_create" :href="link.url"
                  class="bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ link.name }}
            </Link>
        </div>
    </div>
</template>

<style scoped>

</style>
