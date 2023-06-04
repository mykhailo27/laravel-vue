<script setup>

import Tr from "@/Components/Table/Tr.vue";
import Th from "@/Components/Table/Th.vue";
import Td from "@/Components/Table/Td.vue";
import Table from "@/Components/Table/Table.vue";
import TextInput from "@/Components/TextInput.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Pagination from "@/Components/Pagination.vue";
import {ref} from "vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Select from "@/Components/Select.vue";

const props = defineProps({
    data: {
        type: Object,
        required: true
    },
    columns: {
        type: Array,
        required: true
    },
    details_route: {
        type: String,
        required: true
    }
})

const date_columns = [
    'created_at',
    'updated_at',
    'deleted_at',
    'email_verified_at'
];

const selected_id = ref([]);

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

const handleRowClick = (row_id) => {
    window.location.href = props.details_route.replace('__ROW_ID__', row_id)
}

</script>

<template>
    <div class="flex justify-between">
        <!-- table actions -->
        <Dropdown align="left" width="48">
            <template #trigger>
                <span class="inline-flex rounded-md">
                    <button
                        type="button"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                    >
                        Actions

                        <svg
                            class="ml-2 -mr-0.5 h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </span>
            </template>

            <template #content>
                <DropdownLink href="#" :class="'flex justify-between'">
                    <span>Delete</span>
                    <span>10</span>
                </DropdownLink>
                <DropdownLink href="#" method="post" as="button" :class="'flex justify-between'">
                    <span>Refresh</span>
                    <span>10</span>
                </DropdownLink>
            </template>
        </Dropdown>

        <!-- table pagination -->
        <Pagination :links="data.links"/>

        <!-- table per page -->
        <Select :options="[{name: data.per_page, value: data.per_page}, {name: 30, value: 30}, {name: 50, value: 50}]"
                :default_option="{name: data.per_page, value: data.per_page}" label="per page"/>
    </div>
    <Table>
        <template #columns>
            <Th v-for="column in columns">
                <TextInput v-if="column === 'id'" type="checkbox" model-value=""
                           @click="handleTableCheckboxClick"/>
                <template v-else>{{ column.replace('_', ' ') }}</template>
            </Th>
        </template>
        <template #rows>
            <Tr v-for="row in data.data" @click="handleRowClick(row.id)">
                <Td v-for="column in columns">
                    <TextInput v-if="column === 'id'" type="checkbox" :model-value="row[column].toString()"
                               @click.stop @click="handleRowCheckboxClick"/>
                    <DangerButton v-else-if="column === 'actions'" class="ml-3" @click.stop
                                  @click="console.log('delete row')">
                        <i class="fa-sharp fa-solid fa-trash"></i>
                    </DangerButton>
                    <template v-else-if="date_columns.includes(column)">{{
                            (new Date(row[column])).toLocaleDateString()
                        }}
                    </template>
                    <template v-else>{{ row[column] }}</template>
                </Td>
            </Tr>
        </template>
    </Table>
</template>

<style scoped>

</style>
