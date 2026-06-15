<script setup lang="ts">
import { computed } from 'vue';
import StatusBadge from '@/components/StatusBadge.vue';

type ProductImage = {
    id: string;
    path: string | null;
    previewUrl?: string | null;
    file?: File | null;
    isNew?: boolean;
};

type Product = {
    id?: number;
    name: string;
    type: string;
    info: string;
    category: string;
    available: number;
    enabled: boolean;
    image?: string | null;
    imageUrl?: string | null;
    imageEntries?: ProductImage[];
    youtubeVideo?: string | null;
};

const props = defineProps<{
    product: Product;
}>();

const emit = defineEmits<{
    (e: 'edit', product: Product): void;
    (e: 'delete', product: Product): void;
}>();

const imagePreview = computed<string | undefined>(() => {
    return props.product.imageUrl || normalizeImageUrl(props.product.image);
});

function normalizeImageUrl(path?: string | null): string | undefined {
    if (!path) return undefined;

    if (path.startsWith('http://') || path.startsWith('https://')) {
        return path;
    }

    if (path.startsWith('/')) {
        return path;
    }

    if (path.startsWith('images/')) {
        return `/${path}`;
    }

    return `/storage/${path}`;
}
</script>

<template>
    <UCard
        variant="outline"
        :ui="{
            root: 'overflow-hidden rounded-[18px] bg-magazijn-white shadow-sm ring-1 ring-magazijn-purple-soft',
            body: 'p-0 sm:p-0',
        }"
    >
        <div class="flex items-center justify-between px-5 py-4">
            <div class="flex min-w-0 items-center gap-5">
                <div
                    class="h-16 w-16 shrink-0 overflow-hidden rounded-[18px] bg-magazijn-purple"
                >
                    <img
                        v-if="imagePreview"
                        :src="imagePreview"
                        :alt="product.name"
                        class="h-full w-full object-cover"
                    />

                    <div
                        v-else
                        class="flex h-full w-full items-center justify-center text-magazijn-white"
                    >
                        <UIcon name="i-lucide-package" class="h-8 w-8" />
                    </div>
                </div>

                <div class="min-w-0">
                    <h2 class="truncate text-lg font-semibold text-black">
                        {{ product.name }}
                    </h2>

                    <p class="truncate text-sm text-magazijn-gray">
                        {{
                            product.type ||
                            product.category ||
                            'Geen categorie'
                        }}
                    </p>

                    <div class="mt-1 flex flex-wrap gap-2">
                        <span
                            v-if="product.youtubeVideo"
                            class="rounded-full bg-magazijn-green-soft px-2 py-[2px] text-[11px] font-semibold text-magazijn-green"
                        >
                            Video
                        </span>

                        <span
                            v-if="product.imageEntries?.length"
                            class="rounded-full bg-magazijn-purple-soft px-2 py-[2px] text-[11px] font-semibold text-magazijn-purple"
                        >
                            {{ product.imageEntries.length }} foto's
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-5">
                <StatusBadge
                    :status="
                        product.enabled && product.available > 0
                            ? 'available'
                            : 'unavailable'
                    "
                />

                <UButton
                    icon="i-lucide-pencil"
                    color="neutral"
                    variant="ghost"
                    class="text-black hover:bg-magazijn-purple-soft hover:text-magazijn-purple"
                    @click="emit('edit', product)"
                />

                <UButton
                    icon="i-lucide-trash"
                    color="neutral"
                    variant="ghost"
                    class="text-magazijn-red hover:bg-magazijn-red-soft hover:text-magazijn-red"
                    @click="emit('delete', product)"
                />
            </div>
        </div>
    </UCard>
</template>
