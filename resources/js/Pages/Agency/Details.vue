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

const props = defineProps({
    agency: {
        type: Object,
    }
});

const form = useForm({
    name: props.agency?.name ?? '',
    email: props.agency?.email ?? '',
});

const submit = () => {
    if (props.agency !== null) {
        form.put(route('agencies.update', {agency: props.agency.id}), {
            onFinish: () => {
                console.log('Agency updated')
            }
        });
    } else {
        form.post(route('agencies.store'), {
            onFinish: () => {
                console.log('Agency created')
            }
        });
    }
};

const clickSubmitBtn = () => {
    document.getElementById('submit-btn').click();
}

</script>

<template>
    <Head title="Create Agency"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-start mt-4">
                <PrimaryButton @click="clickSubmitBtn" class="ml-4" :class="{ 'opacity-25': form.processing }"
                               :disabled="form.processing">
                    {{ (props.agency === null ? 'Save': 'Update') }}
                </PrimaryButton>
            </div>
        </template>

        <Pill>
            <template #pill-tabs>
                <li role="presentation" class="flex-grow text-center">
                    <Tab :tab="{id: 'agency-form-tab', content_href: '#agency-form', content_id: 'agency-form', name: 'Agency', active:'true'}"
                         data-te-nav-active/>
                </li>
                <li role="presentation" class="flex-grow text-center">
                    <Tab :tab="{id: 'agency-user-tab', content_href: '#agency-user', content_id: 'agency-user', name: 'User'}"/>
                </li>
            </template>
            <template #pill-contents>
                <Content :content="{id: 'agency-form', tab_id: 'agency-form-tab'}" data-te-tab-active>
                    <form @submit.prevent="submit">

                        <div class="mt-4">
                            <InputLabel for="name" value="Name"/>

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>

                        <div>
                            <InputLabel for="email" value="Email"/>

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                autocomplete="email"
                            />

                            <InputError class="mt-2" :message="form.errors.email"/>
                        </div>
                        <button type="submit" id="submit-btn" hidden>Submit</button>
                    </form>
                </Content>
                <Content :content="{id: 'agency-user', tab_id: 'agency-user-tab'}">
                    Agency user
                </Content>
            </template>
        </Pill>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
