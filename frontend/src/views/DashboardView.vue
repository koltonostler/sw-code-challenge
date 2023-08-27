<script setup>
	import { ref } from 'vue';
	import { TransitionRoot, TransitionChild, Dialog } from '@headlessui/vue';
	import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid';
	import ArticleForm from '../components/ArticleForm.vue';
    import ArticleList from '../components/ArticleList.vue';

	const isOpen = ref(false);

	function closeModal() {
		isOpen.value = false;
	}
	function openModal() {
		isOpen.value = true;
	}
</script>

<template>
	<div class="min-h-full">
		<header class="bg-white shadow">
			<div class="mx-auto px-4 py-6 sm:px-6 lg:pl-[12rem] lg:pr-8 sm:flex-row flex-col flex justify-between">
				<h1 class="text-5xl sm:text-3xl mb-3 sm:text-start text-center font-bold tracking-tight text-gray-900">Articles</h1>
				<div class="flex sm:justify-evenly justify-between">
					<div class="inset-0 flex items-center sm:justify-center">
						<div class="flex flex-row justify-center items-start sm:mx-3 mx-0 sm:gap-3 gap-1">
							<MagnifyingGlassIcon
								class="h-7 w-7 text-zinc-400"
								aria-hidden="true"
                                title="Search Articles"
							></MagnifyingGlassIcon>
							<input
								class="px-4 py-2 text-[.8rem] font-medium border-b-2 w-[25vw] sm:w-auto sm:text-sm border-zinc-300 focus-visible:border-[#004E7D]"
                                placeholder="Search Articles"
							/>
						</div>
					</div>
					<div class="inset-0 flex items-center justify-center">
						<button
							type="button"
							@click="openModal"
							class="rounded-md bg-black bg-opacity-20 px-4 py-2 text-sm font-medium text-white hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
						>
							Add Article
						</button>
					</div>
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
										<ArticleForm :closeModal="closeModal" />
									</TransitionChild>
								</div>
							</div>
						</Dialog>
					</TransitionRoot>
				</div>
			</div>
		</header>
		<main>
			<div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
				<ArticleList />
			</div>
		</main>
	</div>
</template>
