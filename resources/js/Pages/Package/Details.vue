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
import {filter} from "@/Modules/DataProcessing.js";

const props = defineProps({
    package: {
        type: Object,
    },
    package_variants: {
        type: Object,
    },
    none_package_variants: {
        type: Object,
    }
});

const package_variants = computed(() => {
    return props.package_variants?.data;
});

const package_form = useForm({
    _method: props.package ? 'put' : 'post',
    name: props.package?.name ?? '',
    desc: props.package?.desc ?? '',
    closet_id: props.closet?.id ?? '',
});

const tab_attributes = {
    package: {
        id: 'package-form-tab',
        content_href: '#package-form',
        content_id: 'package-form',
        name: 'Package'
    },
    variants: {
        id: 'package-variants-tab',
        content_href: '#package-variants',
        content_id: 'package-variants',
        name: 'Variants'
    },
}

const activateTab = (event) => {
    const tab_id = event.target.id;

    switch (tab_id) {
        case tab_attributes.variants.id:
            show_add_variant_btn.value = true;
            show_add_or_update_package_btn.value = false;
            break;
        case tab_attributes.package.id:
            show_add_or_update_package_btn.value = true;
            show_add_variant_btn.value = false;
            break;
    }
}

const submitPackageForm = () => {
    if (props.package !== null) {
        if (package_form.isDirty) {
            package_form.post(route('packages.update', {package: props.package.id}), {
                onFinish: () => console.log('Package updated'),
                onError: (err) => console.error(err)
            });
        }
    } else {
        package_form.post(route('packages.store'), {
            onSuccess: () => console.log('Package created'),
            onError: (err) => console.error(err)
        });
    }
};

const show_add_or_update_package_btn = ref(true)
const show_add_variant_btn = ref(false)
const show_add_variant_modal = ref(false)
const search_variant_input = ref('')

const filtered_non_package_variants = computed(() => {
    return filter(
        props.none_package_variants?.data,
        ['sku', 'size', 'color'],
        search_variant_input.value);
})

const package_exist = computed(() => {
    return props.package === null;
});

const packageVariantModal = () => {
    show_add_variant_modal.value = false
    search_variant_input.value = '';
}

const clickSubmitBtn = () => {
    document.getElementById('submit-btn').click();
}

const handleAddVariant = (event) => {
    const target = event.target;
    const variant_id = target.dataset.variantId

    axios.post(route('api.packages.add-variant', {package: props.package.id, variant: variant_id}))
        .then(res => {
            const variant = res.data.variant;

            if (props.package_variants?.data.findIndex(ob => ob.sku === variant.sku) === -1) {
                props.package_variants?.data.push(variant)
            }

            props.none_package_variants?.data.splice(props.none_package_variants?.data.findIndex(ob => ob.sku === variant.sku), 1);
        })
        .catch(error => console.error(error))
}

const handleRemoveVariant = (event) => {
    const target = event.target;
    const variant_id = target.dataset.variantId

    axios.delete(route('api.packages.remove-variant', {package: props.package.id, variant: variant_id}))
        .then(res => {
            const variant = res.data.variant;

            if (props.none_package_variants?.data.findIndex(ob => ob.sku === variant.sku) === -1) {
                props.none_package_variants?.data.push(variant)
            }

            props.package_variants?.data.splice(props.package_variants?.data.findIndex(ob => ob.sku === variant.sku), 1);
        })
        .catch(error => console.error(error))
}

</script>

<template>
    <Head title="Create Package"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between mt-4">
                <div id="primary-actions">
                    <PrimaryButton v-show="show_add_or_update_package_btn" @click="clickSubmitBtn" class="ml-4"
                                   :class="{ 'opacity-25': package_form.processing }"
                                   :disabled="package_form.processing">
                        {{ (props.package === null ? 'Save' : 'Update') }}
                    </PrimaryButton>
                </div>

                <div id="secondary-actions">
                    <PrimaryButton v-show="show_add_variant_btn" @click="show_add_variant_modal = true">
                        Add Variants
                    </PrimaryButton>
                </div>
            </div>
        </template>

        <Pill>
            <template #pill-tabs>
                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="activateTab"
                         :tab="tab_attributes.package"
                         data-te-nav-active/>
                </li>
                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="activateTab"
                         :tab="tab_attributes.variants"
                         :disabled="package_exist"/>
                </li>
            </template>

            <template #pill-contents>
                <Content :tab="tab_attributes.package" data-te-tab-active>
                    <form @submit.prevent="submitPackageForm">

                        <div>
                            <InputLabel for="name" value="Name"/>
                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="package_form.name"
                                required
                                autocomplete="name"
                            />
                            <InputError class="mt-2" :message="package_form.errors.name"/>
                        </div>

                        <div v-if="props.package">
                            <InputLabel for="state" value="State"/>
                            <TextInput
                                id="state"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="package.state"
                                disabled
                            />
                        </div>

                        <div>
                            <InputLabel for="description" value="Description"/>

                            <textarea
                                class="w-full rounded px-3 py-[0.32rem] leading-[1.6] outline-none"
                                id="description"
                                rows="3"
                                v-model="package_form.desc"
                                placeholder="Package description">
                            </textarea>

                            <InputError class="mt-2" :message="package_form.errors.desc"/>
                        </div>

                        <progress v-if="package_form.progress" :value="package_form.progress.percentage" max="100">
                            {{ package_form.progress.percentage }}%
                        </progress>

                        <button type="submit" id="submit-btn" :disabled="package_form.processing" hidden>Submit</button>
                    </form>

                </Content>
                <Content :tab="tab_attributes.variants">

                    <Table table_id="package-variants-table">
                        <template #columns>
                            <Th>Sku</Th>
                            <Th>Size</Th>
                            <Th>Color</Th>
                            <Th>Create At</Th>
                            <Th>Actions</Th>
                        </template>
                        <template #rows>
                            <Tr v-if="package_variants !== null" v-for="variant in package_variants">
                                <Td>{{ variant.sku }}</Td>
                                <Td>{{ variant.size }}</Td>
                                <Td>{{ variant.color }}</Td>
                                <Td>{{ (new Date(variant.created_at)).toLocaleDateString() }}</Td>
                                <Td>
                                    <DangerButton title="Remove Variant" class="fa-sharp fa-solid fa-trash"
                                                  :data-variant-id="variant.id" @click.stop
                                                  @click="handleRemoveVariant"/>
                                </Td>
                            </Tr>
                        </template>
                    </Table>
                </Content>
            </template>
        </Pill>

        <Modal :show="show_add_variant_modal" @close="packageVariantModal">
            <div class="p-6">
                <div class="flex">
                    <TextInput model-value="" type="search" v-model="search_variant_input" class="w-full mr-4"
                               placeholder="Search Variant"/>
                    <SecondaryButton class="fa-sharp fa-solid fa-xmark"
                                     @click="packageVariantModal"></SecondaryButton>
                </div>

                <Table table_id="add-variants-table">
                    <template #columns>
                        <Th>Sku</Th>
                        <Th>Size</Th>
                        <Th>Color</Th>
                        <Th>Actions</Th>
                    </template>
                    <template #rows>
                        <Tr v-if="filtered_non_package_variants !== null" v-for="variant in filtered_non_package_variants">
                            <Td>{{ variant.sku }}</Td>
                            <Td>{{ variant.size }}</Td>
                            <Td>{{ variant.color }}</Td>
                            <Td>
                                <PrimaryButton title="Add Variant" class="fa-solid fa-plus"
                                               :data-variant-id="variant.id"
                                               @click="handleAddVariant"/>
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
