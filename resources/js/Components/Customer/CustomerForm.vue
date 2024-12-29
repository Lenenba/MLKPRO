<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ImageInput from '../ImageInput.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

const emit = defineEmits(['close']);

const props = defineProps({
    customer: Object, // Receives existing customer details for editing
});

// Initialize the form
const form = useForm({
    name: props.customer?.name || '',
    email: props.customer?.email || '',
    phone: props.customer?.phone || '',
    address: props.customer?.address || '',
    city: props.customer?.city || '',
    state: props.customer?.state || '',
    zip: props.customer?.zip || '',
    company_name: props.customer?.company_name || '',
    logo: props.customer?.logo || '',
    header_image: props.customer?.header_image || '',
    description: props.customer?.description || '',
});

// Function to handle form submission
const submit = () => {
    const routeName = props.customer?.id ? 'customer.update' : 'customer.store';
    const routeParams = props.customer?.id ? props.customer.id : undefined;

    form[props.customer?.id ? 'put' : 'post'](route(routeName, routeParams), {
        onSuccess: () => {
            console.log('Customer saved successfully!');
            emit('close');
        },
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
    });
};

</script>

<template>
    <div class="flex flex-col items-center bg-gray-100 sm:justify-center sm:pt-0">
        <!-- Form Container -->
        <div class="mt-6 w-full px-6 py-4 sm:max-w-md">
            <form @submit.prevent="submit">
                <!-- Name Fields -->
                <div class="flex gap-4">
                    <div class="flex-1">
                        <InputLabel for="name" value="Name" />
                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div class="flex-1">
                        <InputLabel for="company_name" value="Company Name" />
                        <TextInput id="company_name" type="text" class="mt-1 block w-full"
                            v-model="form.company_name" />
                        <InputError class="mt-2" :message="form.errors.company_name" />
                    </div>
                </div>

                <!-- Email and Phone -->
                <div class="flex gap-4 mt-4">
                    <div class="flex-1">
                        <InputLabel for="email" value="Email" />
                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                    <div class="flex-1">
                        <InputLabel for="phone" value="Phone" />
                        <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" />
                        <InputError class="mt-2" :message="form.errors.phone" />
                    </div>
                </div>

                <!-- Address -->
                <div class="mt-4">
                    <InputLabel for="address" value="Address" />
                    <TextInput id="address" type="text" class="mt-1 block w-full" v-model="form.address" />
                    <InputError class="mt-2" :message="form.errors.address" />
                </div>

                <!-- City and State -->
                <div class="flex gap-4 mt-4">
                    <div class="flex-1">
                        <InputLabel for="city" value="City" />
                        <TextInput id="city" type="text" class="mt-1 block w-full" v-model="form.city" />
                        <InputError class="mt-2" :message="form.errors.city" />
                    </div>
                    <div class="flex-1">
                        <InputLabel for="state" value="State" />
                        <TextInput id="state" type="text" class="mt-1 block w-full" v-model="form.state" />
                        <InputError class="mt-2" :message="form.errors.state" />
                    </div>
                    <div class="flex-1">
                        <InputLabel for="zip" value="ZIP Code" />
                        <TextInput id="zip" type="text" class="mt-1 block w-full" v-model="form.zip" />
                        <InputError class="mt-2" :message="form.errors.zip" />
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-4">
                    <InputLabel for="description" value="Description" />
                    <TextAreaInput id="description" class="mt-1 block w-full" v-model="form.description" />
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <!-- Logo Upload -->
                <div class="flex gap-4 mt-4">
                    <div class="flex-1">
                        <InputLabel for="logo" value="Logo" />
                        <ImageInput v-model="form.logo" :model-value="form.logo" :label="'Upload'" />
                    </div>
                    <div class="flex-1">
                        <InputLabel for="header_image" value="Header Image" />
                        <ImageInput v-model="form.header_image" :model-value="form.header_image" :label="'Upload'" />
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex items-center justify-end">
                    <Link :href="route('customer.index')">
                    <button type="button"
                        class="py-2 px-6 text-sm font-medium text-gray-800 bg-white rounded-lg hover:bg-gray-600">
                        Cancel
                    </button>
                    </Link>
                    <PrimaryButton class="ml-4" :disabled="form.processing">
                        {{ props.customer?.id ? 'Update customer' : 'Save customer' }}
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>
