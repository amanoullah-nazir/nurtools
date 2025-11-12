<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Loader2, AlertCircle, Navigation, MapPin } from 'lucide-vue-next';

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
const retryCount = ref(0);
const maxRetries = 3;

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
            navigator.geolocation.getCurrentPosition(
                resolve, 
                (err) => {
                    // Retry on kCLErrorLocationUnknown (error code 0)
                    if (err.code === 2 && retryCount.value < maxRetries) {
                        retryCount.value++;
                        console.log(`Location unavailable, retrying... (${retryCount.value}/${maxRetries})`);
                        // Wait a bit before retrying
                        setTimeout(() => getUserLocation(), 2000);
                        return;
                    }
                    reject(err);
                }, 
                {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 0,
                }
            );
        });

        userLocation.value = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
            accuracy: position.coords.accuracy,
        };

        retryCount.value = 0; // Reset retry count on success
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
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
        
        const response = await fetch('/api/qibla/calculate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                ...(csrfToken && { 'X-CSRF-TOKEN': csrfToken }),
            },
            body: JSON.stringify({
                latitude: userLocation.value.lat,
                longitude: userLocation.value.lng,
            }),
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

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
        case 1: // PERMISSION_DENIED
            return 'Location permission denied. Please enable location services in your browser or device settings.';
        case 2: // POSITION_UNAVAILABLE
            return 'Unable to determine your location. Please ensure you are outdoors or near a window, and that location services are enabled.';
        case 3: // TIMEOUT
            return 'Location request timed out. Please check your internet connection and try again.';
        default:
            return 'Unable to get your location. Please ensure location services are enabled and try again.';
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
    retryCount.value = 0;
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

    <PublicLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Qibla Compass</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        
                        <!-- Loading State -->
                        <div v-if="loading" class="text-center py-12">
                            <Loader2 :size="48" class="mx-auto text-emerald-600 animate-spin" :stroke-width="2" />
                            <p class="mt-4 text-gray-600">Getting your location...</p>
                            <p v-if="retryCount > 0" class="mt-2 text-sm text-gray-500">
                                Retrying... ({{ retryCount }}/{{ maxRetries }})
                            </p>
                            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg max-w-md mx-auto">
                                <p class="text-sm text-blue-800">
                                    <strong>Having trouble?</strong> Make sure location services are enabled and you're outdoors or near a window.
                                </p>
                            </div>
                        </div>

                        <!-- Error State -->
                        <div v-else-if="error" class="text-center py-12">
                            <AlertCircle :size="64" class="mx-auto text-red-600 mb-4" :stroke-width="2" />
                            <p class="text-gray-700 mb-4">{{ error }}</p>
                            <button 
                                @click="retry"
                                class="bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700 transition"
                            >
                                Try Again
                            </button>
                            
                            <!-- Help Tips -->
                            <div class="mt-8 p-6 bg-gray-50 border border-gray-200 rounded-lg max-w-md mx-auto text-left">
                                <h3 class="font-semibold text-gray-900 mb-3">Troubleshooting Tips:</h3>
                                <ul class="space-y-2 text-sm text-gray-700">
                                    <li class="flex items-start">
                                        <span class="mr-2">•</span>
                                        <span>Make sure location services are enabled in your device settings</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="mr-2">•</span>
                                        <span>Check that your browser has permission to access location</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="mr-2">•</span>
                                        <span>Try moving outdoors or near a window for better GPS signal</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="mr-2">•</span>
                                        <span>Ensure you have an active internet connection</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="mr-2">•</span>
                                        <span>On iOS: Settings → Safari → Location → Allow</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Compass -->
                        <div v-else class="flex flex-col items-center">
                            
                            <!-- Location Info -->
                            <div class="w-full mb-8 text-center">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <MapPin :size="20" class="text-gray-600" :stroke-width="2" />
                                    <p class="text-sm text-gray-600">Your Location</p>
                                </div>
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
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <Navigation :size="20" class="text-gray-600" :stroke-width="2" />
                                    <p class="text-sm text-gray-600">Qibla Direction</p>
                                </div>
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
    </PublicLayout>
</template>

<style scoped>
/* Smooth animations */
.transition-transform {
    transition-property: transform;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
