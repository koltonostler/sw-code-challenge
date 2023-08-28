<script setup>
	import {
		TransitionRoot,
		TransitionChild,
		Dialog,
		Disclosure,
		DisclosureButton,
		DisclosurePanel,
		ComboboxButton,
		Combobox,
		ComboboxInput,
		ComboboxOptions,
		ComboboxOption,
	} from '@headlessui/vue';
	import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid';
	import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline';
	import { StarIcon } from '@heroicons/vue/24/solid';
	import { ref, computed, onMounted, watch } from 'vue';
	import UserForm from './UserForm.vue';
	import store from '../store';

	onMounted(() => {
		store.dispatch('fetchAllUsers');
	});

	let filteredUsers = computed(() =>
		query.value === ''
			? store.getters.getUsers
			: store.getters.getUsers.filter((user) =>
					user.name.toLowerCase().replace(/\s+/g, '').includes(query.value.toLowerCase().replace(/\s+/g, ''))
			  )
	);
	let activeUser = ref(store.getters.getActiveUser);
	let query = ref('');
	let selected = ref(filteredUsers[0]);

	watch(filteredUsers, (newFilteredUsers) => {
		if (newFilteredUsers.length > 0) {
			selected.value = newFilteredUsers[0];
		}
	});
	watch(selected, (newSelectedUser) => {
		store.commit('setUser', newSelectedUser);
	});
	const updateSelected = ({ activeUser }) => {
		// Update the selected ref in the parent
		selected.value = activeUser;
	};
	const isOpen = ref(false);

	function closeModal() {
		isOpen.value = false;
	}
	function openModal() {
		isOpen.value = true;
	}

	const navigation = [
		// {name: "Homepage", href: '/'}
	];
</script>

