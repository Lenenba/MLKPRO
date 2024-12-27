<script setup>
defineProps({
    customer: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <!-- Main Profile Section -->
    <div class="w-full md:w-3/5 bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
        <!-- Header Image -->
        <div class="h-48">
            <img src="storage/customers/corporateHeader.webp" alt="Profile Background"
                class="w-full h-full object-cover" />
        </div>

        <!-- Profile Information -->
        <div class="relative -mt-12 flex flex-col items-center">
            <!-- Profile Image -->
            <div class="w-24 h-24 rounded-full border-4 border-white shadow-md overflow-hidden">
                <img :src="customer.logo || 'https://via.placeholder.com/150'" alt="Profile" class="w-full h-full object-cover" />
            </div>

            <!-- Name and Role -->
            <div class="mt-4 text-center">
                <h2 class="text-xl font-bold text-gray-800">{{ customer.compagny_name || 'Unknown User' }}</h2>
                <p class="text-sm text-gray-600">{{ customer.name || 'Role not specified' }}</p>
            </div>
        </div>

        <!-- Stats and Navigation -->
        <div class="mt-6 px-6 pb-6">
            <div class="flex justify-between md:justify-center md:space-x-12 mb-6">
                <div class="text-center">
                    <p class="text-lg font-bold text-gray-800">{{ customer.projectsCompleted || 0 }}+</p>
                    <p class="text-sm text-gray-600">Projects Completed</p>
                </div>
                <div class="text-center">
                    <p class="text-lg font-bold text-gray-800">{{ customer.appsDesigned || 0 }}+</p>
                    <p class="text-sm text-gray-600">Apps Designed</p>
                </div>
                <div class="text-center">
                    <p class="text-lg font-bold text-gray-800">{{ customer.workshops || 0 }}+</p>
                    <p class="text-sm text-gray-600">Workshops</p>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="border-t border-gray-200 pt-4">
                <ul class="flex justify-center space-x-8 text-sm font-medium text-gray-600">
                    <li class="border-b-2 border-gray-800 text-gray-800 cursor-pointer">General</li>
                    <li class="cursor-pointer hover:text-gray-800">Billing</li>
                    <li class="cursor-pointer hover:text-gray-800">Invoices</li>
                    <li class="cursor-pointer hover:text-gray-800">Settings</li>
                </ul>
            </div>
        </div>
    </div>
</template>
