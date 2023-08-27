import { createRouter, createWebHistory } from 'vue-router';
import DashboardView from '../views/DashboardView.vue';
import LandingPageView from '../views/LandingPageView.vue';
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
		{
			path: '/login',
			name: 'login',
			meta: { isGuest: true },
			component: LandingPageView,
		},
	],
});

router.beforeEach((to, from, next) => {
	if (to.meta.requiresAuth === true && !store.state.user.token) {
		next({ name: 'login' });
	} else if (store.state.user.token && to.meta.isGuest) {
		next({ name: 'dashboard' });
	} else {
		next();
	}
});

export default router;