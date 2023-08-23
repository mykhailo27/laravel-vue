<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import Table from "@/Components/Pages/Index/Table.vue";
import {ability} from "@/Config/ability.js";

defineProps({
    stock_moves: {
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
        route_name: 'api.stock_moves.delete-multiple',
        method: 'delete'
    }
];

const row_actions = [
    {
        name: 'delete',
        ability: ability.DELETE,
        route_name: 'api.stock_moves.delete',
        method: 'delete',
        icon_class: 'text-danger hover:border-danger fa-sharp fa-solid fa-trash'
    },
];

</script>

<template>
    <Head title="Company"/>
    <AuthenticatedLayout>

        <Table table_id="stock-move-table" :columns="['id', 'type', 'created_at', 'actions']" :data="stock_moves"
               :details_url="route('stock_moves.details', {stock_move: '__ROW_ID__'})"
               :table_actions="table_actions"
               :row_actions="row_actions"
               :can="can"
        />

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
