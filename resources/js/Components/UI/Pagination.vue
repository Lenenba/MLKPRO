<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    pagination: Object,
})
</script>


<template>
    <div class="mt-6 flex justify-between">
        <Link preserve-scroll :href="pagination.prev_page_url ?? ''"
            class="flex items-center justify-center px-3 py-2 text-sm rounded-lg text-gray-600"
            :class="{ 'bg-gray-200': pagination.prev_page_url, '!text-gray-300': !pagination.prev_page_url }">

        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                clip-rule="evenodd" />
        </svg>
        </Link>
        <Link preserve-scroll :href="pagination.next_page_url ?? ''"
            class="flex items-center justify-center px-3 py-2 text-sm rounded-lg text-gray-600"
            :class="{ 'bg-gray-200': pagination.next_page_url, '!text-gray-300': !pagination.next_page_url }">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        </Link>
    </div>
</template>
