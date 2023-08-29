<script setup>
	import { DialogPanel, DialogTitle } from '@headlessui/vue';
	import store from '../../store';
	import Alert from '../Alert.vue';
	import { ref, defineProps, computed, defineEmits } from 'vue';
	import { Switch } from '@headlessui/vue';

	// define emit and props
	const emit = defineEmits();
	const props = defineProps({
		closeModal: Function,
	});

	// initialize variables
	const enabled = ref(false);
	const isLoading = ref(false);
	const isDisabled = ref(false);
	const user = ref({
		name: '',
		can_edit: '',
	});
	const alertType = ref('');
	const alertMessage = ref('');

	// define methods
	function handleSubmit(e) {
		e.preventDefault();
		isLoading.value = true;
		isDisabled.value = true;
		user.value.can_edit = enabled.value;
		store
			.dispatch('createUser', user.value)
			.then((res) => {
				isLoading.value = false;
				emit('update:selected', { activeUser: res.user });
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
		class="w-full lg:max-w-[30%] sm:max-w-[50%] transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
	>
		<DialogTitle
			as="h3"
			class="text-lg font-medium leading-6 text-gray-900"
		>
			Create New User
		</DialogTitle>
		<form @submit="handleSubmit">
			<div class="space-y-12">
				<div class="border-b border-gray-900/10 pb-12">
					<div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8">
						<div class="sm:col-span-4">
							<label
								for="title"
								class="block text-sm font-medium leading-6 text-gray-900"
								>Name</label
							>
							<div class="mt-2">
								<div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300">
									<input
										v-model="user.name"
										type="text"
										name="name"
										id="name"
										autocomplete="name"
										class="block flex-1 rounded-md border-0 py-1.5 pl-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-insert focus:ring-[#3d7ba2] sm:text-sm sm:leading-6"
										placeholder="Name"
									/>
								</div>
							</div>
						</div>
						<div class="sm:col-span-4">
							<label
								for="title"
								class="block text-sm font-medium leading-6 text-gray-900"
								>Can Edit?</label
							>

							<Switch
								v-model="enabled"
								:class="enabled ? 'bg-blue-600' : 'bg-gray-200'"
								class="relative inline-flex h-6 w-11 items-center rounded-full"
							>
								<span class="sr-only">Enable notifications</span>
								<span
									:class="enabled ? 'translate-x-6' : 'translate-x-1'"
									class="inline-block h-4 w-4 transform rounded-full bg-white transition"
								/>
							</Switch>
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
