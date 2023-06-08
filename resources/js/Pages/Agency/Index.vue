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

</script>

<template>
    <Head title="Agency"/>
    <AuthenticatedLayout>

        <template #header>
            <Header :link="{url: route('agencies.create'), name: 'Create'}" :search_url="route('agencies.index')"/>
        </template>

        <Table :columns="['id', 'name', 'email', 'created_at', 'actions']" :data="agencies"
               :details_route="route('agencies.details', {agency: '__ROW_ID__'})"/>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
