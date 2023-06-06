<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import Table from "@/Components/Table/Table.vue";
import Th from "@/Components/Table/Th.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import TextInput from "@/Components/TextInput.vue";
import Link from "@/Components/Link.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Pagination from "@/Components/Pagination.vue";
import {handleRowClick, handleRowCheckboxClick, handleTableCheckboxClick} from "@/Modules/TableClickHandler.js";


defineProps({
    agencies: {
        type: Object,
        required: true,
    },
});

const form = useForm({});

const deleteAgency = (id => {
    form.delete(route('agencies.destroy', {agency: id}), {
        preserveScroll: true,
        // onSuccess: () => closeModal(),
        // onError: () => passwordInput.value.focus(),
        // onFinish: () => form.reset(),
    });
});

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

        <Pagination :links="agencies.links"/>

        <Table>
            <template #columns>
                <Th>
                    <TextInput type="checkbox" model-value="" @click="handleTableCheckboxClick"/>
                </Th>
                <Th>Name</Th>
                <Th>Email</Th>
                <Th>Create At</Th>
                <Th>Actions</Th>
            </template>
            <template #rows>
                <Tr v-for="agency in agencies.data" @click="handleRowClick(agency.id, route('agencies.details', {agency: '__ROW_ID__'}))">
                    <Td>
                        <TextInput type="checkbox" :model-value="agency.id" @click.stop @click="handleRowCheckboxClick"/>
                    </Td>
                    <Td>{{ agency.name }}</Td>
                    <Td>{{ agency.email }}</Td>
                    <Td>{{ (new Date(agency.created_at)).toLocaleDateString() }}</Td>
                    <Td @click.stop>
                        <DangerButton class="ml-3" @click="deleteAgency(agency.id)">
                            <i class="fa-sharp fa-solid fa-trash"></i>
                        </DangerButton>
                    </Td>
                </Tr>
            </template>
        </Table>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
