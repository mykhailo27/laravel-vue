<script setup>

import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import Toast from "@/Components/Toast.vue";

const props = defineProps({
    country: {
        type: Object,
    }
});

const country_form = useForm({
    _method: 'put',
    name: props.country.name,
    alpha_2: props.country.alpha_2,
    alpha_3: props.country.alpha_3,
    enabled: !!props.country.enabled,
    aliases: props.country.aliases,
    zip_code_regex: props.country.zip_code_regex,
});

const submitCountryForm = () => {
    if (country_form.isDirty) {
        country_form.post(route('countries.update', {country: props.country.id}), {
            onFinish: () => console.log('Country updated'),
            onError: (err) => console.error(err)
        });
    }
};

const clickSubmitBtn = () => {
    document.getElementById('submit-btn').click();
}

const removeAlias = (alias) => {
    const index = country_form.aliases.indexOf(alias)
    if (index !== -1) {
        country_form.aliases.splice(index, 1)
    }
    console.log(country_form.aliases)
}

const addAlias = () => {
    const alias_el = document.querySelector('#alias-input')
    const alias = alias_el.value
    alias_el.value = null;

    if (country_form.aliases.indexOf(alias) === -1) {
        country_form.aliases.push(alias)
    }
    console.log(country_form.aliases)
}

</script>

<template>
    <Head title="Index Country"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between mt-4">
                <div id="primary-actions">
                    <PrimaryButton @click="clickSubmitBtn" class="ml-4"
                                   :class="{ 'opacity-25': country_form.processing }"
                                   :disabled="country_form.processing">
                        Update
                    </PrimaryButton>
                </div>
            </div>
        </template>

        <form @submit.prevent="submitCountryForm">

            <div>
                <InputLabel for="name" value="Name"/>
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="country_form.name"
                    required
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="country_form.errors.name"/>
            </div>

            <div>
                <InputLabel for="alpha_2" value="Alpha 2"/>
                <TextInput
                    id="alpha_2"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="country_form.alpha_2"
                    required
                />
                <InputError class="mt-2" :message="country_form.errors.alpha_2"/>
            </div>

            <div>
                <InputLabel for="alpha_3" value="Alpha 3"/>
                <TextInput
                    id="alpha_3"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="country_form.alpha_3"
                    required
                />
                <InputError class="mt-2" :message="country_form.errors.alpha_3"/>
            </div>

            <div>
                <InputLabel for="zip_code_regex" value="Zip Code Regex"/>
                <TextInput
                    id="zip_code_regex"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="country_form.zip_code_regex"
                    required
                />
                <InputError class="mt-2" :message="country_form.errors.zip_code_regex"/>
            </div>

            <div id="aliases-list">
                <InputLabel for="aliases" value="Aliases"/>
                <div class="flex gap-x-2">
                    <Toast :dismissible="false" v-for="alias in country_form.aliases" :message="alias" @close="removeAlias(alias)"/>
                </div>
                <InputError class="mt-2" :message="country_form.errors.aliases"/>
            </div>

            <div class="my-4 flex flex-wrap items-stretch">
                <input
                    id="alias-input"
                    type="text"
                    class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                    placeholder="New alias"
                    aria-label="Recipient's username"
                    aria-describedby="button-addon2"/>
                <button
                    class="z-[2] inline-block rounded-r bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:z-[3] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                    data-te-ripple-init
                    type="button"
                    @click="addAlias()"
                    id="button-addon2">
                    Add
                </button>
            </div>

            <div class="mt-2">
                <label class="flex items-center">
                    <Checkbox name="enabled" v-model:checked="country_form.enabled"/>
                    <span class="ml-2 text-sm text-gray-600">Enabled</span>
                </label>
            </div>

            <button type="submit" id="submit-btn" :disabled="country_form.processing" hidden>Submit</button>
        </form>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
