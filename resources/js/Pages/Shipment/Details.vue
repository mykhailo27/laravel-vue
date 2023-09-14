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
import AccordionContainer from "@/Components/Accordion/AccordionContainer.vue";
import AccordionItem from "@/Components/Accordion/AccordionItem.vue";

const props = defineProps({
    shipment: {
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
    shipment_variants: {
        type: Object,
    },
    none_shipment_variants: {
        type: Object,
    }
});

const shipment_form = useForm({
    _method: props.shipment ? 'put' : 'post',
    recipient_name: props.shipment?.recipient_name ?? '',
    recipient_email: props.shipment?.recipient_email ?? '',
    recipient_phone: props.shipment?.recipient_phone ?? '',
});

const address_form = useForm({
    _method: props.address ? 'put' : 'post',
    line_1: props.address?.line_1 ?? '',
    line_2: props.address?.line_2 ?? '',
    zip_code: props.address?.zip_code ?? '',
    city: props.address?.city ?? '',
    state_or_region: props.address?.state_or_region ?? '',
    country_id: props.country?.id ?? '',
    addressable_id: props.shipment?.id,
    addressable_type: 'App\\Models\\Shipment',
})

const tab_attributes = {
    shipment: {
        id: 'shipment-form-tab',
        content_href: '#shipment-form',
        content_id: 'shipment-form',
        name: 'Shipment'
    },
    variants: {
        id: 'shipment-variants-tab',
        content_href: '#shipment-variants',
        content_id: 'shipment-variants',
        name: 'Variants'
    },
}

const activateTab = (event) => {
    const tab_id = event.target.id;

    switch (tab_id) {
        case tab_attributes.variants.id:
            show_add_variant_btn.value = true;
            show_add_or_update_variant_btn.value = false;
            break;
        case tab_attributes.shipment.id:
            show_add_or_update_variant_btn.value = true;
            show_add_variant_btn.value = false;
            break;
    }
}

const submitCompanyForm = () => {
    if (props.shipment !== null) {
        if (shipment_form.isDirty) {
            shipment_form.post(route('shipments.update', {shipment: props.shipment.id}), {
                onFinish: () => console.log('Shipment updated'),
                onError: (err) => console.error(err)
            });
        }
    } else {
        shipment_form.post(route('shipments.store'), {
            onSuccess: () => console.log('Shipment created'),
            onError: (err) => console.error(err)
        });
    }
};

const submitAddressForm = () => {
    if (props.address !== null) {
        if (address_form.isDirty) {
            address_form.post(route('address.update', {address: props.address.id}), {
                onSuccess: () => console.log('address updated'),
                onError: (err) => console.error(err)
            });
        }
    } else {
        address_form.post(route('address.store', {model: props.shipment.id}), {
            onSuccess: () => console.log('address created'),
            onError: (err) => console.error(err)
        });
    }
};

const getCountries = computed(() => {
    return props.countries.reduce((countries, country) => {
        countries.push({name: country.name, value: country.id})
        return countries;
    }, [])
})

const show_add_or_update_variant_btn = ref(true)
const show_add_variant_btn = ref(false)
const show_add_variant_modal = ref(false)
const search_variant_input = ref('')

const filtered_none_shipment_variants = computed(() => {
    return filter(
        props.none_shipment_variants?.data,
        ['name', 'color', 'size'],
        search_variant_input.value);
})

const variant_exist = computed(() => {
    return props.shipment === null;
});

const closetVariantModal = () => {
    show_add_variant_modal.value = false
    search_variant_input.value = '';
}

const clickSubmitBtn = () => {
    document.getElementById('submit-btn').click();
}

const handleAddVariant = (event) => {
    const target = event.target;
    const variant_id = target.dataset.variantId
    const quantity_el = document.getElementById('quantity_' + variant_id)

    axios.post(route('api.shipments.add-variant', {shipment: props.shipment.id, variant: variant_id, quantity: quantity_el.value}))
        .then(res => {
            const variant = res.data.variant;

            if (props.shipment_variants?.data.findIndex(ob => ob.sku === variant.sku) === -1) {
                props.shipment_variants?.data.push(variant)
            }

            props.none_shipment_variants?.data.splice(props.none_shipment_variants?.data.findIndex(ob => ob.sku === variant.sku), 1);
        })
        .catch(error => console.error(error))
}

const handleRemoveVariant = (event) => {
    const target = event.target;
    const variant_id = target.dataset.variantId

    axios.delete(route('api.shipments.remove-variant', {shipment: props.shipment.id, variant: variant_id}))
        .then(res => {
            const variant = res.data.variant;

            if (props.none_shipment_variants?.data.findIndex(ob => ob.sku === variant.sku) === -1) {
                props.none_shipment_variants?.data.push(variant)
            }

            props.shipment_variants?.data.splice(props.shipment_variants?.data.findIndex(ob => ob.sku === variant.sku), 1);
        })
        .catch(error => console.error(error))
}

const shipment_variants = computed(function () {
    return props.shipment_variants?.data;
})

</script>

<template>
    <Head title="Create Shipment"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between mt-4">
                <div id="primary-actions">
                    <PrimaryButton v-show="show_add_or_update_variant_btn" @click="clickSubmitBtn" class="ml-4"
                                   :class="{ 'opacity-25': shipment_form.processing }"
                                   :disabled="shipment_form.processing">
                        {{ (props.shipment === null ? 'Save' : 'Update') }}
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
                         :tab="tab_attributes.shipment"
                         data-te-nav-active/>
                </li>
                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="activateTab"
                         :tab="tab_attributes.variants"
                         :disabled="variant_exist"/>
                </li>
            </template>

            <template #pill-contents>
                <Content :tab="tab_attributes.shipment" data-te-tab-active>
                    <form @submit.prevent="submitCompanyForm">

                        <div>
                            <InputLabel for="recipient_name" value="Recipient Name"/>
                            <TextInput
                                id="recipient_name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="shipment_form.recipient_name"
                                required
                                autocomplete="recipient_name"
                            />
                            <InputError class="mt-2" :message="shipment_form.errors.recipient_name"/>
                        </div>

                        <div>
                            <InputLabel for="recipient_email" value="Recipient Name"/>
                            <TextInput
                                id="recipient_email"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="shipment_form.recipient_email"
                                required
                            />
                            <InputError class="mt-2" :message="shipment_form.errors.recipient_email"/>
                        </div>

                        <div>
                            <InputLabel for="recipient_phone" value="Recipient Phone"/>
                            <TextInput
                                id="recipient_phone"
                                type="tel"
                                class="mt-1 block w-full"
                                v-model="shipment_form.recipient_phone"
                                required
                            />
                            <InputError class="mt-2" :message="shipment_form.errors.recipient_phone"/>
                        </div>

                        <progress v-if="shipment_form.progress" :value="shipment_form.progress.percentage" max="100">
                            {{ shipment_form.progress.percentage }}%
                        </progress>

                        <button type="submit" id="submit-btn" :disabled="shipment_form.processing" hidden>Submit
                        </button>
                    </form>

                    <!-- Address -->
                    <AccordionContainer v-if="shipment" id="address_accordion" class="mt-2">
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

                <Content :tab="tab_attributes.variants">

                    <Table table_id="shipment-variants-table">
                        <template #columns>
                            <Th>Name</Th>
                            <Th>Price</Th>
                            <Th>Quantity</Th>
                            <Th>Size</Th>
                            <Th>Color</Th>
                            <Th>Create At</Th>
                            <Th>Actions</Th>
                        </template>
                        <template #rows>
                            <Tr v-if="shipment_variants !== null" v-for="variant in shipment_variants"
                                @click="handleRowClick(variant.id, route('variants.details', {variant: '__ROW_ID__'}))">
                                <Td>{{ variant.name }}</Td>
                                <Td>{{ variant.price }} €</Td>
                                <Td>{{ variant.quantity }}</Td>
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

        <Modal :show="show_add_variant_modal" @close="closetVariantModal">
            <div class="p-6">
                <div class="flex">
                    <TextInput model-value="" type="search" v-model="search_variant_input" class="w-full mr-4"
                               placeholder="Search Variant"/>
                    <SecondaryButton class="fa-sharp fa-solid fa-xmark"
                                     @click="closetVariantModal"></SecondaryButton>
                </div>

                <Table table_id="add-variants-table">
                    <template #columns>
                        <Th>Name</Th>
                        <Th>Price</Th>
                        <Th>Size</Th>
                        <Th>Color</Th>
                        <Th>Quantity</Th>
                        <Th>Actions</Th>
                    </template>
                    <template #rows>
                        <Tr v-if="none_shipment_variants !== null" v-for="variant in filtered_none_shipment_variants">
                            <Td>{{ variant.name }}</Td>
                            <Td>{{ variant.price }}</Td>
                            <Td>{{ variant.size }}</Td>
                            <Td>{{ variant.color }}</Td>
                            <Td>
                                <TextInput
                                    :id="'quantity_' + variant.id"
                                    type="number"
                                    class="mt-1 block w-full py-0.5 pl-1"
                                    model-value="1"
                                    min="1"
                                    required
                                />
                            </Td>
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
