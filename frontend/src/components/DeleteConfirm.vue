<script setup>
	import { DialogPanel, DialogTitle } from '@headlessui/vue';
	import store from '../store';
	import Alert from './Alert.vue';
	import { ref, defineProps } from 'vue';

	const props = defineProps({
		closeModal: Function,
		articleToDelete: Object,
	});

	const article = ref({
		id: props.articleToDelete.id,
		user: {},
	});
	let alertType = ref('');
	let alertMessage = ref('');

	function handleDelete() {
		article.value.user = store.state.activeUser.data;
		store
			.dispatch('deleteArticle', article.value)
			.then((res) => {
				console.log(res);
				alertType.value = 'success';
				alertMessage.value = res.message;

				setTimeout(() => {
					props.closeModal();
				}, 1500);
			})
			.catch((err) => {
				console.log(err);
				alertType.value = 'error';
				alertMessage.value = err.response.data.message;
			});
	}
</script>

<template>
	<DialogPanel
		class="w-full lg:max-w-[30%] sm:max-w-[50%] transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
	>
		<DialogTitle
			as="h3"
			class="text-lg font-medium leading-6 text-gray-900"
		>
			Confirm Delete
		</DialogTitle>

		<div class="space-y-12">
			<div class="border-b border-gray-900/10 pb-12">
				<div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8">
					<div class="sm:col-span-4">Do you want to permanently delete this article?</div>
				</div>
			</div>
		</div>

		<div class="mt-6 flex items-center justify-end gap-x-6">
			<button
				type="button"
				class="text-sm font-semibold leading-6 text-gray-900"
				@click="closeModal"
			>
				Cancel
			</button>
			<button
				@click="handleDelete"
				type="button"
				class="rounded-md bg-[#ff2121] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:opacity-80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
			>
				Delete
			</button>
		</div>
		<Alert
			:alertType="alertType"
			:message="alertMessage"
		/>
	</DialogPanel>
</template>

<style>
	textarea:focus,
	input:focus {
		outline: none;
	}
</style>
