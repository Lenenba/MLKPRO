<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import CustomerHeader from '@/Components/CustomerHeader.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';


const IsOpenCustomerDeleteModal = ref(false);

const handleDelete = () => {
    IsOpenCustomerDeleteModal.value = true;
};

const props = defineProps({
    customer: Object,
    work: Object,
    products: Object,
    filters: Object,
    categories: Object,
});

const cutText = (text, length) => {
    return text.length > length ? text.substring(0, length) + '...' : text;
};

const form = useForm({
    product_id: '',
    quantity_used: 1,
    unit: 'kg',
    work_id: props.work.id,
});
const addProduct = (productId) => {
    form.product_id = productId;
    form.post(route('work.product.store'), {
        onSuccess: () => {
            console.log('Work saved successfully!');
        },
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
    });
};


const buttonCompleted = ref(false);
const buttonViewAll = ref(false);
const buttonmonth = ref(false);

const ActiveButton = 'px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 bg-gray-100 sm:text-sm dark:bg-gray-800 dark:text-gray-300'
const InActiveButton = 'px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100'

const filterForm = useForm({
    name: props.filters.name || "",
});

// Fonction de filtrage avec un délai pour éviter des appels excessifs
let filterTimeout;
const autoFilter = () => {
    if (filterTimeout) {
        clearTimeout(filterTimeout);
    }
    filterTimeout = setTimeout(() => {
        filterForm.get(route('work.edit', props.work.id), {
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
const findCategory = (categoryId) => {
    const category = props.categories.find((category) => category.id === categoryId);
    return category.name;
}

</script>

<template>

    <Head title="Works" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Add product to work
            </h2>
        </template>

        <CustomerHeader :customer="customer" :work="work" />

        <div v-if="work.products.length > 0" class="flex flex-row gap-7 max-w-7xl mx-auto pt-6">
            <section class="container px-4 mx-auto">
                <div class="flex flex-col mt-4">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th scope="col"
                                                class="py-2.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                <span>Product</span>
                                            </th>
                                            <th scope="col"
                                                class="px-12 py-2.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                Category
                                            </th>
                                            <th scope="col"
                                                class="px-12 py-2.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                Stock
                                            </th>

                                            <th scope="col"
                                                class="px-4 py-2.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                Description
                                            </th>

                                            <th scope="col" class="relative py-2.5 px-4">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                        <tr v-for="product in work.products" :key="product.id" :value="product.id">
                                            <td class="px-4 py-2 text-sm font-medium whitespace-nowrap">
                                                <div>
                                                    <h2 class="font-medium text-gray-800 dark:text-white ">{{
                                                        product.name }}
                                                    </h2>
                                                </div>
                                            </td>
                                            <td class="px-12 py-2 text-sm font-medium whitespace-nowrap">
                                                <p class="text-gray-500 dark:text-gray-400">
                                                    {{ findCategory(product.category_id) }}
                                                </p>
                                            </td>
                                            <td class="px-12 py-2 text-sm font-medium whitespace-nowrap">
                                                <div
                                                    class="inline px-3 py-1 text-sm font-normal rounded-full text-emerald-500 gap-x-2 bg-emerald-100/60 dark:bg-gray-800">
                                                    {{ product.stock }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-2 text-sm whitespace-nowrap">
                                                <div>
                                                    <p class="text-gray-500 dark:text-gray-400">{{
                                                        cutText(product.description,
                                                            30) }}</p>
                                                </div>
                                            </td>

                                            <td class="px-4 py-2 text-sm whitespace-nowrap">
                                                <button @click="handleDelete"
                                                    class="flex items-center gap-2 px-4 py-2 text-xs font-semibold text-red-500 hover:bg-red-500/10 rounded-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" class="h-4 w-4">
                                                        <path fill-rule="evenodd"
                                                            d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="flex flex-row gap-7 max-w-7xl mx-auto pt-4">
            <section class="container px-4 mx-auto">
                <div class="mt-6 md:flex md:items-center md:justify-between">
                    <div
                        class="inline-flex overflow-hidden bg-white border divide-x rounded-lg dark:bg-gray-900 rtl:flex-row-reverse dark:border-gray-700 dark:divide-gray-700">
                        <button
                            class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 bg-gray-100 sm:text-sm dark:bg-gray-800 dark:text-gray-300">
                            View all
                        </button>

                        <button
                            class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                            Monitored
                        </button>

                        <button
                            class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                            Unmonitored
                        </button>
                    </div>

                    <div class="relative flex items-center mt-4 md:mt-0">
                        <span class="absolute">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </span>
                        <form @submit.prevent="autoFilter">
                            <input type="text" placeholder="Search" v-model="filterForm.name"
                                @input="filterForm.name.length > 3 ? autoFilter() : null"
                                class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
                        </form>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <div v-for="product in products.data" :key="product.id" :value="product.id">
                        <div class="flex flex-col mt-8 items-center justify-center w-full max-w-sm mx-auto">
                            <img class="w-full h-64 bg-gray-300 bg-center bg-cover rounded-lg shadow-md"
                                :src="product.filename" />

                            <div
                                class="w-56 -mt-10 overflow-hidden bg-white rounded-lg shadow-lg md:w-64 dark:bg-gray-800">
                                <div class="flex flex-col items-center justify-between p-2 md:p-1">
                                    <h3
                                        class="font-bold text-xs tracking-wide text-center text-gray-800 uppercase dark:text-white">
                                        {{ product.name }}
                                    </h3>
                                    <h3
                                        class="font-bold text-xs tracking-wide text-center text-gray-800 uppercase dark:text-white">
                                        {{ product.category.name }}
                                    </h3>
                                </div>

                                <div class="flex items-baseline justify-between px-3 py-2 bg-gray-200 dark:bg-gray-700">
                                    <!-- Price Display -->
                                    <span class="font-bold text-xs text-gray-800 dark:text-gray-200 mr-3">
                                        $129
                                    </span>

                                    <!-- quantity_used Input -->
                                    <div class="flex flex-col">
                                        <input id="quantity_used" type="number"
                                            class="mt-1 block w-10 px-2 py-1 text-xs border rounded-md shadow-sm focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-800 dark:border-gray-600 dark:focus:ring-gray-400 dark:focus:border-gray-400"
                                            v-model.number="form.quantity_used" required />
                                        <p v-if="form.errors.quantity_used"
                                            class="mt-1 text-xs text-red-600 dark:text-red-400">
                                            {{ form.errors.quantity_used }}
                                        </p>
                                    </div>
                                    <button @click="addProduct(product.id)"
                                        class="px-2 py-1 text-xs font-semibold text-white uppercase transition-colors duration-300 transform bg-gray-800 rounded hover:bg-gray-700 dark:hover:bg-gray-600 focus:ring focus:ring-gray-500 focus:outline-none">
                                        Add product
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </AuthenticatedLayout>
</template>
