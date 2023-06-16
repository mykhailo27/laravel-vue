<script setup>

import TextInput from "@/Components/TextInput.vue";
import Link from "@/Components/Link.vue";
import {clearSearchTimer, startSearchTimer} from "@/Modules/TimeOutAction.js";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    link: {
        type: Object,
        required: true,
    },
    index_url: {
        type: String,
        required: true
    },
})

const submitSearch = (value) => {
    startSearchTimer(function (value) {

        router.get(props.index_url, {
            search: value
        }, {
            onFinish: () => {
                // todo set to the element here through vue
                document.querySelector('#search-input').value = value
            },
            onError: (error => console.log(error)),
        })

    }, value)
}

</script>

<template>
    <div class="flex justify-between">
        <!-- table search  -->
        <TextInput type="search" model-value="" id="search-input" class="focus:border-0" placeholder="Search . . ."
                   @update:modelValue="submitSearch"
                   @keydown="clearSearchTimer"/>

        <Link :href="link.url"
              class="bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            {{ link.name }}
        </Link>
    </div>
</template>

<style scoped>

</style>
