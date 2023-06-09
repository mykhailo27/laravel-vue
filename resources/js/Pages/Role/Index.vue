<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Table from "@/Components/Pages/Index/Table.vue";
import Header from "@/Components/Pages/Index/Header.vue";

const props = defineProps({
    roles: {
        type: Object,
        required: true,
    },
});

</script>

<template>
    <Head title="Roles"/>

    <AuthenticatedLayout>
        <template #header>
            <Header :link="{url: route('roles.create'), name: 'Create'}"
                    :index_url="route('roles.index')"/>
        </template>

        <Table :columns="['id', 'name', 'guard_name', 'created_at', 'actions']" :data="roles"
               :details_url="route('roles.details', {role: '__ROW_ID__'})" :index_url="route('roles.index')"/>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
