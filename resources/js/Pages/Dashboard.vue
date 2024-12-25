<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Statistics from '@/Components/Statistics.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                            <!-- Grid -->
                            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                                <Statistics />
                                <Statistics />
                                <Statistics />
                                <Statistics />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
