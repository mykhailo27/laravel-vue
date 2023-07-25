<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Table from "@/Components/Pages/Index/Table.vue";
import Header from "@/Components/Pages/Index/Header.vue";
import {computed} from "vue";

const props = defineProps({
    countries: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object
    }
});

const countries = computed(() => {
    const countries = props.countries;

    countries.data = props.countries.data.reduce((countries, country) => {
        countries.push({
            id: country.id,
            name: country.name,
            alpha_2: country.alpha_2,
            alpha_3: country.alpha_3,
            enabled: country.enabled ? '✔' : '✖',
            created_at: country.created_at,
        })
        return countries;
    }, [])

    return countries;
})

</script>

<template>
    <Head title="countries"/>

    <AuthenticatedLayout>
        <template #header>
            <Header :filters="filters"/>
        </template>

        <Table table_id="countries-table" :columns="['id', 'name', 'alpha_2', 'enabled', 'created_at']"
               :data="countries"
               :details_url="route('countries.details', {country: '__ROW_ID__'})"/>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
