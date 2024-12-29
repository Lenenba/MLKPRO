<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';


const props = defineProps({
    customer: Object,
});

// Initialize the form
const form = useForm({
    name: props.product?.name || '',
});

</script>

<template>

    <Head title="Works" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Create a work
            </h2>
        </template>

        <div class="flex flex-row gap7 max-w-7xl mx-auto pt-6">
            <div class="flex flex-col">
                <section class="container px-4 mx-auto">
                    <div class="sm:flex sm:items-center sm:justify-between">
                        <div>
                            <div class="flex items-center gap-x-3">
                                <div class="flex items-center">
                                    <div class="w-16 h-16 rounded-lg shadow-md overflow-hidden">
                                        <img :src="customer.logo || 'https://via.placeholder.com/150'" alt="Profile"
                                            class="w-full h-full object-cover" />
                                    </div>
                                    <div class="ml-4 text-left">
                                        <h2 class="text-xs font-bold text-gray-800">
                                            {{ customer.company_name || 'Unknown User' }}
                                        </h2>
                                        <p class="text-xs text-gray-600">
                                            {{ customer.name || 'Role not specified' }}
                                        </p>
                                    </div>
                                </div>

                                <span
                                    class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{
                                        customer.works.length }}
                                    works</span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="max-w-6xl mx-auto mt-8 bg-white shadow-md rounded-md p-6">
            <div class="container px-4 mx-auto mt-6">
                <form @submit.prevent="submit" >
                    <!-- Product Name -->
                    <div class="max-w-lg">
                        <InputLabel for="name" value="Product Name" />
                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
