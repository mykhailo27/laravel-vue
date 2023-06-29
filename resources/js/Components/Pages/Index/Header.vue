<script setup>

import TextInput from "@/Components/TextInput.vue";
import Link from "@/Components/Link.vue";
import {router} from "@inertiajs/vue3";
import {ref, watch} from "vue";

const props = defineProps({
    link: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object
    }
})

const search = ref(props.filters.search ?? '')

watch(search, value => {
    router.get(location.href, {
        search: value
    }, {
        preserveState: true,
        onError: (error => console.log(error)),
    })
})

</script>

<template>
    <div class="flex justify-between">
        <!-- table search  -->
        <TextInput type="search" v-model="search" id="search-input" class="focus:border-0" placeholder="Search . . ." autofocus/>

        <Link :href="link.url"
              class="bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            {{ link.name }}
        </Link>
    </div>
</template>

<style scoped>

</style>
