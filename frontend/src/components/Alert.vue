<script>
	export default {
		name: 'Alert',
		props: {
			alertType: String,
			message: String,
		},
	};
</script>

<template>
	<div
		v-if="alertType === 'error'"
		class="bg-orange-100 border-l-4 mt-3 border-orange-500 text-orange-700 p-4"
		role="alert"
	>
		<p class="font-bold">Error</p>
		<p>{{ message }}</p>
	</div>
	<div
		v-if="alertType === 'success'"
		class="bg-green-100 border-l-4 mt-3 border-green-500 text-green-700 p-4"
		role="alert"
	>
		<p class="font-bold">Success</p>
		<p>{{ message }}</p>
	</div>
</template>
