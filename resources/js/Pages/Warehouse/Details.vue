<script setup>

import {computed, onMounted, ref} from "vue";
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Pill from "@/Components/Pill/Pill.vue";
import Tab from "@/Components/Pill/Tab.vue";
import Content from "@/Components/Pill/Content.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {Dropdown, initTE, Ripple,} from "tw-elements";
import Select from "@/Components/Select.vue";
import AccordionContainer from "@/Components/Accordion/AccordionContainer.vue";
import AccordionItem from "@/Components/Accordion/AccordionItem.vue";
import {handleRowClick} from "@/Modules/TableClickHandler.js";
import DangerButton from "@/Components/DangerButton.vue";
import Table from "@/Components/Table/Table.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import Th from "@/Components/Table/Th.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {filter} from "@/Modules/DataProcessing.js";

const props = defineProps({
    warehouse: {
        type: Object,
    },
    responsible_user: {
        type: Object
    },
    address: {
        type: Object,
    },
    country: {
        type: Object,
    },
    countries: {
        type: Object,
    },
    users: {
        type: Array,
    },
    active_countries: {
        type: Array,
    },
    none_active_countries: {
        type: Array,
    },
});

const show_add_or_update_warehouse_btn = ref(true)
const show_add_country_btn = ref(false)
const show_add_country_modal = ref(false)
const search_country_input = ref('')

const filtered_non_active_warehouse_countries = computed(() => {
    return filter(
        props.none_active_countries,
        ['name', 'alpha_2', 'alpha_3'],
        search_country_input.value);
})

const tab_attributes = {
    warehouse: {
        id: 'warehouse-form-tab',
        content_href: '#warehouse-form',
        content_id: 'warehouse-form',
        name: 'warehouse'
    },
    countries: {
        id: 'warehouse-countries-tab',
        content_href: '#warehouse-countries',
        content_id: 'warehouse-countries',
        name: 'countries'
    },
}

const warehouse_exist = computed(() => {
    return props.warehouse === null;
});

const activateTab = (event) => {
    const tab_id = event.target.id;

    switch (tab_id) {
        case tab_attributes.countries.id:
            show_add_country_btn.value = true;
            show_add_or_update_warehouse_btn.value = false;
            break;
        case tab_attributes.warehouse.id:
            show_add_or_update_warehouse_btn.value = true;
            show_add_country_btn.value = false;
            break;
    }
}

const address_form = useForm({
    _method: props.address ? 'put' : 'post',
    line_1: props.address?.line_1 ?? '',
    line_2: props.address?.line_2 ?? '',
    zip_code: props.address?.zip_code ?? '',
    city: props.address?.city ?? '',
    state_or_region: props.address?.state_or_region ?? '',
    country_id: props.country?.id ?? '',
    addressable_id: props.warehouse?.id,
    addressable_type: 'App\\Models\\Warehouse',
})

const submitAddressForm = () => {
    if (props.address !== null) {
        if (address_form.isDirty) {
            address_form.post(route('address.update', {address: props.address.id}), {
                onSuccess: () => console.log('address updated'),
                onError: (err) => console.error(err)
            });
        }
    } else {
        address_form.post(route('address.store', {model: props.warehouse.id}), {
            onSuccess: () => console.log('address created'),
            onError: (err) => console.error(err)
        });
    }
};

const warehouse_form = useForm({
    _method: props.warehouse ? 'put' : 'post',
    name: props.warehouse?.name ?? '',
    return_cost: props.warehouse?.return_cost ?? '',
    currency: props.warehouse?.currency ?? '',
    responsible_user_id: props.responsible_user?.id ?? '',
});

const submitWarehouseForm = () => {
    if (props.warehouse !== null) {
        if (warehouse_form.isDirty) {
            warehouse_form.post(route('warehouses.update', {warehouse: props.warehouse.id}), {
                onFinish: () => console.log('Warehouse updated'),
                onError: (err) => console.error(err)
            });
        }
    } else {
        warehouse_form.post(route('warehouses.store'), {
            onSuccess: () => console.log('Warehouse created'),
            onError: (err) => console.error(err)
        });
    }
};

const clickSubmitBtn = () => {
    document.getElementById('submit-btn').click();
}

const getUsers = computed(() => {
    return props.users.reduce((users, user) => {
        users.push({name: user.name, value: user.id})
        return users;
    }, [])
})

const getCountries = computed(() => {
    return props.countries.reduce((countries, country) => {
        countries.push({name: country.name, value: country.id})
        return countries;
    }, [])
})

const closetCountryModal = () => {
    show_add_country_modal.value = false
    search_country_input.value = '';
}

const handleRemoveCountry = (event) => {
    const target = event.target;
    const country_id = target.dataset.countryId

    axios.delete(route('api.warehouses.remove-country', {warehouse: props.warehouse.id, country: country_id}))
        .then(res => {
            const country = res.data.country;

            if (props.none_active_countries.findIndex(ob => ob.name === country.name) === -1) {
                props.none_active_countries.push(country)
            }

            props.active_countries.splice(props.active_countries.findIndex(ob => ob.name === country.name), 1);
        })
        .catch(error => console.error(error))
}

