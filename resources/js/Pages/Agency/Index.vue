<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Table from "@/Components/Table/Table.vue";
import Th from "@/Components/Table/Th.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
    agencies: {
        type: Array,
        required: true
    },
});

const table_checkbox = 'table-checkbox'

</script>

<template>
    <Head title="Agency"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Agency</h2>
        </template>

        <Table>
            <template #columns>
                <Th>
                    <TextInput type="checkbox" id="table-checkbox" :model-value="table_checkbox"/>
                </Th>
                <Th>Name</Th>
                <Th>Email</Th>
                <Th>Create At</Th>
            </template>
            <template #rows>
                <Tr v-for="agency in agencies">
                    <Td>
                        <TextInput type="checkbox" :model-value="agency.id"/>
                    </Td>
                    <Td>{{ agency.name }}</Td>
                    <Td>{{ agency.email }}</Td>
                    <Td>{{ (new Date(agency.created_at)).toLocaleDateString() }}</Td>
                </Tr>
            </template>
        </Table>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
