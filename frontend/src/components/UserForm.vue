<script setup>
	import { DialogPanel, DialogTitle } from '@headlessui/vue';
	import store from '../store';
	import Alert from './Alert.vue';
	import { ref, defineProps, computed, defineEmits } from 'vue';
	import { Switch } from '@headlessui/vue';

    const emit = defineEmits();

	const enabled = ref(false);

	const props = defineProps({
		closeModal: Function,
	});

	const user = ref({
		name: '',
		can_edit: '',
	});
	let alertType = ref('');
	let alertMessage = ref('');

	function handleSubmit(e) {
		e.preventDefault();
        
		user.value.can_edit = enabled.value;
		store
			.dispatch('createUser', user.value)
			.then((res) => {
                emit('update:selected', {activeUser: res.user})
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
					type="button"
					class="text-sm font-semibold leading-6 text-gray-900"
					@click="closeModal"
				>
					Cancel
				</button>
				<button
					type="submit"
					class="rounded-md bg-[#004E7D] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:opacity-80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
				>
					Save
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
