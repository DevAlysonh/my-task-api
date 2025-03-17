<script setup>
import { ref, watchEffect } from 'vue';
import AppPage from '@/components/AppPage.vue';
import TaskService from '@/services/TaskService';
import Modal from '@/components/Modal.vue';
import TaskDetails from '@/components/TaskDetails.vue';

const props = defineProps({
    tasks: {
        type: Object,
        required: false
    }
});

const TaskStatus = {
    pending: { label: 'Pendente', color: 'bg-yellow-600' },
    completed: { label: 'Completo', color: 'bg-green-600' },
    progress: { label: 'Em Progresso', color: 'bg-blue-600' },
    cancelled: { label: 'Cancelado', color: 'bg-red-600' }
};

const statusFilter = ref('');
const dateFilter = ref('');
const filteredTasks = ref([]);
const selectedTask = ref(null);
const isModalOpen = ref(false);

const fetchTasks = async () => {
    const filters = {
        status: statusFilter.value || undefined,
        date: dateFilter.value || undefined
    };

    const response = await TaskService.getTasks(filters);
    filteredTasks.value = response.tasks;
};

const clearFilters = () => {
    statusFilter.value = '';
    dateFilter.value = '';
    fetchTasks();
};

const openDetailsModal = (task) => {
    selectedTask.value = task;
    isModalOpen.value = true;
}

const closeDetailsModal = () => {
    isModalOpen.value = false;
    selectedTask.value = null;
}

const handleTaskUpdate = (updatedTask) => {
    selectedTask.value = {
        ...updatedTask,
        comments: selectedTask.value ? selectedTask.value.comments : [] // Preserva os comentários
    };

    filteredTasks.value = filteredTasks.value.map(task =>
        task.id === updatedTask.id
            ? { ...task, ...updatedTask, comments: task.comments }
            : task
    );
};

watchEffect(fetchTasks);
</script>

<template>
    <AppPage>
        <div class="w-full bg-white shadow-lg p-3 rounded-lg mb-10">
            <span>Filtros:</span>
            <div class="flex space-x-4 mt-4">
                <div class="flex flex-col">
                    <span>Status</span>
                    <select v-model="statusFilter" class="border h-full p-2 rounded">
                        <option value="">Todos</option>
                        <option v-for="(status, key) in TaskStatus" :key="key" :value="key">
                            {{ status.label }}
                        </option>
                    </select>
                </div>
                <div class="flex flex-col h-full">
                    <label for="date">Data de Criação</label>
                    <input id="date" type="date" v-model="dateFilter" class="border p-2 rounded" />
                </div>
                <div class="flex items-end">
                    <button @click="clearFilters"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                        Limpar Filtros
                    </button>
                </div>
            </div>
        </div>

        <div v-if="filteredTasks && filteredTasks.length > 0"
            class="grid-cols-1 lg:grid grid-cols-3 space-y-4 lg:space-y-0 gap-4">
            <div v-for="task in filteredTasks" :key="task.id" @click="openDetailsModal(task)"
                class="p-4 bg-white rounded-lg shadow-lg hover:bg-gray-100 hover:cursor-pointer">
                <div class="flex flex-col space-y-6">
                    <span class="text-lg text-gray-600 font-bold mb-3">{{ task.title }}</span>
                    <span class="font-bold text-gray-600">
                        Status:
                        <a :class="`p-1 text-white rounded-lg ${TaskStatus[task.status]?.color}`">
                            {{ TaskStatus[task.status]?.label }}
                        </a>
                    </span>
                    <div class="p-2 bg-sky-50 shadow rounded-lg border-gray-300">
                        <p>{{ task.description }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="text-center text-gray-500 font-semibold mt-6">
            <span>Não há tarefas disponíveis.</span>
        </div>
    </AppPage>
    <Modal :show="isModalOpen">
        <TaskDetails @update-task="handleTaskUpdate" @close-modal="closeDetailsModal" :task="selectedTask" />
    </Modal>
</template>