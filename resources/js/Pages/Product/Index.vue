<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProductCard from '@/Components/ProductCard.vue';
import { Head } from '@inertiajs/vue3';
defineProps({
    products: Object,
    categories: Object
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
                <div class="overflow-hidden">
                    <div class="p-6 text-gray-900">
                        <ProductCard :products="products" :categories="categories"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
