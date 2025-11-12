<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Footer from '@/Components/Footer.vue';
import { Link } from '@inertiajs/vue3';
import { Compass } from 'lucide-vue-next';
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex flex-col">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <Link :href="route('welcome')" class="flex items-center space-x-2 w-fit">
                    <div class="p-2 bg-emerald-600 rounded-lg">
                        <Compass :size="20" class="text-white" :stroke-width="2" />
                    </div>
                    <span class="text-xl font-bold text-gray-900">Nurtools</span>
                </Link>
            </div>
        </header>

        <!-- Content -->
        <div class="flex-1 flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <slot />
            </div>
        </div>

        <!-- Footer -->
        <Footer />
    </div>
</template>
