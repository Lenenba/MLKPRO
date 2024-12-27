<script setup>
import { defineEmits } from 'vue';

const emit = defineEmits(['NewProduct']);

// Fonction pour fermer la modale
const NewProduct = () => {
    emit('NewProduct');
};
</script>

<template>
    <div class="p-6 bg-white border border-gray-200 rounded-lg max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-800">Product search</h2>
            <button
                class="flex items-center justify-center w-6 h-6 rounded-full border border-gray-300 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-4 h-4 text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.5 12a7.5 7.5 0 1115 0 7.5 7.5 0 01-15 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 12a3.75 3.75 0 107.5 0 3.75 3.75 0 00-7.5 0z" />
                </svg>
            </button>
        </div>

        <!-- Dropdown Filters -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-4">
            <select
                class="w-full p-2 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option selected>Clothing</option>
                <option>Accessories</option>
                <option>Footwear</option>
            </select>

            <select
                class="w-full p-2 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option selected>Designer</option>
                <option>Designer 1</option>
                <option>Designer 2</option>
            </select>

            <select
                class="w-full p-2 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option selected>Color</option>
                <option>Red</option>
                <option>Blue</option>
                <option>Green</option>
            </select>

            <select
                class="w-full p-2 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option selected>Price Range</option>
                <option>$0 - $50</option>
                <option>$50 - $100</option>
            </select>

            <select
                class="w-full p-2 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option selected>Sort by</option>
                <option>Price: Low to High</option>
                <option>Price: High to Low</option>
            </select>
        </div>

        <!-- Checkbox Filters -->
        <div class="flex flex-wrap gap-4">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                Blazers
            </label>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                Casual Shirts
            </label>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                Formal Shirts
            </label>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                Jeans
            </label>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                Polos
            </label>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                Shorts
            </label>
            <div class="flex mx-auto ">
                <button @click="NewProduct"
                    class="py-2 px-6 text-sm font-medium text-white bg-gray-800 rounded-lg hover:bg-gray-600">
                    Add New Product
                </button>
            </div>
        </div>
    </div>
</template>
