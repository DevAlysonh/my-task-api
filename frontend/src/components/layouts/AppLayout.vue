<script setup>
import NavigationMenu from './partials/NavigationMenu.vue';
</script>

<template>
    <div class="flex flex-col min-h-screen">

        <NavigationMenu />

        <main class="flex-grow lg:mt-[100px]">
            <div>
                <slot />
            </div>
        </main>
    </div>
</template>