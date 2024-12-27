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
        Previous
        </Link>
        <Link preserve-scroll :href="pagination.next_page_url ?? ''"
            class="flex items-center justify-center px-3 py-2 text-sm rounded-lg text-gray-600"
            :class="{ 'bg-gray-200': pagination.next_page_url, '!text-gray-300': !pagination.next_page_url }">
        Next
        </Link>
    </div>
</template>
