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
    closet: {
        type: Object,
    },
    closet_users: {
        type: Object,
    },
    non_closet_users: {
        type: Object,
    }
});

const closet_form = useForm({
    _method: props.closet ? 'put' : 'post',
    name: props.closet?.name ?? '',
    active: props.closet?.active ?? '',
});

const tab_attributes = {
    closet: {
        id: 'closet-form-tab',
        content_href: '#closet-form',
        content_id: 'closet-form',
        name: 'Closet'
    },
    users: {
        id: 'closet-users-tab',
        content_href: '#closet-users',
        content_id: 'closet-users',
        name: 'Users'
    },
}

const activateTab = (event) => {
    const tab_id = event.target.id;

    switch (tab_id) {
        case tab_attributes.users.id:
            show_add_user_btn.value = true;
            show_add_or_update_closet_btn.value = false;
            break;
        case tab_attributes.closet.id:
            show_add_or_update_closet_btn.value = true;
            show_add_user_btn.value = false;
            break;
    }
}

const submitClosetForm = () => {
    if (props.closet !== null) {
        if (closet_form.isDirty) {
            closet_form.post(route('closets.update', {closet: props.closet.id}), {
                onFinish: () => console.log('Closet updated'),
                onError: (err) => console.error(err)
            });
        }
    } else {
        closet_form.post(route('closets.store'), {
            onSuccess: () => console.log('Closet created'),
            onError: (err) => console.error(err)
        });
    }
};

const show_add_or_update_closet_btn = ref(true)
const show_add_user_btn = ref(false)
const show_add_user_modal = ref(false)
const search_user_input = ref('')

const filtered_non_closet_users = computed(() => {
    return filter(
        props.non_closet_users,
        ['name', 'email'],
        search_user_input.value);
})

const closet_exist = computed(() => {
    return props.closet === null;
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

    axios.post(route('api.closets.add-user', {closet: props.closet.id, user: user_id}))
        .then(res => {
            const user = res.data.user;

            if (props.closet_users.findIndex(ob => ob.name === user.name) === -1) {
                props.closet_users.push(user)
            }

            props.non_closet_users.splice(props.non_closet_users.findIndex(ob => ob.name === user.name), 1);
        })
        .catch(error => console.error(error))
}

const handleRemoveUser = (event) => {
    const target = event.target;
    const user_id = target.dataset.userId

    axios.delete(route('api.closets.remove-user', {closet: props.closet.id, user: user_id}))
        .then(res => {
            const user = res.data.user;

            if (props.non_closet_users.findIndex(ob => ob.name === user.name) === -1) {
                props.non_closet_users.push(user)
            }

            props.closet_users.splice(props.closet_users.findIndex(ob => ob.name === user.name), 1);
        })
        .catch(error => console.error(error))
}

</script>

<template>
    <Head title="Create Closet"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between mt-4">
                <div id="primary-actions">
                    <PrimaryButton v-show="show_add_or_update_closet_btn" @click="clickSubmitBtn" class="ml-4"
                                   :class="{ 'opacity-25': closet_form.processing }"
                                   :disabled="closet_form.processing">
                        {{ (props.closet === null ? 'Save' : 'Update') }}
                    </PrimaryButton>
                </div>

                <div id="secondary-actions">
                    <PrimaryButton v-show="show_add_user_btn" @click="show_add_user_modal = true">
                        Add Users
                    </PrimaryButton>
                </div>
            </div>
        </template>

        <Pill>
            <template #pill-tabs>
                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="activateTab"
                         :tab="tab_attributes.closet"
                         data-te-nav-active/>
                </li>
                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="activateTab"
                         :tab="tab_attributes.users"
                         :disabled="closet_exist"/>
                </li>
            </template>

            <template #pill-contents>
                <Content :tab="tab_attributes.closet" data-te-tab-active>
                    <form @submit.prevent="submitClosetForm">

                        <div>
                            <InputLabel for="name" value="Name"/>
                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="closet_form.name"
                                required
                                autocomplete="name"
                            />
                            <InputError class="mt-2" :message="closet_form.errors.name"/>
                        </div>

                        <div class="flex gap-2 mt-2">
                            <TextInput
                                id="active"
                                type="checkbox"
                                @change="closet_form.active = !closet_form.active"
                                model-value="closet_form.active"
                                :checked="closet_form.active === 1 ? 'checked': null"
                            />
                            <InputLabel for="active" value="Active"/>
                            <InputError class="mt-2" :message="closet_form.errors.active"/>
                        </div>

                        <progress v-if="closet_form.progress" :value="closet_form.progress.percentage" max="100">
                            {{ closet_form.progress.percentage }}%
                        </progress>

                        <button type="submit" id="submit-btn" :disabled="closet_form.processing" hidden>Submit</button>
                    </form>

                </Content>
                <Content :tab="tab_attributes.users">

                    <Table table_id="closet-users-table">
                        <template #columns>
                            <Th>Name</Th>
                            <Th>Email</Th>
                            <Th>Create At</Th>
                            <Th>Actions</Th>
                        </template>
                        <template #rows>
                            <Tr v-if="closet_users !== null" v-for="user in closet_users"
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
                        <Tr v-if="non_closet_users !== null" v-for="user in filtered_non_closet_users">
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
