<script setup>

import {Toast, initTE} from "tw-elements";
import {onMounted} from "vue";

defineProps({
    message: {
        type: String,
        required: true
    },
    small_info: {
        type: String
    },
    details: {
        type: String
    }
})

defineEmits(['close']);

onMounted(() => {
    initTE({ Toast });
})

</script>

<template>
    <div
        class="pointer-events-auto hidden w-fit max-w-full rounded-lg bg-white bg-clip-padding text-sm shadow-lg shadow-black/5 data-[te-toast-show]:block data-[te-toast-hide]:hidden dark:bg-neutral-600"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        data-te-autohide="false"
        data-te-toast-init
        data-te-toast-show>
        <div
            class="flex items-center justify-between rounded-t-lg border-b-2 border-neutral-100 border-opacity-100 bg-white bg-clip-padding px-4 pb-2 pt-2.5 dark:border-opacity-50 dark:bg-neutral-600">
            <p class="font-bold text-neutral-500 dark:text-neutral-200">
                {{ message }}
            </p>
            <div class="flex items-center">
                <p v-if="small_info" class="text-xs text-neutral-600 dark:text-neutral-300">
                    {{ small_info }}
                </p>
                <button
                    type="button"
                    @click="$emit('close')"
                    class="ml-2 box-content rounded-none border-none opacity-80 hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                    data-te-toast-dismiss
                    aria-label="Close">
                    <span
                        class="w-[1em] focus:opacity-100 disabled:pointer-events-none disabled:select-none disabled:opacity-25 [&.disabled]:pointer-events-none [&.disabled]:select-none [&.disabled]:opacity-25">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.5"
                          stroke="currentColor"
                          class="h-6 w-6">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>
        <div v-if="details"
            class="break-words rounded-b-lg bg-white px-4 py-4 text-neutral-700 dark:bg-neutral-600 dark:text-neutral-200">
            {{ details }}
        </div>
    </div>
</template>

<style scoped>

</style>
