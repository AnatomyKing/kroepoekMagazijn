<script setup lang="ts">
import { computed, ref } from 'vue';

const name = ref('');
const count = ref(0);

const greeting = computed(() => {
    if (!name.value.trim()) {
        return 'Type something in the input to test Vue + Nuxt UI.';
    }

    return `Hello ${name.value}, Nuxt UI is working.`;
});
</script>

<template>
    <div class="min-h-screen bg-background text-foreground">
        <div class="mx-auto flex min-h-screen max-w-3xl items-center justify-center p-6">
            <UCard class="w-full">
                <template #header>
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h1 class="text-2xl font-bold">Nuxt UI Test Page</h1>
                            <p class="text-sm text-muted-foreground">
                                Simple Blade + Vue + Tailwind + Nuxt UI test
                            </p>
                        </div>

                        <UBadge color="primary" variant="soft">
                            /test
                        </UBadge>
                    </div>
                </template>

                <div class="space-y-6">
                    <UAlert
                        title="Nuxt UI is loaded"
                        description="If this card, input, buttons, badge, and alert look styled, it works."
                    />

                    <UInput
                        v-model="name"
                        placeholder="Type your name here"
                        size="lg"
                    />

                    <div class="flex flex-wrap items-center gap-3">
                        <UButton @click="count++">
                            Click me
                        </UButton>

                        <UButton color="neutral" variant="soft" @click="count = 0">
                            Reset
                        </UButton>

                        <UBadge color="neutral" variant="soft">
                            Clicks: {{ count }}
                        </UBadge>
                    </div>

                    <UAlert
                        color="success"
                        variant="soft"
                        title="Live Vue state"
                        :description="greeting"
                    />
                </div>
            </UCard>
        </div>
    </div>
</template>