const handleAddCountry = (event) => {
    const target = event.target;
    const country_id = target.dataset.countryId

    axios.post(route('api.warehouses.add-country', {warehouse: props.warehouse.id, country: country_id}))
        .then(res => {
            const country = res.data.country;

            if (props.active_countries.findIndex(ob => ob.name === country.name) === -1) {
                props.active_countries.push(country)
            }

            props.none_active_countries.splice(props.none_active_countries.findIndex(ob => ob.name === country.name), 1);
        })
        .catch(error => console.error(error))
}

onMounted(() => {
    initTE({Dropdown, Ripple});
})

</script>

<template>
    <Head title="Create Warehouse"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between mt-4">
                <div id="primary-actions">
                    <PrimaryButton v-show="show_add_or_update_warehouse_btn" @click="clickSubmitBtn" class="ml-4"
                                   :class="{ 'opacity-25': warehouse_form.processing }"
                                   :disabled="warehouse_form.processing">
                        {{ (props.warehouse === null ? 'Save' : 'Update') }}
                    </PrimaryButton>
                </div>

                <div id="secondary-actions">
                    <PrimaryButton v-show="show_add_country_btn" @click="show_add_country_modal = true">
                        Add Countries
                    </PrimaryButton>
                </div>
            </div>
        </template>

        <Pill>
            <template #pill-tabs>
                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="activateTab"
                         :tab="tab_attributes.warehouse"
                         data-te-nav-active/>
                </li>
                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="activateTab"
                         :tab="tab_attributes.countries"
                         :disabled="warehouse_exist"/>
                </li>
            </template>

            <template #pill-contents>
                <Content :tab="tab_attributes.warehouse" data-te-tab-active>
                    <form @submit.prevent="submitWarehouseForm">

                        <div>
                            <InputLabel for="name" value="Name"/>
                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="warehouse_form.name"
                                required
                                autocomplete="name"
                            />
                            <InputError class="mt-2" :message="warehouse_form.errors.name"/>
                        </div>

                        <div class="mt-3">
                            <Select v-if="users" :modelValue="warehouse_form.responsible_user_id"
                                    @update:modelValue="value => warehouse_form.responsible_user_id = value"
                                    :options="getUsers" label="Select Responsible User"/>
                            <InputError class="mt-2" :message="warehouse_form.errors.responsible_user_id"/>
                        </div>

                        <div>
                            <InputLabel for="name" value="Name"/>
                            <div
                                class="relative mb-4 flex flex-wrap items-stretch"
                                data-te-dropdown-ref>
                                <button
                                    class="z-[2] flex items-center whitespace-nowrap rounded-l border-2 border-primary px-6 pb-[6px] pt-2 text-xs font-medium uppercase leading-normal text-primary transition duration-150 ease-in-out hover:border-primary-600 hover:bg-neutral-500 hover:bg-opacity-10 hover:text-primary-600 focus:z-[3] focus:border-primary-600 focus:text-primary-600 focus:outline-none focus:ring-0 active:border-primary-700 active:text-primary-700 dark:hover:bg-neutral-100 dark:hover:bg-opacity-10"
                                    type="button"
                                    data-te-dropdown-toggle-ref
                                    aria-expanded="false"
                                    data-te-ripple-init>
                                    <span class="text-lg">{{ warehouse_form.currency }}</span>
                                    <span class="-mt-[0.2rem] ml-2 w-2">
                                        <svg
                                            aria-hidden="true"
                                            focusable="false"
                                            data-prefix="fas"
                                            data-icon="caret-down"
                                            role="img"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 320 512">
                                        <path
                                            fill="currentColor"
                                            d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"></path>
                                    </svg>
                                </span>
                                </button>
                                <ul
                                    class="absolute z-[1000] float-left m-0 hidden w-20 list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                                    data-te-dropdown-menu-ref>
                                    <li>
                                        <span @click="warehouse_form.currency = '$'"
                                              class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                                              data-te-dropdown-item-ref>
                                            $
                                        </span>
                                    </li>
                                    <li>
                                        <span @click="warehouse_form.currency = '€'"
                                              class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                                              data-te-dropdown-item-ref>
                                            €
                                        </span>
                                    </li>
                                    <li>
                                        <span @click="warehouse_form.currency = '£'"
                                              class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                                              data-te-dropdown-item-ref>
                                            £
                                        </span>
                                    </li>
                                </ul>
                                <TextInput
                                    id="return_cost"
                                    type="number"
                                    step="0.01"
                                    class="relative mt-1 -ml-0.5 block w-[1px] min-w-0 flex-auto px-3 py-[0.3rem]"
                                    v-model="warehouse_form.return_cost"
                                    required
                                />
                            </div>
                        </div>

                        <progress v-if="warehouse_form.progress" :value="warehouse_form.progress.percentage" max="100">
                            {{ warehouse_form.progress.percentage }}%
                        </progress>

                        <button type="submit" id="submit-btn" :disabled="warehouse_form.processing" hidden>Submit
                        </button>
                    </form>

                    <AccordionContainer v-if="warehouse" id="address_accordion" class="mt-2">
                        <AccordionItem title_id="address_form_dropdown" title_name="Address"
                                       item_id="address_form_content">
                            <form @submit.prevent="submitAddressForm">
                                <div>
                                    <InputLabel for="line_1" value="Address Line 1"/>
                                    <TextInput
                                        id="line_1"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="address_form.line_1"
                                        required
                                    />
                                    <InputError class="mt-2" :message="address_form.errors.line_1"/>
                                </div>

                                <div>
                                    <InputLabel for="line_2" value="Address Line 2"/>
                                    <TextInput
                                        id="line_2"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="address_form.line_2"
                                    />
                                    <InputError class="mt-2" :message="address_form.errors.line_2"/>
                                </div>

                                <div>
                                    <InputLabel for="zip_code" value="Zip code"/>
                                    <TextInput
                                        id="zip_code"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="address_form.zip_code"
                                        required
                                    />
                                    <InputError class="mt-2" :message="address_form.errors.zip_code"/>
                                </div>

                                <div>
                                    <InputLabel for="city" value="City"/>
                                    <TextInput
                                        id="city"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="address_form.city"
                                        required
                                    />
                                    <InputError class="mt-2" :message="address_form.errors.city"/>
                                </div>

                                <div>
                                    <InputLabel for="state_or_region" value="Address state | region"/>
                                    <TextInput
                                        id="state_or_region"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="address_form.state_or_region"
                                        required
                                    />
                                    <InputError class="mt-2" :message="address_form.errors.state_or_region"/>
                                </div>

                                <div class="mt-4">
                                    <Select v-if="countries" :modelValue="country?.id"
                                            @update:modelValue="value => address_form.country_id = value"
                                            :options="getCountries" label="Country"/>
                                </div>

                                <PrimaryButton type="submit" :disabled="address_form.processing" class="mt-2">
                                    {{ address ? 'Update' : 'Save' }}
                                </PrimaryButton>
                            </form>
                        </AccordionItem>
                    </AccordionContainer>

                </Content>
                <Content :tab="tab_attributes.countries">
                    <Table table_id="company-users-table">
                        <template #columns>
                            <Th>Name</Th>
                            <Th>Alpha Two</Th>
                            <Th>Alpha Three</Th>
                            <Th>Active</Th>
                            <Th>Create At</Th>
                            <Th>Actions</Th>
                        </template>
                        <template #rows>
                            <Tr v-if="active_countries.length" v-for="country in active_countries"
                                @click="handleRowClick(country.id, route('countries.details', {country: '__ROW_ID__'}))">
                                <Td>{{ country.name }}</Td>
                                <Td>{{ country.alpha_2 }}</Td>
                                <Td>{{ country.alpha_3 }}</Td>
                                <Td>{{ country.pivot.active ? '✔' : '✖' }}</Td>
                                <Td>{{ (new Date(country.created_at)).toLocaleDateString() }}</Td>
                                <Td>
                                    <DangerButton title="Remove Country" class="fa-sharp fa-solid fa-trash"
                                                  :data-country-id="country.id" @click.stop
                                                  @click="handleRemoveCountry"/>
                                </Td>
                            </Tr>
                        </template>
                    </Table>
                </Content>
            </template>
        </Pill>

        <Modal :show="show_add_country_modal" @close="closetCountryModal">
            <div class="p-6">
                <div class="flex">
                    <TextInput model-value="" type="search" v-model="search_country_input" class="w-full mr-4"
                               placeholder="Search Country"/>
                    <SecondaryButton class="fa-sharp fa-solid fa-xmark"
                                     @click="closetCountryModal"></SecondaryButton>
                </div>

                <Table table_id="add-countries-table">
                    <template #columns>
                        <Th>Name</Th>
                        <Th>Alpha Two</Th>
                        <Th>Alpha Three</Th>
                        <Th>Actions</Th>
                    </template>
                    <template #rows>
                        <Tr v-if="none_active_countries.length"
                            v-for="country in filtered_non_active_warehouse_countries">
                            <Td>{{ country.name }}</Td>
                            <Td>{{ country.alpha_2 }}</Td>
                            <Td>{{ country.alpha_3 }}</Td>
                            <Td>
                                <PrimaryButton title="Add Country" class="fa-solid fa-plus"
                                               :data-country-id="country.id"
                                               @click="handleAddCountry"/>
                            </Td>
                        </Tr>
                    </template>
                </Table>
            </div>
        </Modal>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
