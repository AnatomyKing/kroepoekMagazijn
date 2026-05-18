<script setup>
import MagazijnHeaderBar from '../MagazijnHeaderBar.vue';
import HomeProductenContents from './HomeProductenContents.vue';

const user = {
    name: 'Pien van den Broek',
    email: 'ps251239@summacollege.nl',
};

const navigation = [
    {
        label: 'Producten',
        icon: 'i-lucide-camera',
        active: true,
    },
    {
        label: 'Mijn Reserveringen',
        icon: 'i-lucide-shopping-cart',
        active: false,
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

            <HomeProductenContents />
        </div>
    </UApp>
</template>
