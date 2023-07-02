<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Pill from "@/Components/Pill/Pill.vue";
import Tab from "@/Components/Pill/Tab.vue";
import Content from "@/Components/Pill/Content.vue";
import {computed, ref} from "vue";
import Tr from "@/Components/Table/Tr.vue";
import Th from "@/Components/Table/Th.vue";
import Td from "@/Components/Table/Td.vue";
import Table from "@/Components/Table/Table.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import {handleRowClick} from "@/Modules/TableClickHandler.js";
import {filter} from "@/Modules/DataProcessing.js";
import Select from "@/Components/Select.vue";

const props = defineProps({
    company: {
        type: Object,
    },
    address: {
        type: Object,
    },
    country: {
        type: Object,
    },
    countries: {
        type: Array,
    },
    company_users: {
        type: Object,
    },
    non_company_users: {
        type: Object,
    }
});

const company_form = useForm({
    _method: props.company ? 'put': 'post',
    name: props.company?.name ?? '',
    abbreviation: props.company?.abbreviation ?? '',
    vat: props.company?.vat ?? '',
    logo: props.company?.logo ?? '',

    address_line_1: props.address?.line_1 ?? '',
    address_line_2: props.address?.line_2 ?? '',
    address_zip_code: props.address?.zip_code ?? '',
    address_city: props.address?.city ?? '',
    address_state_or_region: props.address?.state_or_region ?? '',
    address_country: props.country?.id ?? '',
});

const tab_attributes = {
    company: {id: 'company-form-tab', content_href: '#company-form', content_id: 'company-form', name: 'Company'},
    users: {id: 'company-users-tab', content_href: '#company-users', content_id: 'company-users', name: 'Users'},
}

const submit = () => {
    if (props.company !== null) {
        if (company_form.isDirty) {
            company_form.post(route('companies.update', {company: props.company.id}), {
                onFinish: () => {
                    console.log('Company updated')
                }
            });
        } else {
            console.log('no change to update')
        }
    } else {
        company_form.post(route('companies.store'), {
            onFinish: () => {
                console.log('Company created')
            }
        });
    }
};

const getCountries = computed(() => {
    return props.countries.reduce((countries, country) => {
        countries.push({name: country.name, value: country.id})
        return countries;
    }, [])
})

const show_add_or_update_company_btn = ref(true)
const show_add_user_btn = ref(false)

const activateTab = (event) => {
    const tab_id = event.target.id;

    switch (tab_id) {
        case tab_attributes.users.id:
            show_add_user_btn.value = true;
            show_add_or_update_company_btn.value = false;
            break;
        case tab_attributes.company.id:
            show_add_or_update_company_btn.value = true;
            show_add_user_btn.value = false;
            break;
    }
}

const show_add_user_modal = ref(false)
const search_user_input = ref('')

const filtered_non_company_users = computed(() => {
    return filter(
        props.non_company_users,
        ['name', 'email'],
        search_user_input.value);
})

const company_exist = computed(() => {
    return props.company === null;
});

const closetUserModal = () => {
    show_add_user_modal.value = false
    search_user_input.value = '';
}

const clickSubmitBtn = () => {
    document.getElementById('submit-btn').click();
}

const handleAddUser = (event) => {
    const target = event.target;
    const user_id = target.dataset.userId

    axios.post(route('api.companies.add-user', {company: props.company.id, user: user_id}))
        .then(res => {
            const user = res.data.user;

            if (props.company_users.findIndex(ob => ob.name === user.name) === -1) {
                props.company_users.push(user)
            }

            props.non_company_users.splice(props.non_company_users.findIndex(ob => ob.name === user.name), 1);
        })
        .catch(error => console.error(error))
}

const handleRemoveUser = (event) => {
    const target = event.target;
    const user_id = target.dataset.userId

    axios.delete(route('api.companies.remove-user', {company: props.company.id, user: user_id}))
        .then(res => {
            const user = res.data.user;

            if (props.non_company_users.findIndex(ob => ob.name === user.name) === -1) {
                props.non_company_users.push(user)
            }

            props.company_users.splice(props.company_users.findIndex(ob => ob.name === user.name), 1);
        })
        .catch(error => console.error(error))
}

</script>

