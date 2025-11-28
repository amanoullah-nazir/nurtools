<script setup>
import { ref, onMounted } from 'vue';
import { X, Download } from 'lucide-vue-next';

const showInstallPrompt = ref(false);
const deferredPrompt = ref(null);

onMounted(() => {
    // Listen for the beforeinstallprompt event
    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent the mini-infobar from appearing on mobile
        e.preventDefault();
        // Stash the event so it can be triggered later
        deferredPrompt.value = e;
        // Show the install prompt
        showInstallPrompt.value = true;
    });

    // Check if app is already installed
    window.addEventListener('appinstalled', () => {
        showInstallPrompt.value = false;
        deferredPrompt.value = null;
    });
});

const installApp = async () => {
    if (!deferredPrompt.value) {
        return;
    }

    // Show the install prompt
    deferredPrompt.value.prompt();

    // Wait for the user to respond to the prompt
    const { outcome } = await deferredPrompt.value.userChoice;

    // Clear the deferredPrompt
    deferredPrompt.value = null;
    showInstallPrompt.value = false;

    console.log(`User response to the install prompt: ${outcome}`);
};

const dismissPrompt = () => {
    showInstallPrompt.value = false;
    // Store in localStorage to not show again for 7 days
    localStorage.setItem('pwa-install-dismissed', Date.now().toString());
};

// Check if user dismissed recently
onMounted(() => {
    const dismissed = localStorage.getItem('pwa-install-dismissed');
    if (dismissed) {
        const dismissedTime = parseInt(dismissed);
        const daysSinceDismissed = (Date.now() - dismissedTime) / (1000 * 60 * 60 * 24);
        if (daysSinceDismissed < 7) {
            showInstallPrompt.value = false;
        }
    }
});
</script>

<template>
    <Transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="translate-y-full opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-full opacity-0"
    >
        <div
            v-if="showInstallPrompt"
            class="fixed bottom-0 left-0 right-0 z-50 p-4 bg-white border-t border-gray-200 shadow-lg md:bottom-4 md:left-4 md:right-auto md:max-w-md md:rounded-lg md:border"
        >
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 p-2 bg-emerald-100 rounded-lg">
                    <Download class="w-6 h-6 text-emerald-600" />
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900 mb-1">Install Nurtools</h3>
                    <p class="text-sm text-gray-600 mb-3">
                        Install our app for quick access to Qibla compass and Zakaat calculator, even offline.
                    </p>
                    <div class="flex gap-2">
                        <button
                            @click="installApp"
                            class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition"
                        >
                            Install
                        </button>
                        <button
                            @click="dismissPrompt"
                            class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition"
                        >
                            Not Now
                        </button>
                    </div>
                </div>
                <button
                    @click="dismissPrompt"
                    class="flex-shrink-0 p-1 text-gray-400 hover:text-gray-600 transition"
                >
                    <X class="w-5 h-5" />
                </button>
            </div>
        </div>
    </Transition>
</template>
