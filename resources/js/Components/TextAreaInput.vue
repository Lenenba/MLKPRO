<script setup>
import { onMounted, ref } from 'vue';

// Modèle de liaison pour le composant
const model = defineModel({
    type: String,
    required: true,
});

const textarea = ref(null);

// Appliquer l'autofocus si l'attribut est présent
onMounted(() => {
    if (textarea.value.hasAttribute('autofocus')) {
        textarea.value.focus();
    }
});

// Exposer une méthode focus pour accéder au composant depuis le parent
defineExpose({
    focus: () => textarea.value.focus(),
});
</script>

<template>

    <textarea
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 "
        v-model="model"
        ref="textarea"
        rows="6" placeholder="Type your message..."></textarea>
</template>
