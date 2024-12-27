<script setup>
import Modal from '@/Components/Modal.vue';
import ProductForm from '@/Components/Product/ProductForm.vue';
import { ref } from 'vue';

const IsOpenProductModal = ref(false);

const ActionProduct = () => {
    IsOpenProductModal.value = true;
};

const closeModal = () => {
    IsOpenProductModal.value = false;
};

defineProps({
    products: Object,
    categories: Object,
})

const getProductImage = (product) => {
    if (!product.filename) return '/images/default-product.png'; // Image par défaut si aucune n'est fournie
    return product.filename.startsWith('http') ? product.filename : `/storage/${product.filename}`;
};

const handleEdit = () => {
    // Émettre un événement pour éditer
    emit('edit-product', product);
};

const handleDelete = () => {
    // Émettre un événement pour supprimer
    emit('delete-product', product.id);
};
</script>

<template>
    <div
        class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
        <div class="h-36 flex justify-center items-center bg-gray-400 rounded-t-xl">
            <img :src="getProductImage(product)" alt="Product Image" class="object-cover h-full w-full rounded-t-xl" />
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
            <p class="mt-4 text-xs text-gray-400 dark:text-neutral-400">
                Added by: <span class="font-medium text-gray-600 dark:text-neutral-300">{{ product.user.name }}</span>
            </p>
        </div>
        <div
            class="mt-auto flex border-t border-gray-200 divide-x divide-gray-200 dark:border-neutral-700 dark:divide-neutral-700">
            <button @click="handleEdit"
                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                Edit
            </button>
            <button @click="handleDelete"
                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                Delete
            </button>
        </div>

        <Modal :show="IsOpenProductModal" @close="closeModal">
            <ProductForm :categories="categories" :product="product"  @close="closeModal"/>
        </Modal>
    </div>
</template>
