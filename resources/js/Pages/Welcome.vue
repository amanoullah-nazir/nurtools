<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { Compass, Calculator, Database } from 'lucide-vue-next';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="Nurtools - Islamic Tools" />

    <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center relative">
        <!-- Header Navigation -->
        <div v-if="canLogin" class="absolute top-0 right-0 p-6">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-emerald-700 hover:text-emerald-900"
            >
                Dashboard
            </Link>
            <template v-else>
                <Link :href="route('login')" class="font-semibold text-emerald-700 hover:text-emerald-900">
                    Log in
                </Link>
                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ms-4 font-semibold text-white bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded-lg"
                >
                    Register
                </Link>
            </template>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto px-4 py-12 text-center">
            <div class="mb-8">
                <div class="inline-block p-6 bg-emerald-600 rounded-3xl shadow-2xl">
                    <Compass :size="80" class="text-white" :stroke-width="2" />
                </div>
            </div>

            <h1 class="text-5xl sm:text-6xl font-bold text-emerald-900 mb-4">Nurtools</h1>
            <p class="text-xl sm:text-2xl text-emerald-700 mb-12">Islamic Tools for Daily Life</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-12">
                <div class="bg-white p-6 rounded-xl shadow-lg text-left">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-emerald-100 rounded-lg">
                            <Compass :size="24" class="text-emerald-600" :stroke-width="2" />
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Qibla Compass</h3>
                            <p class="text-gray-600">Find the direction to Makkah from anywhere in the world.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-lg text-left">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-emerald-100 rounded-lg">
                            <Calculator :size="24" class="text-emerald-600" :stroke-width="2" />
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Zakaat Calculator</h3>
                            <p class="text-gray-600">Calculate your Zakaat obligations with accurate Nisab thresholds.</p>
                        </div>
                    </div>
                </div>
            </div>

            <template v-if="$page.props.auth.user">
                <Link
                    :href="route('qibla.index')"
                    class="inline-block bg-emerald-600 text-white text-lg font-semibold px-8 py-4 rounded-lg hover:bg-emerald-700 shadow-lg"
                >
                    Open Qibla Compass
                </Link>
            </template>
            <template v-else>
                <Link
                    :href="route('register')"
                    class="inline-block bg-emerald-600 text-white text-lg font-semibold px-8 py-4 rounded-lg hover:bg-emerald-700 shadow-lg"
                >
                    Get Started - It's Free
                </Link>
            </template>
        </div>
    </div>
</template>
