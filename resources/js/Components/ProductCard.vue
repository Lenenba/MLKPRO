<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Pagination from '@/Components/UI/Pagination.vue'

// Modal visibility state
const isModalOpen = ref(false);

// Product data
const newProduct = ref({
    name: '',
    description: '',
    category_id: '',
    stock: 0,
});

// Function to toggle modal visibility
const toggleModal = () => {
    isModalOpen.value = !isModalOpen.value;
};


defineProps({
    products: Object,
    categories: Object,
});
</script>

<template>
    <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8  mx-auto">
        <!-- Add Product Button -->
        <div class="flex justify-end mb-6">
            <button @click="toggleModal"
                class="py-2 px-4 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:bg-blue-700">
                Add New Product
            </button>
        </div>

        <!-- Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card -->
            <div v-for="product in products.data" :key="product.id"
                class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
                <div class="h-36 flex justify-center items-center bg-blue-600 rounded-t-xl">
                    <img :src="product.image" alt="Product Image" class="object-cover h-full w-full rounded-t-xl" />
                </div>
                <div class="p-4 md:p-6 flex flex-col justify-between flex-1">
                    <div>
                        <span class="block mb-1 text-xs font-semibold uppercase text-blue-600 dark:text-blue-500">
                            {{ product.category.name }}
                        </span>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">
                            {{ product.name }}
                        </h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-neutral-500">
                            {{ product.description }}
                        </p>
                    </div>
                    <p class="mt-4 text-xs text-gray-400 dark:text-neutral-400 ">
                        Added by: <span class="font-medium text-gray-600 dark:text-neutral-300">{{ product.user.name
                            }}</span>
                    </p>
                </div>
                <div
                    class="mt-auto flex border-t border-gray-200 divide-x divide-gray-200 dark:border-neutral-700 dark:divide-neutral-700">
                    <a href="#"
                        class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                        Edit
                    </a>
                    <a href="#"
                        class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                        Delete
                    </a>
                </div>
            </div>
            <!-- End Card -->
        </div>
        <!-- End Grid -->

        <!-- Footer -->
        <Pagination :pagination="products" />
        <!-- End Footer -->


        <!-- Modal -->
        <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <!-- Card Section -->
            <div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 mx-auto"><!-- Card -->
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-neutral-800">
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
                            Prodict Details
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-neutral-400">
                           Enter all the details of the product you want to add
                        </p>
                    </div>

                    <form>
                        <!-- Grid -->
                        <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                            <div class="sm:col-span-3">
                                <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                                    Product image
                                </label>
                            </div>
                            <!-- End Col -->

                            <div class="sm:col-span-9">
                                <div class="flex items-center gap-5">
                                    <img class="inline-block size-16 rounded-full ring-2 ring-white dark:ring-neutral-900"
                                        src="https://preline.co/assets/img/160x160/img1.jpg" alt="Avatar">
                                    <div class="flex gap-x-2">
                                        <div>
                                            <button type="button"
                                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                    <polyline points="17 8 12 3 7 8" />
                                                    <line x1="12" x2="12" y1="3" y2="15" />
                                                </svg>
                                                Upload photo
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="name"
                                    class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                                    Product name
                                </label>
                            </div>
                            <!-- End Col -->

                            <div class="sm:col-span-9">
                                <input id="name" type="text"
                                    class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    placeholder="product name">
                            </div>
                            <!-- End Col -->

                            <div class="sm:col-span-3">
                                <label for="stock"
                                    class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                                    Stock quantity
                                </label>
                            </div>
                            <!-- End Col -->

                            <div class="sm:col-span-9">
                                <input id="stock" type="number"
                                    class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    placeholder="0">
                            </div>

                            <div class="sm:col-span-3">
                                <label for="stock"
                                    class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                                   seuil de stock
                                </label>
                            </div>
                            <!-- End Col -->

                            <div class="sm:col-span-9">
                                <input id="stock" type="number"
                                    class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    placeholder="0">
                            </div>
                            <!-- End Col -->
                            <div class="sm:col-span-3">
                                <label for="af-submit-app-category" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-neutral-200">
                                Category
                                </label>
                            </div>
                            <div class="sm:col-span-9">
                                <select id="af-submit-app-category" class="py-2 px-3 pe-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                <option selected>Select a category</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.name }}
                                </option>
                                </select>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="af-account-bio"
                                    class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                                    Description
                                </label>
                            </div>
                            <!-- End Col -->

                            <div class="sm:col-span-9">
                                <textarea id="af-account-bio"
                                    class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    rows="6" placeholder="Type your message..."></textarea>
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Grid -->

                        <div class="mt-5 flex justify-end gap-x-2">
                            <button type="button"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                                Cancel
                            </button>
                            <button type="button"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                Add new product
                            </button>
                        </div>
                    </form>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Card Section -->
        </div>
        <!-- End Modal -->
    </div>
</template>
