<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Compass, Heart, Globe, Users } from 'lucide-vue-next';
</script>

<template>
    <Head title="About Us" />

    <PublicLayout>
        <div class="py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">About Nurtools</h1>
                    <p class="text-xl text-gray-600">
                        Essential Islamic tools for daily life, accessible on any device
                    </p>
                </div>

                <!-- Mission Section -->
                <div class="bg-white rounded-lg shadow-sm p-8 mb-8">
                    <div class="flex items-center justify-center mb-6">
                        <div class="p-4 bg-emerald-100 rounded-full">
                            <Heart :size="32" class="text-emerald-600" :stroke-width="2" />
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">Our Mission</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Nurtools was created to provide Muslims around the world with easy access to essential Islamic tools. 
                        Whether you need to find the Qibla direction for prayer or calculate your Zakaat obligations, 
                        we believe these tools should be accessible to everyone, on any device, anywhere in the world.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        Our name "Nur" means light in Arabic, and we strive to bring clarity and ease to your daily 
                        Islamic practices through technology.
                    </p>
                </div>

                <!-- Features Grid -->
                <div class="grid md:grid-cols-3 gap-6 mb-12">
                    <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                        <div class="flex items-center justify-center mb-4">
                            <div class="p-3 bg-emerald-100 rounded-full">
                                <Compass :size="24" class="text-emerald-600" :stroke-width="2" />
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Accurate Tools</h3>
                        <p class="text-gray-600 text-sm">
                            Built with precision using modern technology and verified calculations
                        </p>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                        <div class="flex items-center justify-center mb-4">
                            <div class="p-3 bg-emerald-100 rounded-full">
                                <Globe :size="24" class="text-emerald-600" :stroke-width="2" />
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Works Anywhere</h3>
                        <p class="text-gray-600 text-sm">
                            Progressive Web App that works offline and on any device
                        </p>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                        <div class="flex items-center justify-center mb-4">
                            <div class="p-3 bg-emerald-100 rounded-full">
                                <Users :size="24" class="text-emerald-600" :stroke-width="2" />
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Free for All</h3>
                        <p class="text-gray-600 text-sm">
                            Core tools are completely free with optional premium features
                        </p>
                    </div>
                </div>

                <!-- Values Section -->
                <div class="bg-white rounded-lg shadow-sm p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Our Values</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Accessibility First</h3>
                            <p class="text-gray-700">
                                We believe essential Islamic tools should be free and accessible to everyone, 
                                regardless of their location or device.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Privacy Focused</h3>
                            <p class="text-gray-700">
                                Your data is yours. We don't track, sell, or share your personal information. 
                                Tools work without requiring an account.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Continuous Improvement</h3>
                            <p class="text-gray-700">
                                We're constantly working to improve our tools and add new features based on 
                                community feedback and needs.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
