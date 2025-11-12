<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
</script>

<template>
    <Head title="Terms of Service" />

    <PublicLayout>
        <div class="py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Terms of Service</h1>
                    <p class="text-gray-600">Last updated: November 12, 2025</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-8 space-y-8">
                    <!-- Introduction -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Agreement to Terms</h2>
                        <p class="text-gray-700 leading-relaxed">
                            By accessing or using Nurtools, you agree to be bound by these Terms of Service and all 
                            applicable laws and regulations. If you do not agree with any of these terms, you are 
                            prohibited from using or accessing this site.
                        </p>
                    </section>

                    <!-- Use License -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Use License</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Permission is granted to use Nurtools for personal, non-commercial purposes. This license 
                            shall automatically terminate if you violate any of these restrictions.
                        </p>
                        <p class="text-gray-700 leading-relaxed mb-4">You may not:</p>
                        <ul class="list-disc list-inside space-y-2 text-gray-700">
                            <li>Modify or copy the materials</li>
                            <li>Use the materials for any commercial purpose</li>
                            <li>Attempt to reverse engineer any software contained in Nurtools</li>
                            <li>Remove any copyright or other proprietary notations</li>
                            <li>Transfer the materials to another person or "mirror" the materials on any other server</li>
                        </ul>
                    </section>

                    <!-- User Accounts -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">User Accounts</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            When you create an account with us, you must provide accurate, complete, and current 
                            information. Failure to do so constitutes a breach of the Terms.
                        </p>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            You are responsible for safeguarding your password and for any activities or actions 
                            under your account. You must notify us immediately upon becoming aware of any breach 
                            of security or unauthorized use of your account.
                        </p>
                    </section>

                    <!-- Premium Services -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Premium Services</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Some features of Nurtools require a paid subscription. By purchasing a premium subscription:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-700 mb-4">
                            <li>You agree to pay all fees and charges associated with your subscription</li>
                            <li>Subscriptions automatically renew unless cancelled before the renewal date</li>
                            <li>You can cancel your subscription at any time from your account settings</li>
                            <li>Refunds are provided within 14 days of purchase if no premium features have been used</li>
                            <li>Premium features are subject to availability and may change</li>
                        </ul>
                    </section>

                    <!-- Accuracy of Tools -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Accuracy of Tools</h2>
                        <p class="text-gray-700 leading-relaxed">
                            While we strive to provide accurate calculations for Qibla direction, Zakaat, and other 
                            Islamic tools, we cannot guarantee 100% accuracy in all situations. Factors such as device 
                            sensors, magnetic interference, and user location accuracy may affect results. Users should 
                            use these tools as a guide and consult with religious scholars for important decisions.
                        </p>
                    </section>

                    <!-- Disclaimer -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Disclaimer</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            The materials on Nurtools are provided on an "as is" basis. Nurtools makes no warranties, 
                            expressed or implied, and hereby disclaims and negates all other warranties including, 
                            without limitation, implied warranties or conditions of merchantability, fitness for a 
                            particular purpose, or non-infringement of intellectual property or other violation of rights.
                        </p>
                    </section>

                    <!-- Limitations -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Limitations of Liability</h2>
                        <p class="text-gray-700 leading-relaxed">
                            In no event shall Nurtools or its suppliers be liable for any damages (including, without 
                            limitation, damages for loss of data or profit, or due to business interruption) arising 
                            out of the use or inability to use Nurtools, even if Nurtools or an authorized representative 
                            has been notified orally or in writing of the possibility of such damage.
                        </p>
                    </section>

                    <!-- User Content -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">User Content</h2>
                        <p class="text-gray-700 leading-relaxed">
                            Users who create accounts may store personal calculation history and preferences. You retain 
                            ownership of any content you submit or store. By using our services, you grant us permission 
                            to use this data to provide and improve our services.
                        </p>
                    </section>

                    <!-- Termination -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Termination</h2>
                        <p class="text-gray-700 leading-relaxed">
                            We may terminate or suspend your account and access to our services immediately, without 
                            prior notice or liability, for any reason, including without limitation if you breach the 
                            Terms of Service. Upon termination, your right to use the services will immediately cease.
                        </p>
                    </section>

                    <!-- Governing Law -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Governing Law</h2>
                        <p class="text-gray-700 leading-relaxed">
                            These Terms shall be governed and construed in accordance with applicable laws, without 
                            regard to its conflict of law provisions. Our failure to enforce any right or provision of 
                            these Terms will not be considered a waiver of those rights.
                        </p>
                    </section>

                    <!-- Changes to Terms -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Changes to Terms</h2>
                        <p class="text-gray-700 leading-relaxed">
                            We reserve the right to modify or replace these Terms at any time. If a revision is material, 
                            we will provide at least 30 days' notice prior to any new terms taking effect. What constitutes 
                            a material change will be determined at our sole discretion. By continuing to access or use 
                            our services after revisions become effective, you agree to be bound by the revised terms.
                        </p>
                    </section>

                    <!-- Contact Information -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Contact Information</h2>
                        <p class="text-gray-700 leading-relaxed">
                            If you have any questions about these Terms of Service, please contact us at:
                        </p>
                        <p class="text-gray-700 mt-2">
                            <strong>Email:</strong> support@nurtools.com
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
