<script setup>
import { useForm, Link, Head } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NotFoundWorks from '@/Components/UI/NotFoundWorks.vue';
import Works from '@/Components/Customer/works.vue';
import CustomerHeader from '@/Components/CustomerHeader.vue';

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
        filterForm.get(route('customer.show', props.customer.id), {
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
    if (status === 'completed') {
        buttonViewAll.value = false;
        buttonCompleted.value = !buttonCompleted.value;
        filterForm.status = buttonCompleted.value ? 1 : 0; // Définir le statut à filtrer
    } else if (status === 'viewAll') {
        buttonViewAll.value = !buttonViewAll.value;
        buttonCompleted.value = false;
        buttonmonth.value = false;
        filterForm.status = "";
        filterForm.month = "";
        filterForm.name = "";
    }
    else if (status === 'month') {
        if (filterForm.month === new Date().getMonth() + 1) {
            buttonViewAll.value = false;
            filterForm.month = "";
            buttonmonth.value = false;
        } else {
            buttonmonth.value = true;
            buttonViewAll.value = false;
            const currentMonth = new Date().getMonth() + 1; // Get current month (0-11, so add 1)
            filterForm.month = currentMonth;
        }
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
        <CustomerHeader :customer="customer" :work="works" :tab="customer.name" />
        <div class="flex flex-row gap7 max-w-7xl mx-auto pt-6">
            <section class="container px-4 mx-auto">
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

                            <button @click="applyFilter('month')" :class="buttonmonth ? ActiveButton : InActiveButton">
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

                            <input type="text" placeholder="Search" v-model="filterForm.name"
                                @input="filterForm.name.length > 3 ? autoFilter() : null"
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
