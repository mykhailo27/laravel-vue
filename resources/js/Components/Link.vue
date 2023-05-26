<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    contentClasses: {
        type: String,
        default: 'px-6 py-3.5',
    },
});

</script>

<template>
    <Link :href="href" class="flex items-center justify-start outline-none" :class="contentClasses">
        <slot />
    </Link>
</template>
