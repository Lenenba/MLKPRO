<script setup>
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import CustomerForm from '@/Components/Customer/CustomerForm.vue';

const emit = defineEmits(['CustomerDetails']);
const IsOpenCustomerModal = ref(false);
const IsOpenCustomerDeleteModal = ref(false);

const handleEdit = () => {
    IsOpenCustomerModal.value = true;
};

const handleDelete = () => {
    IsOpenCustomerDeleteModal.value = true;
};

const closeModal = () => {
    IsOpenCustomerModal.value = false;
    IsOpenCustomerDeleteModal.value = false;
};


defineProps({
    customer: Object,
});
</script>

<template>
    <section class="max-w-2xl mx-auto px-8 w-full cursor-pointer" @click="emit('CustomerDetails', customer.id)">
        <!-- Billing Cards -->
        <div class="space-y-4">
            <!-- Single Card Component -->
            <div class="flex flex-col bg-white rounded-lg border border-gray-300 shadow-md hover:shadow-lg transition-shadow p-4">
                <div class="flex items-start justify-between mb-4">
                    <!-- Icon and Info -->
                    <div class="flex items-center gap-3">
                        <div class="border border-gray-200 p-2.5 rounded-lg bg-gray-50">
                            <img v-if="customer.logo" :src="customer.logo" alt="Customer Logo" class="h-6 w-6 rounded object-cover">
                            <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="h-6 w-6 text-gray-900">
                                <path fill-rule="evenodd"
                                    d="M7.5 5.25a3 3 0 013-3h3a3 3 0 013 3v.205c.933.085 1.857.197 2.774.334 1.454.218 2.476 1.483 2.476 2.917v3.033c0 1.211-.734 2.352-1.936 2.752A24.726 24.726 0 0112 15.75c-2.73 0-5.357-.442-7.814-1.259-1.202-.4-1.936-1.541-1.936-2.752V8.706c0-1.434 1.022-2.7 2.476-2.917A48.814 48.814 0 017.5 5.455V5.25zm7.5 0v.09a49.488 49.488 0 00-6 0v-.09a1.5 1.5 0 011.5-1.5h3a1.5 1.5 0 011.5 1.5zm-3 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                    clip-rule="evenodd" />
                                <path
                                    d="M3 18.4v-2.796a4.3 4.3 0 00.713.31A26.226 26.226 0 0012 17.25c2.892 0 5.68-.468 8.287-1.335.252-.084.49-.189.713-.311V18.4c0 1.452-1.047 2.728-2.523 2.923-2.12.282-4.282.427-6.477.427a49.19 49.19 0 01-6.477-.427C4.047 21.128 3 19.852 3 18.4z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-blue-gray-900">{{ customer.company_name }}</p>
                            <p class="text-xs text-gray-600">Company</p>
                        </div>
                    </div>
                    <!-- Actions -->
                    <div class="flex gap-2">
                        <button @click="handleEdit"
                            class="flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-100 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="h-4 w-4">
                                <path
                                    d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                            </svg>
                            Edit
                        </button>
                        <button @click="handleDelete"
                            class="flex items-center gap-2 px-4 py-2 text-xs font-semibold text-red-500 hover:bg-red-500/10 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="h-4 w-4">
                                <path fill-rule="evenodd"
                                    d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"
                                    clip-rule="evenodd" />
                            </svg>
                            Delete
                        </button>
                    </div>
                </div>
                <!-- Additional Details -->
                <div class="text-xs text-gray-600 space-y-1">
                    <div class="flex gap-1">
                        <p class="font-medium">Contact:</p>
                        <p class="font-bold text-blue-gray-900">{{ customer.name }}</p>
                    </div>
                    <div class="flex gap-1">
                        <p class="font-medium">Email Address:</p>
                        <p class="font-bold text-blue-gray-900">{{ customer.email }}</p>
                    </div>
                    <div class="flex gap-1">
                        <p class="font-medium">Address:</p>
                        <p class="font-bold text-blue-gray-900">{{ customer.address }}</p>
                    </div>
                </div>
            </div>
        </div>


        <Modal :show="IsOpenCustomerModal" @close="closeModal">
            <CustomerForm  :customer="customer"  @close="closeModal"/>
        </Modal>
    </section>
</template>
