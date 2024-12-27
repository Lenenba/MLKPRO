<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Box from '@/Components/Customer/Box.vue';
import Pagination from '@/Components/UI/Pagination.vue';
import BoxDetails from '@/Components/Customer/BoxDetails.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    customers: {
        type: Object,
        required: true
    }
})
// Track the selected customer details
const selectedCustomer = ref(null);

const handleCustomerDetails = (customerId) => {
    const customer = props.customers.data.find((c) => c.id === customerId);
    if (customer) {
        selectedCustomer.value = customer;
    } else {
        console.error(`Customer with ID ${customerId} not found.`);
    }
};
</script>

<template>

    <Head title="Customers" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Customers
            </h2>
        </template>

        <div class="flex flex-row gap-6 max-w-6xl mx-auto pt-6">
            <!-- Sidebar Box -->
            <div class="w-full md:w-2/5">

                <div class="flex flex-col space-y-4">
                    <!-- Header -->
                    <div class="flex flex-col md:flex-row px-8 w-full">
                        <button
                            class="flex items-center gap-2 px-6 py-2 text-sm  font-medium  text-white bg-gray-800 rounded-lg hover:bg-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                                stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Add New Product
                        </button>
                    </div>
                    <Box v-for="customer in customers.data" :key="customer.id" :customer="customer"
                        @CustomerDetails="handleCustomerDetails" />
                    <Pagination :pagination="customers" />
                </div>
            </div>

            <!-- Customer Details -->
            <BoxDetails v-if="selectedCustomer" :customer="selectedCustomer" />
        </div>

    </AuthenticatedLayout>
</template>
