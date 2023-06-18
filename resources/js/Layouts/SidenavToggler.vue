<script setup>

</script>

<template>
    <!-- Toggler -->
    <div class="flex items-center sm:hidden">
        <button
            class="inline-flex items-center justify-center mr-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
            data-te-sidenav-toggle-ref
            data-te-target="#app-sidenav"
            aria-controls="#app-sidenav"
            aria-haspopup="true">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path class="inline-flex"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>
        </button>
    </div>
    <!-- Toggler -->
</template>

<style scoped>

</style>
