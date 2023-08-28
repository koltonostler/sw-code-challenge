import { createRouter, createWebHistory } from 'vue-router';
import DashboardView from '../views/DashboardView.vue';
import store from '../store';



const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			redirect: '/dashboard',
		},
		{
			path: '/dashboard',
			name: 'dashboard',
			meta: { requiresAuth: true },
			component: DashboardView,
		},
	],
});



export default router;