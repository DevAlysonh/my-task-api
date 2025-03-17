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

    async updateTask(taskId, taskData) {
        const token = localStorage.getItem('token');
        
        if (!token) {
            throw new Error('Token de autenticação não encontrado');
        }

        try {
            const response = await axios.patch(`${API_URL}/tasks/${taskId}`, taskData, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
            
            return response.data;
        } catch (error) {
            throw error;
        }
    },

    async createTask(taskData) {
        const token = localStorage.getItem('token');
        
        if (!token) {
            throw new Error('Token de autenticação não encontrado');
        }

        try {
            const response = await axios.post(`${API_URL}/tasks/`, taskData, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
            
            return response.data;
        } catch (error) {
            throw error;
        }
    },


    async addComment(taskId, commentContent) {
        try {
            const token = localStorage.getItem('token');

            const response = await axios.post(
                `${API_URL}/comments`, 
                {
                    content: commentContent,
                    task_id: taskId
                },
                {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                }
            );

            return response.data;
        } catch (error) {
            throw new Error('Erro ao adicionar comentário: ' + error.message);
        }
    },

    async deleteComment(commentId) {
        const token = localStorage.getItem('token');
        
        if (!token) {
            throw new Error('Token de autenticação não encontrado');
        }

        try {
            const response = await axios.delete(`${API_URL}/comments/${commentId}`, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
            
            return response.data;
        } catch (error) {
            throw error;
        }
    }
};

export default taskService;