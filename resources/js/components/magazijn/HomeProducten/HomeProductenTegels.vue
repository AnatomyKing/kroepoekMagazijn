<script setup>
defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['select']);
</script>

<template>
    <article
        class="cursor-pointer overflow-hidden rounded-[15px] border border-magazijn-purple-soft bg-magazijn-white transition hover:-translate-y-[2px] hover:shadow-md"
        tabindex="0"
        role="button"
        @click="emit('select', product)"
        @keydown.enter="emit('select', product)"
        @keydown.space.prevent="emit('select', product)"
    >
        <div class="relative h-[clamp(210px,45vw,214px)] bg-magazijn-purple">
            <div class="absolute left-3 top-3 flex items-center gap-[6px]">
                <UBadge
                    label="Beschikbaar"
                    variant="solid"
                    class="h-[19px] rounded-[6px] bg-magazijn-green px-[11px] text-[11px] leading-none text-magazijn-white ring-0"
                />

                <UBadge
                    :label="product.available"
                    variant="solid"
                    class="grid size-[20px] place-items-center rounded-full bg-magazijn-green p-0 text-[11px] leading-none text-magazijn-white ring-0"
                />
            </div>
        </div>

        <div class="relative h-[134px] bg-magazijn-white px-3 pt-[16px]">
            <h2 class="max-w-[calc(100%-48px)] truncate text-[22px] font-bold leading-7 tracking-[-0.02em] text-black">
                {{ product.name }}
            </h2>

            <p class="mt-[4px] truncate text-[16px] leading-5 text-magazijn-gray">
                {{ product.type }}
            </p>

            <p class="mt-[14px] truncate text-[16px] leading-5 text-magazijn-gray">
                {{ product.info }}
            </p>

            <span class="absolute right-[22px] top-[21px] size-[30px] rounded-full bg-magazijn-purple" />
        </div>
    </article>
</template>
