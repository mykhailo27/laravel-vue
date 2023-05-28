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
import {ref} from "vue";

defineProps({
    agencies: {
        type: Object,
        required: true,
    },
});

const selected_id = ref([]);
const table_checkbox = 'table-checkbox'
const form = useForm({});

const deleteAgency = (id => {
    form.delete(route('agencies.destroy', {agency: id}), {
        preserveScroll: true,
        // onSuccess: () => closeModal(),
        // onError: () => passwordInput.value.focus(),
        // onFinish: () => form.reset(),
    });
});

const details = (id => {
    window.location.href = route('agencies.details', {agency: id})
})

const updateSelectedId = (row_checkbox => {
    const value = row_checkbox.value;
    const index = selected_id.value.indexOf(value)

    if (row_checkbox.checked && index === -1) {
        selected_id.value.push(value)
    } else if (index !== -1) {
        selected_id.value.splice(index, 1);
    }
})

const handleTableCheckboxClick = (event => {
    const target = event.target;
    const checked = target.checked;

    target.closest('table')
        .querySelectorAll('tbody tr input')
        .forEach(input => {
            input.checked = checked
            updateSelectedId(input)
        })
})

const handleRowCheckboxClick = (event => {
    const target = event.target;

    updateSelectedId(target);

    const all_row_checkbox = target.closest('table')
        .querySelectorAll('tbody tr input[type="checkbox"]');

    const checked_rows_checkbox = [...all_row_checkbox]
        .filter(row_checkbox => row_checkbox.checked);

    target.closest('table')
        .querySelector('thead th input')
        .checked = all_row_checkbox.length === checked_rows_checkbox.length
})

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

        <div class="">
            <Pagination :links="agencies.links"/>
        </div>

        <Table>
            <template #columns>
                <Th>
                    <TextInput type="checkbox" @click="handleTableCheckboxClick" id="table-checkbox"
                               :model-value="table_checkbox"/>
                </Th>
                <Th>Name</Th>
                <Th>Email</Th>
                <Th>Create At</Th>
                <Th>Actions</Th>
            </template>
            <template #rows>
                <Tr v-for="agency in agencies.data" @click="details(agency.id)">
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
