<script setup>
import { ref, computed } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Calculator, Info, DollarSign, TrendingUp, Coins, Briefcase, Wallet, CreditCard } from 'lucide-vue-next';

// Form data
const cash = ref('');
const bankBalance = ref('');
const gold = ref('');
const silver = ref('');
const investments = ref('');
const businessAssets = ref('');
const otherAssets = ref('');
const debts = ref('');

// Results
const result = ref(null);
const calculating = ref(false);
const showResults = ref(false);

// Nisab threshold (approximate value in USD)
// Based on 85g of gold or 595g of silver
const NISAB_THRESHOLD = 5000;

// Calculate total assets
const totalAssets = computed(() => {
    return parseFloat(cash.value || 0) + 
           parseFloat(bankBalance.value || 0) + 
           parseFloat(gold.value || 0) + 
           parseFloat(silver.value || 0) + 
           parseFloat(investments.value || 0) + 
           parseFloat(businessAssets.value || 0) + 
           parseFloat(otherAssets.value || 0);
});

// Calculate Zakaat
const calculateZakaat = () => {
    calculating.value = true;
    showResults.value = false;

    // Small delay to show loading state
    setTimeout(() => {
        const assets = {
            cash: parseFloat(cash.value || 0),
            bankBalance: parseFloat(bankBalance.value || 0),
            gold: parseFloat(gold.value || 0),
            silver: parseFloat(silver.value || 0),
            investments: parseFloat(investments.value || 0),
            businessAssets: parseFloat(businessAssets.value || 0),
            otherAssets: parseFloat(otherAssets.value || 0),
            debts: parseFloat(debts.value || 0),
        };

        // Calculate totals
        const totalAssetsValue = assets.cash + assets.bankBalance + assets.gold 
                               + assets.silver + assets.investments + assets.businessAssets 
                               + assets.otherAssets;
        
        const totalDeductions = assets.debts;
        const zakaatableAmount = totalAssetsValue - totalDeductions;

        // Calculate Zakaat (2.5%)
        let zakaatDue = 0;
        let isZakaatDue = false;

        if (zakaatableAmount >= NISAB_THRESHOLD) {
            zakaatDue = zakaatableAmount * 0.025; // 2.5%
            isZakaatDue = true;
        }

        result.value = {
            totalAssets: totalAssetsValue,
            totalDeductions: totalDeductions,
            zakaatableAmount: zakaatableAmount,
            nisab: NISAB_THRESHOLD,
            isZakaatDue: isZakaatDue,
            zakaatDue: zakaatDue,
            breakdown: assets,
        };

        showResults.value = true;
        calculating.value = false;
    }, 300);
};

// Reset form
const resetForm = () => {
    cash.value = '';
    bankBalance.value = '';
    gold.value = '';
    silver.value = '';
    investments.value = '';
    businessAssets.value = '';
    otherAssets.value = '';
    debts.value = '';
    result.value = null;
    showResults.value = false;
};

// Format currency
const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2,
    }).format(amount);
};
</script>

