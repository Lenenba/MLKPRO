<script setup>
import { ref } from 'vue';
defineProps({
    customer: {
        type: Object,
        required: true
    }
});
const tabs = ref(['Works', 'Billing', 'Settings']);
const activeTab = ref('Works');

const setActiveTab = (tab) => {
    activeTab.value = tab;
};
</script>

<template>
    <div class="flex flex-col md:flex-row items-center justify-between mx-auto space-y-4 md:space-y-0 mt-4">
        <!-- Profile Image and Name -->
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
        <div class="w-full md:w-auto mt-4 md:mt-0">
            <div class="w-full  bg-gray-100 p-2 rounded-lg shadow-sm">
                <ul class="flex space-x-4 justify-center">
                    <li v-for="tab in tabs" :key="tab" @click="setActiveTab(tab)"
                        class="py-2 px-4 text-xs font-medium cursor-pointer rounded-lg" :class="{
                            'bg-white text-gray-800 shadow-sm': tab === activeTab,
                            'text-gray-600 hover:bg-gray-200': tab !== activeTab
                        }">
                        {{ tab }}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="mt-6 w-full bg-white p-6 rounded-lg  ">
        <!-- Works Tab -->
        <div v-if="activeTab === 'Works'">
            <div v-if="customer.works.length === 0" class="flex flex-col items-center justify-center h-64">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                    class="h-20 w-20 mx-auto">
                    <path fill-rule="evenodd"
                        d="M11.828 2.25c-.916 0-1.699.663-1.85 1.567l-.091.549a.798.798 0 01-.517.608 7.45 7.45 0 00-.478.198.798.798 0 01-.796-.064l-.453-.324a1.875 1.875 0 00-2.416.2l-.243.243a1.875 1.875 0 00-.2 2.416l.324.453a.798.798 0 01.064.796 7.448 7.448 0 00-.198.478.798.798 0 01-.608.517l-.55.092a1.875 1.875 0 00-1.566 1.849v.344c0 .916.663 1.699 1.567 1.85l.549.091c.281.047.508.25.608.517.06.162.127.321.198.478a.798.798 0 01-.064.796l-.324.453a1.875 1.875 0 00.2 2.416l.243.243c.648.648 1.67.733 2.416.2l.453-.324a.798.798 0 01.796-.064c.157.071.316.137.478.198.267.1.47.327.517.608l.092.55c.15.903.932 1.566 1.849 1.566h.344c.916 0 1.699-.663 1.85-1.567l.091-.549a.798.798 0 01.517-.608 7.52 7.52 0 00.478-.198.798.798 0 01.796.064l.453.324a1.875 1.875 0 002.416-.2l.243-.243c.648-.648.733-1.67.2-2.416l-.324-.453a.798.798 0 01-.064-.796c.071-.157.137-.316.198-.478.1-.267.327-.47.608-.517l.55-.091a1.875 1.875 0 001.566-1.85v-.344c0-.916-.663-1.699-1.567-1.85l-.549-.091a.798.798 0 01-.608-.517 7.507 7.507 0 00-.198-.478.798.798 0 01.064-.796l.324-.453a1.875 1.875 0 00-.2-2.416l-.243-.243a1.875 1.875 0 00-2.416-.2l-.453.324a.798.798 0 01-.796.064 7.462 7.462 0 00-.478-.198.798.798 0 01-.517-.608l-.091-.55a1.875 1.875 0 00-1.85-1.566h-.344zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"
                        clip-rule="evenodd"></path>
                </svg>
                <h2 class="text-lg font-bold text-gray-700">No works available</h2>
                <p class="text-sm text-gray-500">This customer has no works assigned. Services will appear here when
                    added.</p>
            </div>
            <div v-else class="flex flex-col">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 px-4 text-xs font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                            Description
                                        </th>
                                        <th scope="col"
                                            class="px-12 py-3.5 text-xs font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                            Status
                                        </th>
                                        <th scope="col" class="relative py-3.5 px-4">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                    <tr v-for="work in customer.works" :key="work.id" :customer="work">
                                        <td class="px-4 py-4 text-xs font-medium text-gray-700 whitespace-nowrap">
                                            {{ work.description.length > 50 ? work.description.slice(0, 50) + '...' :
                                            work.description }}
                                        </td>
                                        <td class="px-12 py-4 text-xs font-medium text-gray-700 whitespace-nowrap">
                                            <div :class="[
                                                'inline-flex items-center px-3 py-1 rounded-full gap-x-2',
                                                work.is_completed ? 'bg-emerald-100/60 dark:bg-gray-800' : 'bg-yellow-100/60 dark:bg-gray-800'
                                            ]">
                                                <span :class="[
                                                    'h-1.5 w-1.5 rounded-full',
                                                    work.is_completed ? 'bg-emerald-500' : 'bg-yellow-500'
                                                ]">
                                                </span>
                                                <h2 :class="[
                                                    'text-xs font-normal',
                                                    work.is_completed ? 'text-emerald-500' : 'text-yellow-500'
                                                ]">
                                                    {{ work.is_completed ? 'Completed' : 'In Progress' }}
                                                </h2>
                                            </div>
                                        </td>

                                        <td class="px-4 py-4 text-xs whitespace-nowrap">
                                            <div class="flex items-center gap-x-6">
                                                <button
                                                    class="text-gray-500 transition-colors duration-200 dark:hover:text-red-500 dark:text-gray-300 hover:text-red-500 focus:outline-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                                <button
                                                    class="text-gray-500 transition-colors duration-200 dark:hover:text-yellow-500 dark:text-gray-300 hover:text-yellow-500 focus:outline-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <a href="#"
                        class="flex items-center px-5 py-2 text-xs text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                        </svg>

                        <span>
                            previous
                        </span>
                    </a>

                    <div class="items-center hidden lg:flex gap-x-3">
                        <a href="#"
                            class="px-2 py-1 text-xs text-blue-500 rounded-md dark:bg-gray-800 bg-blue-100/60">1</a>
                        <a href="#"
                            class="px-2 py-1 text-xs text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">2</a>
                        <a href="#"
                            class="px-2 py-1 text-xs text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">3</a>
                        <a href="#"
                            class="px-2 py-1 text-xs text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">...</a>
                        <a href="#"
                            class="px-2 py-1 text-xs text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">12</a>
                        <a href="#"
                            class="px-2 py-1 text-xs text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">13</a>
                        <a href="#"
                            class="px-2 py-1 text-xs text-gray-500 rounded-md dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">14</a>
                    </div>

                    <a href="#"
                        class="flex items-center px-5 py-2 text-xs text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800">
                        <span>
                            Next
                        </span>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        <!-- Billing Tab -->
        <div v-if="activeTab === 'Billing'">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Billing</h2>
            <p>Billing content goes here...</p>
        </div>

        <!-- Settings Tab -->
        <div v-if="activeTab === 'Settings'">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Settings</h2>
            <p>Settings content goes here...</p>
        </div>
    </div>
</template>
