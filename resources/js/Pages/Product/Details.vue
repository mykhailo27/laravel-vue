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
import {currency} from "@/Config/Currency.js";
import Select from "@/Components/Select.vue";

const props = defineProps({
    product: {
        type: Object,
    },
    product_variants: {
        type: Object,
    },
    sizes: {
        type: Object,
    },
    colors: {
        type: Object,
    }
});


const product_variants = computed(() => {
    return props.product_variants?.data;
});

const product_form = useForm({
    _method: props.product ? 'put' : 'post',
    name: props.product?.name ?? '',
    sku: props.product?.sku ?? '',
    desc: props.product?.desc ?? '',
    price: props.product?.price ?? '',
});

const tab_attributes = {
    product: {
        id: 'product-form-tab',
        content_href: '#product-form',
        content_id: 'product-form',
        name: 'Product'
    },
    variants: {
        id: 'product-variants-tab',
        content_href: '#product-variants',
        content_id: 'product-variants',
        name: 'Variants'
    },
}

const activateTab = (event) => {
    const tab_id = event.target.id;

    switch (tab_id) {
        case tab_attributes.variants.id:
            show_add_variant_btn.value = true;
            show_add_or_update_product_btn.value = false;
            break;
        case tab_attributes.product.id:
            show_add_or_update_product_btn.value = true;
            show_add_variant_btn.value = false;
            break;
    }
}

const handleDeleteVariant = (event) => {
    const target = event.target;
    const variant_id = Number(target.dataset.variantId)

    axios.delete(route('api.variants.delete', {id: variant_id}))
        .then(res => {
            if (res.data.success) {
                props.product_variants.data.splice(props.product_variants.data.findIndex(ob => ob.id === variant_id), 1);
            }
        })
        .catch(error => console.error(error))
}

const submitProductForm = () => {
    if (props.product !== null) {
        if (product_form.isDirty) {
            product_form.post(route('products.update', {product: props.product.id}), {
                onFinish: () => console.log('Product updated'),
                onError: (err) => console.error(err)
            });
        }
    } else {
        product_form.post(route('products.store'), {
            onSuccess: () => console.log('Product created'),
            onError: (err) => console.error(err)
        });
    }
};

const show_add_or_update_product_btn = ref(true)
const show_add_variant_btn = ref(false)
const show_add_variant_modal = ref(false)
const show_stock_move_intake_modal = ref(false)

const product_exist = computed(() => {
    return props.product === null;
});

const closetVariantModal = () => {
    show_add_variant_modal.value = false
}

const clickSubmitBtn = () => {
    document.getElementById('submit-btn').click();
}

const stockMoveIntakeModelSwitch = (switch_on) => {
    show_stock_move_intake_modal.value = switch_on
}

const variant_form = useForm({
    size_id: '',
    color_id: '',
})

const stock_move_intake_form = useForm({
    variant_id: '',
    amount: 1,
})

const submitVariantForm = () => {
    variant_form.post(route('products.add-variant', {product: props.product.id}), {
        onSuccess: () => console.log('Variant created'),
        onError: (err) => console.error(err)
    });
}

const submitStockMoveIntakeForm = () => {
    axios.post(route('api.products.stock_move-intake'), {
        variant_id: stock_move_intake_form.variant_id,
        amount: stock_move_intake_form.amount,
    }).then(res => {
        res.data.success
            ? stockMoveIntakeModelSwitch(false)
            : console.warn(res)
    }).catch(error => console.error(error))
}

const getSizes = computed(() => {
    return props.sizes.reduce((sizes, size) => {
        sizes.push({name: size.name, value: size.id})
        return sizes;
    }, [])
})

const getColors = computed(() => {
    return props.colors.reduce((colors, color) => {
        colors.push({name: color.name, value: color.id})
        return colors;
    }, [])
})

const getVariants = computed(() => {
    return product_variants.value.reduce((variants, variant) => {
        variants.push({name: variant.sku, value: variant.id})
        return variants;
    }, [])
})

</script>

