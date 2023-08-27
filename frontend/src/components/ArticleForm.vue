<script setup>
	import { DialogPanel, DialogTitle } from '@headlessui/vue';
	import { PhotoIcon, UserCircleIcon } from '@heroicons/vue/24/solid';
	const props = defineProps({ closeModal: Function });
</script>

<template>
	<DialogPanel
		class="w-full lg:max-w-[70%] sm:max-w-[90%] transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
	>
		<DialogTitle
			as="h3"
			class="text-lg font-medium leading-6 text-gray-900"
		>
			Create New Article
		</DialogTitle>
		<form>
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
										type="text"
										name="name"
										id="name"
										autocomplete="name"
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
									id="body"
									name="body"
									rows="3"
									class="block w-full rounded-md border-0 py-1.5 pl-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-insert focus:ring-[#3d7ba2] sm:text-sm sm:leading-6"
								/>
							</div>
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
					@click="closeModal"
					class="rounded-md bg-[#004E7D] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:opacity-80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
				>
					Save
				</button>
			</div>
		</form>
	</DialogPanel>
</template>

<style>
	textarea:focus,
	input:focus {
		outline: none;
	}
</style>
