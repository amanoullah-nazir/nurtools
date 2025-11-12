<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
</script>

<template>
    <Head title="Privacy Policy" />

    <PublicLayout>
        <div class="py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Privacy Policy</h1>
                    <p class="text-gray-600">Last updated: November 12, 2025</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-8 space-y-8">
                    <!-- Introduction -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Introduction</h2>
                        <p class="text-gray-700 leading-relaxed">
                            At Nurtools, we take your privacy seriously. This Privacy Policy explains how we collect, 
                            use, and protect your personal information when you use our Islamic tools platform.
                        </p>
                    </section>

                    <!-- Information We Collect -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Information We Collect</h2>
                        
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 mt-4">Location Data</h3>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            When you use the Qibla Compass, we request your device's location to calculate the 
                            direction to Makkah. This data is processed in real-time and is not stored on our servers. 
                            Location access is only used when you actively use the Qibla feature and can be revoked 
                            at any time through your browser settings.
                        </p>

                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Account Information</h3>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            If you create an account for premium features, we collect your name, email address, 
                            and password (encrypted). This information is used solely for account management and 
                            service delivery.
                        </p>

                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Usage Data</h3>
                        <p class="text-gray-700 leading-relaxed">
                            We may collect anonymous usage statistics to improve our services, including pages 
                            visited, features used, and general device information. This data is aggregated and 
                            cannot be used to identify individual users.
                        </p>
                    </section>

                    <!-- How We Use Your Information -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">How We Use Your Information</h2>
                        <ul class="list-disc list-inside space-y-2 text-gray-700">
                            <li>To provide and maintain our services</li>
                            <li>To calculate Qibla direction based on your location</li>
                            <li>To manage your account and provide customer support</li>
                            <li>To process premium subscriptions and payments</li>
                            <li>To send service-related notifications (if you have an account)</li>
                            <li>To improve and optimize our tools</li>
                        </ul>
                    </section>

                    <!-- Data Storage and Security -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Data Storage and Security</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            We implement industry-standard security measures to protect your personal information. 
                            All data transmission is encrypted using SSL/TLS. Passwords are hashed and cannot be 
                            viewed by anyone, including our staff.
                        </p>
                        <p class="text-gray-700 leading-relaxed">
                            Location data used for Qibla calculations is processed on-device and through our API 
                            in real-time without persistent storage. Premium user data is stored securely and is 
                            only retained as long as your account is active.
                        </p>
                    </section>

                    <!-- Third-Party Services -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Third-Party Services</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            We use the following third-party services:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-700">
                            <li><strong>Payment Processing:</strong> For premium subscriptions, we use secure payment processors that comply with PCI-DSS standards. We do not store credit card information.</li>
                            <li><strong>Analytics:</strong> We may use privacy-focused analytics to understand how our tools are used, without collecting personally identifiable information.</li>
                        </ul>
                    </section>

                    <!-- Your Rights -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Your Rights</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">You have the right to:</p>
                        <ul class="list-disc list-inside space-y-2 text-gray-700">
                            <li>Access your personal data</li>
                            <li>Correct inaccurate data</li>
                            <li>Request deletion of your account and data</li>
                            <li>Opt-out of marketing communications</li>
                            <li>Export your data</li>
                            <li>Revoke location permissions at any time</li>
                        </ul>
                    </section>

                    <!-- Children's Privacy -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Children's Privacy</h2>
                        <p class="text-gray-700 leading-relaxed">
                            Our services are available to users of all ages. We do not knowingly collect personal 
                            information from children under 13 without parental consent. If you believe we have 
                            collected such information, please contact us immediately.
                        </p>
                    </section>

                    <!-- Changes to This Policy -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Changes to This Policy</h2>
                        <p class="text-gray-700 leading-relaxed">
                            We may update this Privacy Policy from time to time. We will notify users of any 
                            material changes by posting the new policy on this page and updating the "Last updated" 
                            date. Continued use of our services after changes constitutes acceptance of the updated policy.
                        </p>
                    </section>

                    <!-- Contact Us -->
                    <section>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Contact Us</h2>
                        <p class="text-gray-700 leading-relaxed">
                            If you have any questions about this Privacy Policy or our data practices, please contact us at:
                        </p>
                        <p class="text-gray-700 mt-2">
                            <strong>Email:</strong> privacy@nurtools.com
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>
