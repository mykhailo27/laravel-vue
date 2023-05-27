<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Table from "@/Components/Table/Table.vue";
import Th from "@/Components/Table/Th.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import TextInput from "@/Components/TextInput.vue";
import Link from "@/Components/Link.vue";

defineProps({
    agencies: {
        type: Array,
        required: true
    },
});

const table_checkbox = 'table-checkbox'

function details(id) {
    window.location.href = route('agencies.details', {agency: id})
}

</script>

<template>
    <Head title="Agency"/>

    <AuthenticatedLayout>
        <template #header>
                <Link :href="route('agencies.create')"
                      class="font-semibold border rounded leading-none w-fit hover:bg-gray-200 hover:shadow-lg active:bg-gray-200 active:shadow-lg">Create</Link>
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
                <Tr v-for="agency in agencies" v-on:click="details(agency.id)">
                    <Td>
                        <TextInput type="checkbox" :model-value="agency.id" v-on:click.stop/>
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
