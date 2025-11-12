<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Check, Compass, Calculator, Bell, Cloud, TrendingUp, Sparkles } from 'lucide-vue-next';
</script>

<template>
    <Head title="Pricing - Nurtools" />

    <PublicLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="text-center mb-12">
                    <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">
                        Choose Your Plan
                    </h1>
                    <p class="text-xl text-gray-600">
                        Start free, upgrade anytime for premium features
                    </p>
                </div>

                <!-- Pricing Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto px-4">
                    <!-- Free Plan -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-gray-200">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Free</h2>
                            <div class="flex items-baseline mb-4">
                                <span class="text-5xl font-bold text-gray-900">$0</span>
                                <span class="text-gray-600 ml-2">/forever</span>
                            </div>
                            <p class="text-gray-600">Perfect for casual users</p>
                        </div>

                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start">
                                <Check :size="20" class="text-emerald-600 mr-3 mt-0.5 flex-shrink-0" :stroke-width="2" />
                                <span class="text-gray-700">
                                    <Compass :size="16" class="inline mr-1" :stroke-width="2" />
                                    Qibla Compass with real-time direction
                                </span>
                            </li>
                            <li class="flex items-start">
                                <Check :size="20" class="text-emerald-600 mr-3 mt-0.5 flex-shrink-0" :stroke-width="2" />
                                <span class="text-gray-700">
                                    <Calculator :size="16" class="inline mr-1" :stroke-width="2" />
                                    Basic Zakaat Calculator
                                </span>
                            </li>
                            <li class="flex items-start">
                                <Check :size="20" class="text-emerald-600 mr-3 mt-0.5 flex-shrink-0" :stroke-width="2" />
                                <span class="text-gray-700">Works on mobile and desktop</span>
                            </li>
                            <li class="flex items-start">
                                <Check :size="20" class="text-emerald-600 mr-3 mt-0.5 flex-shrink-0" :stroke-width="2" />
                                <span class="text-gray-700">Progressive Web App (PWA)</span>
                            </li>
                            <li class="flex items-start">
                                <Check :size="20" class="text-emerald-600 mr-3 mt-0.5 flex-shrink-0" :stroke-width="2" />
                                <span class="text-gray-700">No ads</span>
                            </li>
                        </ul>

                        <Link
                            :href="route('qibla.index')"
                            class="block w-full text-center px-6 py-3 bg-gray-200 text-gray-900 font-semibold rounded-lg hover:bg-gray-300 transition"
                        >
                            Start Using Free
                        </Link>
                    </div>

                    <!-- Premium Plan -->
                    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl shadow-2xl p-8 border-2 border-emerald-500 relative">
                        <!-- Popular Badge -->
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                            <span class="bg-amber-400 text-amber-900 px-4 py-1 rounded-full text-sm font-bold flex items-center gap-1">
                                <Sparkles :size="14" :stroke-width="2" />
                                Most Popular
                            </span>
                        </div>

                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-white mb-2">Premium</h2>
                            <div class="flex items-baseline mb-4">
                                <span class="text-5xl font-bold text-white">$4.99</span>
                                <span class="text-emerald-100 ml-2">/month</span>
                            </div>
                            <p class="text-emerald-100">For dedicated users</p>
                        </div>

                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start">
                                <Check :size="20" class="text-white mr-3 mt-0.5 flex-shrink-0" :stroke-width="2.5" />
                                <span class="text-white font-medium">Everything in Free, plus:</span>
                            </li>
                            <li class="flex items-start">
                                <Check :size="20" class="text-white mr-3 mt-0.5 flex-shrink-0" :stroke-width="2.5" />
                                <span class="text-emerald-50">
                                    <Calculator :size="16" class="inline mr-1" :stroke-width="2" />
                                    Advanced Zakaat Calculator with history
                                </span>
                            </li>
                            <li class="flex items-start">
                                <Check :size="20" class="text-white mr-3 mt-0.5 flex-shrink-0" :stroke-width="2.5" />
                                <span class="text-emerald-50">
                                    <Bell :size="16" class="inline mr-1" :stroke-width="2" />
                                    Prayer time notifications
                                </span>
                            </li>
                            <li class="flex items-start">
                                <Check :size="20" class="text-white mr-3 mt-0.5 flex-shrink-0" :stroke-width="2.5" />
                                <span class="text-emerald-50">
                                    <Cloud :size="16" class="inline mr-1" :stroke-width="2" />
                                    Cloud sync across devices
                                </span>
                            </li>
                            <li class="flex items-start">
                                <Check :size="20" class="text-white mr-3 mt-0.5 flex-shrink-0" :stroke-width="2.5" />
                                <span class="text-emerald-50">
                                    <TrendingUp :size="16" class="inline mr-1" :stroke-width="2" />
                                    Zakaat tracking & reports
                                </span>
                            </li>
                            <li class="flex items-start">
                                <Check :size="20" class="text-white mr-3 mt-0.5 flex-shrink-0" :stroke-width="2.5" />
                                <span class="text-emerald-50">Priority support</span>
                            </li>
                            <li class="flex items-start">
                                <Check :size="20" class="text-white mr-3 mt-0.5 flex-shrink-0" :stroke-width="2.5" />
                                <span class="text-emerald-50">Early access to new features</span>
                            </li>
                        </ul>

                        <Link
                            :href="route('register')"
                            class="block w-full text-center px-6 py-3 bg-white text-emerald-700 font-semibold rounded-lg hover:bg-emerald-50 transition shadow-lg"
                        >
                            Start Premium Trial
                        </Link>
                        <p class="text-center text-emerald-100 text-sm mt-3">
                            14 days free trial • Cancel anytime
                        </p>
                    </div>
                </div>

                <!-- FAQ or additional info -->
                <div class="mt-16 text-center max-w-3xl mx-auto px-4">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h3>
                    <div class="space-y-6 text-left">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Do I need an account to use the free features?</h4>
                            <p class="text-gray-600">No! You can use the Qibla Compass and basic Zakaat Calculator without creating an account.</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Can I cancel my premium subscription anytime?</h4>
                            <p class="text-gray-600">Yes, you can cancel anytime from your account settings. Your premium features will remain active until the end of your billing period.</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">What payment methods do you accept?</h4>
                            <p class="text-gray-600">We accept all major credit cards, debit cards, and PayPal.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
