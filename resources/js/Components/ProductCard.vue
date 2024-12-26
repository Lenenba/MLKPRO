<script setup>
import { Link } from '@inertiajs/vue3'
import Pagination from '@/Components/UI/Pagination.vue'

defineProps({
    products: Object,
});
</script>

<template>
    <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8  mx-auto">
        <!-- Add Product Button -->
        <div class="flex justify-end mb-6">
            <button @click="() => {/* Logic to add a new product */ }"
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
    </div>
</template>
