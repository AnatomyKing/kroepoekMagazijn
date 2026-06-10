<template>
    <div class="p-6">
        <!-- Toon de lijst alleen als er geen product wordt bewerkt -->
        <AdminProductenBeheerContents
            v-if="!editingProduct"
            @edit="startEdit"
            @add="startAdd"
        />

        <!-- Toon het bewerkingsformulier als er een product is geselecteerd -->
        <AdminProductenBeheerEdit
            v-else
            :product="editingProduct"
            :isNew="isNewProduct"
            @close="closeEdit"
        />
    </div>
</template>

<script setup>
import { ref } from 'vue';
import AdminProductenBeheerContents from './AdminProductenBeheerContents.vue';
import AdminProductenBeheerEdit from './AdminProductenBeheerEdit.vue';

const editingProduct = ref(null);
const isNewProduct = ref(false);

// Bewerken van bestaand product
function startEdit(product) {
    editingProduct.value = { ...product }; // kopieer om directe mutatie te voorkomen
    isNewProduct.value = false;
}

// Nieuw product toevoegen
function startAdd() {
    editingProduct.value = {
        name: '',
        category: '',
        info: '',
        available: 1,
        enabled: true,
    };
    isNewProduct.value = true;
}

// Sluit formulier en vernieuw de lijst
function closeEdit() {
    editingProduct.value = null;
    // Vernieuw de pagina of roep fetchItems() aan in de contents component
    // Optie 1: herlaad de pagina
    window.location.reload();
    // Optie 2: gebruik een event bus of ref om fetchItems aan te roepen
}
</script>
