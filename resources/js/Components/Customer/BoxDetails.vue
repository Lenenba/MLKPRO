<script setup>
import Tab from '@/Components/UI/Tab.vue';

const handleEdit = () => {
    IsOpenProductModal.value = true;
};

const handleDelete = () => {
    IsOpenProductDeleteModal.value = true;
};
defineProps({
    customer: {
        type: Object,
        required: true
    }
});

const getCustomerImage = (customer) => {
    if (!customer.header_image) return '/storage/customers/corporateHeader.webp'; // Image par défaut si aucune n'est fournie
    return customer.header_image.startsWith('http') ? customer.header_image : `/storage/${customer.header_image}`;
};
</script>

<template>
    <!-- Main Profile Section -->
    <div v-if="customer.name"
        class="w-full p-3 md:w-4/6 ml-4 bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
        <!-- Header Image -->
        <div class="h-28 rounded-lg overflow-hidden">
            <img :src="getCustomerImage(customer)" alt="Profile Background" class="w-full h-full object-cover" />
        </div>

        <div class="w-full md:w-auto mt-4 md:mt-0">
            <Tab :customer="customer"/>
        </div>

    </div>
</template>
