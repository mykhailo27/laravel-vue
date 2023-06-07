<script setup>

import TextInput from "@/Components/TextInput.vue";
import Link from "@/Components/Link.vue";

defineProps({
    link: {
        type: Object,
        required: true,
    },
    search_url: {
        type: String,
        required: true
    }
})

</script>

<template>
    <div class="flex justify-between">
        <!-- table search  -->
        <TextInput type="search" name="search" model-value="" class="focus:border-0"
                   placeholder="Search . . ."/>

        <Link :href="link.url"
              class="font-semibold border rounded leading-none w-fit hover:bg-gray-200 hover:shadow-lg active:bg-gray-200 active:shadow-lg">
            {{ link.name }}
        </Link>
    </div>
</template>

<style scoped>

</style>
