<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProductCard from '@/Components/Product/ProductCard.vue';
import ProductForm from '@/Components/Product/ProductForm.vue';
import Search from '@/Components/Search.vue';
import Pagination from '@/Components/UI/Pagination.vue';
import { Head } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';

const IsOpenAddNewProduct = ref(false);

// Produit sélectionné (ou nouveau produit)
const selectedProduct = ref(null);

const AddNewProduct = () => {
    selectedProduct.value = { // Produit vide par défaut
        name: '',
        category_id: '',
        stock: 0,
        minimum_stock: 0,
        description: '',
        image: null,
    };
    IsOpenAddNewProduct.value = true;
};

const closeModal = () => {
    IsOpenAddNewProduct.value = false;
};

defineProps({
    products: Object,
    categories: Object,
})

</script>

<template>

    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Products
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6 w-full" >
                    <Search @NewProduct="AddNewProduct" />
                </div>
                <div class="overflow-hidden">
                    <div class="p-6 text-gray-900">
                        <div class="grid sm:grid-cols-3 lg:grid-cols-4 gap-6">
                            <ProductCard v-for="product in products.data" :key="product.id" :product="product" :categories="categories"/>
                        </div>
                        <Pagination :pagination="products" />

                        <Modal :show="IsOpenAddNewProduct" @close="closeModal">
                            <ProductForm :categories="categories" :product="selectedProduct"  @close="closeModal"/>
                        </Modal>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
