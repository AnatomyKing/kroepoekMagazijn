<script setup>
import { ref } from 'vue';

defineProps({
    user: {
        type: Object,
        required: true,
    },
    navigation: {
        type: Array,
        required: true,
    },
});

const menuOpen = ref(false);
</script>

<template>
    <header class="sticky top-0 z-50 bg-magazijn-purple text-magazijn-white">
        <div class="flex h-[80px] items-center px-4 sm:px-8">
            <div class="flex min-w-0 shrink-0 items-center gap-4 sm:gap-5 lg:w-[250px]">
                <div class="grid size-12 shrink-0 place-items-center rounded-full bg-magazijn-white text-magazijn-purple">
                    <span class="text-[16px] font-extrabold tracking-[-0.18em]">
                        MM
                    </span>
                </div>

                <div class="text-[26px] font-bold tracking-[0.08em]">
                    SUMMA
                </div>
            </div>

            <nav class="hidden h-full items-center gap-6 lg:flex">
                <UButton
                    v-for="item in navigation"
                    :key="item.label"
                    :label="item.label"
                    :icon="item.icon"
                    variant="ghost"
                    size="md"
                    :class="[
                        'h-full rounded-none px-2 text-[16px] font-semibold tracking-wide hover:bg-magazijn-blue-gray/15',
                        item.active ? 'text-magazijn-white' : 'text-magazijn-blue-gray'
                    ]"
                />
            </nav>

            <div class="ml-auto hidden items-center gap-8 text-right lg:flex">
                <div>
                    <div class="text-[17px] font-bold leading-5 tracking-wide text-magazijn-white">
                        {{ user.name }}
                    </div>

                    <div class="mt-[2px] text-[14px] font-semibold text-magazijn-blue-gray">
                        {{ user.email }}
                    </div>
                </div>

                <UButton
                    icon="i-lucide-log-out"
                    variant="ghost"
                    size="xl"
                    aria-label="Uitloggen"
                    class="text-magazijn-blue-gray hover:bg-magazijn-blue-gray/15 hover:text-magazijn-white"
                />
            </div>

            <UButton
                :icon="menuOpen ? 'i-lucide-x' : 'i-lucide-menu'"
                variant="ghost"
                size="xl"
                aria-label="Menu openen"
                class="ml-auto text-magazijn-white hover:bg-magazijn-blue-gray/15 lg:hidden"
                @click="menuOpen = !menuOpen"
            />
        </div>

        <div
            v-if="menuOpen"
            class="border-t border-magazijn-blue-gray/40 bg-magazijn-purple lg:hidden"
        >
            <nav class="flex flex-col gap-1 px-6 py-4">
                <UButton
                    v-for="item in navigation"
                    :key="item.label"
                    :icon="item.icon"
                    variant="ghost"
                    size="xl"
                    :class="[
                        'h-[48px] justify-start rounded-none px-2 text-[17px] font-semibold tracking-wide hover:bg-magazijn-blue-gray/15',
                        item.active ? 'text-magazijn-white' : 'text-magazijn-blue-gray'
                    ]"
                    @click="menuOpen = false"
                >
                    <span>{{ item.label }}</span>
                </UButton>

                <UButton
                    icon="i-lucide-log-out"
                    variant="ghost"
                    size="xl"
                    class="h-[48px] justify-start rounded-none px-2 text-[17px] font-semibold tracking-wide text-magazijn-blue-gray hover:bg-magazijn-blue-gray/15 hover:text-magazijn-white"
                    @click="menuOpen = false"
                >
                    <span>Uitloggen</span>
                </UButton>
            </nav>

            <div class="border-t border-magazijn-blue-gray/40 px-7 py-4">
                <div class="text-[17px] font-bold leading-5 tracking-wide text-magazijn-white">
                    {{ user.name }}
                </div>

                <div class="mt-[2px] text-[14px] font-semibold text-magazijn-blue-gray">
                    {{ user.email }}
                </div>
            </div>
        </div>
    </header>
</template>
