<script setup>
import { useForm, Link, Head } from '@inertiajs/vue3';
import { defineProps, ref, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NotFoundWorks from '@/Components/UI/NotFoundWorks.vue';
import Works from '@/Components/Customer/works.vue';

const buttonCompleted = ref(false);
const buttonViewAll = ref(false);
const buttonmonth = ref(false);

const ActiveButton = 'px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 bg-gray-100 sm:text-sm dark:bg-gray-800 dark:text-gray-300'
const InActiveButton = 'px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100'
const props = defineProps({
    customer: Object,
    works: Object,
    filters: Object,
});

const filterForm = useForm({
    name: props.filters.name || "",
    status: props.filters.status || "",
    month: props.filters.month || "",
});

// Fonction de filtrage avec un délai pour éviter des appels excessifs
let filterTimeout;
const autoFilter = () => {
    if (filterTimeout) {
        clearTimeout(filterTimeout);
    }
    filterTimeout = setTimeout(() => {
        filterForm.get(route('customer.show',props.customer.id), {
            preserveState: true,
            preserveScroll: true,
        });
    }, 300); // Délai de 300ms pour éviter les appels excessifs
};

// Réinitialiser le formulaire lorsque la recherche est vide
watch(() => filterForm.name, (newValue) => {
    if (!newValue) {
        filterForm.name = "";
        autoFilter();
    }
});

// Appliquer un filtre en fonction d'un bouton (par exemple, Completed)
const applyFilter = (status) => {
    if(status === 'completed') {
        buttonViewAll.value = false;
        buttonCompleted.value = !buttonCompleted.value;
        filterForm.status = buttonCompleted.value ? 1 : 0; // Définir le statut à filtrer
    }else if(status === 'viewAll') {
        buttonViewAll.value = !buttonViewAll.value;
        buttonCompleted.value = false;
        buttonmonth.value = false;
        filterForm.status = "";
        filterForm.month = "";
        filterForm.name = "";
    }
    else if(status === 'month'){
        if(filterForm.month === new Date().getMonth() + 1) {
            buttonViewAll.value = false;
            filterForm.month = "";
            buttonmonth.value = false;
        } else {
        buttonmonth.value = true;
        buttonViewAll.value = false;
        const currentMonth = new Date().getMonth() + 1; // Get current month (0-11, so add 1)
        filterForm.month = currentMonth; }
    }
    autoFilter();
};

</script>

<template>

    <Head title="Works" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Customer Works
            </h2>
        </template>
        <div class="flex flex-row gap7 max-w-7xl mx-auto pt-6">
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
                                works.data.length }}
                                works</span>
                        </div>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">These companies have purchased in the
                            last 12
                            months.</p>
                    </div>

                    <div class="flex items-center mt-4 gap-x-3">
                        <button
                            class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_3098_154395)">
                                    <path
                                        d="M13.3333 13.3332L9.99997 9.9999M9.99997 9.9999L6.66663 13.3332M9.99997 9.9999V17.4999M16.9916 15.3249C17.8044 14.8818 18.4465 14.1806 18.8165 13.3321C19.1866 12.4835 19.2635 11.5359 19.0351 10.6388C18.8068 9.7417 18.2862 8.94616 17.5555 8.37778C16.8248 7.80939 15.9257 7.50052 15 7.4999H13.95C13.6977 6.52427 13.2276 5.61852 12.5749 4.85073C11.9222 4.08295 11.104 3.47311 10.1817 3.06708C9.25943 2.66104 8.25709 2.46937 7.25006 2.50647C6.24304 2.54358 5.25752 2.80849 4.36761 3.28129C3.47771 3.7541 2.70656 4.42249 2.11215 5.23622C1.51774 6.04996 1.11554 6.98785 0.935783 7.9794C0.756025 8.97095 0.803388 9.99035 1.07431 10.961C1.34523 11.9316 1.83267 12.8281 2.49997 13.5832"
                                        stroke="currentColor" stroke-width="1.67" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_3098_154395">
                                        <rect width="20" height="20" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>

                            <span>Import</span>
                        </button>

                        <button
                            class="flex items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <Link :href="route('work.create', customer.id)">
                                <span>Add work</span>
                            </Link>
                        </button>
                    </div>
                </div>

                <form @submit.prevent="autoFilter">
                    <div class="mt-6 md:flex md:items-center md:justify-between">
                        <div
                            class="inline-flex overflow-hidden bg-white border divide-x rounded-lg dark:bg-gray-900 rtl:flex-row-reverse dark:border-gray-700 dark:divide-gray-700">
                            <button @click="applyFilter('viewAll')"
                                :class="buttonViewAll ? ActiveButton : InActiveButton">
                                View all
                            </button>

                            <button @click="applyFilter('completed')"
                                :class="buttonCompleted ? ActiveButton : InActiveButton">
                                Completed
                            </button>

                            <button @click="applyFilter('month')"
                                :class="buttonmonth ? ActiveButton : InActiveButton">
                                This month
                            </button>
                        </div>
                        <div class="relative flex items-center mt-4 md:mt-0">
                            <span class="absolute">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </span>

                            <input type="text" placeholder="Search"  v-model="filterForm.name" @input="filterForm.name.length > 3 ? autoFilter() : null"
                                class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
                        </div>
                    </div>
                </form>


                <!-- without works -->
                <div v-if="works.data.length === 0"
                    class="flex items-center mt-6 text-center border rounded-lg h-96 dark:border-gray-700">
                    <NotFoundWorks />
                </div>
                <!-- with works -->
                <div v-else>
                    <Works :works="works.data" />
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
