<script setup>
import { Link } from '@inertiajs/vue3';
import { Compass, Mail, Github, Twitter } from 'lucide-vue-next';
</script>

<template>
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="p-2 bg-emerald-600 rounded-lg">
                            <Compass :size="24" class="text-white" :stroke-width="2" />
                        </div>
                        <span class="text-xl font-bold text-gray-900">Nurtools</span>
                    </div>
                    <p class="text-gray-600 mb-4 max-w-md">
                        Islamic tools for daily life. Find Qibla direction, calculate Zakaat, and more — accessible on any device.
                    </p>
                    <p class="text-sm text-gray-500">
                        © {{ new Date().getFullYear() }} Nurtools. All rights reserved.
                    </p>
                </div>

                <!-- Tools -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Tools</h3>
                    <ul class="space-y-3">
                        <li>
                            <Link :href="route('qibla.index')" class="text-gray-600 hover:text-emerald-600 transition">
                                Qibla Compass
                            </Link>
                        </li>
                        <li>
                            <span class="text-gray-400">Zakaat Calculator (Soon)</span>
                        </li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Company</h3>
                    <ul class="space-y-3">
                        <li>
                            <Link :href="route('pricing')" class="text-gray-600 hover:text-emerald-600 transition">
                                Pricing
                            </Link>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-emerald-600 transition">
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-emerald-600 transition">
                                Privacy Policy
                            </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-emerald-600 transition">
                                Terms of Service
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Social Links -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <div class="flex items-center justify-center space-x-6">
                    <a href="#" class="text-gray-400 hover:text-emerald-600 transition">
                        <span class="sr-only">Twitter</span>
                        <Twitter :size="20" :stroke-width="2" />
                    </a>
                    <a href="#" class="text-gray-400 hover:text-emerald-600 transition">
                        <span class="sr-only">GitHub</span>
                        <Github :size="20" :stroke-width="2" />
                    </a>
                    <a href="#" class="text-gray-400 hover:text-emerald-600 transition">
                        <span class="sr-only">Email</span>
                        <Mail :size="20" :stroke-width="2" />
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>
