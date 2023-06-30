<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import {computed, ref} from "vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Tab from "@/Components/Pill/Tab.vue";
import Content from "@/Components/Pill/Content.vue";
import Pill from "@/Components/Pill/Pill.vue";
import Th from "@/Components/Table/Th.vue";
import Tr from "@/Components/Table/Tr.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Table from "@/Components/Table/Table.vue";
import Td from "@/Components/Table/Td.vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import {filter} from "@/Modules/DataProcessing.js";

const props = defineProps({
    role: {
        type: Object,
    },
    role_permissions: {
        type: Array,
    },
    permissions: {
        type: Array,
    }
});

const role_form = useForm({
    name: props.role?.name ?? '',
    guard_name: props.role?.guard_name ?? '',
});

const tab_attributes = {
    role: {id: 'role-form-tab', content_href: '#role-form', content_id: 'role-form', name: 'Role'},
    permissions: {
        id: 'role-permissions-tab',
        content_href: '#role-permissions',
        content_id: 'role-permissions',
        name: 'Permissions'
    }
}

const submit = () => {
    if (props.role !== null) {
        if (role_form.name !== props.role.name || role_form.guard_name !== props.role.guard_name) {
            role_form.put(route('roles.update', {role: props.role.id}), {
                onFinish: () => {
                    console.log('role updated')
                }
            });
        } else {
            console.log('no change to update')
        }
    } else {
        role_form.post(route('roles.store'), {
            onFinish: () => {
                console.log('role created')
            }
        });
    }
};

const create_state = computed(() => {
    return props.role === null;
});

const show_add_or_update_role_btn = ref(true)
const show_add_permission_btn = ref(false)

const show_add_permission_modal = ref(false)
const search_permission_input = ref('')

const closetPermissionModal = () => {
    show_add_permission_modal.value = false
    search_permission_input.value = '';
}

const filtered_permissions = computed(() => {
    return filter(
        props.permissions,
        ['name', 'guard_name'],
        search_permission_input.value
    )
})

const handleRemovePermission = (event) => {
    const target = event.target;
    const permission_id = target.dataset.permissionId

    axios.delete(route('api.roles.remove-permission', {role: props.role.id, permission: permission_id}))
        .then(res => {
            const permission = res.data.permission;

            if (props.permissions.findIndex(ob => ob.id === permission.id) === -1) {
                props.permissions.push(permission)
            }

            props.role_permissions.splice(props.role_permissions.findIndex(ob => ob.id === permission.id), 1);
        })
        .catch(error => console.error(error))
}

const handleAddPermission = (event) => {
    const target = event.target;
    const permission_id = target.dataset.permissionId

    axios.post(route('api.roles.add-permission', {role: props.role.id, permission: permission_id}))
        .then(res => {
            const permission = res.data.permission;

            if (props.role_permissions.findIndex(ob => ob.id === permission.id) === -1) {
                props.role_permissions.push(permission)
            }

            props.permissions.splice(props.permissions.findIndex(ob => ob.id === permission.id), 1);
        })
        .catch(error => console.error(error))
}

const activateTab = (event) => {
    const tab_id = event.target.id;

    switch (tab_id) {
        case tab_attributes.role.id:
            show_add_permission_btn.value = false;
            show_add_or_update_role_btn.value = true;
            break;
        case tab_attributes.permissions.id:
            show_add_or_update_role_btn.value = false;
            show_add_permission_btn.value = true;
            break;
    }
}

const clickSubmitBtn = () => {
    document.getElementById('submit-btn').click();
}

</script>

<template>
    <Head title="Create Role"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center mt-4">
                <div>
                    <PrimaryButton v-show="show_add_or_update_role_btn" @click="clickSubmitBtn" class="ml-4"
                                   :class="{ 'opacity-25': role_form.processing }"
                                   :disabled="role_form.processing">
                        {{ (create_state ? 'Save' : 'Update') }}
                    </PrimaryButton>
                </div>

                <div>
                    <PrimaryButton v-show="show_add_permission_btn" @click="show_add_permission_modal = true">
                        Add Permission
                    </PrimaryButton>
                </div>
            </div>
        </template>

        <Pill>
            <template #pill-tabs>
                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="activateTab" :tab="tab_attributes.role" data-te-nav-active/>
                </li>

                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="activateTab" :tab="tab_attributes.permissions" :disabled="create_state"/>
                </li>
            </template>

            <template #pill-contents>
                <Content :tab="tab_attributes.role" data-te-tab-active>
                    <form @submit.prevent="submit">

                        <div>
                            <InputLabel for="name" value="Name"/>

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="role_form.name"
                                required
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="role_form.errors.name"/>
                        </div>

                        <div>
                            <InputLabel for="guard_name" value="Guard name"/>

                            <select name="guard_name" id="guard_name"
                                    autocomplete="guard_name" class="rounded border-1 mt-1 block w-full"
                                    required v-model="role_form.guard_name">

                                <option value="web">Web</option>
                                <option value="sanctum">Sanctum</option>
                            </select>

                            <InputError class="mt-2" :message="role_form.errors.guard_name"/>
                        </div>
                        <button type="submit" id="submit-btn" hidden>Submit</button>
                    </form>
                </Content>

                <Content :tab="tab_attributes.permissions">
                    <Table table_id="role-permissions-table">
                        <template #columns>
                            <Th>Name</Th>
                            <Th>Guard</Th>
                            <Th>Create At</Th>
                            <Th>Actions</Th>
                        </template>
                        <template #rows>
                            <Tr v-if="role_permissions !== null" v-for="permission in role_permissions"  class="capitalize">
                                <Td>{{ permission.name?.split('_',).join(' ') }}</Td>
                                <Td>{{ permission.guard_name }}</Td>
                                <Td>{{ (new Date(permission.created_at)).toLocaleDateString() }}</Td>
                                <Td>
                                    <DangerButton title="Remove Permission" class="fa-sharp fa-solid fa-trash"
                                                  :data-permission-id="permission.id" @click="handleRemovePermission"/>
                                </Td>
                            </Tr>
                        </template>
                    </Table>
                </Content>
            </template>
        </Pill>

        <Modal :show="show_add_permission_modal" @close="closetPermissionModal">
            <div class="p-6">
                <div class="flex">
                    <TextInput model-value="" type="search" v-model="search_permission_input" class="w-full mr-4"
                               placeholder="Search Permission"/>
                    <SecondaryButton class="fa-sharp fa-solid fa-xmark"
                                     @click="closetPermissionModal"></SecondaryButton>
                </div>

                <Table table_id="add-permissions-table">
                    <template #columns>
                        <Th>Name</Th>
                        <Th>Guard</Th>
                        <Th>Action</Th>
                    </template>
                    <template #rows>
                        <Tr v-if="permissions !== null" v-for="permission in filtered_permissions" class="capitalize">
                            <Td>{{ permission.name?.split('_',).join(' ') }}</Td>
                            <Td>{{ permission.guard_name }}</Td>
                            <Td>
                                <PrimaryButton title="Add Permission" class="fa-solid fa-plus"
                                               :data-permission-id="permission.id"
                                               @click="handleAddPermission"/>
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
