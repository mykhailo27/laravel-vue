<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import Table from "@/Components/Pages/Index/Table.vue";
import Header from "@/Components/Pages/Index/Header.vue";
import {ability} from "@/Config/ability.js";

defineProps({
    closets: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object
    },
    can: {
        type: Object
    }
});

const form = useForm({});

const table_actions = [
    {
        name: 'delete', ability: ability.DELETE_ANY,
        route_name: 'api.closets.delete-multiple',
        method: 'delete'
    }
];

const row_actions = [
    {
        name: 'delete',
        ability: ability.DELETE,
        route_name: 'api.closets.delete',
        method: 'delete',
        icon_class: 'text-danger hover:border-danger fa-sharp fa-solid fa-trash'
    },
];

</script>

<template>
    <Head title="Closet"/>
    <AuthenticatedLayout>

        <template #header>
            <Header :link="{url: route('closets.create'), name: 'Create'}"
                    :filters="filters" :can_create="can[ability.CREATE]"/>
        </template>

        <Table table_id="closet-table" :columns="['id', 'name', 'active', 'created_at', 'actions']" :data="closets"
               :details_url="route('closets.details', {closet: '__ROW_ID__'})"
               :table_actions="table_actions"
               :row_actions="row_actions"
               :can="can"
        />

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