<template>
    <Head title="Create Company"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between mt-4">
                <div id="primary-actions">
                    <PrimaryButton v-show="show_add_or_update_company_btn" @click="clickSubmitBtn" class="ml-4" :class="{ 'opacity-25': company_form.processing }"
                                   :disabled="company_form.processing">
                        {{ (props.company === null ? 'Save' : 'Update') }}
                    </PrimaryButton>
                </div>

                <div id="secondary-actions">
                    <PrimaryButton v-show="show_add_user_btn" @click="show_add_user_modal = true">Add Users</PrimaryButton>
                </div>
            </div>
        </template>

        <Pill>
            <template #pill-tabs>
                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="activateTab"
                         :tab="tab_attributes.company"
                         data-te-nav-active/>
                </li>
                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="activateTab"
                         :tab="tab_attributes.users"
                         :disabled="company_exist"/>
                </li>
            </template>

            <template #pill-contents>
                <Content :tab="tab_attributes.company" data-te-tab-active>
                    <form @submit.prevent="submit">

                        <div>
                            <InputLabel for="name" value="Name"/>

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="company_form.name"
                                required
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="company_form.errors.name"/>
                        </div>

                        <div>
                            <InputLabel for="abbreviation" value="Abbreviation"/>

                            <TextInput
                                id="abbreviation"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="company_form.abbreviation"
                                required
                            />

                            <InputError class="mt-2" :message="company_form.errors.abbreviation"/>
                        </div>

                        <div>
                            <InputLabel for="vat" value="Vat"/>

                            <TextInput
                                id="vat"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="company_form.vat"
                                required
                            />

                            <InputError class="mt-2" :message="company_form.errors.vat"/>
                        </div>

                        <div>
                            <InputLabel for="logo" value="Logo"/>

                            <input
                                id="logo"
                                type="file"
                                accept=".png"
                                class="border py-2 mt-1 block w-full"
                                @input="company_form.logo = $event.target.files[0]"
                                required
                            />

                            <InputError class="mt-2" :message="company_form.errors.logo"/>
                        </div>

                        <!-- Address -->

                        <div>
                            <InputLabel for="address_line_1" value="Address Line 1"/>

                            <TextInput
                                id="address_line_1"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="company_form.address_line_1"
                                required
                            />

                            <InputError class="mt-2" :message="company_form.errors.address_line_1"/>
                        </div>

                        <div>
                            <InputLabel for="address_line_2" value="Address Line 2"/>

                            <TextInput
                                id="address_line_2"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="company_form.address_line_2"
                            />

                            <InputError class="mt-2" :message="company_form.errors.address_line_2"/>
                        </div>

                        <div>
                            <InputLabel for="address_zip_code" value="Address zip code"/>

                            <TextInput
                                id="address_zip_code"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="company_form.address_zip_code"
                                required
                            />

                            <InputError class="mt-2" :message="company_form.errors.address_zip_code"/>
                        </div>

                        <div>
                            <InputLabel for="address_city" value="Address city"/>

                            <TextInput
                                id="address_city"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="company_form.address_city"
                                required
                            />

                            <InputError class="mt-2" :message="company_form.errors.address_city"/>
                        </div>

                        <div>
                            <InputLabel for="address_state_or_region" value="Address state | region"/>

                            <TextInput
                                id="address_state_or_region"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="company_form.address_state_or_region"
                                required
                            />

                            <InputError class="mt-2" :message="company_form.errors.address_state_or_region"/>
                        </div>

                        <div class="mt-4">
                            <Select v-if="countries" :modelValue="country?.id"
                                    @update:modelValue="value => company_form.address_country = value"
                                    :options="getCountries" label="Address country"/>
                        </div>

                        <progress v-if="company_form.progress" :value="company_form.progress.percentage" max="100">
                            {{ company_form.progress.percentage }}%
                        </progress>

                        <button type="submit" id="submit-btn" :disabled="company_form.processing" hidden>Submit</button>
                    </form>

                    <img v-if="company?.logo" :src="company.logo"
                        class="mt-2 h-auto max-w-sm rounded-lg shadow-none transition-shadow duration-300 ease-in-out hover:shadow-lg hover:shadow-black/30"
                        alt="company logo"/>
                </Content>
                <Content :tab="tab_attributes.users">

                    <Table table_id="company-users-table">
                        <template #columns>
                            <Th>Name</Th>
                            <Th>Email</Th>
                            <Th>Create At</Th>
                            <Th>Actions</Th>
                        </template>
                        <template #rows>
                            <Tr v-if="company_users !== null" v-for="user in company_users"
                                @click="handleRowClick(user.id, route('users.details', {user: '__ROW_ID__'}))">
                                <Td>{{ user.name }}</Td>
                                <Td>{{ user.email }}</Td>
                                <Td>{{ (new Date(user.created_at)).toLocaleDateString() }}</Td>
                                <Td>
                                    <DangerButton title="Remove User" class="fa-sharp fa-solid fa-trash"
                                                  :data-user-id="user.id" @click.stop @click="handleRemoveUser"/>
                                </Td>
                            </Tr>
                        </template>
                    </Table>
                </Content>
            </template>
        </Pill>

        <Modal :show="show_add_user_modal" @close="closetUserModal">
            <div class="p-6">
                <div class="flex">
                    <TextInput model-value="" type="search" v-model="search_user_input" class="w-full mr-4"
                               placeholder="Search User"/>
                    <SecondaryButton class="fa-sharp fa-solid fa-xmark"
                                     @click="closetUserModal"></SecondaryButton>
                </div>

                <Table table_id="add-users-table">
                    <template #columns>
                        <Th>Name</Th>
                        <Th>Email</Th>
                        <Th>Actions</Th>
                    </template>
                    <template #rows>
                        <Tr v-if="non_company_users !== null" v-for="user in filtered_non_company_users">
                            <Td>{{ user.name }}</Td>
                            <Td>{{ user.email }}</Td>
                            <Td>
                                <PrimaryButton title="Add User" class="fa-solid fa-plus" :data-user-id="user.id"
                                               @click="handleAddUser"/>
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
