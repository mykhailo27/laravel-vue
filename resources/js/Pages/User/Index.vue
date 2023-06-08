<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Table from "@/Components/Pages/Index/Table.vue";
import Header from "@/Components/Pages/Index/Header.vue";
import {ref} from "vue";

const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
});

const filtered_user = ref(props.users);

const getUsers = (data) => {
    filtered_user.value = data
}

</script>

<template>
    <Head title="Users"/>

    <AuthenticatedLayout>
        <template #header>
            <Header @filteredUsers="getUsers" :link="{url: route('users.create'), name: 'Create'}"
                    :search_url="route('users.index')"/>
        </template>

        <Table :columns="['id', 'name', 'email', 'created_at', 'actions']" :data="filtered_user"
               :details_route="route('users.details', {user: '__ROW_ID__'})"/>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
