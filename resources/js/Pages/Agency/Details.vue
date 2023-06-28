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

const props = defineProps({
    agency: {
        type: Object,
    },
    agency_users: {
        type: Object,
    },
    non_agency_users: {
        type: Object,
    }
});

const agency_form = useForm({
    name: props.agency?.name ?? '',
    email: props.agency?.email ?? '',
});

const tab_attributes = {
    agency: {id: 'agency-form-tab', content_href: '#agency-form', content_id: 'agency-form', name: 'Agency'},
    users: {id: 'agency-users-tab', content_href: '#agency-users', content_id: 'agency-users', name: 'Users'},
}

const submit = () => {
    if (props.agency !== null) {
        if (agency_form.name !== props.agency.name || agency_form.email !== props.agency.email) {
            agency_form.put(route('agencies.update', {agency: props.agency.id}), {
                onFinish: () => {
                    console.log('Agency updated')
                }
            });
        } else {
            console.log('no change to update')
        }
    } else {
        agency_form.post(route('agencies.store'), {
            onFinish: () => {
                console.log('Agency created')
            }
        });
    }
};


const show_add_or_update_agency_btn = ref(true)
const show_add_user_btn = ref(false)

const activateTab = (event) => {
    const tab_id = event.target.id;

    switch (tab_id) {
        case tab_attributes.users.id:
            show_add_user_btn.value = true;
            show_add_or_update_agency_btn.value = false;
            break;
        case tab_attributes.agency.id:
            show_add_or_update_agency_btn.value = true;
            show_add_user_btn.value = false;
            break;
    }
}

const show_add_user_modal = ref(false)
const search_user_input = ref('')

const filtered_non_agency_users = computed(() => {
    return filter(
        props.non_agency_users,
        ['name', 'email'],
        search_user_input.value);
})

const agency_exist = computed(() => {
    return props.agency === null;
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

    axios.post(route('api.agencies.add-user', {agency: props.agency.id, user: user_id}))
        .then(res => {
            const user = res.data.user;

            if (props.agency_users.findIndex(ob => ob.name === user.name) === -1) {
                props.agency_users.push(user)
            }

            props.non_agency_users.splice(props.non_agency_users.findIndex(ob => ob.name === user.name), 1);
        })
        .catch(error => console.error(error))
}

const handleRemoveUser = (event) => {
    const target = event.target;
    const user_id = target.dataset.userId

    axios.delete(route('api.agencies.remove-user', {agency: props.agency.id, user: user_id}))
        .then(res => {
            const user = res.data.user;

            if (props.non_agency_users.findIndex(ob => ob.name === user.name) === -1) {
                props.non_agency_users.push(user)
            }

            props.agency_users.splice(props.agency_users.findIndex(ob => ob.name === user.name), 1);
        })
        .catch(error => console.error(error))
}

</script>

<template>
    <Head title="Create Agency"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between mt-4">
                <div id="primary-actions">
                    <PrimaryButton v-show="show_add_or_update_agency_btn" @click="clickSubmitBtn" class="ml-4" :class="{ 'opacity-25': agency_form.processing }"
                                   :disabled="agency_form.processing">
                        {{ (props.agency === null ? 'Save' : 'Update') }}
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
                         :tab="tab_attributes.agency"
                         data-te-nav-active/>
                </li>
                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="activateTab"
                         :tab="tab_attributes.users"
                         :disabled="agency_exist"/>
                </li>
            </template>

            <template #pill-contents>
                <Content :tab="tab_attributes.agency" data-te-tab-active>
                    <form @submit.prevent="submit">

                        <div>
                            <InputLabel for="name" value="Name"/>

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="agency_form.name"
                                required
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="agency_form.errors.name"/>
                        </div>

                        <div>
                            <InputLabel for="email" value="Email"/>

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="agency_form.email"
                                required
                                autocomplete="email"
                            />

                            <InputError class="mt-2" :message="agency_form.errors.email"/>
                        </div>
                        <button type="submit" id="submit-btn" hidden>Submit</button>
                    </form>
                </Content>
                <Content :tab="tab_attributes.users">

                    <Table table_id="agency-users-table">
                        <template #columns>
                            <Th>Name</Th>
                            <Th>Email</Th>
                            <Th>Create At</Th>
                            <Th>Actions</Th>
                        </template>
                        <template #rows>
                            <Tr v-if="agency_users !== null" v-for="user in agency_users"
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
                        <Tr v-if="non_agency_users !== null" v-for="user in filtered_non_agency_users">
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