<template>
	<Disclosure
		as="nav"
		style="background-color: #004e7d"
		v-slot="{ open }"
	>
		<div class="mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex h-24 items-center justify-between">
				<div class="flex items-center">
					<div class="flex-shrink-0">
						<img
							class=""
							src="@/assets/Studies_Weekly_Nav_Logo.webp"
							alt="Studies Weekly"
						/>
					</div>
					<div class="hidden md:block">
						<div class="ml-10 flex items-baseline space-x-4">
							<a
								v-for="item in navigation"
								:key="item.name"
								:href="item.href"
								:class="[
									item.current
										? 'bg-gray-900 text-white'
										: 'text-gray-300 hover:bg-sky-950 hover:text-white',
									'rounded-md px-3 py-2 text-sm font-medium',
								]"
								:aria-current="item.current ? 'page' : undefined"
								>{{ item.name }}</a
							>
						</div>
					</div>
				</div>
				<div class="hidden md:block">
					<div class="ml-4 flex items-center justify-center md:ml-6">
						<Combobox v-model="selected">
							<label
								class="px-4 text-2xl text-white"
								for="user"
								@click="
									() => {
										console.log(store.state.activeUser);
									}
								"
								>User</label
							>
							<div class="relative">
								<div
									class="relative w-full cursor-default overflow-hidden rounded-lg bg-white text-left shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 focus-visible:ring-offset-2 focus-visible:ring-offset-teal-300 sm:text-sm"
								>
									<ComboboxInput
										id="user"
										class="w-full border-none py-2 pl-3 pr-10 text-base font-medium leading-5 text-gray-900 focus:ring-0"
										:displayValue="(user) => user.name"
										@change="query = $event.target.value"
									/>
									<ComboboxButton class="absolute inset-y-0 right-0 flex items-center pr-2">
										<ChevronUpDownIcon
											class="h-5 w-5 text-gray-400"
											aria-hidden="true"
										/>
									</ComboboxButton>
								</div>
								<TransitionRoot
									leave="transition ease-in duration-100"
									leaveFrom="opacity-100"
									leaveTo="opacity-0"
									@after-leave="query = ''"
								>
									<ComboboxOptions
										class="z-10 absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
									>
										<div
											v-if="filteredUsers.length === 0 && query !== ''"
											class="relative cursor-default select-none py-2 px-4 text-gray-700"
										>
											Nothing found.
										</div>

										<ComboboxOption
											v-for="user in filteredUsers"
											as="template"
											:key="user.id"
											:value="user"
											v-slot="{ selected, active }"
										>
											<li
												class="relative cursor-default select-none py-2 pl-10 pr-4"
												:class="{
													'bg-teal-600 text-white': active,
													'text-gray-900': !active,
												}"
											>
												<span
													class="block truncate"
													:class="{ 'font-medium': selected, 'font-normal': !selected }"
												>
													{{ user.name }}
													<span v-if="user.can_edit"
														><StarIcon
															class="inline-block h-3 w-3 text-yellow-400 absolute top-2"
															aria-hidden="true"
													/></span>
												</span>
												<span
													v-if="selected"
													class="absolute inset-y-0 left-0 flex items-center pl-3"
													:class="{ 'text-white': active, 'text-teal-600': !active }"
												>
													<CheckIcon
														class="h-5 w-5"
														aria-hidden="true"
													/>
												</span>
											</li>
										</ComboboxOption>
									</ComboboxOptions>
								</TransitionRoot>
							</div>
						</Combobox>
						<div class="inset-0 flex items-center justify-center mx-3">
							<button
								type="button"
								@click="openModal"
								class="rounded-md bg-black bg-opacity-20 px-4 py-2 text-sm font-medium text-white hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
							>
								Create User
							</button>
							<TransitionRoot
								appear
								:show="isOpen"
								as="template"
							>
								<Dialog
									as="div"
									class="relative z-10"
								>
									<TransitionChild
										as="template"
										enter="duration-300 ease-out"
										enter-from="opacity-0"
										enter-to="opacity-100"
										leave="duration-200 ease-in"
										leave-from="opacity-100"
										leave-to="opacity-0"
									>
										<div class="fixed inset-0 bg-black bg-opacity-25" />
									</TransitionChild>

									<div class="fixed inset-0 overflow-y-auto">
										<div class="flex min-h-full items-center justify-center p-4 text-center">
											<TransitionChild
												as="template"
												enter="duration-300 ease-out"
												enter-from="opacity-0 scale-95"
												enter-to="opacity-100 scale-100"
												leave="duration-200 ease-in"
												leave-from="opacity-100 scale-100"
												leave-to="opacity-0 scale-95"
											>
												<UserForm
													:closeModal="closeModal"
													@update:selected="updateSelected"
												/>
											</TransitionChild>
										</div>
									</div>
								</Dialog>
							</TransitionRoot>
						</div>
					</div>
				</div>
				<div class="-mr-2 flex md:hidden">
					<!-- Mobile menu button -->
					<DisclosureButton
						class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
					>
						<span class="absolute -inset-0.5" />
						<span class="sr-only">Open main menu</span>
						<Bars3Icon
							v-if="!open"
							class="block h-6 w-6"
							aria-hidden="true"
						/>
						<XMarkIcon
							v-else
							class="block h-6 w-6"
							aria-hidden="true"
						/>
					</DisclosureButton>
				</div>
			</div>
		</div>

		<DisclosurePanel class="md:hidden">
			<div
				v-if="navigation.length > 0"
				class="space-y-1 px-2 pb-3 pt-2 sm:px-3"
			>
				<DisclosureButton
					v-for="item in navigation"
					:key="item.name"
					as="a"
					:href="item.href"
					:class="[
						item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white',
						'block rounded-md px-3 py-2 text-base font-medium',
					]"
					:aria-current="item.current ? 'page' : undefined"
					>{{ item.name }}</DisclosureButton
				>
			</div>
			<div class="pb-3 px-3">
				<Combobox v-model="selected">
					<div class="relative flex flex-col">
						<label
							class="top-1 pl-2 text-lg text-white"
							for="user"
							>User</label
						>
						<div
							class="relative w-full cursor-default overflow-hidden rounded-lg bg-white text-left shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 focus-visible:ring-offset-2 focus-visible:ring-offset-teal-300 sm:text-sm"
						>
							<ComboboxInput
								id="user"
								class="w-full border-none py-2 pl-3 pr-10 text-sm leading-5 text-gray-900 focus:ring-0"
								:displayValue="(user) => user.name"
								@change="query = $event.target.value"
							/>
							<ComboboxButton class="absolute inset-y-0 right-0 flex items-center pr-2">
								<ChevronUpDownIcon
									class="h-5 w-5 text-gray-400"
									aria-hidden="true"
								/>
							</ComboboxButton>
						</div>
						<TransitionRoot
							leave="transition ease-in duration-100"
							leaveFrom="opacity-100"
							leaveTo="opacity-0"
							@after-leave="query = ''"
						>
							<ComboboxOptions
								class="absolute max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
							>
								<div
									v-if="filteredUsers.length === 0 && query !== ''"
									class="relative cursor-default select-none py-2 px-4 text-gray-700"
								>
									Nothing found.
								</div>

								<ComboboxOption
									v-for="user in filteredUsers"
									as="template"
									:key="user.id"
									:value="user"
									v-slot="{ selected, active }"
								>
									<li
										class="relative cursor-default select-none py-2 pl-10 pr-4"
										:class="{
											'bg-teal-600 text-white': active,
											'text-gray-900': !active,
										}"
									>
										<span
											class="block truncate"
											:class="{ 'font-medium': selected, 'font-normal': !selected }"
										>
											{{ user.name }}
											<span v-if="user.can_edit"
												><StarIcon
													class="inline-block h-3 w-3 text-yellow-400 absolute top-2"
													aria-hidden="true"
											/></span>
										</span>
										<span
											v-if="selected"
											class="absolute inset-y-0 left-0 flex items-center pl-3"
											:class="{ 'text-white': active, 'text-teal-600': !active }"
										>
											<CheckIcon
												class="h-5 w-5"
												aria-hidden="true"
											/>
										</span>
									</li>
								</ComboboxOption>
							</ComboboxOptions>
						</TransitionRoot>
						<button
							type="button"
							@click="openModal"
							class="rounded-md justify-self-center mt-3 bg-black bg-opacity-20 px-4 py-2 text-sm font-medium text-white hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
						>
							Create User
						</button>
					</div>
				</Combobox>
			</div>
		</DisclosurePanel>
	</Disclosure>
</template>

<style></style>
