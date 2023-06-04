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

const props = defineProps({
    user: {
        type: Object,
    }
});

const user_form = useForm({
    name: props.user?.name ?? '',
    email: props.user?.email ?? '',
});

const tab_attributes = {
    user: {id: 'user-form-tab', content_href: '#user-form', content_id: 'user-form', name: 'User'},
    roles: {id: 'user-roles-tab', content_href: '#user-roles', content_id: 'user-roles', name: 'Roles'},
    permissions: {
        id: 'user-permissions-tab',
        content_href: '#user-permissions',
        content_id: 'user-permissions',
        name: 'Permissions'
    }
}

const submit = () => {
    if (props.user !== null) {
        if (user_form.name !== props.user.name || user_form.email !== props.user.email) {
            user_form.put(route('users.update', {user: props.user.id}), {
                onFinish: () => {
                    console.log('User updated')
                }
            });
        } else {
            console.log('no change to update')
        }
    } else {
        user_form.post(route('users.store'), {
            onFinish: () => {
                console.log('User created')
            }
        });
    }
};

const create_state = computed(() => {
    return props.user === null;
});

const show_add_or_update_user_btn = ref(true)
const show_add_role_btn = ref(false)
const show_add_permission_btn = ref(false)

const activateTab = (event) => {
    const tab_id = event.target.id;

    switch (tab_id) {
        case tab_attributes.user.id:
            show_add_role_btn.value = false;
            show_add_permission_btn.value = false;
            show_add_or_update_user_btn.value = true;
            break;
        case tab_attributes.roles.id:
            show_add_or_update_user_btn.value = false;
            show_add_permission_btn.value = false;
            show_add_role_btn.value = true;
            break;
        case tab_attributes.permissions.id:
            show_add_role_btn.value = false;
            show_add_or_update_user_btn.value = false;
            show_add_permission_btn.value = true;
            break;
    }
}

const clickSubmitBtn = () => {
    document.getElementById('submit-btn').click();
}

</script>

<template>
    <Head title="Create User"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center mt-4">
                <div>
                    <PrimaryButton v-show="show_add_or_update_user_btn" @click="clickSubmitBtn" class="ml-4"
                                   :class="{ 'opacity-25': user_form.processing }"
                                   :disabled="user_form.processing">
                        {{ (create_state ? 'Save' : 'Update') }}
                    </PrimaryButton>
                </div>

                <div>
                    <PrimaryButton v-show="show_add_role_btn" @click="console.log('show add role modal')">
                        Add Role
                    </PrimaryButton>
                    <PrimaryButton v-show="show_add_permission_btn" @click="console.log('show add permission modal')">
                        Add Permission
                    </PrimaryButton>
                </div>
            </div>
        </template>

        <Pill>
            <template #pill-tabs>
                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="activateTab" :tab="tab_attributes.user" data-te-nav-active/>
                </li>
                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="activateTab" :tab="tab_attributes.roles" :disabled="create_state"/>
                </li>

                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="activateTab" :tab="tab_attributes.permissions" :disabled="create_state"/>
                </li>
            </template>

            <template #pill-contents>
                <Content :tab="tab_attributes.user" data-te-tab-active>
                    <form @submit.prevent="submit">

                        <div>
                            <InputLabel for="name" value="Name"/>

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="user_form.name"
                                required
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="user_form.errors.name"/>
                        </div>

                        <div>
                            <InputLabel for="email" value="Email"/>

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="user_form.email"
                                required
                                autocomplete="email"
                            />

                            <InputError class="mt-2" :message="user_form.errors.email"/>
                        </div>
                        <button type="submit" id="submit-btn" hidden>Submit</button>
                    </form>
                </Content>
                <Content :tab="tab_attributes.roles">
                    roles
                </Content>

                <Content :tab="tab_attributes.permissions">
                    permissions
                </Content>
            </template>
        </Pill>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
