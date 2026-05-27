<script setup>
import MijnReserveringenTegels from './MijnReserveringenTegels.vue';

const reservations = [
    {
        id: 1,
        name: 'Naam',
        date: 'datum',
        info: 'Informatie',
        status: 'Teruggebracht',
    },
    {
        id: 2,
        name: 'Naam',
        date: 'datum',
        info: 'Informatie',
        status: 'Teruggebracht',
    },
];
</script>

<template>
    <div class="space-y-8">
        <!-- Bovenste profielkaart -->
        <div
            class="flex items-center gap-5 rounded-lg border border-neutral-200 bg-white p-6 shadow-sm"
        >
            <div
                class="flex h-14 w-14 items-center justify-center rounded-xl border border-neutral-300"
            ></div>

            <div>
                <h1 class="text-2xl font-semibold">Naam</h1>

                <p class="text-neutral-500">Naam@gmail.com</p>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid gap-6 md:grid-cols-3">
            <!-- Totaal -->
            <div
                class="rounded-lg border border-neutral-200 bg-white p-6 shadow-sm"
            >
                <div class="flex items-center gap-4">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-xl border border-neutral-300"
                    ></div>

                    <div>
                        <h2 class="text-2xl font-semibold">3</h2>

                        <p class="text-neutral-500">Totaal</p>
                    </div>
                </div>
            </div>

            <!-- Actief -->
            <div
                class="rounded-lg border border-neutral-200 bg-white p-6 shadow-sm"
            >
                <div class="flex items-center gap-4">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-xl border border-neutral-300"
                    ></div>

                    <div>
                        <h2 class="text-2xl font-semibold">3</h2>

                        <p class="text-neutral-500">Actief</p>
                    </div>
                </div>
            </div>

            <!-- Teruggebracht -->
            <div
                class="rounded-lg border border-neutral-200 bg-white p-6 shadow-sm"
            >
                <div class="flex items-center gap-4">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-xl border border-neutral-300"
                    ></div>

                    <div>
                        <h2 class="text-2xl font-semibold">3</h2>

                        <p class="text-neutral-500">Teruggebracht</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Titel -->
        <div>
            <h2 class="mb-4 text-3xl font-semibold">Mijn reserveringen</h2>

            <!-- Filters -->
            <div class="grid gap-4 md:grid-cols-[1fr_240px_240px]">
                <UInput
                    v-model="search"
                    icon="i-lucide-search"
                    placeholder="Zoek een reservering"
                    variant="outline"
                    size="xl"
                    class="min-w-[min(100%,360px)] flex-[999_1_360px]"
                    :ui="{
                        base: 'h-[46px] rounded-[10px] bg-magazijn-white text-[14px] text-magazijn-purple shadow-sm ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                        leadingIcon: 'text-magazijn-gray',
                    }"
                />

                <select
                    class="mt-1 h-12 rounded-lg border border-neutral-200 bg-white px-4 outline-none"
                >
                    <option>Alle statussen</option>
                </select>
                <!-- <USelect v-model="value" :items="items" class="w-48" /> -->

                <select
                    class="mt-1 h-12 rounded-lg border border-neutral-200 bg-white px-4 outline-none"
                >
                    <option>Deze maand</option>
                </select>
            </div>
        </div>

        <!-- Tegels -->
        <div class="space-y-5">
            <MijnReserveringenTegels
                v-for="reservation in reservations"
                :key="reservation.id"
                :reservation="reservation"
            />
        </div>
    </div>
</template>
