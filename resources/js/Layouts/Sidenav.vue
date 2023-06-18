<script setup>

import {initTE, Ripple, Sidenav} from "tw-elements";
import {onMounted} from "vue";
import Link from "@/Components/Link.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const props = defineProps({
    content: {
        type: String,
        required: true
    }
});

let innerWidth = null;
let sidenavInstance = null;

const setMode = (sidenavInstance) => {
    if (window.innerWidth === innerWidth) {
        return; // Check necessary for Android devices
    }
    innerWidth = window.innerWidth;

    if (window.innerWidth < sidenavInstance.getBreakpoint("sm")) {
        sidenavInstance.changeMode("over");
        sidenavInstance.hide();
    } else {
        sidenavInstance.changeMode("side");
        sidenavInstance.show();
    }
};

onMounted(function () {
    initTE({Sidenav, Ripple});

    const side_nav = document.getElementById("app-sidenav");
    sidenavInstance = Sidenav.getInstance(side_nav);

    if (window.innerWidth < sidenavInstance.getBreakpoint("sm")) {
        setMode(sidenavInstance);
    }
    window.addEventListener("resize", function () {
        setMode(sidenavInstance)
    });

})
</script>

<template>
    <!-- Sidenav -->
    <nav
        id="app-sidenav"
        class="absolute left-0 top-0 z-[1035] h-full w-60 -translate-x-full overflow-hidden bg-white shadow-[0_4px_12px_0_rgba(0,0,0,0.07),_0_2px_4px_rgba(0,0,0,0.05)] data-[te-sidenav-hidden='false']:translate-x-0 dark:bg-zinc-800"
        data-te-sidenav-init
        data-te-sidenav-hidden="false"
        data-te-sidenav-mode="side"
        data-te-sidenav-slim="true"
        data-te-sidenav-slim-collapsed="false"
        :data-te-sidenav-content="'.' + content"
        data-te-sidenav-scroll-container="#scroll-container"
        data-te-sidenav-accordion="true"
        data-te-sidenav-mode-breakpoint-over="0"
        data-te-sidenav-mode-breakpoint-side="sm"
        data-te-sidenav-position="absolute">

        <div class="flex justify-between px-6">
            <Link :href="route('dashboard')"
                  class="pl-0 flex items-center justify-center py-4 outline-none"
                  data-te-ripple-init data-te-ripple-color="primary">
                <ApplicationLogo class="block h-8 pr-4 w-auto fill-current text-gray-800"/>
                <span
                    class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                    data-te-sidenav-slim="false"
                >Wardrobe</span>
            </Link>

            <i @click="sidenavInstance.toggleSlim()"
               class="fa-solid fa-angles-left self-center group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
               data-te-sidenav-slim="false"
            ></i>
        </div>

        <hr>

        <div id="scroll-container">
            <ul class="relative m-0 list-none px-[0.2rem]" data-te-sidenav-menu-ref>
                <li class="relative">
                    <Link :href="route('dashboard')"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-solid fa-chart-line"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Dashboard</span>
                    </Link>
                </li>
                <li class="relative pt-4">
                    <span class="px-6 py-4 text-[0.6rem] font-bold uppercase text-gray-600 dark:text-gray-400">
                        General
                    </span>
                    <Link href="#"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-solid fa-shirt"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Products</span>
                    </Link>
                    <Link href="#"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-solid fa-box"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Packages</span>
                    </Link>

                    <Link href="#"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-solid fa-truck-arrow-right"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Shipments</span>
                    </Link>

                    <Link href="#"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-solid fa-people-group"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Campaigns</span>
                    </Link>
                    <Link href="#"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-solid fa-shop"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Web-shops</span>
                    </Link>
                    <Link href="#"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-solid fa-notdef"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Closets</span>
                    </Link>

                    <Link href="#"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-solid fa-building"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Companies</span>
                    </Link>
                    <Link href="#"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-solid fa-file-contract"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Subscriptions</span>
                    </Link>
                </li>
                <li class="relative pt-4">
                    <span class="px-6 py-4 text-[0.6rem] font-bold uppercase text-gray-600 dark:text-gray-400">
                        Internal
                    </span>
                    <Link href="#"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-brands fa-app-store-ios"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Shop Apps</span>
                    </Link>

                    <Link :href="route('agencies.index')"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-brands fa-app-store-ios"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Agencies</span>
                    </Link>
                    <Link href="#"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-solid fa-flag"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Countries</span>
                    </Link>

                    <Link href="#"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-solid fa-envelope"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Messages</span>
                    </Link>

                    <Link href="#"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-solid fa-socks"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Product Types</span>
                    </Link>

                    <Link href="#"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-solid fa-cubes"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Stock Moves</span>
                    </Link>

                    <div>
                        <a
                            class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                            data-te-sidenav-link-ref>
                            <i class="mr-2 fa-solid fa-file-invoice-dollar"></i>
                            <span
                                class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                                data-te-sidenav-slim="false">Invoicing</span>
                            <span
                                class="absolute right-0 ml-auto mr-[0.5rem] transition-transform duration-300 ease-linear motion-reduce:transition-none [&>svg]:text-gray-600 dark:[&>svg]:text-gray-300"
                                data-te-sidenav-rotate-icon-ref>
                              <svg
                                  xmlns="http://www.w3.org/2000/svg"
                                  viewBox="0 0 20 20"
                                  fill="currentColor"
                                  class="h-5 w-5">
                                <path
                                    fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd"/>
                              </svg>
                        </span>
                        </a>
                        <ul
                            class="!visible relative m-0 hidden list-none p-0 data-[te-collapse-show]:block "
                            data-te-sidenav-collapse-ref>
                            <li class="relative">
                                <a
                                    class="flex h-6 cursor-pointer items-center truncate rounded-[5px] py-4 pl-[3.4rem] pr-6 text-[0.78rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                                    data-te-sidenav-link-ref
                                >Charges</a
                                >
                            </li>
                            <li class="relative">
                                <a
                                    class="flex h-6 cursor-pointer items-center truncate rounded-[5px] py-4 pl-[3.4rem] pr-6 text-[0.78rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                                    data-te-sidenav-link-ref
                                >Invoices</a
                                >
                            </li>
                        </ul>
                    </div>

                    <Link href="#"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fas fa-bolt"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Variation Types</span>
                    </Link>

                    <Link href="#"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-solid fa-warehouse"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Warehouses</span>
                    </Link>
                </li>

                <li class="relative pt-4">
                    <span class="px-6 py-4 text-[0.6rem] font-bold uppercase text-gray-600 dark:text-gray-400">
                        Settings
                    </span>

                    <Link :href="route('users.index')"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-solid fa-circle-user"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Users</span>
                    </Link>

                    <Link :href="route('roles.index')"
                          class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                          data-te-sidenav-link-ref>
                        <i class="mr-2 fa-solid fa-user-tag"></i>
                        <span
                            class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                            data-te-sidenav-slim="false">Roles</span>
                    </Link>
                </li>
            </ul>
        </div>

        <hr>
        <div class="absolute bottom-0 px-6">
            <a href="https://teamsunday.com/" target="_blank"
                  class="pl-0 flex items-center justify-center py-4 outline-none"
                  data-te-ripple-init data-te-ripple-color="primary">
                <ApplicationLogo class="block h-8 pr-4 w-auto fill-current text-gray-800"/>
                <span
                    class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                    data-te-sidenav-slim="false"
                >Team Sunday</span>
            </a>
        </div>
    </nav>
    <!-- Sidenav -->
</template>

<style scoped>

</style>
