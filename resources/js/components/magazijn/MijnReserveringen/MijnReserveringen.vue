<script setup lang="ts">
import MagazijnHeaderBar from '../MagazijnHeaderBar.vue';


const user = {
    name: 'Pien van den Broek',
    email: 'ps251239@summacollege.nl',
};

const navigation = [
    {
        label: 'Producten',
        icon: 'i-lucide-camera',
        active: false,
    },
    {
        label: 'Mijn Reserveringen',
        icon: 'i-lucide-shopping-cart',
        active: true,
    },
    {
        label: 'Producten Beheer',
        icon: 'i-lucide-camera',
        active: false,
    },
    {
        label: 'Alle Reserveringen',
        icon: 'i-lucide-shopping-cart',
        active: false,
    },
];
</script>

<template>
    <UApp>
        <div class="min-h-screen bg-magazijn-white text-magazijn-purple">
            <MagazijnHeaderBar
                :user="user"
                :navigation="navigation"
            />

        </div>
    </UApp>
</template>

<style scoped>

</style>
