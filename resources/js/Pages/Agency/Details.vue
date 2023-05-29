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
import Pagination from "@/Components/Pagination.vue";
import Table from "@/Components/Table/Table.vue";
import ShowModalButton from "@/Components/Modal/ShowModalButton.vue";
import CenteredModal from "@/Components/Modal/CenteredModal.vue";

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

const show_add_user_btn = ref(false)

const agency_exist = computed(() => {
    return props.agency === null;
});

const user_table_checkbox = 'user-table-checkbox';

const clickSubmitBtn = () => {
    document.getElementById('submit-btn').click();
}

const handleAddUser = (event) => {
    const target = event.target;
    const user_id = target.dataset.userId

    axios.post(route('agencies.add-user', {agency: props.agency.id, user: user_id}))
        .then(response => console.log(response))
        .catch(error => console.error(error))
}

</script>

<template>
    <Head title="Create Agency"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between mt-4">
                <PrimaryButton @click="clickSubmitBtn" class="ml-4" :class="{ 'opacity-25': agency_form.processing }"
                               :disabled="agency_form.processing">
                    {{ (props.agency === null ? 'Save' : 'Update') }}
                </PrimaryButton>

                <ShowModalButton v-show="show_add_user_btn" data-te-target="#usersModalCenteredScrollable">Add Users</ShowModalButton>
            </div>
        </template>

        <CenteredModal id="usersModalCenteredScrollable" aria-labelledby="usersModalCenteredScrollable">
            <template #modelTitle>
                <TextInput model-value="" type="search" name="search-user" id="search-user"  class="w-full mr-4" placeholder="Search User"/>
            </template>

            <Table>
                <template #columns>
                    <Th>Name</Th>
                    <Th>Email</Th>
                    <Th>Action</Th>
                </template>
                <template #rows>
                    <Tr v-for="user in non_agency_users">
                        <Td>{{ user.name }}</Td>
                        <Td>{{ user.email }}</Td>
                        <Td>
                            <PrimaryButton @click="handleAddUser" :data-user-id="user.id">Add</PrimaryButton>
                        </Td>
                    </Tr>
                </template>
            </Table>
        </CenteredModal>

        <Pill>
            <template #pill-tabs>
                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="show_add_user_btn = false"
                        :tab="{id: 'agency-form-tab', content_href: '#agency-form', content_id: 'agency-form', name: 'Agency'}"
                        data-te-nav-active/>
                </li>
                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="show_add_user_btn = true"
                        :tab="{id: 'agency-users-tab', content_href: '#agency-users', content_id: 'agency-users', name: 'Users'}"
                        :disabled="agency_exist"/>
                </li>
            </template>

            <template #pill-contents>
                <Content :content="{id: 'agency-form', tab_id: 'agency-form-tab'}" data-te-tab-active>
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
                <Content :content="{id: 'agency-users', tab_id: 'agency-users-tab'}">

                    <Pagination :links="agency_users.links"/>

                    <Table>
                        <template #columns>
                            <Th>
                                <TextInput type="checkbox" v-bind:id="user_table_checkbox"
                                           :model-value="user_table_checkbox"/>
                            </Th>
                            <Th>Name</Th>
                            <Th>Email</Th>
                            <Th>Create At</Th>
                        </template>
                        <template #rows>
                            <Tr v-for="user in agency_users.data">
                                <Td>
                                    <TextInput type="checkbox" :model-value="user.id.toString()"/>
                                </Td>
                                <Td>{{ user.name }}</Td>
                                <Td>{{ user.email }}</Td>
                                <Td>{{ (new Date(user.created_at)).toLocaleDateString() }}</Td>
                            </Tr>
                        </template>
                    </Table>
                </Content>
            </template>
        </Pill>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
