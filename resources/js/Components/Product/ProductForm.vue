<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    categories: Object,
    product: Object,
});

const form = useForm({
    name: '',
    category_id: '',
    stock: 0,
    minumum_stock: 0,
    description: '',
});

const submit = () => {
    console.log(form);
};
</script>

<template>
    <GuestLayout>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Product Name" />
                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="category_id" value="Category" />
                <SelectInput id="category_id" v-model="form.category_id" class="mt-1 block w-full" required autofocus>
                    <option disabled value="">Please select an option</option>
                    <option v-for="category in categories" :key="category.id" :value="category.name">
                        {{ category.name }}
                    </option>
                </SelectInput>
                <InputError class="mt-2" :message="form.errors.category_id" />
            </div>

            <div>
                <InputLabel for="stock" value="Stock" />
                <TextInput id="stock" type="number" class="mt-1 block w-full" v-model.number="form.stock" required autofocus />
                <InputError class="mt-2" :message="form.errors.stock" />
            </div>

            <div>
                <InputLabel for="minumum_stock" value="Minimun Stock" />
                <TextInput id="minumum_stock" type="text" class="mt-1 block w-full" v-model.number="form.minumum_stock"
                    required autofocus />
                <InputError class="mt-2" :message="form.errors.minumum_stock" />
            </div>


            <div>
                <InputLabel for="description" value="Description" />
                <TextAreaInput class="mt-1 block w-full" v-model="form.description"  required autofocus/>
                <InputError class="mt-2" :message="form.errors.minumum_stock" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton class="ms-4" :disabled="form.processing">
                    Save
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
