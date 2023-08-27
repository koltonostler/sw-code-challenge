<template>
	<ul
		role="list"
		class="divide-y divide-gray-100 max-w-7xl"
	>
		<li class="flex justify-between gap-x-6 py-5 border-b-2 border-[#004E7D]">
			<div class="flex basis-[10%] sm:flex sm:flex-col sm:items-center">
				<p class="text-sm font-bold leading-6 text-gray-900">Author</p>
			</div>
			<div class="hidden basis-[10%] sm:flex sm:flex-col sm:items-center">
				<p class="text-sm font-bold leading-6 text-gray-900">Title</p>
			</div>
			<div class="hidden basis-[50%] sm:flex sm:flex-col sm:items-center">
				<p class="text-sm font-bold leading-6 text-gray-900 text-wrap">Body</p>
			</div>
			<div class="hidden basis-[10%] sm:flex sm:flex-col sm:items-center">
				<p class="text-sm font-bold leading-6 text-gray-900">Published Date</p>
			</div>
			<div class="hidden basis-[9%] sm:flex sm:flex-col sm:items-center">
				<p class="text-sm font-bold leading-6 text-gray-900"></p>
			</div>
		</li>
		<li
			v-for="article in articles"
			:key="article.id"
			class="flex justify-between gap-x-6 py-5"
		>
			<div class="flex basis-[10%] sm:flex sm:flex-col sm:items-center">
				<p class="text-sm font-semibold leading-6 text-gray-900">{{ article.author }}</p>
			</div>
			<div class="hidden basis-[10%] sm:flex sm:flex-col sm:items-center">
				<p class="text-sm leading-6 text-gray-900">{{ article.title }}</p>
			</div>
			<div class="hidden basis-[50%] sm:flex sm:flex-col sm:items-center px-5">
				<p class="text-sm leading-6 text-gray-900 text-wrap">{{ article.body }}</p>
			</div>
			<div class="hidden basis-[10%] sm:flex sm:flex-col sm:items-center">
				<p class="text-sm leading-6 text-gray-900">{{ article.publishDate }}</p>
			</div>
			<Menu
				as="div"
				class="relative inline-block text-left"
			>
				<div>
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
						class="absolute right-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
					>
						<div class="px-1 py-1">
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

						<div class="px-1 py-1">
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
	</ul>
</template>

