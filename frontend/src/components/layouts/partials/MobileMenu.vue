<script setup>
import { isAuthenticated, logout } from "@/services/AuthService";
import { useRouter } from "vue-router";

const props = defineProps({
    isOpen: Boolean,
});

const emit = defineEmits(['close-mobile-menu']);
const router = useRouter();

const destroySession = () => {
    logout();

    router.push('/login');
    emit('close-mobile-menu');
}
</script>

<template>
    <div v-if="isOpen" class="fixed inset-0 z-40 lg:hidden bg-gray-950/60">
        <transition name="fade-slide" appear>
            <div class="fixed right-0 w-[250px] h-full bg-white z-50" :class="isAuthenticated() ? 'flex flex-col justify-between' : ''">
                <div class="flex justify-between items-center p-4">
                    <div>
                        <h1>app</h1>
                    </div>
                    <button @click="emit('close-mobile-menu')" class="text-indigo-900 font-bold ms-auto">
                        Fechar
                    </button>
                </div>
                <div v-if="isAuthenticated()" class="p-4 space-y-4 flex flex-col">
                    <router-link to="/dashboard" class="nav-link p-2" exact-active-class="active-nav-link">
                        Dashboard
                    </router-link>
                </div>
                <div v-else class="p-4 space-y-4 flex flex-col">
                    <router-link to="/login" class="nav-link p-2" exact-active-class="active-nav-link">
                        Login
                    </router-link>
                </div>

                <div v-if="isAuthenticated()" class="mt-auto w-full px-2 py-2 text-center">
                    <button @click="destroySession()" class="primary-button">Logout</button>
                </div>
            </div>
        </transition>
    </div>
</template>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 0.3s ease;
}

.fade-slide-enter-from,
.fade-slide-leave-to {
    opacity: 0;
    transform: translateX(100%);
}

.fade-slide-enter-to,
.fade-slide-leave-from {
    opacity: 1;
    transform: translateX(0);
}
</style>