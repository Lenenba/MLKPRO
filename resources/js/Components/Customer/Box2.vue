<script setup>
import { Link } from '@inertiajs/vue3';


const props = defineProps({
    customer: Object,
});

const slideText = (text) => {
    return text.length > 20 ? text.substring(0, 20) + '...' : text;
};

const getCustomerImage = (customer) => {
    if (!customer.logo) return '/storage/customers/corporateHeader.webp'; // Image par défaut si aucune n'est fournie
    return customer.logo.startsWith('http') ? customer.logo : `/storage/${customer.logo}`;
};
</script>

<template>
    <section class="max-w-2xl mx-auto px-8 w-full cursor-pointer">
        <!-- Billing Cards -->
        <div class="space-y-4">

            <!-- Single Card Component -->
            <div
                class="max-w-xs mx-auto bg-gray-800 text-white rounded-lg shadow-md overflow-hidden flex flex-col ">
                <!-- Image Section -->
                <div class="relative h-40">
                    <img :src="getCustomerImage(customer)" alt="Customer Image" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                </div>

                <!-- Content Section -->
                <div class="p-6 text-center flex-grow flex flex-col justify-between">
                    <div>
                        <h2 class="text-lg font-semibold uppercase">{{ slideText(customer.name)  }}</h2>
                        <p class="text-xl font-bold mt-4">{{ slideText(customer.company_name) }}</p>
                    </div>
                </div>

                <!-- Buttons Section -->
                <div class="px-6 pb-6">
                    <Link :href="route('customer.show', customer.id)">
                        <button
                            class="w-full bg-blue-500 text-white text-sm font-medium py-2 px-4 rounded-lg hover:bg-blue-600 mb-2">
                            Works
                        </button>
                    </Link>
                    <button
                        class="w-full bg-gray-100 text-gray-800 text-sm font-medium py-2 px-4 rounded-lg hover:bg-gray-200 mb-2">
                        Invoices
                    </button>
                    <button
                        class="w-full bg-green-500 text-white text-sm font-medium py-2 px-4 rounded-lg hover:bg-green-600">
                        Settings
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>
