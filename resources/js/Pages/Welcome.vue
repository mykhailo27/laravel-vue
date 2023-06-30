<script setup>
import {Head} from '@inertiajs/vue3';
import Link from "@/Components/Link.vue";
import NamedApplicationLogo from "@/Components/NamedApplicationLogo.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
});

const show_add_permission_modal = ref(false)

const closetPermissionModal = () => {
    show_add_permission_modal.value = false
}

</script>

<template>
    <Head title="Welcome"/>

    <!-- Section: Design Block -->
    <section>
        <!-- Navbar -->
        <nav
            class="relative flex w-full items-center justify-between bg-white py-2 shadow-sm shadow-neutral-700/10 dark:bg-neutral-800 dark:shadow-black/30  lg:flex-wrap lg:justify-start"
            data-te-navbar-ref>
            <!-- Container wrapper -->
            <div class="flex w-full flex-wrap items-center justify-between px-6">
                <!-- Navbar Brand -->
                <Link href="/" content-classes="px-0">
                    <NamedApplicationLogo/>
                </Link>
                <!-- Navbar Brand -->

                <!-- Right elements -->
                <div v-if="canLogin" class="my-1 flex items-center lg:my-0 lg:ml-auto">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                        Dashboard
                    </Link>

                    <template v-else>
                        <Link
                            v-if="canLogin"
                            :href="route('login')">
                            Log in
                        </Link>
                    </template>
                </div>
                <!-- Right elements -->

            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->

        <!-- Jumbotron -->
        <div class="px-6 py-12 text-center md:px-12 lg:text-left">
            <div class="w-100 mx-auto sm:max-w-2xl md:max-w-3xl lg:max-w-5xl xl:max-w-7xl xl:px-32">
                <div class="grid items-center lg:grid-cols-2">
                    <div class="mb-12 md:mt-12 lg:mt-0 lg:mb-0">
                        <div
                            class="block rounded-lg bg-[hsla(0,0%,100%,0.55)] px-6 py-12 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-[hsla(0,0%,5%,0.55)] dark:shadow-black/20 md:px-12 lg:-mr-14 backdrop-blur-[30px]">
                            <h1 class="mt-2 mb-16 text-2xl font-bold tracking-tight md:text-3xl xl:text-4xl">
                                Sunday help companies<br/><span class="text-primary">make their clients be their ambassadors.</span>
                            </h1>
                            <div class="flex gap-2 items-center lg:justify-start justify-center">
                                <PrimaryButton class="sm:py-4" @click="show_add_permission_modal = true">
                                    Contact Us
                                </PrimaryButton>
                                <a class="inline-block rounded text-sm sm:py-4 py-2 px-4 font-medium uppercase leading-normal text-primary transition duration-150 ease-in-out hover:bg-neutral-500 hover:bg-opacity-10 hover:text-primary-600 focus:text-primary-600 focus:outline-none focus:ring-0 active:text-primary-700 dark:hover:bg-neutral-700 dark:hover:bg-opacity-40"
                                   data-te-ripple-init data-te-ripple-color="light"
                                   href="https://teamsunday.com/partners/"
                                   target="_blank" role="button">Learn more</a>
                            </div>
                        </div>
                    </div>
                    <div class="md:mb-12 lg:mb-0">
                        <img src="https://teamsunday.com/catalog/img/caps.jpg"
                             class="w-full rounded-lg shadow-lg dark:shadow-black/20" alt="">
                    </div>
                </div>
            </div>
        </div>
        <!-- Jumbotron -->
    </section>
    <!-- Section: Design Block -->

    <!-- Modal: contact Block -->
    <Modal :show="show_add_permission_modal" @close="closetPermissionModal">
        <!-- Container for demo purpose -->
        <div class="p-6">

            <div class="flex justify-end mb-3">
                <SecondaryButton class="fa-sharp fa-solid fa-xmark" @click="closetPermissionModal"/>
            </div>

            <!-- Section: Design Block -->
            <section class="text-center">
                <div class="mx-auto max-w-[700px] md:px-3">
                    <h2 class="mb-12 text-3xl font-bold">Contact us</h2>
                    <form>
                        <div class="relative mb-6" data-te-input-wrapper-init>
                            <input
                                type="text"
                                class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                id="exampleInput90"
                                placeholder="Name"/>
                            <label
                                class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary"
                                for="exampleInput90"
                            >Name
                            </label>
                        </div>
                        <div class="relative mb-6" data-te-input-wrapper-init>
                            <input
                                type="email"
                                class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                id="exampleInput91"
                                placeholder="Email address"/>
                            <label
                                class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary"
                                for="exampleInput91"
                            >Email address
                            </label>
                        </div>
                        <div class="relative mb-6" data-te-input-wrapper-init>
          <textarea
              class="peer block min-h-[auto] w-full rounded border-0 bg-transparent py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
              id="exampleFormControlTextarea1"
              rows="3"
              placeholder="Your message"></textarea>
                            <label
                                for="exampleFormControlTextarea1"
                                class="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary"
                            >Message</label
                            >
                        </div>
                        <div
                            class="mb-6 inline-block min-h-[1.5rem] justify-center pl-[1.5rem] md:flex">
                            <input
                                class="relative float-left mt-[0.15rem] mr-[6px] -ml-[1.5rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:ml-[0.25rem] checked:after:-mt-px checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-t-0 checked:after:border-l-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:ml-[0.25rem] checked:focus:after:-mt-px checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-t-0 checked:focus:after:border-l-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent dark:border-neutral-600 dark:checked:border-primary dark:checked:bg-primary dark:focus:before:shadow-[0px_0px_0px_13px_rgba(255,255,255,0.4)] dark:checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca]"
                                type="checkbox"
                                value=""
                                id="exampleCheck96"
                                checked/>
                            <label
                                class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                for="exampleCheck96">
                                Send me a copy of this message
                            </label>
                        </div>
                        <button
                            type="button"
                            data-te-ripple-init
                            data-te-ripple-color="light"
                            class="mb-6 inline-block w-full rounded bg-primary px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                            Send
                        </button>
                    </form>
                </div>
            </section>
            <!-- Section: Design Block -->
        </div>
        <!-- Container for demo purpose -->
    </Modal>
    <!-- Modal: contact Block -->

</template>

<style scoped>

</style>
