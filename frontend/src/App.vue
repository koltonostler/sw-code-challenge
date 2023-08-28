<script setup>
	import DashboardView from './views/DashboardView.vue';
	import TopbarNavigation from './components/TopbarNavigation.vue';
	import { onMounted } from 'vue';
    import store from './store';

	onMounted(() => {
		
		// store.dispatch('fetchAllUsers');
	});
</script>

<template>
	<header>
		<TopbarNavigation />
	</header>

	<main>
		<DashboardView />
	</main>
</template>

<style scoped></style>
