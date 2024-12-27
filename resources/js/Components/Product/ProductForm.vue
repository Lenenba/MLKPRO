<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { defineEmits } from 'vue';

const emit = defineEmits(['close']);

const props = defineProps({
    categories: Array,
    product: Object,
});

// Initialize the form
const form = useForm({
    name: props.product?.name || '',
    category_id: props.product?.category_id || '',
    stock: props.product?.stock || 0,
    minimum_stock: props.product?.minimum_stock || 0,
    description: props.product?.description || '',
    image: props.product?.filename || '',
});

// Function to handle form submission
const submit = () => {
    const routeName = props.product?.id ? 'product.update' : 'product.store';
    const routeParams = props.product?.id ? props.product.id : undefined;

    form[props.product?.id ? 'put' : 'post'](route(routeName, routeParams), {
        onSuccess: () => {
            console.log('Product saved successfully!');
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
    <!-- Logo -->
    <div class="mt-6">
      <Link href="/">
        <ApplicationLogo class="h-20 w-20 fill-current text-gray-500" />
      </Link>
    </div>

    <!-- Form Container -->
    <div class="mt-6 w-full px-6 py-4 sm:max-w-md">
      <form @submit.prevent="submit">
        <!-- Product Name -->
        <div>
          <InputLabel for="name" value="Product Name" />
          <TextInput
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
            required
          />
          <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <!-- Category -->
        <div class="mt-4">
          <InputLabel for="category_id" value="Category" />
          <SelectInput
            id="category_id"
            v-model="form.category_id"
            class="mt-1 block w-full"
            required
          >
            <option disabled value="">Please select an option</option>
            <option
              v-for="category in categories"
              :key="category.id"
              :value="category.id"
            >
              {{ category.name }}
            </option>
          </SelectInput>
          <InputError class="mt-2" :message="form.errors.category_id" />
        </div>

        <!-- Stock -->
        <div class="mt-4">
          <InputLabel for="stock" value="Stock" />
          <TextInput
            id="stock"
            type="number"
            class="mt-1 block w-full"
            v-model.number="form.stock"
            required
          />
          <InputError class="mt-2" :message="form.errors.stock" />
        </div>

        <!-- Minimum Stock -->
        <div class="mt-4">
          <InputLabel for="minimum_stock" value="Minimum Stock" />
          <TextInput
            id="minimum_stock"
            type="number"
            class="mt-1 block w-full"
            v-model.number="form.minimum_stock"
            required
          />
          <InputError class="mt-2" :message="form.errors.minimum_stock" />
        </div>

        <!-- Description -->
        <div class="mt-4">
          <InputLabel for="description" value="Description" />
          <TextAreaInput
            id="description"
            class="mt-1 block w-full"
            v-model="form.description"
            required
          />
          <InputError class="mt-2" :message="form.errors.description" />
        </div>

        <!-- Images -->
        <div class="mt-4">
          <InputLabel for="image" value="Images" />
          <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
            <div class="text-center">
              <svg
                class="mx-auto size-12 text-gray-300"
                viewBox="0 0 24 24"
                fill="currentColor"
                aria-hidden="true"
                data-slot="icon"
              >
                <path
                  fill-rule="evenodd"
                  d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                  clip-rule="evenodd"
                />
              </svg>
              <div class="mt-4 flex text-sm text-gray-600">
                <label
                  for="image"
                  class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600"
                >
                  <span>Upload a file</span>
                  <input
                    id="image"
                    name="image"
                    type="file"
                    class="sr-only"
                    @change="(e) => (form.image = e.target.files[0])"
                  />
                </label>
                <p class="pl-1">or drag and drop</p>
              </div>
              <p class="text-xs text-gray-600">PNG, JPG, GIF up to 10MB</p>
            </div>
          </div>
          <InputError class="mt-2" :message="form.errors.image" />
        </div>

        <!-- Submit Button -->
        <div class="mt-4 flex items-center justify-end">
          <PrimaryButton class="ml-4" :disabled="form.processing">
            {{ props.product?.id ? 'Update' : 'Save' }}
          </PrimaryButton>
        </div>
      </form>
    </div>
  </div>
</template>
