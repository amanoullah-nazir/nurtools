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
    if (!userLocation.value || deviceHeading.value === null) return 0;
    // Calculate the direction the compass needle should point
    // Subtract device heading from Qibla bearing to get relative direction
    let direction = qiblaBearing.value - deviceHeading.value;
    // Normalize to 0-360 range
    direction = ((direction % 360) + 360) % 360;
    return direction;
});

const compassRotation = computed(() => {
    // Rotate the entire compass to match device heading
    return -deviceHeading.value;
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
    let heading = null;
    
    if (event.webkitCompassHeading !== undefined) {
        // iOS Safari - webkitCompassHeading gives true heading
        heading = event.webkitCompassHeading;
    } else if (event.alpha !== null) {
        // Android Chrome - use alpha for heading
        // Alpha ranges from 0-360 where 0/360 is North
        heading = 360 - event.alpha;
        
        // Adjust for absolute orientation if available
        if (event.absolute && event.webkitCompassAccuracy !== undefined) {
            heading = event.alpha;
        }
    }
    
    if (heading !== null) {
        // Normalize to 0-360
        heading = ((heading % 360) + 360) % 360;
        deviceHeading.value = heading;
        calibrating.value = false;
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
                                <!-- Compass Background with Cardinal Directions (rotates with device) -->
                                <div 
                                    class="absolute inset-0 rounded-full border-8 border-emerald-600 bg-gradient-to-br from-emerald-50 to-white shadow-2xl transition-transform duration-300 ease-out"
                                    :style="{ transform: `rotate(${compassRotation}deg)` }"
                                >
                                    <!-- Cardinal directions -->
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="relative w-full h-full">
                                            <div class="absolute top-4 left-1/2 -translate-x-1/2 font-bold text-2xl text-emerald-800">N</div>
                                            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 font-bold text-xl text-gray-600">S</div>
                                            <div class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-xl text-gray-600">W</div>
                                            <div class="absolute right-4 top-1/2 -translate-y-1/2 font-bold text-xl text-gray-600">E</div>
                                        </div>
                                    </div>

                                    <!-- Degree markings -->
                                    <div class="absolute inset-8">
                                        <div v-for="deg in 36" :key="deg" 
                                            class="absolute top-1/2 left-1/2 -translate-y-1/2 origin-left"
                                            :style="{ transform: `translate(-50%, -50%) rotate(${(deg - 1) * 10}deg)`, transformOrigin: 'left center' }">
                                            <div class="h-0.5 bg-gray-400" 
                                                :class="deg % 9 === 1 ? 'w-8 opacity-80' : deg % 3 === 1 ? 'w-6 opacity-60' : 'w-4 opacity-40'"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fixed Qibla Needle (points to Qibla relative to North) -->
                                <div 
                                    class="absolute inset-0 flex items-center justify-center transition-transform duration-500 ease-out pointer-events-none"
                                    :style="{ transform: `rotate(${qiblaBearing}deg)` }"
                                >
                                    <div class="relative">
                                        <!-- Qibla direction indicator (green arrow pointing to Kaaba) -->
                                        <div class="absolute bottom-0 left-1/2 -translate-x-1/2">
                                            <svg class="w-12 h-32" viewBox="0 0 48 128" fill="none">
                                                <!-- Arrow shaft -->
                                                <rect x="18" y="20" width="12" height="80" fill="#059669" rx="2"/>
                                                <!-- Arrow head -->
                                                <path d="M24 0 L48 28 L24 20 L0 28 Z" fill="#059669"/>
                                                <!-- Kaaba icon at base -->
                                                <circle cx="24" cy="110" r="14" fill="#047857"/>
                                                <rect x="18" y="104" width="12" height="12" fill="white" opacity="0.9"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Center circle -->
                                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-8 h-8 bg-white rounded-full border-4 border-emerald-800 shadow-lg z-10"></div>

                                <!-- Device heading indicator (fixed at top) -->
                                <div class="absolute top-2 left-1/2 -translate-x-1/2 z-20">
                                    <div class="w-1 h-6 bg-red-600 rounded-full shadow-lg"></div>
                                </div>
                            </div>

                            <!-- Bearing Info -->
                            <div class="mt-8 grid grid-cols-2 gap-4 w-full max-w-md">
                                <div class="text-center p-4 bg-emerald-50 rounded-lg border border-emerald-200">
                                    <div class="flex items-center justify-center gap-2 mb-2">
                                        <Navigation :size="18" class="text-emerald-600" :stroke-width="2" />
                                        <p class="text-xs font-medium text-emerald-700">Qibla</p>
                                    </div>
                                    <p class="text-2xl font-bold text-emerald-600">
                                        {{ qiblaBearing.toFixed(1) }}°
                                    </p>
                                </div>
                                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center justify-center gap-2 mb-2">
                                        <Navigation :size="18" class="text-gray-600" :stroke-width="2" />
                                        <p class="text-xs font-medium text-gray-700">Heading</p>
                                    </div>
                                    <p class="text-2xl font-bold text-gray-600">
                                        {{ deviceHeading.toFixed(1) }}°
                                    </p>
                                </div>
                            </div>

                            <!-- Instructions -->
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-600">
                                    Hold your device flat and rotate until the green arrow points up
                                </p>
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
