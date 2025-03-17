import { createRouter, createWebHistory } from "vue-router";
import TheWelcome from '../components/TheWelcome.vue';
import Dashboard from '../views/Dashboard.vue';
import { isAuthenticated } from "@/services/AuthService";
import Login from "@/views/Login.vue";
import taskService from "../services/TaskService";

const routes = [
    {
        path: '/',
        component: TheWelcome,
        beforeEnter: (to, from, next) => {
            if (isAuthenticated()) {
                next('/dashboard');
            }

            next();
        }
    },
    {
        path: '/dashboard',
        component: Dashboard,
        props: (route) => ({tasks: route.params.tasks}),
        beforeEnter: (to, from, next) => {
            const loadTasks = async () => {
                if (!isAuthenticated()) {
                    next('/login');
                }
    
                try {
                    const tasks = await taskService.getTasks();
                    to.params.tasks = tasks;
                    next()
                } catch (error) {
                    console.log(error);
                    next(false);
                }
            }
            loadTasks();
        }
    },
    {
        path: '/login',
        component: Login,
        beforeEnter: (to, from, next) => {
            if (isAuthenticated()) {
                next('/dashboard');
            }

            next();
        }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
