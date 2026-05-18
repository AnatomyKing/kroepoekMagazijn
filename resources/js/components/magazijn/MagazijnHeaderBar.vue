<script setup>
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
</script>

<template>
    <header class="h-[80px] bg-magazijn-purple text-magazijn-white">
        <div class="flex h-full items-center px-8">
            <div class="flex w-[250px] shrink-0 items-center gap-5">
                <div class="grid size-12 place-items-center rounded-full bg-magazijn-white text-magazijn-purple">
                    <span class="text-[16px] font-extrabold tracking-[-0.18em]">
                        MM
                    </span>
                </div>

                <div class="text-[26px] font-bold tracking-[0.08em]">
                    SUMMA
                </div>
            </div>

            <nav class="flex h-full items-center gap-6">
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

            <div class="ml-auto flex items-center gap-8 text-right">
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
        </div>
    </header>
</template>
