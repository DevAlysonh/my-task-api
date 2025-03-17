<script setup>
import { ref } from 'vue';
import { login } from '../services/AuthService';
import AppPage from '@/components/AppPage.vue';

const email = ref('');
const password = ref('');
const errorMessage = ref('');

const handleLogin = async () => {
    try {
        await login(email.value, password.value);
        window.location.href = '/dashboard';
    } catch (error) {
        errorMessage.value = error.response.data.message || 'Erro ao fazer login, verifique as credenciais de acesso.';
    }
};
</script>

<template>
    <AppPage>
        <div class="h-[calc(100vh-100px)] flex justify-center items-center">
            <div class="rounded-lg shadow-lg p-8 text-center space-y-8 w-6/12 bg-white">
                <h2 class="text-gray-500 font-bold text-3xl">Login</h2>
                <form @submit.prevent="handleLogin" class="flex flex-col justify-center gap-4">
                    <input
                        type="email"
                        v-model="email"
                        placeholder="Email"
                        class="border-b-1 border-gray-600 focus:outline-none"
                        required
                    />
                    <input
                        type="password"
                        v-model="password"
                        placeholder="Senha"
                        class="border-b-1 border-gray-600 focus:outline-none"
                        required
                    />
                    <button type="submit" class="p-2 rounded-lg bg-blue-300 mt-4 hover:bg-blue-400 hover:cursor-pointer">Entrar</button>
                </form>
                <p v-if="errorMessage" class="text-red-800 italic">{{ errorMessage }}</p>
            </div>
        </div>
    </AppPage>
</template>

<style scoped>
</style>
