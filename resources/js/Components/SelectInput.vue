<script setup>
import { onMounted, ref } from 'vue';

// Modèle de liaison pour le composant
const model = defineModel({
    type: [String, Number],
    required: true,
});

const select = ref(null);

// Appliquer l'autofocus si l'attribut est présent
onMounted(() => {
    if (select.value.hasAttribute('autofocus')) {
        select.value.focus();
    }
});

// Exposer une méthode focus pour accéder au composant depuis le parent
defineExpose({
    focus: () => select.value.focus(),
});
</script>

<template>
    <select
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        v-model="model"
        ref="select"
    >
        <slot></slot>
    </select>
</template>
