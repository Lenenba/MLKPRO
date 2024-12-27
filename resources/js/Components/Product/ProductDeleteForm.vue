<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { defineEmits } from 'vue';
// Emit pour communiquer avec le parent
const emit = defineEmits(['close']);

// Props pour recevoir les données du produit
const props = defineProps({
    product: {
        type: Object,
        required: true
    }
});

// Utilisation du formulaire Inertia pour gérer les requêtes
const form = useForm({
    productId: props.product.id
});

// Fonction pour fermer la modale
const closeModal = () => {
    emit('close');
};

// Fonction pour soumettre le formulaire et supprimer le produit
const deleteProduct = () => {
    form.delete(route('product.destroy', { id: props.product.id }), {
        onSuccess: () => {
            console.log('Product has been deleted successfully!');
            closeModal();
        },
        onError: (errors) => {
            console.error('Validation errors:', errors);
        }
    });
    emit('close');
};
</script>

<template>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
            Are you sure you want to delete this product?
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Once your product is deleted, all of its resources and data
            will be permanently deleted. This action cannot be undone.
        </p>

        <!-- Erreur d'entrée si nécessaire -->
        <InputError :message="form.errors.productId" class="mt-4" />

        <div class="mt-6 flex justify-end">
            <!-- Bouton d'annulation -->
            <SecondaryButton @click="closeModal">
                Cancel
            </SecondaryButton>

            <!-- Bouton de suppression -->
            <DangerButton class="ms-3" :disabled="form.processing" @click="deleteProduct">
                Delete Product
            </DangerButton>
        </div>
    </div>
</template>
