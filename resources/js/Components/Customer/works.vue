<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    works: Array,
});

const cutText = (text, length) => {
    return text.length > length ? text.substring(0, length) + '...' : text;
};

const formatTime = (timeSpent) => {
    const hours = Math.floor(timeSpent / 60);
    const minutes = timeSpent % 60;
    return `${hours}h ${minutes}min`;
}

const Ratings = (ratings) => {
    const totalPossibleRatings = 3; // Assuming a max rating of 5 for each work
    const totalRatings = ratings.reduce((acc, rating) => acc + rating.rating, 0);
    const averageRating = Math.round(totalRatings / ratings.length);
    return `${averageRating}/${totalPossibleRatings}`;
}

</script>


<template>
    <div class="flex flex-col mt-6">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th scope="col"
                                    class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <button class="flex items-center gap-x-3 focus:outline-none">
                                        <span>Work name</span>

                                        <svg class="h-3" viewBox="0 0 10 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z"
                                                fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                            <path
                                                d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z"
                                                fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                            <path
                                                d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z"
                                                fill="currentColor" stroke="currentColor" stroke-width="0.3" />
                                        </svg>
                                    </button>
                                </th>

                                <th scope="col"
                                    class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Status
                                </th>

                                <th scope="col"
                                    class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Description
                                </th>

                                <th scope="col"
                                    class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Products</th>

                                <th scope="col"
                                    class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Ratings</th>

                                <th scope="col" class="relative py-3.5 px-4">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                            <tr v-for="work in works" :key="work.id" :work="work">
                                <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                    <div>
                                        <h2 class="font-medium text-gray-800 dark:text-white ">{{ work.type }}
                                        </h2>
                                        <p class="text-sm font-normal text-gray-600 dark:text-gray-400">
                                            Time spent: {{ formatTime(work.time_spent) }}</p>
                                    </div>
                                </td>
                                <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
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
                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                    <div>
                                        <h4 class="text-gray-700 dark:text-gray-200">{{ cutText(work.description, 30) }}
                                        </h4>
                                        <p class="text-gray-500 dark:text-gray-400"> {{ work.work_date }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                    <div v-if="work.products.length === 0" class="flex items-center">
                                        <p
                                            class="flex items-center justify-center w-6 h-6 -mx-1 text-xs text-blue-600 bg-blue-100 border-2 border-white rounded-full">
                                            0</p>
                                    </div>
                                    <div v-else class="flex items-center">
                                        <img v-for="product in work.products" :key="product.id" :work="product"
                                            class="object-cover w-8 h-8 -mx-1 border-2 border-white rounded-full dark:border-gray-700 shrink-0"
                                            :src="product.filename" alt="">
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                    <div v-if="work.ratings.length > 0"
                                        class="w-48 h-1.5 bg-blue-200 overflow-hidden rounded-full">
                                        <div :class="`bg-blue-500 h-1.5 w-${Ratings(work.ratings)}`"></div>
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                    <Link :href="`/work/edit/${work.id}`">
                                        <div
                                            class="flex overflow-hidden divide-x rounded-lg rtl:flex-row-reverse dark:bg-gray-900 dark:border-gray-700 dark:divide-gray-700">
                                            <button
                                                class="border border-white rounded-lg px-4 py-2 font-medium text-gray-600 transition-colors duration-200 sm:px-6 dark:hover:bg-gray-800 dark:text-gray-300 hover:bg-gray-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
