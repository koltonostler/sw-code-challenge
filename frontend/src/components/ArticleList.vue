<script setup>
	import { Menu, MenuButton, MenuItems, MenuItem, TransitionRoot, TransitionChild, Dialog } from '@headlessui/vue';
	import ArticleForm from './ArticleForm.vue';
	import { ChevronDownIcon } from '@heroicons/vue/20/solid';
	import { computed, onMounted, defineProps, watch, ref } from 'vue';
	import store from '../store';
import DeleteConfirm from './DeleteConfirm.vue';

	const props = defineProps({
		query: String,
	});

	const isOpen = ref(false);

	function closeModal() {
		isOpen.value = false;
	}
	function openModal() {
		isOpen.value = true;
	}
	const isDeleteOpen = ref(false);

	function closeDeleteModal() {
		isDeleteOpen.value = false;
	}
	function openDeleteModal() {
		isDeleteOpen.value = true;
	}
	const computedAuthor = computed(() => (article) => {
		return store.getters.getUsers.find((user) => user.id === article.user_id).name;
	});

	const filteredArticles = computed(() => {
		let articles = store.getters.getArticles;
		if (!props.query) {
			return articles;
		}
		const searchTerm = props.query.toLowerCase();
		return articles.filter((article) => {
			return article.title.toLowerCase().includes(searchTerm);
		});
	});
	let alertType = ref('');
	let alertMessage = ref('');

	const articles = computed(() => store.getters.getArticles);
	onMounted(() => {
		store.dispatch('fetchAllArticles');
	});

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
	<ul
		role="list"
		class="divide-y divide-gray-100 max-w-[100rem] text-center"
	>
		<li class="px-5 flex justify-between gap-x-6 py-5 border-b-2 border-[#004E7D]">
			<div class="flex basis-[15%] sm:flex sm:flex-col sm:items-center">
				<p class="text-sm font-bold leading-6 text-gray-900">Author</p>
			</div>
			<div class="basis-[15%] sm:flex sm:flex-col sm:items-center">
				<p class="text-sm font-bold leading-6 text-gray-900">Title</p>
			</div>
			<div class="hidden basis-[40%] sm:flex sm:flex-col sm:items-center">
				<p class="text-sm font-bold leading-6 text-gray-900 text-wrap">Body</p>
			</div>
			<div class="basis-[15%] sm:flex sm:flex-col sm:items-center">
				<p class="text-sm font-bold leading-6 text-gray-900">Published Date</p>
			</div>
			<div class="basis-[106px] sm:flex sm:flex-col sm:items-center">
				<p class="text-sm font-bold leading-6 text-gray-900"></p>
			</div>
		</li>
		<li
			v-for="article in filteredArticles"
			:key="article.id"
			class="px-5 flex justify-between gap-x-6 py-5"
		>
			<div class="flex basis-[15%] sm:flex sm:flex-col sm:items-center">
				<p class="text-sm font-semibold leading-6 text-gray-900">
					{{ computedAuthor(article) }}
				</p>
			</div>
			<div class="basis-[15%] sm:flex sm:flex-col sm:items-center">
				<p class="text-sm leading-6 text-gray-900">{{ article.title }}</p>
			</div>
			<div class="hidden basis-[40%] sm:flex sm:flex-col sm:items-center px-5">
				<p class="text-sm leading-6 text-gray-900 text-wrap">{{ article.body }}</p>
			</div>
			<div class="basis-[15%] sm:flex sm:flex-col sm:items-center">
				<p class="text-sm leading-6 text-gray-900">{{ formatDate(article.created_at) }}</p>
			</div>
			<Menu
				as="div"
				class="relative inline-block text-left"
			>
				<div @click="store.commit('setArticle', article)">
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
		</li>
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
							<ArticleForm
								:closeModal="closeModal"
								:articleToEdit="store.getters.getCurrentArticle"
								:isEdit="true"
							/>
						</TransitionChild>
					</div>
				</div>
			</Dialog>
		</TransitionRoot>
		<TransitionRoot
			appear
			:show="isDeleteOpen"
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
							<DeleteConfirm
								:closeModal="closeDeleteModal"
								:articleToDelete="store.getters.getCurrentArticle"
							/>
						</TransitionChild>
					</div>
				</div>
			</Dialog>
		</TransitionRoot>
	</ul>
</template>
