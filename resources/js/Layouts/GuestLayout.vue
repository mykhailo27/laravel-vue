<script setup>
import NamedApplicationLogo from "@/Components/NamedApplicationLogo.vue";
import Link from "@/Components/Link.vue";
</script>

<template>
    <div class="min-h-screen w-full">

        <nav
            class="fixed top-0 w-full items-center py-4 px-6 shadow-sm shadow-neutral-700/10 bg-white dark:bg-neutral-800 dark:shadow-black/30"
            data-te-navbar-ref>
            <!-- Container wrapper -->
            <Link href="/" content-classes="p-0">
                <NamedApplicationLogo/>
            </Link>
        </nav>

        <!-- Section: Design Block -->
        <section class="flex flex-wrap h-screen items-center p-6 md:p-12 lg:p-16">
            <div class="mt-12 mb-6 w-full shrink-0 grow-0 basis-auto lg:mb-0 lg:w-5/12">
                <img src="https://wardrobe.teamsunday.com/img/2021/09/sunday_wardrobe.png"
                     alt="Sunday Wardrobe™"
                     class="w-full rounded-lg shadow-lg dark:shadow-black/20 lg:ml-[50px]">
            </div>

            <div class="z-[10] w-full shrink-0 grow-0 basis-auto lg:w-7/12 rounded-lg shadow-lg p-6">
                <slot/>
            </div>
        </section>
    </div>
</template>
