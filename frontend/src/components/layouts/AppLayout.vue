<script setup>
import NavigationMenu from './partials/NavigationMenu.vue';
import Footer from './partials/Footer.vue';
</script>

<template>
    <div class="flex flex-col min-h-screen">

        <NavigationMenu />

        <main class="flex-grow lg:mt-[100px]">
            <div class="space-y-10 mb-10">
                <slot />
            </div>
        </main>

        <Footer />
    </div>
</template>