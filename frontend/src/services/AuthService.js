import axios from 'axios';
import { useRouter } from 'vue-router';

const API_URL = 'http://localhost/api';

export async function login(email, password) {
    try {
        const response = await axios.post(
            `${API_URL}/login`,
            {email, password}
        );

        const token = response.data.token;

        if (token) {
            localStorage.setItem('token', token);
        }

        return response.data;
    } catch (error) {
        throw error;
    }
}

export function logout() {
    localStorage.removeItem('token');
}

export function isAuthenticated() {
    return !!localStorage.getItem('token')
}