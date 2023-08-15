<script setup>

import Tr from "@/Components/Table/Tr.vue";
import Th from "@/Components/Table/Th.vue";
import Td from "@/Components/Table/Td.vue";
import Table from "@/Components/Table/Table.vue";
import TextInput from "@/Components/TextInput.vue";
import Pagination from "@/Components/Pagination.vue";
import Select from "@/Components/Select.vue";
import Dropdown from "@/Components/Dropdown.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {router} from "@inertiajs/vue3";
import {computed} from "vue"
import {currency} from "@/Config/Currency.js";

import {
    handleRowCheckboxClick,
    handleRowClick,
    handleTableCheckboxClick,
    resetCheckbox,
    selected_ids,
} from "@/Modules/TableClickHandler.js";

const props = defineProps({
    data: {
        type: Object,
        required: true
    },
    columns: {
        type: Array,
        required: true
    },
    details_url: {
        type: String,
        required: true
    },
    table_actions: {
        type: Array
    },
    table_id: {
        type: String,
        required: true
    },
    row_actions: {
        type: Array
    },
    can: {
        type: Object
    }
})

const per_pages = [
    {name: 10, value: 10},
    {name: 30, value: 30},
    {name: 50, value: 50}
];

const getPerPages = computed(() => {
    const item = props.data.per_page;

    if (per_pages.findIndex(per_page => per_page.name
        === item && per_page.value === item) === -1) {
        per_pages.push({name: item, value: item});
    }
    return per_pages;
})

const date_columns = [
    'created_at',
    'updated_at',
    'deleted_at',
    'email_verified_at'
];

const updatePerPage = (per_page) => {
    router.visit(location.href, {
        method: 'get',
        preserveState: true,
        data: {
            per_page: per_page,
        },
    })
}

const preformTableAction = (action, ids, table_id) => {
    axios.request(route(action.route_name), {
        data: {ids: ids},
        method: action.method
    }).then(res => {
        res.data.success
            ? router.reload()
            : console.warn(res)
        resetCheckbox(table_id)
    }).catch(error => console.error(error))
}

const preformRowAction = (action, id) => {
    axios.request(route(action.route_name), {
        data: {id: id},
        method: action.method
    }).then(res => {
        res.data.success
            ? router.reload()
            : console.warn(res)
    }).catch(error => console.error(error))
}

</script>

<template>

    <div class="flex justify-between flex-wrap gap-2 items-center">
        <!-- table actions -->
        <div>
            <Dropdown align="left" width="48" v-if="table_actions">
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
                    <template v-for="action in table_actions">
                        <SecondaryButton v-if="can[action.ability]"
                                         @click="preformTableAction(action, selected_ids, table_id)"
                                         class="flex justify-between w-full">
                            <span>{{ action.name }}</span>
                            <span>{{ selected_ids.length }}</span>
                        </SecondaryButton>
                    </template>
                </template>
            </Dropdown>
        </div>

        <!-- table pagination -->
        <Pagination v-if="data" :links="data.links" :from="data.from" :to="data.to" :total="data.total"/>

        <!-- table per page -->
        <Select v-if="data" @update:modelValue="updatePerPage"
                :options="getPerPages"
                :modelValue="data.per_page" label="per page"/>
    </div>
    <Table v-if="data" :table_id="table_id">
        <template #columns>
            <Th v-for="column in columns">
                <TextInput v-if="column === 'id'" type="checkbox" model-value=""
                           @click="handleTableCheckboxClick"/>
                <template v-else>{{ column.replace('_', ' ') }}</template>
            </Th>
        </template>
        <template #rows>
            <Tr v-for="row in data.data" @click="handleRowClick(row.id, props.details_url)">
                <Td v-for="column in columns">
                    <TextInput v-if="column === 'id'" type="checkbox" :model-value="row[column].toString()"
                               @click.stop @click="handleRowCheckboxClick"/>
                    <div v-else-if="column === 'actions'" class="flex ml-3">
                        <template v-for="action in row_actions">
                            <i v-if="row.can[action.ability]" @click.stop @click="preformRowAction(action, row.id)"
                               class="rounded-full p-2 border border-transparent" :class="action.icon_class"/>
                        </template>
                    </div>
                    <template v-else-if="date_columns.includes(column)">{{
                            (new Date(row[column])).toLocaleDateString()
                        }}
                    </template>
                    <template v-else-if="column === 'price'">{{
                            row[column] + ' ' + currency.EURO
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
