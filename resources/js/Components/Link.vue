<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    }
});

</script>

<template>
    <Link :href="href" class="flex items-center justify-start px-6 py-3.5 outline-none">
        <slot />
    </Link>
</template>
