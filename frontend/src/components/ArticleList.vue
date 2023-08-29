<script setup>
	import { TransitionRoot, TransitionChild, Dialog } from '@headlessui/vue';
	import ArticleForm from './Forms/ArticleForm.vue';
	import Article from './Article.vue';
	import ArticleSkeleton from './ArticleSkeleton.vue';
	import { computed, onMounted, defineProps, ref, watch } from 'vue';
	import store from '../store';
	import DeleteConfirm from './DeleteConfirm.vue';

	// define props
	const props = defineProps({
		query: String,
	});

	// initialize variables
	const isLoading = ref(false);
	const isOpen = ref(false);
	const isDeleteOpen = ref(false);

	// get computed variables
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

	// fetch articles on mount and handle loading
	onMounted(() => {
		isLoading.value = true;
		store.dispatch('fetchAllArticles');
	});

	watch(filteredArticles, (newVal, oldVal) => {
		isLoading.value = false;
	});

	// define methods
	function closeModal() {
		isOpen.value = false;
	}
	function openModal() {
		isOpen.value = true;
	}
	function closeDeleteModal() {
		isDeleteOpen.value = false;
	}
	function openDeleteModal() {
		isDeleteOpen.value = true;
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
			v-if="isLoading"
			v-for="i in 9"
			:key="i"
			class="px-5 flex justify-between gap-x-6 py-5"
		>
			<ArticleSkeleton />
		</li>
		<div
			class="p-3"
			v-else-if="filteredArticles.length === 0"
		>
			<span v-if="query.length > 0">No articles returned from title search</span>
			<span v-else>No articles found, please create one to get started!</span>
		</div>
		<li
			v-else
			v-for="article in filteredArticles"
			:key="article.id"
			class="px-5 flex justify-between gap-x-6 py-5"
		>
			<Article
				:article="article"
				:openModal="openModal"
				:openDeleteModal="openDeleteModal"
			/>
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
