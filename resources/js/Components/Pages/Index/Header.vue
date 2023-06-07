<script setup>

import TextInput from "@/Components/TextInput.vue";
import Link from "@/Components/Link.vue";
import {clearSearchTimer, StartSearchTimer} from "@/Modules/TimeOutAction.js";

const props = defineProps({
    link: {
        type: Object,
        required: true,
    },
    search_url: {
        type: String,
        required: true
    }
})

const submitSearch = (event) => {
    StartSearchTimer(function (value) {

        axios.get(props.search_url + '?search=' + value)
            .then(res => {
                console.log(res)
            })

    }, event.target.value)
}

</script>

<template>
    <div class="flex justify-between">
        <!-- table search  -->
        <TextInput type="search" name="search" model-value="" class="focus:border-0"
                   placeholder="Search . . ." @keydown="clearSearchTimer" @keyup="submitSearch"/>

        <Link :href="link.url"
              class="font-semibold border rounded leading-none w-fit hover:bg-gray-200 hover:shadow-lg active:bg-gray-200 active:shadow-lg">
            {{ link.name }}
        </Link>
    </div>
</template>

<style scoped>

</style>
