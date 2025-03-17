import { createRouter, createWebHistory } from "vue-router";
import TheWelcome from '../components/TheWelcome.vue';
import Dashboard from '../views/Dashboard.vue';
import { isAuthenticated } from "@/services/AuthService";
import Login from "@/views/Login.vue";

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
        beforeEnter: (to, from, next) => {
            if (!isAuthenticated()) {
                next('/login');
            }

            next();
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
