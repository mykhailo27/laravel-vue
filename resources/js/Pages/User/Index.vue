<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Index from "@/Components/Pages/Index.vue";
import Link from "@/Components/Link.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
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
                <!-- table search  -->
                <TextInput type="search" name="search" model-value="" class="focus:border-0"
                           placeholder="Search . . ."/>

                <Link :href="route('users.create')"
                      class="font-semibold border rounded leading-none w-fit hover:bg-gray-200 hover:shadow-lg active:bg-gray-200 active:shadow-lg">
                    Create
                </Link>
            </div>
        </template>

        <Index :columns="['id', 'name', 'email', 'created_at', 'actions']" :data="users"
                   :details_route="route('users.details', {user: '__ROW_ID__'})"/>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
