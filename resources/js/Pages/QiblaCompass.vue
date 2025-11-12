<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    makkahCoordinates: Object,
});

// State
const userLocation = ref(null);
const deviceHeading = ref(0);
const qiblaBearing = ref(0);
const distance = ref(0);
const loading = ref(true);
const error = ref(null);
const calibrating = ref(false);
const permissionStatus = ref('prompt');

// Computed
const qiblaDirection = computed(() => {
    if (!userLocation.value || !deviceHeading.value === null) return 0;
    // Calculate the direction the compass needle should point
    // This is the difference between Qibla bearing and device heading
    return qiblaBearing.value - deviceHeading.value;
});

const formattedDistance = computed(() => {
    if (distance.value < 1) {
        return `${Math.round(distance.value * 1000)} m`;
    }
    return `${distance.value.toFixed(2)} km`;
});

// Request geolocation permission and get user location
const getUserLocation = async () => {
    loading.value = true;
    error.value = null;

    if (!navigator.geolocation) {
        error.value = 'Geolocation is not supported by your browser';
        loading.value = false;
        return;
    }

    try {
        const position = await new Promise((resolve, reject) => {
            navigator.geolocation.getCurrentPosition(resolve, reject, {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0,
            });
        });

        userLocation.value = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
            accuracy: position.coords.accuracy,
        };

        await calculateQibla();
        loading.value = false;
    } catch (err) {
        console.error('Geolocation error:', err);
        error.value = getGeolocationError(err);
        loading.value = false;
    }
};

// Calculate Qibla direction from backend
const calculateQibla = async () => {
    if (!userLocation.value) return;

    try {
        const response = await fetch('/api/qibla/calculate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                latitude: userLocation.value.lat,
                longitude: userLocation.value.lng,
            }),
        });

        const data = await response.json();
        qiblaBearing.value = data.bearing;
        distance.value = data.distance;
    } catch (err) {
        console.error('Qibla calculation error:', err);
        error.value = 'Failed to calculate Qibla direction';
    }
};

// Handle device orientation
const handleOrientation = (event) => {
    if (event.webkitCompassHeading) {
        // iOS Safari
        deviceHeading.value = event.webkitCompassHeading;
    } else if (event.alpha !== null) {
        // Android Chrome
        deviceHeading.value = 360 - event.alpha;
    }
};

// Request device orientation permission (required on iOS 13+)
const requestOrientationPermission = async () => {
    if (typeof DeviceOrientationEvent !== 'undefined' && 
        typeof DeviceOrientationEvent.requestPermission === 'function') {
        try {
            const permission = await DeviceOrientationEvent.requestPermission();
            permissionStatus.value = permission;
            
            if (permission === 'granted') {
                window.addEventListener('deviceorientation', handleOrientation, true);
            } else {
                error.value = 'Compass permission denied. Please enable in Settings.';
            }
        } catch (err) {
            console.error('Orientation permission error:', err);
            error.value = 'Failed to request compass permission';
        }
    } else {
        // No permission needed (Android/older iOS)
        window.addEventListener('deviceorientation', handleOrientation, true);
        permissionStatus.value = 'granted';
    }
};

// Get user-friendly error message
const getGeolocationError = (err) => {
    switch (err.code) {
        case err.PERMISSION_DENIED:
            return 'Location permission denied. Please enable location services.';
        case err.POSITION_UNAVAILABLE:
            return 'Location information unavailable. Please try again.';
        case err.TIMEOUT:
            return 'Location request timed out. Please try again.';
        default:
            return 'An unknown error occurred getting your location.';
    }
};

// Initialize compass
const initializeCompass = async () => {
    await getUserLocation();
    await requestOrientationPermission();
};

// Retry function
const retry = () => {
    error.value = null;
    initializeCompass();
};

// Lifecycle
onMounted(() => {
    initializeCompass();
});

onUnmounted(() => {
    window.removeEventListener('deviceorientation', handleOrientation, true);
});
</script>

<template>
    <Head title="Qibla Compass" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Qibla Compass</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        
                        <!-- Loading State -->
                        <div v-if="loading" class="text-center py-12">
                            <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-600"></div>
                            <p class="mt-4 text-gray-600">Getting your location...</p>
                        </div>

                        <!-- Error State -->
                        <div v-else-if="error" class="text-center py-12">
                            <div class="text-red-600 mb-4">
                                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-gray-700 mb-4">{{ error }}</p>
                            <button 
                                @click="retry"
                                class="bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700 transition"
                            >
                                Try Again
                            </button>
                        </div>

                        <!-- Compass -->
                        <div v-else class="flex flex-col items-center">
                            
                            <!-- Location Info -->
                            <div class="w-full mb-8 text-center">
                                <p class="text-sm text-gray-600">Your Location</p>
                                <p class="text-lg font-semibold">
                                    {{ userLocation?.lat.toFixed(4) }}°, {{ userLocation?.lng.toFixed(4) }}°
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Distance to Makkah: <span class="font-semibold">{{ formattedDistance }}</span>
                                </p>
                            </div>

                            <!-- Compass Circle -->
                            <div class="relative w-80 h-80 sm:w-96 sm:h-96">
                                <!-- Compass Background -->
                                <div class="absolute inset-0 rounded-full border-8 border-emerald-600 bg-gradient-to-br from-emerald-50 to-white shadow-2xl">
                                    <!-- Cardinal directions -->
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="relative w-full h-full">
                                            <div class="absolute top-2 left-1/2 -translate-x-1/2 font-bold text-emerald-800">N</div>
                                            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 font-bold text-gray-600">S</div>
                                            <div class="absolute left-2 top-1/2 -translate-y-1/2 font-bold text-gray-600">W</div>
                                            <div class="absolute right-2 top-1/2 -translate-y-1/2 font-bold text-gray-600">E</div>
                                        </div>
                                    </div>

                                    <!-- Qibla Needle -->
                                    <div 
                                        class="absolute inset-0 flex items-center justify-center transition-transform duration-300 ease-out"
                                        :style="{ transform: `rotate(${qiblaDirection}deg)` }"
                                    >
                                        <div class="relative">
                                            <!-- North (red) part of needle -->
                                            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0 border-l-[15px] border-l-transparent border-r-[15px] border-r-transparent border-b-[120px] border-b-emerald-600"></div>
                                            <!-- South (white) part of needle -->
                                            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-0 h-0 border-l-[15px] border-l-transparent border-r-[15px] border-r-transparent border-t-[120px] border-t-gray-300"></div>
                                            <!-- Center dot -->
                                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-4 h-4 bg-white rounded-full border-2 border-emerald-800"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kaaba Icon -->
                                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-emerald-800 pointer-events-none">
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2L4 6v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V6l-8-4zm0 2.18l6 3v4.82c0 4.52-3.13 8.75-6 9.82-2.87-1.07-6-5.3-6-9.82V7.18l6-3z"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Bearing Info -->
                            <div class="mt-8 text-center">
                                <p class="text-sm text-gray-600">Qibla Direction</p>
                                <p class="text-3xl font-bold text-emerald-600">
                                    {{ qiblaBearing.toFixed(1) }}°
                                </p>
                                <p class="text-xs text-gray-500 mt-2">Point your device towards this direction</p>
                            </div>

                            <!-- Calibration Notice -->
                            <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-lg max-w-md">
                                <p class="text-sm text-amber-800">
                                    <strong>Tip:</strong> For best results, hold your device flat and away from magnetic interference. 
                                    Move your device in a figure-8 motion to calibrate the compass.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Smooth animations */
.transition-transform {
    transition-property: transform;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
