<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';

const emit = defineEmits(['NewProduct']);
const props = defineProps({
    filters: Object,
    categories: Array,
});

const filterForm = useForm({
    category_id: props.filters.category_id ?? "",
    stock: props.filters.stock ?? "",
    name: props.filters.name ?? "",
});

// Fonction de filtrage avec un délai pour éviter des appels excessifs
let filterTimeout;
const autoFilter = () => {
    if (filterTimeout) {
        clearTimeout(filterTimeout);
    }
    filterTimeout = setTimeout(() => {
        filterForm.get(route('product.index'), {
            preserveState: true,
            preserveScroll: true,
        });
    }, 300); // Délai de 300ms pour éviter les appels excessifs
};

const clear = () => {
    filterForm.category_id = null
    filterForm.stock = null
    filterForm.name = null
    autoFilter()

};

const NewProduct = () => {
    emit('NewProduct');
};
</script>

<template>
    <form @submit.prevent="autoFilter">
        <div class="p-6 bg-white border border-gray-200 rounded-lg mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-gray-800">Product Search</h2>
                <button
                    class="flex items-center justify-center w-6 h-6 rounded-full border border-gray-300 hover:bg-gray-100"
                    type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-4 h-4 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.5 12a7.5 7.5 0 1115 0 7.5 7.5 0 01-15 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 12a3.75 3.75 0 107.5 0 3.75 3.75 0 00-7.5 0z" />
                    </svg>
                </button>
            </div>

            <!-- Filters -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                <div class="col-span-3">
                    <InputLabel for="name" value="Name" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="filterForm.name"
                        @input="filterForm.name.length > 3 ? autoFilter() : null"
                    />
                    <InputError class="mt-2" :message="filterForm.errors.name" />
                </div>
                <div>
                    <InputLabel for="category_id" value="Category" />
                    <SelectInput
                        id="category_id"
                        v-model="filterForm.category_id"
                        class="mt-1 block w-full"
                        @change="autoFilter"
                    >
                        <option value="">All Categories</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </SelectInput>
                    <InputError class="mt-2" :message="filterForm.errors.category_id" />
                </div>
                <div>
                    <InputLabel for="stock" value="Stock" />
                    <SelectInput
                        id="stock"
                        v-model="filterForm.stock"
                        class="mt-1 block w-full"
                        @change="autoFilter"
                    >
                        <option value="">All Stocks</option>
                        <option value="0-10">0 - 10</option>
                        <option value="10-100">10 - 100</option>
                        <option value=">100"> > 100</option>
                    </SelectInput>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-between mt-6">
                <div class="flex gap-4">
                    <button type="button" @click="clear"
                        class="py-2 px-6 text-sm font-medium text-white bg-gray-800 rounded-lg hover:bg-gray-600">
                        Clear
                    </button>
                </div>
                <button type="button" @click="NewProduct"
                    class="py-2 px-6 text-sm font-medium text-white bg-gray-800 rounded-lg hover:bg-gray-600">
                    Add New Product
                </button>
            </div>
        </div>
    </form>
</template>
