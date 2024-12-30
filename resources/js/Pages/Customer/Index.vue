<script setup>
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Box from '@/Components/Customer/Box2.vue';
import Pagination from '@/Components/UI/Pagination.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    customers: {
        type: Object,
        required: true
    },
    filters: {
        type: Object,
        required: true
    }
})

const filterForm = useForm({
    company_name: props.filters.company_name ?? "",
});

// Fonction de filtrage avec un délai pour éviter des appels excessifs
let filterTimeout;
const autoFilter = () => {
    if (filterTimeout) {
        clearTimeout(filterTimeout);
    }
    filterTimeout = setTimeout(() => {
        filterForm.get(route('customer.index'), {
            preserveState: true,
            preserveScroll: true,
        });
    }, 300); // Délai de 300ms pour éviter les appels excessifs
};

const clear = () => {
    filterForm.company_name = null
    autoFilter()

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


        <div class="py-12 max-w-7xl mx-auto">
            <form @submit.prevent="autoFilter">
                <div class="p-6 bg-white border border-gray-200 rounded-lg mx-auto">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-gray-800">Customer Search</h2>
                    </div>

                    <!-- Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                        <div class="col-span-3">
                            <InputLabel for="company_name" value="Company name" />
                            <TextInput id="company_name" type="text" class="mt-1 block w-full" v-model="filterForm.company_name"
                                @input="filterForm.company_name.length > 3 ? autoFilter() : null" />
                            <InputError class="mt-2" :message="filterForm.errors.company_name" />
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
                        <Link :href="route('customer.create')">
                            <button type="button"
                                class="py-2 px-6 text-sm font-medium text-white bg-gray-800 rounded-lg hover:bg-gray-600">
                                Add New Customer
                            </button>
                        </Link>
                    </div>
                </div>
            </form>
            <div class="flex flex-row gap7 pt-6">
                <Box v-for="customer in customers.data" :key="customer.id" :customer="customer"/>
            </div>
            <Pagination :pagination="customers" />
        </div>
    </AuthenticatedLayout>
</template>
