<script setup>
import MagazijnHeaderBar from '@/components/magazijn/MagazijnHeaderBar.vue';

const user = {
    name: 'Pien van den Broek',
    email: 'ps251239@summacollege.nl',
};
</script>

<template>
    <UApp>
        <div class="min-h-screen bg-magazijn-white text-magazijn-purple">
            <MagazijnHeaderBar :user="user" />

            <slot />
        </div>
    </UApp>
</template>
