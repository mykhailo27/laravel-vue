<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import Link from "@/Components/Link.vue";
import NamedApplicationLogo from "@/Components/NamedApplicationLogo.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {onMounted, ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import { initTE, Ripple} from "tw-elements";

defineProps({
    canLogin: {
        type: Boolean,
    },
});

const form = useForm({
    name: '',
    email: '',
    message: '',
    send_me: false,
});

const submit = () => {
    form.post(route('contact'), {
        onSuccess: () => closetContactModal(),
    });
};

const show_contact_modal = ref(false)

const closetContactModal = () => {
    show_contact_modal.value = false
}

onMounted(() => {
    initTE({Ripple});
})

</script>

<template>
    <Head title="Welcome"/>

    <!-- Section: Design Block -->
    <section class="min-h-screen overflow-auto"><!-- Navbar -->
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
                                <PrimaryButton class="sm:py-4" @click="show_contact_modal = true">
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

        <!-- Footer container -->
        <footer
            class="bg-neutral-100 text-center text-neutral-600 dark:bg-neutral-600 dark:text-neutral-200 lg:text-left">
            <div
                class="flex items-center justify-center border-b-2 border-neutral-200 p-6 dark:border-neutral-500 lg:justify-between">
                <div class="mr-12 hidden lg:block">
                    <span>Get connected with us on social networks:</span>
                </div>
                <!-- Social network icons container -->
                <div class="flex justify-center">
                    <a href="#!" class="mr-6 text-neutral-600 dark:text-neutral-200">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                        </svg>
                    </a>
                    <a href="#!" class="mr-6 text-neutral-600 dark:text-neutral-200">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="#!" class="mr-6 text-neutral-600 dark:text-neutral-200">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Main container div: holds the entire content of the footer, including four sections (Tailwind Elements, Products, Useful links, and Contact), with responsive styling and appropriate padding/margins. -->
            <div class="mx-6 py-10 text-center md:text-left">
                <div class="grid-1 grid gap-6 md:grid-cols-3 lg:grid-cols-3">
                    <!-- Tailwind Elements section -->
                    <div>
                        <div class="mb-2 flex justify-center md:justify-start">
                            <NamedApplicationLogo/>
                        </div>
                        <p>
                            Sunday supports creative agencies in offering full custom clothing for their clients.
                        </p>
                    </div>
                    <!-- Useful links section -->
                    <div>
                        <h6
                            class="mb-4 flex justify-center font-semibold uppercase md:justify-start">
                            Legal Policy
                        </h6>
                        <p class="mb-4">
                            <a href="https://teamsunday.com/legal/terms-and-conditions/"
                               class="text-neutral-600 dark:text-neutral-200">
                                Terms and conditions
                            </a>
                        </p>
                        <p class="mb-4">
                            <a href="https://teamsunday.com/legal/privacy-policy/"
                               class="text-neutral-600 dark:text-neutral-200">
                                Privacy policy
                            </a>
                        </p>
                        <p class="mb-4">
                            <a href="https://teamsunday.com/legal/cookie-policy/"
                               class="text-neutral-600 dark:text-neutral-200"
                            >cookie policy</a
                            >
                        </p>
                    </div>
                    <!-- Contact section -->
                    <div>
                        <h6
                            class="mb-4 flex justify-center font-semibold uppercase md:justify-start">
                            Contact
                        </h6>
                        <p class="mb-4 flex items-center justify-center md:justify-start">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="mr-3 h-5 w-5">
                                <path
                                    d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z"/>
                                <path
                                    d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z"/>
                            </svg>
                            Krommebeekpark 21 8800 Roeselare
                        </p>
                        <p class="mb-4 flex items-center justify-center md:justify-start">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="mr-3 h-5 w-5">
                                <path
                                    d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z"/>
                                <path
                                    d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z"/>
                            </svg>
                            info@teamsunday.com
                        </p>
                        <p class="mb-4 flex items-center justify-center md:justify-start">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="mr-3 h-5 w-5">
                                <path
                                    fill-rule="evenodd"
                                    d="M1.5 4.5a3 3 0 013-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 01-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 006.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 011.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 01-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5z"
                                    clip-rule="evenodd"/>
                            </svg>
                            +32 51 20 11 98
                        </p>
                    </div>
                </div>
            </div>

            <!--Copyright section-->
            <div class="bg-neutral-200 p-6 text-center dark:bg-neutral-700">
                <span>© 2023 SUNDAY GROUP BV: </span>
                <a
                    class="font-semibold text-neutral-600 dark:text-neutral-400"
                    href="https://teamsunday.com"
                >Team Sunday</a
                >
            </div>
        </footer>
    </section>
    <!-- Section: Design Block -->

    <!-- Modal: contact Block -->
    <Modal :show="show_contact_modal" @close="closetContactModal">
        <!-- Container for demo purpose -->
        <div class="p-6">
            <div class="flex justify-between mb-3">
                <h2 class="text-3xl font-bold">Contact us</h2>
                <SecondaryButton class="fa-sharp fa-solid fa-xmark" @click="closetContactModal"/>
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Name"/>

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        placeholder="Your Name"
                        required
                        autofocus
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
                        placeholder="Your email"
                        required
                    />

                    <InputError class="mt-2" :message="form.errors.email"/>
                </div>

                <div class="mt-4">
                    <InputLabel for="message" value="Message"/>

                    <textarea
                        class="block min-h-[auto] w-full py-[0.32rem] px-3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        id="message"
                        rows="3"
                        name="message"
                        placeholder="Your message"
                        v-model="form.message"
                        required
                    />

                    <InputError class="mt-2" :message="form.errors.message"/>
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox name="send_me" v-model:checked="form.send_me"/>
                        <span class="ml-2 text-sm text-gray-600">Send me copy</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton
                        class="ml-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                        Send
                    </PrimaryButton>
                </div>
            </form>
        </div>
        <!-- Container for demo purpose -->
    </Modal>
    <!-- Modal: contact Block -->

</template>

<style scoped>

</style>
