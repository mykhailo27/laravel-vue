<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import Table from "@/Components/Pages/Index/Table.vue";
import Header from "@/Components/Pages/Index/Header.vue";

defineProps({
    agencies: {
        type: Object,
        required: true,
    },
});

const form = useForm({});

const table_actions = [
    {name: 'Delete', route_name: 'api.agencies.delete-multiple', method: 'delete'}
];

</script>

<template>
    <Head title="Agency"/>
    <AuthenticatedLayout>

        <template #header>
            <Header :link="{url: route('agencies.create'), name: 'Create'}"/>
        </template>

        <Table :columns="['id', 'name', 'email', 'created_at', 'actions']" :data="agencies"
               :details_url="route('agencies.details', {agency: '__ROW_ID__'})" :table_actions="table_actions"/>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
