<script setup>
	import { DialogPanel, DialogTitle } from '@headlessui/vue';
	import store from '../../store';
	import Alert from '../Alert.vue';
	import { ref, defineProps, computed } from 'vue';

	// define props
	const props = defineProps({
		closeModal: Function,
		articleToEdit: Object,
		isEdit: Boolean,
	});

	// initialize variables
	const article = ref({
		title: props.articleToEdit.title,
		body: props.articleToEdit.body,
		id: props.articleToEdit.id,
		user: {},
	});
	let alertType = ref('');
	let alertMessage = ref('');
	const isLoading = ref(false);
	const isDisabled = ref(false);

	// define methods
	function handleSubmit(e) {
		e.preventDefault();
		isLoading.value = true;
		isDisabled.value = true;
		article.value.user = store.state.activeUser.data;

		let apiCall = 'createArticle';
		if (props.isEdit) {
			apiCall = 'updateArticle';
		}

		store
			.dispatch(apiCall, article.value)
			.then((res) => {
				isLoading.value = false;
				alertType.value = 'success';
				alertMessage.value = res.message;

				setTimeout(() => {
					props.closeModal();
					isDisabled.value = false;
				}, 1500);
			})
			.catch((err) => {
				isLoading.value = false;
				isDisabled.value = false;
				console.log(err);
				alertType.value = 'error';
				alertMessage.value = err.response.data.message;
			});
	}
</script>

<template>
	<DialogPanel
		class="w-full lg:max-w-[70%] sm:max-w-[90%] transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
	>
		<DialogTitle
			v-if="props.isEdit"
			as="h3"
			class="text-lg font-medium leading-6 text-gray-900"
		>
			Edit Article
		</DialogTitle>
		<DialogTitle
			v-else
			as="h3"
			class="text-lg font-medium leading-6 text-gray-900"
		>
			Create New Article
		</DialogTitle>
		<form @submit="handleSubmit">
			<div class="space-y-12">
				<div class="border-b border-gray-900/10 pb-12">
					<div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
						<div class="sm:col-span-4">
							<label
								for="title"
								class="block text-sm font-medium leading-6 text-gray-900"
								>Title</label
							>
							<div class="mt-2">
								<div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 sm:max-w-md">
									<input
										v-model="article.title"
										type="text"
										name="title"
										id="title"
										autocomplete="title"
										class="block flex-1 rounded-md border-0 py-1.5 pl-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-insert focus:ring-[#3d7ba2] sm:text-sm sm:leading-6"
										placeholder="New Article Title"
									/>
								</div>
							</div>
						</div>

						<div class="col-span-full">
							<label
								for="body"
								class="block text-sm font-medium leading-6 text-gray-900"
								>Body</label
							>
							<div class="mt-2">
								<textarea
									v-model="article.body"
									id="body"
									name="body"
									rows="3"
                                    placeholder="Article body"
									class="block w-full rounded-md border-0 py-1.5 pl-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-insert focus:ring-[#3d7ba2] sm:text-sm sm:leading-6"
								/>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="mt-6 flex items-center justify-end gap-x-6">
				<button
					:disabled="isDisabled"
					type="button"
					class="text-sm font-semibold leading-6 text-gray-900"
					@click="closeModal"
				>
					Cancel
				</button>
				<button
					:disabled="isDisabled"
					type="submit"
					class="rounded-md bg-[#004E7D] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:opacity-80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
				>
					<div v-if="!isLoading">Save</div>
					<div
						v-else
						role="status"
					>
						<svg
							aria-hidden="true"
							class="w-[29.3px] h-[20px] text-gray-200 animate-spin dark:text-gray-600 fill-white"
							viewBox="0 0 100 101"
							fill="none"
							xmlns="http://www.w3.org/2000/svg"
						>
							<path
								d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
								fill="currentColor"
							/>
							<path
								d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
								fill="currentFill"
							/>
						</svg>
						<span class="sr-only">Loading...</span>
					</div>
				</button>
			</div>
			<Alert
				:alertType="alertType"
				:message="alertMessage"
			/>
		</form>
	</DialogPanel>
</template>

<style>
	textarea:focus,
	input:focus {
		outline: none;
	}
</style>
