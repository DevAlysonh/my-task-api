import axios from "axios";

const API_URL = "http://localhost/api";

const taskService = {
    async getTasks(filters = {}) {
        const token = localStorage.getItem('token');

        if (!token) {
            throw new Error('Token de autenticação não encontrado');
        }

        try {
            const queryParams = new URLSearchParams();
            
            if (filters.status) {
                queryParams.append('status', filters.status);
            }
            if (filters.date) {
                queryParams.append('created_at', filters.date);
            }

            const response = await axios.get(`${API_URL}/tasks?${queryParams.toString()}`, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
            
            return response.data;
        } catch (error) {
            throw error;
        }
    },
};

export default taskService;