<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import Link from "@/Components/Link.vue";
import PageTable from "@/Components/Pages/Table.vue";

defineProps({
    agencies: {
        type: Object,
        required: true,
    },
});

const form = useForm({});

</script>

<template>
    <Head title="Agency"/>
    <AuthenticatedLayout>

        <template #header>
            <Link :href="route('agencies.create')"
                  class="font-semibold border rounded leading-none w-fit hover:bg-gray-200 hover:shadow-lg active:bg-gray-200 active:shadow-lg">
                Create
            </Link>
        </template>

        <PageTable :columns="['id', 'name', 'email', 'created_at', 'actions']" :data="agencies"
                   :details_route="route('agencies.details', {agency: '__ROW_ID__'})"/>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
