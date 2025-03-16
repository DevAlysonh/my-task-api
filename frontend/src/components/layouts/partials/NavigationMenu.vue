<script setup>
import { onMounted, ref } from 'vue';
import MobileMenu from './MobileMenu.vue';
import { isAuthenticated } from '@/services/AuthService';

const showMobileMenu = ref(false);
const activeLink = ref('home');

const toggleMenu = () => {
    showMobileMenu.value = !showMobileMenu.value;
};

const scrollToSection = (sectionId) => {
    const section = document.getElementById(sectionId);
    const navbar = document.querySelector('.navbar');

    if (section && navbar) {
        const sectionPosition = section.getBoundingClientRect().top + window.scrollY;
        const offsetPosition = sectionPosition - 150;

        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth',
        });
    }
};

const setActiveLink = (link) => {
    activeLink.value = link;
};

onMounted(() => {
    activeLink.value = 'home';
});
</script>

<template>
    <nav class="navbar-gradient shadow-lg hidden lg:block fixed w-full z-10 top-0 navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="desk-nav-menu" class="flex justify-between items-center h-16">

                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center text-white">
                    <a href="/">
                        <h1>app</h1>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex lg:flex-col space-x-8 items-end space-y-2">
                    <div v-if="isAuthenticated()" class="flex space-x-1">
                        <router-link to="/dashboard" class="nav-link p-2" exact-active-class="active-nav-link">
                            Dashboard
                        </router-link>
                    </div>
                    <div v-else class="flex space-x-1">
                        <router-link to="/login" class="nav-link p-2" exact-active-class="active-nav-link">
                            Login
                        </router-link>
                    </div>
                </div>
                <!-- Desktop Menu -->
            </div>
        </div>
    </nav>

    <!-- Hamburguer Mobile Menu Button -->
    <div
        class="lg:hidden flex items-center fixed mt-10 right-0 me-5 z-10 p-2 bg-white rounded-xl shadow-lg shadow-black/30">
        <button @click="toggleMenu" class="text-indigo-900 focus:outline-none hover:cursor-pointer">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>
    </div>

    <!-- Sidebar Menu for Mobile -->
    <MobileMenu @close-mobile-menu="toggleMenu" :isOpen="showMobileMenu" />
</template>

<style scoped>
#desk-nav-menu {
    height: 100px;
}
</style>
