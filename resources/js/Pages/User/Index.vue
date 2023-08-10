<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Table from "@/Components/Pages/Index/Table.vue";
import Header from "@/Components/Pages/Index/Header.vue";
import {ability} from "@/Config/ability.js";

const props = defineProps({
    users: {
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

const table_actions = [
    {
        name: 'delete', ability: ability.DELETE_ANY,
        route_name: 'api.users.delete-multiple',
        method: 'delete'
    }
];

const row_actions = [
    {
        name: 'delete',
        ability: ability.DELETE,
        route_name: 'api.users.delete',
        method: 'delete',
        icon_class: 'text-danger hover:border-danger fa-sharp fa-solid fa-trash'
    },
];

</script>

<template>
    <Head title="Users"/>

    <AuthenticatedLayout>
        <template #header>
            <Header :link="{url: route('users.create'), name: 'Create'}"
                    :filters="filters" :can_create="can[ability.CREATE]"/>
        </template>

        <Table table_id="users-table" :columns="['id', 'name', 'email', 'created_at', 'actions']" :data="users"
               :details_url="route('users.details', {user: '__ROW_ID__'})"
               :table_actions="table_actions"
               :row_actions="row_actions"
               :can="can"
        />

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