<template>
    <Head title="Zakaat Calculator" />

    <PublicLayout>
        <div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-12">
                    <div class="flex justify-center mb-4">
                        <div class="bg-emerald-600 p-4 rounded-full">
                            <Calculator class="w-12 h-12 text-white" />
                        </div>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Zakaat Calculator</h1>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Calculate your obligatory Zakaat (2.5%) on eligible wealth that has been in your possession for one lunar year.
                    </p>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded-r-lg">
                    <div class="flex items-start">
                        <Info class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" />
                        <div class="text-sm text-blue-800">
                            <p class="font-semibold mb-1">What is Zakaat?</p>
                            <p>Zakaat is one of the Five Pillars of Islam. It is an obligatory charity (2.5%) on wealth that exceeds the Nisab threshold and has been in possession for one lunar year (Hawl).</p>
                        </div>
                    </div>
                </div>

                <!-- Calculator Form -->
                <div class="bg-white shadow-xl rounded-2xl p-8 mb-8">
                    <form @submit.prevent="calculateZakaat">
                        <div class="space-y-8">
                            <!-- Assets Section -->
                            <div>
                                <h2 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
                                    <Wallet class="w-6 h-6 mr-2 text-emerald-600" />
                                    Your Assets
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Cash -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <DollarSign class="w-4 h-4 inline mr-1" />
                                            Cash in Hand
                                        </label>
                                        <input
                                            v-model="cash"
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            placeholder="0.00"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        />
                                    </div>

                                    <!-- Bank Balance -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <CreditCard class="w-4 h-4 inline mr-1" />
                                            Bank Balance
                                        </label>
                                        <input
                                            v-model="bankBalance"
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            placeholder="0.00"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        />
                                    </div>

                                    <!-- Gold -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <Coins class="w-4 h-4 inline mr-1" />
                                            Gold (Value)
                                        </label>
                                        <input
                                            v-model="gold"
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            placeholder="0.00"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        />
                                    </div>

                                    <!-- Silver -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <Coins class="w-4 h-4 inline mr-1" />
                                            Silver (Value)
                                        </label>
                                        <input
                                            v-model="silver"
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            placeholder="0.00"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        />
                                    </div>

                                    <!-- Investments -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <TrendingUp class="w-4 h-4 inline mr-1" />
                                            Investments & Stocks
                                        </label>
                                        <input
                                            v-model="investments"
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            placeholder="0.00"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        />
                                    </div>

                                    <!-- Business Assets -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            <Briefcase class="w-4 h-4 inline mr-1" />
                                            Business Assets
                                        </label>
                                        <input
                                            v-model="businessAssets"
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            placeholder="0.00"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        />
                                    </div>

                                    <!-- Other Assets -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Other Assets
                                        </label>
                                        <input
                                            v-model="otherAssets"
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            placeholder="0.00"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- Deductions Section -->
                            <div>
                                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Deductions</h2>

                                <div class="grid grid-cols-1 gap-6">
                                    <!-- Debts -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Outstanding Debts & Liabilities
                                        </label>
                                        <input
                                            v-model="debts"
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            placeholder="0.00"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- Total Assets Display -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="flex justify-between items-center text-lg">
                                    <span class="font-medium text-gray-700">Total Assets:</span>
                                    <span class="font-bold text-gray-900">{{ formatCurrency(totalAssets) }}</span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-4">
                                <button
                                    type="submit"
                                    :disabled="calculating"
                                    class="flex-1 bg-emerald-600 text-white py-4 px-6 rounded-lg font-semibold hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                >
                                    <span v-if="calculating">Calculating...</span>
                                    <span v-else>Calculate Zakaat</span>
                                </button>

                                <button
                                    type="button"
                                    @click="resetForm"
                                    class="px-6 py-4 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors"
                                >
                                    Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Results -->
                <div v-if="showResults && result" class="bg-white shadow-xl rounded-2xl p-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Your Zakaat Calculation</h2>

                    <div class="space-y-4">
                        <!-- Total Assets -->
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">Total Assets</span>
                            <span class="font-semibold text-gray-900">{{ formatCurrency(result.totalAssets) }}</span>
                        </div>

                        <!-- Total Deductions -->
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">Total Deductions</span>
                            <span class="font-semibold text-red-600">-{{ formatCurrency(result.totalDeductions) }}</span>
                        </div>

                        <!-- Zakatable Amount -->
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700 font-medium">Zakatable Amount</span>
                            <span class="font-semibold text-gray-900">{{ formatCurrency(result.zakaatableAmount) }}</span>
                        </div>

                        <!-- Nisab Threshold -->
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-700">Nisab Threshold</span>
                            <span class="font-semibold text-gray-900">{{ formatCurrency(result.nisab) }}</span>
                        </div>

                        <!-- Zakaat Due -->
                        <div v-if="result.isZakaatDue" class="bg-emerald-50 rounded-lg p-6 mt-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-emerald-700 mb-1">Zakaat Due (2.5%)</p>
                                    <p class="text-3xl font-bold text-emerald-600">{{ formatCurrency(result.zakaatDue) }}</p>
                                </div>
                                <Calculator class="w-12 h-12 text-emerald-600" />
                            </div>
                            <p class="text-sm text-emerald-700 mt-4">
                                Your wealth exceeds the Nisab threshold. Zakaat is obligatory on you.
                            </p>
                        </div>

                        <!-- No Zakaat Due -->
                        <div v-else class="bg-blue-50 rounded-lg p-6 mt-6">
                            <div class="flex items-center">
                                <Info class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0" />
                                <div>
                                    <p class="font-semibold text-blue-900 mb-1">No Zakaat Due</p>
                                    <p class="text-sm text-blue-700">
                                        Your wealth is below the Nisab threshold. Zakaat is not obligatory at this time.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Educational Info -->
                <div class="mt-8 bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Understanding Zakaat</h3>
                    <div class="space-y-3 text-sm text-gray-600">
                        <p><strong>Nisab:</strong> The minimum amount of wealth one must possess for Zakaat to be obligatory. It is equivalent to 85 grams of gold or 595 grams of silver.</p>
                        <p><strong>Hawl:</strong> The lunar year (354 days) that wealth must be held before Zakaat becomes due.</p>
                        <p><strong>Rate:</strong> Zakaat is calculated at 2.5% (1/40) of eligible wealth.</p>
                        <p><strong>Note:</strong> This calculator provides a basic estimation. For precise calculations, especially regarding business assets and complex financial situations, please consult a qualified Islamic scholar.</p>
                    </div>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
