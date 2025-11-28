<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Footer from '@/Components/Footer.vue';
import InstallPrompt from '@/Components/InstallPrompt.vue';
import { Link } from '@inertiajs/vue3';
import { Menu, X, Compass, Calculator, DollarSign, User } from 'lucide-vue-next';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex flex-col">
        <div class="flex-1 flex flex-col">
            <nav class="bg-white border-b border-gray-200 shadow-sm">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('welcome')" class="flex items-center space-x-2">
                                    <div class="p-2 bg-emerald-600 rounded-lg">
                                        <Compass :size="20" class="text-white" :stroke-width="2" />
                                    </div>
                                    <span class="text-xl font-bold text-gray-900">Nurtools</span>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <Link
                                    :href="route('qibla.index')"
                                    :class="[
                                        route().current('qibla.index')
                                            ? 'border-emerald-600 text-gray-900'
                                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                        'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition'
                                    ]"
                                >
                                    <Compass :size="18" class="mr-2" :stroke-width="2" />
                                    Qibla Compass
                                </Link>
                                <Link
                                    :href="route('zakaat.index')"
                                    :class="[
                                        route().current('zakaat.index')
                                            ? 'border-emerald-600 text-gray-900'
                                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                        'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition'
                                    ]"
                                >
                                    <Calculator :size="18" class="mr-2" :stroke-width="2" />
                                    Zakaat Calculator
                                </Link>
                                <Link
                                    :href="route('pricing')"
                                    :class="[
                                        route().current('pricing')
                                            ? 'border-emerald-600 text-gray-900'
                                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                        'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition'
                                    ]"
                                >
                                    <DollarSign :size="18" class="mr-2" :stroke-width="2" />
                                    Pricing
                                </Link>
                            </div>
                        </div>

                        <!-- Right Side -->
                        <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                            <template v-if="$page.props.auth.user">
                                <Link
                                    :href="route('dashboard')"
                                    class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition"
                                >
                                    <User :size="18" class="mr-2" :stroke-width="2" />
                                    Dashboard
                                </Link>
                            </template>
                            <template v-else>
                                <Link
                                    :href="route('login')"
                                    class="text-sm font-medium text-gray-700 hover:text-emerald-600 transition"
                                >
                                    Log in
                                </Link>
                                <Link
                                    :href="route('register')"
                                    class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition"
                                >
                                    Sign Up
                                </Link>
                            </template>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <Menu v-if="!showingNavigationDropdown" :size="24" :stroke-width="2" />
                                <X v-else :size="24" :stroke-width="2" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <Link
                            :href="route('qibla.index')"
                            :class="[
                                route().current('qibla.index')
                                    ? 'bg-emerald-50 border-emerald-600 text-emerald-700'
                                    : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800',
                                'flex items-center w-full ps-3 pe-4 py-2 border-l-4 text-base font-medium transition'
                            ]"
                        >
                            <Compass :size="18" class="mr-2" :stroke-width="2" />
                            Qibla Compass
                        </Link>
                        <Link
                            :href="route('zakaat.index')"
                            :class="[
                                route().current('zakaat.index')
                                    ? 'bg-emerald-50 border-emerald-600 text-emerald-700'
                                    : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800',
                                'flex items-center w-full ps-3 pe-4 py-2 border-l-4 text-base font-medium transition'
                            ]"
                        >
                            <Calculator :size="18" class="mr-2" :stroke-width="2" />
                            Zakaat Calculator
                        </Link>
                        <Link
                            :href="route('pricing')"
                            :class="[
                                route().current('pricing')
                                    ? 'bg-emerald-50 border-emerald-600 text-emerald-700'
                                    : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800',
                                'flex items-center w-full ps-3 pe-4 py-2 border-l-4 text-base font-medium transition'
                            ]"
                        >
                            <DollarSign :size="18" class="mr-2" :stroke-width="2" />
                            Pricing
                        </Link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="mt-3 space-y-1">
                            <template v-if="$page.props.auth.user">
                                <div class="px-4 pb-2">
                                    <div class="font-medium text-base text-gray-800">
                                        {{ $page.props.auth.user.name }}
                                    </div>
                                    <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                                </div>
                                <Link
                                    :href="route('dashboard')"
                                    class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition"
                                >
                                    Dashboard
                                </Link>
                                <Link
                                    :href="route('profile.edit')"
                                    class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition"
                                >
                                    Profile
                                </Link>
                                <Link
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition"
                                >
                                    Log Out
                                </Link>
                            </template>
                            <template v-else>
                                <Link
                                    :href="route('login')"
                                    class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 transition"
                                >
                                    Log in
                                </Link>
                                <Link
                                    :href="route('register')"
                                    class="block w-full ps-3 pe-4 py-2 border-l-4 border-emerald-600 text-start text-base font-medium bg-emerald-50 text-emerald-700 transition"
                                >
                                    Sign Up
                                </Link>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1">
                <slot />
            </main>
        </div>
        
        <!-- Footer -->
        <Footer />
        
        <!-- PWA Install Prompt -->
        <InstallPrompt />
    </div>
</template>
