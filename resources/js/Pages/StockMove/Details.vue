<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Head} from "@inertiajs/vue3";
import {ref} from "vue";

const props = defineProps({
    stock_move: {
        type: Object,
    },
    variant: {
        type: Object,
    },
    next_action: {
        type: String
    },
    previous_action: {
        type: String
    },
    can: {
        type: Object
    }
});

const stock_move = ref(props.stock_move.data)
const next_action = ref(props.next_action)
const previous_action = ref(props.previous_action)
const variant = ref(props.variant.data)

const processStockMoveType = (action) => {
    axios.post(route('api.stock_moves.process', {stock_move: stock_move.value.id, action: action}))
        .then(res => {
            stock_move.value = res.data.stock_move
            next_action.value = res.data.next_action
            previous_action.value = res.data.previous_action
        })
        .catch(error => console.error(error))
}

</script>

<template>
    <Head title="Stock move"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <div>
                    <PrimaryButton v-if="next_action" @click="processStockMoveType(next_action)">
                        {{ next_action }}
                    </PrimaryButton>
                </div>
                <div>
                    <PrimaryButton v-if="previous_action" @click="processStockMoveType(previous_action)">
                        {{ previous_action }}
                    </PrimaryButton>
                </div>
            </div>
        </template>

        <div class="mb-1 flex justify-between border rounded p-2">
           <span>{{ stock_move.type }}</span>
           <span>{{ (new Date(stock_move.created_at)).toLocaleDateString() }}</span>
        </div>

        <div class="flex justify-between border rounded p-2">
            <span>{{ variant.size + ':' + variant.color }}</span>
            <span>{{ variant.sku }}</span>
            <span>{{ (new Date(variant.created_at)).toLocaleDateString() }}</span>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
