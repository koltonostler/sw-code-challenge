<script setup>
	import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
	import { ChevronDownIcon } from '@heroicons/vue/20/solid';
	import { computed, defineProps } from 'vue';
	import store from '../store';
	
    // define props
	const props = defineProps({
		openModal: Function,
		openDeleteModal: Function,
		article: Object,
	});

    // get computed variables
	const computedAuthor = computed(() => (article) => {
		return store.getters.getUsers.find((user) => user.id === article.user_id).name;
	});

    // define methods
	function formatDate(isoDate) {
		const date = new Date(isoDate);
		const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		const month = months[date.getMonth()];
		const day = date.getDate();
		const year = date.getFullYear();
		return `${month} ${day}, ${year}`;
	}
</script>
<template>
	<div class="flex basis-[15%] sm:flex sm:flex-col sm:items-center">
		<p class="text-sm font-semibold leading-6 text-gray-900">
			{{ computedAuthor(props.article) }}
		</p>
	</div>
	<div class="basis-[15%] sm:flex sm:flex-col sm:items-center">
		<p class="text-sm leading-6 text-gray-900">{{ props.article.title }}</p>
	</div>
	<div class="hidden basis-[40%] sm:flex sm:flex-col sm:items-center px-5">
		<p class="text-sm leading-6 text-gray-900 text-wrap">{{ props.article.body }}</p>
	</div>
	<div class="basis-[15%] sm:flex sm:flex-col sm:items-center">
		<p class="text-sm leading-6 text-gray-900">{{ formatDate(props.article.created_at) }}</p>
	</div>
	<Menu
		as="div"
		class="relative inline-block text-left"
	>
		<div @click="store.commit('setArticle', props.article)">
			<MenuButton
				class="inline-flex w-full justify-center rounded-md bg-black bg-opacity-20 px-4 py-2 text-sm font-medium text-white hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
			>
				Options
				<ChevronDownIcon
					class="ml-2 -mr-1 h-5 w-5 text-violet-200 hover:text-violet-100"
					aria-hidden="true"
				/>
			</MenuButton>
		</div>

		<transition
			enter-active-class="transition duration-100 ease-out"
			enter-from-class="transform scale-95 opacity-0"
			enter-to-class="transform scale-100 opacity-100"
			leave-active-class="transition duration-75 ease-in"
			leave-from-class="transform scale-100 opacity-100"
			leave-to-class="transform scale-95 opacity-0"
		>
			<MenuItems
				class="z-10 absolute right-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
			>
				<div
					@click="openModal()"
					class="px-1 py-1"
				>
					<MenuItem v-slot="{ active }">
						<button
							:class="[
								active ? 'bg-[#004E7D] text-white' : 'text-gray-900',
								'group flex w-full items-center rounded-md px-2 py-2 text-sm',
							]"
						>
							Edit
						</button>
					</MenuItem>
				</div>

				<div
					@click="openDeleteModal()"
					class="px-1 py-1"
				>
					<MenuItem v-slot="{ active }">
						<button
							:class="[
								active ? 'bg-[#004E7D] text-white' : 'text-gray-900',
								'group flex w-full items-center rounded-md px-2 py-2 text-sm',
							]"
						>
							Delete
						</button>
					</MenuItem>
				</div>
			</MenuItems>
		</transition>
	</Menu>
</template>


