<script setup>
import CustomerForm from '@/Components/Customer/CustomerForm.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    customer: Object, // Receives existing customer details for editing
});


</script>

<template>

    <Head title="Customers" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Customers
            </h2>
        </template>
        <CustomerForm :customer="customer" />
    </AuthenticatedLayout>

</template>
