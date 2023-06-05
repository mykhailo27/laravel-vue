<script setup>

import Tr from "@/Components/Table/Tr.vue";
import Th from "@/Components/Table/Th.vue";
import Td from "@/Components/Table/Td.vue";
import Table from "@/Components/Table/Table.vue";
import TextInput from "@/Components/TextInput.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Pagination from "@/Components/Pagination.vue";
import {ref} from "vue";
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
        <!-- table search  -->
        <TextInput type="search" name="search" model-value="" class="focus:border-0" placeholder="Search . . ."/>

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
