<script setup>
import { ref, computed } from 'vue';
import { TrashIcon, XMarkIcon } from "@heroicons/vue/24/outline/index.js";
import taskService from "@/services/TaskService.js"

const props = defineProps({
    task: {
        type: Object,
        required: true
    }
});

const emit = defineEmits([
    'update-task',
    'close-modal'
]);

const isEditing = ref(false);
const editedTask = ref({ ...props.task });
const newComment = ref('');
const errors = ref({});

const TaskStatus = {
    pending: { label: 'Pendente', color: 'bg-yellow-600' },
    completed: { label: 'Completo', color: 'bg-green-600' },
    progress: { label: 'Em Progresso', color: 'bg-blue-600' },
    cancelled: { label: 'Cancelado', color: 'bg-red-600' }
};

const formattedDate = computed(() => {
    return formatDate(props.task.created_at);
});

const enableEdit = () => {
    isEditing.value = true;
};

const saveChanges = async () => {
    try {
        const updatedTask = await taskService.updateTask(props.task.id, editedTask.value);
        emit('update-task', updatedTask);
        isEditing.value = false;
        errors.value = {};
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.messages || {};
        } else {
            console.error("Erro ao salvar tarefa:", error);
        }
    }
};

const cancelEdit = () => {
    editedTask.value = { ...props.task };
    isEditing.value = false;
};

const formatDate = (dateString) => {
    const newDate = new Date(dateString);
    return newDate.toLocaleDateString('pt-BR');
};

const addComment = async () => {
    if (!newComment.value.trim()) {
        alert('Por favor, digite um comentário!');
        return;
    }

    try {
        const comment = await taskService.addComment(props.task.id, newComment.value);
        props.task.comments.push(comment);
        emit('update-task', props.task);
        newComment.value = '';
    } catch (error) {
        console.error('Erro ao adicionar comentário:', error);
        alert('Erro ao adicionar comentário.');
    }
};

const deleteComment = async (commentId) => {
    if (confirm("Você tem certeza que deseja excluir este comentário?")) {
        try {
            await taskService.deleteComment(commentId);
            props.task.comments = props.task.comments.filter(comment => comment.id !== commentId);
            alert("Comentário excluído com sucesso.");
        } catch (error) {
            console.error("Erro ao excluir comentário:", error);
            alert("Erro ao excluir comentário.");
        }
    }
};
</script>

<template>
    <div class="bg-white p-6 rounded-lg shadow-lg w-full">
        <div v-if="isEditing" class="space-y-4">
            <!-- Campos editáveis -->
            <div>
                <label class="font-bold text-gray-700">Título:</label>
                <input v-model="editedTask.title" class="border p-2 w-full rounded mt-1" />
                <div v-if="errors.title" class="text-red-600 text-sm">
                    {{ errors.title[0] }}
                </div>
            </div>

            <div>
                <label class="font-bold text-gray-700 mt-4">Descrição:</label>
                <textarea v-model="editedTask.description" class="border p-2 w-full rounded mt-1"></textarea>
                <div v-if="errors.description" class="text-red-600 text-sm ">
                    {{ errors.description[0] }}
                </div>
            </div>

            <label class="font-bold text-gray-700 mt-4">Status:</label>
            <select v-model="editedTask.status" class="border p-2 w-full rounded mt-1">
                <option v-for="(status, key) in TaskStatus" :key="key" :value="key">
                    {{ status.label }}
                </option>
            </select>

            <div class="flex justify-end space-x-2 mt-4">
                <button @click="cancelEdit" class="bg-gray-400 text-white px-4 py-2 rounded-lg">Cancelar</button>
                <button @click="saveChanges" class="bg-green-500 text-white px-4 py-2 rounded-lg">Salvar</button>
            </div>
        </div>

        <div v-else>
            <!-- Botão de editar -->
            <div class="w-full flex justify-between items-center mb-4">
                <button @click="enableEdit"
                    class="bg-blue-500 font-bold text-white px-4 py-2 rounded-lg hover:cursor-pointer hover:bg-blue-600">
                    Editar
                </button>

                <button @click="emit('close-modal')"
                    class="bg-red-600 p-2 rounded-lg hover:cursor-pointer hover:bg-red-700">
                    <XMarkIcon class="size-6 text-white" />
                </button>
            </div>

            <!-- Exibição das informações -->
            <h2 class="text-xl font-bold">{{ task.title }}</h2>
            <p class="text-gray-600 mt-2">{{ task.description }}</p>

            <div class="mt-4 space-x-2">
                <span class="font-bold text-gray-600">Status:</span>
                <span :class="`p-1 text-white font-bold rounded-lg ${TaskStatus[task.status]?.color}`">
                    {{ TaskStatus[task.status]?.label }}
                </span>
            </div>

            <div class="mt-2">
                <span class="font-bold text-gray-600">Data de criação:</span>
                <span class="text-gray-500">{{ formattedDate }}</span>
            </div>

            <div class="w-full mt-4 bg-green-100/80 p-2 rounded-lg shadow-md">
                <div v-if="newComment" class="text-end">
                    <button @click="addComment"
                        class="px-2 font-bold text-white bg-green-500 rounded-lg hover:bg-green-600 hover:cursor-pointer">salvar</button>
                </div>
                <div>
                    <label class="text-md font-bold text-gray-700">Adicionar Comentário</label>
                    <textarea v-model="newComment" id="comment" type="text_area"
                        class="border px-3 py-2 border-gray-400 rounded-lg w-full h-[80px]"
                        placeholder="Digite seu comentário aqui..." />
                </div>
            </div>

            <!-- Lista de Comentários -->
            <div class="mt-6">
                <h3 class="text-lg font-bold text-gray-700">Comentários:</h3>
                <ul v-if="task.comments && task.comments.length > 0" class="mt-2 space-y-2">
                    <div v-for="(comment, index) in task.comments" :key="index" class="bg-gray-100 p-2 rounded-lg">
                        <div class="w-full flex justify-between items-center">
                            <span class="font-bold text-gray-500 text-xs italic">{{ comment.user_name }}, em {{
                            formatDate(comment.created_at) }}:</span>
                            <button @click="deleteComment(comment.id)"
                                class="bg-red-500 p-1 hover:bg-red-600 hover:cursor-pointer rounded-lg text-white font-bold uppercase text-xs">
                                <TrashIcon class="size-5 text-white" />
                            </button>
                        </div>
                        <li>
                            {{ comment.content }}
                        </li>
                    </div>
                </ul>
                <p v-else class="text-gray-500 mt-2">Nenhum comentário disponível.</p>
            </div>
        </div>
    </div>
</template>