<template>
    <Head title="Create Product"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between mt-4">
                <div id="primary-actions">
                    <PrimaryButton v-show="show_add_or_update_product_btn" @click="clickSubmitBtn" class="ml-4"
                                   :class="{ 'opacity-25': product_form.processing }"
                                   :disabled="product_form.processing">
                        {{ (props.product === null ? 'Save' : 'Update') }}
                    </PrimaryButton>
                </div>

                <div id="secondary-actions">
                    <PrimaryButton class="mr-1" @click="stockMoveIntakeModelSwitch(true)">
                        Intake
                    </PrimaryButton>
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
                         :tab="tab_attributes.product"
                         data-te-nav-active/>
                </li>
                <li role="presentation" class="flex-grow text-center">
                    <Tab @click="activateTab"
                         :tab="tab_attributes.variants"
                         :disabled="product_exist"/>
                </li>
            </template>

            <template #pill-contents>
                <Content :tab="tab_attributes.product" data-te-tab-active>
                    <form @submit.prevent="submitProductForm">

                        <div>
                            <InputLabel for="name" value="Name"/>
                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="product_form.name"
                                required
                                autocomplete="name"
                            />
                            <InputError class="mt-2" :message="product_form.errors.name"/>
                        </div>

                        <div>
                            <InputLabel for="sku" value="Sku"/>
                            <TextInput
                                id="sku"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="product_form.sku"
                                required
                            />
                            <InputError class="mt-2" :message="product_form.errors.sku"/>
                        </div>

                        <div>
                            <InputLabel for="price" value="Price"/>

                            <div class="relative flex flex-wrap items-stretch">
                                <TextInput
                                    id="price"
                                    type="text"
                                    class="relative m-0 -ml-px block w-[1px] min-w-0 flex-auto rounded-none rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                                    aria-label="Dollar amount (with dot and two decimal places)"
                                    v-model="product_form.price"
                                    required
                                />

                                <span
                                    class="flex items-center whitespace-nowrap rounded-r border border-solid border-neutral-300 px-3 py-[0.25rem] text-center text-base font-normal leading-[1.6] text-neutral-700 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200">
                                    {{ currency.EURO }}</span>
                            </div>
                            <InputError class="mt-2" :message="product_form.errors.price"/>
                        </div>

                        <div>
                            <InputLabel for="description" value="Description"/>

                            <textarea
                                class="w-full rounded px-3 py-[0.32rem] leading-[1.6] outline-none"
                                id="description"
                                rows="3"
                                v-model="product_form.desc"
                                placeholder="Product description">
                            </textarea>

                            <InputError class="mt-2" :message="product_form.errors.desc"/>
                        </div>

                        <progress v-if="product_form.progress" :value="product_form.progress.percentage" max="100">
                            {{ product_form.progress.percentage }}%
                        </progress>

                        <button type="submit" id="submit-btn" :disabled="product_form.processing" hidden>Submit</button>
                    </form>

                </Content>

                <Content :tab="tab_attributes.variants">

                    <Table table_id="product-variants-table">
                        <template #columns>
                            <Th>Sku</Th>
                            <Th>Size</Th>
                            <Th>Color</Th>
                            <Th>Create At</Th>
                            <Th>Actions</Th>
                        </template>
                        <template #rows>
                            <Tr v-if="product_variants !== null" v-for="variant in product_variants">
                                <Td>{{ variant.sku }}</Td>
                                <Td>{{ variant.size }}</Td>
                                <Td>{{ variant.color }}</Td>
                                <Td>{{ (new Date(variant.created_at)).toLocaleDateString() }}</Td>
                                <Td>
                                    <DangerButton title="Remove Variant" class="fa-sharp fa-solid fa-trash"
                                                  :data-variant-id="variant.id" @click.stop
                                                  @click="handleDeleteVariant"/>
                                </Td>
                            </Tr>
                        </template>
                    </Table>
                </Content>
            </template>
        </Pill>

        <Modal :show="show_add_variant_modal" @close="closetVariantModal">
            <div class="p-6">
                <div class="flex justify-between">
                    <h4>Create Variant</h4>
                    <SecondaryButton class="fa-sharp fa-solid fa-xmark"
                                     @click="closetVariantModal"></SecondaryButton>
                </div>

                <form @submit.prevent="submitVariantForm">

                    <div class="mt-4">
                        <Select v-if="sizes"
                                @update:modelValue="value => variant_form.size_id = value"
                                :options="getSizes" label="Size"/>
                    </div>

                    <div class="mt-4">
                        <Select v-if="colors"
                                @update:modelValue="value => variant_form.color_id = value"
                                :options="getColors" label="Color"/>
                    </div>

                    <progress v-if="variant_form.progress" :value="variant_form.progress.percentage" max="100">
                        {{ variant_form.progress.percentage }}%
                    </progress>

                    <PrimaryButton type="submit" class="float-right my-2" :disabled="variant_form.processing">Add
                    </PrimaryButton>

                </form>
            </div>
        </Modal>

        <Modal :show="show_stock_move_intake_modal" @close="stockMoveIntakeModelSwitch(false)">
            <div class="p-6">
                <div class="flex justify-between">
                    <h4>Stock Move Intake</h4>
                    <SecondaryButton class="fa-sharp fa-solid fa-xmark"
                                     @click="stockMoveIntakeModelSwitch(false)"></SecondaryButton>
                </div>

                <form @submit.prevent="submitStockMoveIntakeForm">

                    <div class="mt-4">
                        <Select v-if="product_variants"
                                @update:modelValue="value => stock_move_intake_form.variant_id = value"
                                :options="getVariants" label="Variant"/>
                    </div>

                    <div>
                        <InputLabel for="amount" value="Amount"/>
                        <TextInput
                            id="amount"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="stock_move_intake_form.amount"
                            required
                        />
                        <InputError class="mt-2" :message="stock_move_intake_form.errors.amount"/>
                    </div>

                    <progress v-if="stock_move_intake_form.progress"
                              :value="stock_move_intake_form.progress.percentage" max="100">
                        {{ stock_move_intake_form.progress.percentage }}%
                    </progress>

                    <PrimaryButton type="submit" class="float-right my-2"
                                   :disabled="stock_move_intake_form.processing">
                        Intake
                    </PrimaryButton>

                </form>
            </div>
        </Modal>

    </AuthenticatedLayout>
</template>

<style scoped>

</style>
