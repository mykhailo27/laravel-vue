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
    search_url: {
        type: String,
        required: true
    },
})

const submitSearch = (value) => {
    startSearchTimer(function (value) {

        router.get(props.search_url, {
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
              class="font-semibold border rounded leading-none w-fit hover:bg-gray-200 hover:shadow-lg active:bg-gray-200 active:shadow-lg">
            {{ link.name }}
        </Link>
    </div>
</template>

<style scoped>

</style>
