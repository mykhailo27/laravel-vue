<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import PageTable from "@/Components/Pages/Table.vue";
import Link from "@/Components/Link.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

defineProps({
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
            <div class="flex justify-between">
                <Link :href="route('users.create')"
                      class="font-semibold border rounded leading-none w-fit hover:bg-gray-200 hover:shadow-lg active:bg-gray-200 active:shadow-lg">
                    Create
                </Link>

                <!-- table actions -->
                <Dropdown align="right" width="48">
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
            </div>
        </template>

        <PageTable :columns="['id', 'name', 'email', 'created_at', 'actions']" :data="users"
                   :details_route="route('users.details', {user: '__ROW_ID__'})"/>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
