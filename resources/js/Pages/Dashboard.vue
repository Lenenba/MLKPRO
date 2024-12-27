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
                <div class="overflow-hiddenm ">
                    <div class="p-6 text-gray-900">
                        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                            <!-- Grid -->
                            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                                <Statistics />
                                <Statistics />
                                <Statistics />
                                <Statistics />
                            </div>
                            <!-- Card -->
                            <div
                                class="p-4 md:p-5 sm:my-6 lg:my-8 min-h-[410px] flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                                <!-- Header -->
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h2 class="text-sm text-gray-500 dark:text-neutral-500">
                                            Visitors
                                        </h2>
                                        <p class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                            80.3k
                                        </p>
                                    </div>

                                    <div>
                                        <span
                                            class="py-[5px] px-1.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-md bg-red-100 text-red-800 dark:bg-red-500/10 dark:text-red-500">
                                            <svg class="inline-block size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M12 5v14" />
                                                <path d="m19 12-7 7-7-7" />
                                            </svg>
                                            2%
                                        </span>
                                    </div>
                                </div>
                                <!-- End Header -->

                                <div id="hs-single-area-chart"></div>
                            </div>
                            <!-- End Card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
