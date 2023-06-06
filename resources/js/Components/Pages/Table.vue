<script setup>

import Tr from "@/Components/Table/Tr.vue";
import Th from "@/Components/Table/Th.vue";
import Td from "@/Components/Table/Td.vue";
import Table from "@/Components/Table/Table.vue";
import TextInput from "@/Components/TextInput.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Pagination from "@/Components/Pagination.vue";
import Select from "@/Components/Select.vue";
import {handleRowClick, handleRowCheckboxClick, handleTableCheckboxClick} from "@/Modules/TableClickHandler.js";

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

</script>

<template>
    <div class="flex justify-between flex-wrap gap-2">
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
            <Tr v-for="row in data.data" @click="handleRowClick(row.id, props.details_route)">
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
