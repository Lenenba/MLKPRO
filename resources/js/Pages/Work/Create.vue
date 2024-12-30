<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';


const props = defineProps({
    customer: Object,
});

// Initialize the form
const form = useForm({
    type:  '',
    location:  '',
    work_date: '',
    is_completed: false,
    time_spent: '',
    cost: '',
    description: '',
    customer_id: props.customer.id,
});

const submit = () => {
form.is_completed = form.is_completed ? 1 : 0;
form.post(route('work.store'), {
    onSuccess: () => {
        console.log('Work saved successfully!');
    },
    onError: (errors) => {
        console.error('Validation errors:', errors);
    },
});
};
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
        <div class="max-w-5xl mx-auto mt-8 bg-white shadow-md rounded-md p-6">
            <div class="container mt-6 w-full">
                <form @submit.prevent="submit">
                    <!-- Work Type, Location, and Work Date -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Work Type -->
                        <div>
                            <InputLabel for="type" value="Type" />
                            <TextInput id="type" type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                v-model="form.type" required />
                            <InputError class="mt-2" :message="form.errors.type" />
                        </div>

                        <!-- Location -->
                        <div>
                            <InputLabel for="location" value="Location" />
                            <TextInput id="location" type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                v-model="form.location" required />
                            <InputError class="mt-2" :message="form.errors.location" />
                        </div>
                        <!-- Cost -->
                        <div>
                            <InputLabel for="cost" value="Cost" />
                            <TextInput id="cost" type="number"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                v-model="form.cost" step="0.01" required />
                            <InputError class="mt-2" :message="form.errors.cost" />
                        </div>

                    </div>

                    <!-- Is Completed, Time Spent, and Cost -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">

                        <!-- Work Date -->
                        <div>
                            <InputLabel for="work_date" value="Work Date" />
                            <TextInput id="work_date" type="date"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                v-model="form.work_date" required />
                            <InputError class="mt-2" :message="form.errors.work_date" />
                            <input type="hidden" v-model="form.customer_id"/>
                        </div>

                        <!-- Time Spent -->
                        <div>
                            <InputLabel for="time_spent" value="Time Spent" />
                            <TextInput id="time_spent" type="number"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                v-model="form.time_spent" step="1" required max="48"/>
                            <InputError class="mt-2" :message="form.errors.time_spent" />
                        </div>

                        <!-- Is Completed -->
                        <div>
                            <InputLabel for="is_completed" value="Is Completed" />
                            <div class="flex items-center mt-2">
                                <button type="button" @click="form.is_completed = !form.is_completed" :class="{
                                    'bg-green-500': form.is_completed,
                                    'bg-gray-300': !form.is_completed
                                }"
                                    class="relative inline-flex items-center h-6 rounded-full w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <span :class="{
                                        'translate-x-6': form.is_completed,
                                        'translate-x-1': !form.is_completed
                                    }"
                                        class="inline-block w-4 h-4 transform bg-white rounded-full transition-transform"></span>
                                </button>
                            </div>
                            <InputError class="mt-2" :message="form.errors.is_completed" />
                        </div>

                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div class="col-span-3 flex flex-col justify-end">
                            <InputLabel for="description" value="Description" />
                            <TextAreaInput id="description" type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                v-model="form.description" required></TextAreaInput>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div class="col-span-3 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Create Work
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
