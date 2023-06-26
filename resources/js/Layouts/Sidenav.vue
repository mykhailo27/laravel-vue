<script setup>

import {initTE, Ripple, Sidenav} from "tw-elements";
import {onMounted} from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import SidenavLink from "@/Components/SidenavLink.vue";
import {Link} from "@inertiajs/vue3";
import SidenavDropdown from "@/Components/SidenavDropdown.vue";
import SidenavDropdownItem from "@/Components/SidenavDropdownItem.vue";

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

        <div class="flex justify-between">
            <Link :href="route('dashboard')"
                  class="flex w-full h-16 cursor-pointer items-center truncate rounded-[5px] px-6 py-6 gap-2 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                  data-te-sidenav-link-ref data-te-ripple-init data-te-ripple-color="primary">
                <ApplicationLogo class="block h-8 w-auto fill-current text-gray-800"/>
                <span
                    class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                    data-te-sidenav-slim="false">Wardrobe</span>
            </Link>

            <i @click="sidenavInstance.toggleSlim()"
               class="absolute right-0 px-4 py-6 fa-solid fa-angles-left self-center group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
               data-te-sidenav-slim="false"
            ></i>
        </div>

        <hr>

        <div id="scroll-container">
            <ul class="relative m-0 list-none px-[0.2rem]" data-te-sidenav-menu-ref>
                <li class="relative">
                    <SidenavLink route_name="dashboard" name="Dashboard">
                        <template #icon>
                            <i class="fa-solid fa-chart-line"></i>
                        </template>
                    </SidenavLink>
                </li>

                <li class="relative pt-4">
                    <span class="px-6 py-4 text-[0.6rem] font-bold uppercase text-gray-600 dark:text-gray-400">
                        General
                    </span>

                    <SidenavLink route_name="dashboard" name="Products">
                        <template #icon>
                            <i class="fa-solid fa-shirt"></i>
                        </template>
                    </SidenavLink>
                </li>

                <li class="relative">
                    <SidenavLink route_name="dashboard" name="Packages">
                        <template #icon>
                            <i class="fa-solid fa-box"></i>
                        </template>
                    </SidenavLink>
                </li>

                <li class="relative">
                    <SidenavLink route_name="dashboard" name="Shipment">
                        <template #icon>
                            <i class="fa-solid fa-truck-arrow-right"></i>
                        </template>
                    </SidenavLink>
                </li>

                <li class="relative">
                    <SidenavLink route_name="dashboard" name="Campaigns">
                        <template #icon>
                            <i class="fa-solid fa-people-group"></i>
                        </template>
                    </SidenavLink>
                </li>

                <li class="relative">
                    <SidenavLink route_name="dashboard" name="Web-shops">
                        <template #icon>
                            <i class="fa-solid fa-shop"></i>
                        </template>
                    </SidenavLink>
                </li>

                <li class="relative">
                    <SidenavLink route_name="dashboard" name="Closets">
                        <template #icon>
                            <i class="fa-solid fa-notdef"></i>
                        </template>
                    </SidenavLink>
                </li>
                `
                <li class="relative">
                    <SidenavLink route_name="dashboard" name="Companies">
                        <template #icon>
                            <i class="fa-solid fa-building"></i>
                        </template>
                    </SidenavLink>
                </li>

                <li class="relative">
                    <SidenavLink route_name="dashboard" name="Subscriptions">
                        <template #icon>
                            <i class="fa-solid fa-file-contract"></i>
                        </template>
                    </SidenavLink>
                </li>
                <li class="relative pt-4">
                    <span class="px-6 py-4 text-[0.6rem] font-bold uppercase text-gray-600 dark:text-gray-400">
                        Internal
                    </span>

                    <SidenavLink route_name="dashboard" name="Shop Apps">
                        <template #icon>
                            <i class="fa-brands fa-app-store-ios"></i>
                        </template>
                    </SidenavLink>
                </li>

                <li class="relative">
                    <SidenavLink route_name="agencies.index" name="Agencies">
                        <template #icon>
                            <i class="fa-brands fa-app-store-ios"></i>
                        </template>
                    </SidenavLink>
                </li>

                <li class="relative">
                    <SidenavLink route_name="dashboard" name="Countries">
                        <template #icon>
                            <i class="mr-2 fa-solid fa-flag"></i>
                        </template>
                    </SidenavLink>
                </li>

                <li class="relative">
                    <SidenavLink route_name="dashboard" name="Messages">
                        <template #icon>
                            <i class="fa-solid fa-envelope"></i>
                        </template>
                    </SidenavLink>
                </li>

                <li class="relative">
                    <SidenavLink route_name="dashboard" name="Product Types">
                        <template #icon>
                            <i class="mr-2 fa-solid fa-socks"></i>
                        </template>
                    </SidenavLink>
                </li>

                <li class="relative">
                    <SidenavLink route_name="dashboard" name="Stock Moves">
                        <template #icon>
                            <i class="mr-2 fa-solid fa-cubes"></i>
                        </template>
                    </SidenavLink>
                </li>

                <li class="relative">
                    <SidenavDropdown name="Invoicing">
                        <template #items>
                            <li class="relative">
                                <SidenavDropdownItem href="#" name="Charges"/>
                            </li>
                            <li class="relative">
                                <SidenavDropdownItem href="#" name="Invoices"/>
                            </li>
                        </template>
                    </SidenavDropdown>
                </li>

                <li class="relative">
                    <SidenavLink route_name="dashboard" name="Variation Types">
                        <template #icon>
                            <i class="mr-2 fas fa-bolt"></i>
                        </template>
                    </SidenavLink>
                </li>

                <li class="relative">
                    <SidenavLink route_name="dashboard" name="Warehouses">
                        <template #icon>
                            <i class="fa-solid fa-warehouse"></i>
                        </template>
                    </SidenavLink>
                </li>

                <li class="relative pt-4">
                    <span class="px-6 py-4 text-[0.6rem] font-bold uppercase text-gray-600 dark:text-gray-400">
                        Settings
                    </span>

                    <SidenavLink route_name="users.index" name="Users">
                        <template #icon>
                            <i class="fa-solid fa-circle-user"></i>
                        </template>
                    </SidenavLink>
                </li>

                <li class="relative">
                    <SidenavLink route_name="roles.index" name="Roles">
                        <template #icon>
                            <i class="fa-solid fa-user-tag"></i>
                        </template>
                    </SidenavLink>
                </li>
            </ul>
        </div>

        <hr>
        <div class="absolute bottom-0 w-full">
            <a href="https://teamsunday.com/" target="_blank"
               class="flex items-center justify-start py-4 px-4 outline-none"
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