<script setup>
	import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
	import { ChevronDownIcon } from '@heroicons/vue/20/solid';
	const articles = [
		{
			id: 1,
			author: 'Leslie Alexander',
			title: 'Article 1',
			body: 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam reiciendis, perferendis rem quisquam, laudantium eos ex dignissimos ducimus quia maxime sit, voluptatum aliquam exercitationem molestias asperiores? Ex ad sapiente quibusdam? Quo temporibus ea rerum illum consequatur repellendus voluptate, voluptatum provident ipsum doloribus eligendi quas velit optio doloremque, aliquid cupiditate animi esse possimus! Expedita voluptatibus, repudiandae aut consequuntur reprehenderit vitae itaque.  Eveniet nisi fugit quia voluptatum quibusdam aperiam? Dolor earum unde pariatur architecto, dolores harum nulla tempora. Impedit, consectetur cupiditate suscipit blanditiis debitis quos praesentium fugit! Totam quidem aperiam cumque eveniet! Fugiat, consequatur labore sit dicta officiis in enim voluptatibus laborum unde perspiciatis, culpa natus veritatis consequuntur assumenda nam mollitia? Placeat minima consectetur suscipit nisi eaque nulla qui velit doloribus optio. Est, ut excepturi maxime debitis nostrum rerum delectus, odit, fugit eaque asperiores quo animi ea repudiandae aspernatur. Voluptatum impedit molestiae libero nulla, dolorem nihil facere repellendus eos voluptate beatae at!',
			publishDate: 'Aug 23, 2023',
		},
		{
			id: 2,
			author: 'Kolton',
			title: 'Article 2',
			body: 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam reiciendis, perferendis rem quisquam, laudantium eos ex dignissimos ducimus quia maxime sit, voluptatum aliquam exercitationem molestias asperiores? Ex ad sapiente quibusdam? Quo temporibus ea rerum illum consequatur repellendus voluptate, voluptatum provident ipsum doloribus eligendi quas velit optio doloremque, aliquid cupiditate animi esse possimus! Expedita voluptatibus, repudiandae aut consequuntur reprehenderit vitae itaque.  Eveniet nisi fugit quia voluptatum quibusdam aperiam? Dolor earum unde pariatur architecto, dolores harum nulla tempora. Impedit, consectetur cupiditate suscipit blanditiis debitis quos praesentium fugit! Totam quidem aperiam cumque eveniet! Fugiat, consequatur labore sit dicta officiis in enim voluptatibus laborum unde perspiciatis, culpa natus veritatis consequuntur assumenda nam mollitia? Placeat minima consectetur suscipit nisi eaque nulla qui velit doloribus optio. Est, ut excepturi maxime debitis nostrum rerum delectus, odit, fugit eaque asperiores quo animi ea repudiandae aspernatur. Voluptatum impedit molestiae libero nulla, dolorem nihil facere repellendus eos voluptate beatae at!',
			publishDate: 'Aug 12, 2023',
		},
		{
			id: 3,
			author: 'Emelia',
			title: 'Article 3',
			body: 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam reiciendis, perferendis rem quisquam, laudantium eos ex dignissimos ducimus quia maxime sit, voluptatum aliquam exercitationem molestias asperiores? Ex ad sapiente quibusdam? Quo temporibus ea rerum illum consequatur repellendus voluptate, voluptatum provident ipsum doloribus eligendi quas velit optio doloremque, aliquid cupiditate animi esse possimus! Expedita voluptatibus, repudiandae aut consequuntur reprehenderit vitae itaque.  Eveniet nisi fugit quia voluptatum quibusdam aperiam? Dolor earum unde pariatur architecto, dolores harum nulla tempora. Impedit, consectetur cupiditate suscipit blanditiis debitis quos praesentium fugit! Totam quidem aperiam cumque eveniet! Fugiat, consequatur labore sit dicta officiis in enim voluptatibus laborum unde perspiciatis, culpa natus veritatis consequuntur assumenda nam mollitia? Placeat minima consectetur suscipit nisi eaque nulla qui velit doloribus optio. Est, ut excepturi maxime debitis nostrum rerum delectus, odit, fugit eaque asperiores quo animi ea repudiandae aspernatur. Voluptatum impedit molestiae libero nulla, dolorem nihil facere repellendus eos voluptate beatae at!',
			publishDate: 'Aug 27, 2023',
		},
		{
			id: 4,
			author: 'Jane',
			title: 'Article 4',
			body: 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam reiciendis, perferendis rem quisquam, laudantium eos ex dignissimos ducimus quia maxime sit, voluptatum aliquam exercitationem molestias asperiores? Ex ad sapiente quibusdam? Quo temporibus ea rerum illum consequatur repellendus voluptate, voluptatum provident ipsum doloribus eligendi quas velit optio doloremque, aliquid cupiditate animi esse possimus! Expedita voluptatibus, repudiandae aut consequuntur reprehenderit vitae itaque.  Eveniet nisi fugit quia voluptatum quibusdam aperiam? Dolor earum unde pariatur architecto, dolores harum nulla tempora. Impedit, consectetur cupiditate suscipit blanditiis debitis quos praesentium fugit! Totam quidem aperiam cumque eveniet! Fugiat, consequatur labore sit dicta officiis in enim voluptatibus laborum unde perspiciatis, culpa natus veritatis consequuntur assumenda nam mollitia? Placeat minima consectetur suscipit nisi eaque nulla qui velit doloribus optio. Est, ut excepturi maxime debitis nostrum rerum delectus, odit, fugit eaque asperiores quo animi ea repudiandae aspernatur. Voluptatum impedit molestiae libero nulla, dolorem nihil facere repellendus eos voluptate beatae at!',
			publishDate: 'Aug 22, 2023',
		},
		{
			id: 5,
			author: 'Michrelr',
			title: 'Article 5',
			body: 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam reiciendis, perferendis rem quisquam, laudantium eos ex dignissimos ducimus quia maxime sit, voluptatum aliquam exercitationem molestias asperiores? Ex ad sapiente quibusdam? Quo temporibus ea rerum illum consequatur repellendus voluptate, voluptatum provident ipsum doloribus eligendi quas velit optio doloremque, aliquid cupiditate animi esse possimus! Expedita voluptatibus, repudiandae aut consequuntur reprehenderit vitae itaque.  Eveniet nisi fugit quia voluptatum quibusdam aperiam? Dolor earum unde pariatur architecto, dolores harum nulla tempora. Impedit, consectetur cupiditate suscipit blanditiis debitis quos praesentium fugit! Totam quidem aperiam cumque eveniet! Fugiat, consequatur labore sit dicta officiis in enim voluptatibus laborum unde perspiciatis, culpa natus veritatis consequuntur assumenda nam mollitia? Placeat minima consectetur suscipit nisi eaque nulla qui velit doloribus optio. Est, ut excepturi maxime debitis nostrum rerum delectus, odit, fugit eaque asperiores quo animi ea repudiandae aspernatur. Voluptatum impedit molestiae libero nulla, dolorem nihil facere repellendus eos voluptate beatae at!',
			publishDate: 'Aug 4, 2023',
		},
		{
			id: 6,
			author: 'Michaela',
			title: 'Article 6',
			body: 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nam reiciendis, perferendis rem quisquam, laudantium eos ex dignissimos ducimus quia maxime sit, voluptatum aliquam exercitationem molestias asperiores? Ex ad sapiente quibusdam? Quo temporibus ea rerum illum consequatur repellendus voluptate, voluptatum provident ipsum doloribus eligendi quas velit optio doloremque, aliquid cupiditate animi esse possimus! Expedita voluptatibus, repudiandae aut consequuntur reprehenderit vitae itaque.  Eveniet nisi fugit quia voluptatum quibusdam aperiam? Dolor earum unde pariatur architecto, dolores harum nulla tempora. Impedit, consectetur cupiditate suscipit blanditiis debitis quos praesentium fugit! Totam quidem aperiam cumque eveniet! Fugiat, consequatur labore sit dicta officiis in enim voluptatibus laborum unde perspiciatis, culpa natus veritatis consequuntur assumenda nam mollitia? Placeat minima consectetur suscipit nisi eaque nulla qui velit doloribus optio. Est, ut excepturi maxime debitis nostrum rerum delectus, odit, fugit eaque asperiores quo animi ea repudiandae aspernatur. Voluptatum impedit molestiae libero nulla, dolorem nihil facere repellendus eos voluptate beatae at!',
			publishDate: 'Aug 21, 2023',
		},
	];
</script>
