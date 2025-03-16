<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { login } from '../services/AuthService';

const email = ref('');
const password = ref('');
const router = useRouter();
const errorMessage = ref('');

const handleLogin = async () => {
    try {
        await login(email.value, password.value);
        router.push('/dashboard');
    } catch (error) {
        errorMessage.value = error.response.data.message || 'Erro ao fazer login, verifique as credenciais de acesso.';
    }
};
</script>

<template>
    <div class="login-container">
        <h2>Login</h2>
        <form @submit.prevent="handleLogin">
            <input type="email" v-model="email" placeholder="Email" required />
            <input type="password" v-model="password" placeholder="Senha" required />
            <button type="submit">Entrar</button>
        </form>
        <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    </div>
</template>

<style scoped>
.login-container {
    width: 300px;
    margin: auto;
    padding: 20px;
    text-align: center;
}
.error {
    color: red;
}
</style>
