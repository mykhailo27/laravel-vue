<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Table from "@/Components/Pages/Index/Table.vue";
import Header from "@/Components/Pages/Index/Header.vue";

const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
});

</script>

<template>
    <Head title="Users"/>

    <AuthenticatedLayout>
        <template #header>
            <Header :link="{url: route('users.create'), name: 'Create'}" search_url="#"/>
        </template>

        <Table :columns="['id', 'name', 'email', 'created_at', 'actions']" :data="users"
               :details_route="route('users.details', {user: '__ROW_ID__'})"/>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
