<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'userType', 'name', 'email', 'organizationName', 'primarySpecialty' => '','primaryState'=>'',
    'primaryState', 'specialties' => [], 'states' => [], 'dateOfBirth' => '', 'ssn' => '', 'homeAddress' => '',
    'practiceAddress' => '', 'phoneNumber' => '', 'npiNumber' => '', 'caqhId' => '',
    'caqhLogin' => '', 'caqhPassword' => '', 'pecosLogin' => '', 'pecosPassword' => '',
    'stateLicenses' => [], 'educations' => [], 'deaNumber' => '', 'deaExpiration' => '',
    'workHistory' => [], 'references' => [], 'insuranceCarrier' => '', 'policyNumber' => '',
    'coverageAmount' => '', 'policyEffectiveDate' => '', 'policyExpirationDate' => '',
    'licenseSuspended' => null, 'felonyConviction' => null, 'malpracticeClaims' => null
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'userType', 'name', 'email', 'organizationName', 'primarySpecialty' => '','primaryState'=>'',
    'primaryState', 'specialties' => [], 'states' => [], 'dateOfBirth' => '', 'ssn' => '', 'homeAddress' => '',
    'practiceAddress' => '', 'phoneNumber' => '', 'npiNumber' => '', 'caqhId' => '',
    'caqhLogin' => '', 'caqhPassword' => '', 'pecosLogin' => '', 'pecosPassword' => '',
    'stateLicenses' => [], 'educations' => [], 'deaNumber' => '', 'deaExpiration' => '',
    'workHistory' => [], 'references' => [], 'insuranceCarrier' => '', 'policyNumber' => '',
    'coverageAmount' => '', 'policyEffectiveDate' => '', 'policyExpirationDate' => '',
    'licenseSuspended' => null, 'felonyConviction' => null, 'malpracticeClaims' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<!-- Step 7: Final Review & E-Sign -->
<div>
    <h2 class="text-2xl font-bold text-text-primary mb-6">
        Final Review
    </h2>
    <p class="text-text-secondary mb-8">
        Please review all information for accuracy before submitting. You can edit any section by clicking the 'Edit' button.
    </p>

    <!-- Core Profile Section -->
    <div class="bg-white border border-border rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-text-primary">Core Profile</h3>
            <button type="button"
                    wire:click="goToStep(1)"
                    class="text-primary-600 hover:text-primary-700 font-medium">
                Edit
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium text-text-primary">Full Name:</span>
                <span class="ml-2 text-text-secondary"><?php echo e($name ?: 'Not provided'); ?></span>
            </div>
            <div>
                <span class="font-medium text-text-primary">Email:</span>
                <span class="ml-2 text-text-secondary"><?php echo e($email ?: 'Not provided'); ?></span>
            </div>
            <div>
                <span class="font-medium text-text-primary"><?php echo e($userType === 'doctor' ? 'Organization Name' : 'Clinic Name'); ?>:</span>
                <span class="ml-2 text-text-secondary"><?php echo e($organizationName ?: 'Not provided'); ?></span>
            </div>
            <div>
                <span class="font-medium text-text-primary">Primary Specialty:</span>
                <span class="ml-2 text-text-secondary"><?php echo e($primarySpecialty ? $specialties->find($primarySpecialty)?->name : 'Not provided'); ?></span>
            </div>
            <div>
                <span class="font-medium text-text-primary">Primary State:</span>
                <span class="ml-2 text-text-secondary"><?php echo e($primaryState ? $states->where('id', $primaryState)->first()?->name : 'Not provided'); ?></span>
            </div>
        </div>
    </div>

    <!-- Personal & Contact Section -->
    <div class="bg-white border border-border rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-text-primary">Personal & Contact</h3>
            <button type="button"
                    wire:click="goToStep(2)"
                    class="text-primary-600 hover:text-primary-700 font-medium">
                Edit
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium text-text-primary">Date of Birth:</span>
                <span class="ml-2 text-text-secondary"><?php echo e($dateOfBirth ?: 'Not provided'); ?></span>
            </div>
            <div>
                <span class="font-medium text-text-primary">SSN:</span>
                <span class="ml-2 text-text-secondary"><?php echo e($ssn ? '***-**-****' : 'Not provided'); ?></span>
            </div>
            <div class="lg:col-span-2">
                <span class="font-medium text-text-primary">Home Address:</span>
                <span class="ml-2 text-text-secondary"><?php echo e($homeAddress ?: 'Not provided'); ?></span>
            </div>
            <div class="lg:col-span-2">
                <span class="font-medium text-text-primary">Practice Address:</span>
                <span class="ml-2 text-text-secondary"><?php echo e($practiceAddress ?: 'Not provided'); ?></span>
            </div>
            <div>
                <span class="font-medium text-text-primary">Phone:</span>
                <span class="ml-2 text-text-secondary"><?php echo e($phoneNumber ?: 'Not provided'); ?></span>
            </div>
            <div>
                <span class="font-medium text-text-primary">NPI:</span>
                <span class="ml-2 text-text-secondary"><?php echo e($npiNumber ?: 'Not provided'); ?></span>
            </div>
            <!--[if BLOCK]><![endif]--><?php if($caqhId): ?>
                <div>
                    <span class="font-medium text-text-primary">CAQH ID:</span>
                    <span class="ml-2 text-text-secondary"><?php echo e($caqhId); ?></span>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>

    <!-- Credentials Section -->
    <div class="bg-white border border-border rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-text-primary">Credentials</h3>
            <button type="button"
                    wire:click="goToStep(3)"
                    class="text-primary-600 hover:text-primary-700 font-medium">
                Edit
            </button>
        </div>

        <!--[if BLOCK]><![endif]--><?php if(count($stateLicenses) > 0 && $stateLicenses[0]['state']): ?>
            <div class="mb-4">
                <h4 class="font-medium text-text-primary mb-2">State Licenses:</h4>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stateLicenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $license): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <!--[if BLOCK]><![endif]--><?php if($license['state']): ?>
                        <div class="text-sm text-text-secondary mb-1">
                            <?php echo e($states->where('code', $license['state'])->first()?->name); ?> - <?php echo e($license['license_number'] ?: 'No number provided'); ?>

                            <!--[if BLOCK]><![endif]--><?php if($license['expiration_date']): ?>
                                (Expires: <?php echo e($license['expiration_date']); ?>)
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!--[if BLOCK]><![endif]--><?php if(count($educations) > 0 && $educations[0]['institution']): ?>
            <div class="mb-4">
                <h4 class="font-medium text-text-primary mb-2">Education:</h4>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $educations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $education): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <!--[if BLOCK]><![endif]--><?php if($education['institution']): ?>
                        <div class="text-sm text-text-secondary mb-1">
                            <?php echo e($education['degree']); ?> - <?php echo e($education['institution']); ?>

                            <!--[if BLOCK]><![endif]--><?php if($education['year_completed']): ?>
                                (<?php echo e($education['year_completed']); ?>)
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!--[if BLOCK]><![endif]--><?php if($deaNumber): ?>
            <div class="text-sm">
                <span class="font-medium text-text-primary">DEA Number:</span>
                <span class="ml-2 text-text-secondary"><?php echo e($deaNumber); ?></span>
                <!--[if BLOCK]><![endif]--><?php if($deaExpiration): ?>
                    <span class="text-text-secondary">(Expires: <?php echo e($deaExpiration); ?>)</span>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!-- Professional History Section -->
    <div class="bg-white border border-border rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-text-primary">Professional History</h3>
            <button type="button"
                    wire:click="goToStep(4)"
                    class="text-primary-600 hover:text-primary-700 font-medium">
                Edit
            </button>
        </div>

        <!--[if BLOCK]><![endif]--><?php if(count($workHistory) > 0 && !empty($workHistory[0]['employer'])): ?>
            <div class="mb-4">
                <h4 class="font-medium text-text-primary mb-2">Work History:</h4>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $workHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $work): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <!--[if BLOCK]><![endif]--><?php if(!empty($work['employer'])): ?>
                        <div class="text-sm text-text-secondary mb-2">
                            <strong><?php echo e($work['position'] ?? 'N/A'); ?></strong> at <?php echo e($work['employer']); ?>

                            <!--[if BLOCK]><![endif]--><?php if(!empty($work['start_date']) || !empty($work['end_date'])): ?>
                                <br><span class="text-xs"><?php echo e($work['start_date'] ?? ''); ?> - <?php echo e($work['end_date'] ?: 'Present'); ?></span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!--[if BLOCK]><![endif]--><?php if(count($references) > 0 && !empty($references[0]['name'])): ?>
            <div>
                <h4 class="font-medium text-text-primary mb-2">References:</h4>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $references; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reference): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <!--[if BLOCK]><![endif]--><?php if(!empty($reference['name'])): ?>
                        <div class="text-sm text-text-secondary mb-2">
                            <?php echo e($reference['name']); ?><?php echo e(!empty($reference['relationship']) ? ', ' . $reference['relationship'] : ''); ?>

                            <!--[if BLOCK]><![endif]--><?php if(!empty($reference['phone']) || !empty($reference['email'])): ?>
                                <br><span class="text-xs">
                                    <?php if(!empty($reference['phone'])): ?>Phone: <?php echo e($reference['phone']); ?><?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php if(!empty($reference['phone']) && !empty($reference['email'])): ?> | <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($reference['email'])): ?>Email: <?php echo e($reference['email']); ?><?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!-- Insurance & Attestation Section -->
    <!--[if BLOCK]><![endif]--><?php if($insuranceCarrier || $policyNumber): ?>
        <div class="bg-white border border-border rounded-lg p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-text-primary">Insurance & Attestation</h3>
                <button type="button"
                        wire:click="goToStep(5)"
                        class="text-primary-600 hover:text-primary-700 font-medium">
                    Edit
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 text-sm">
                <!--[if BLOCK]><![endif]--><?php if($insuranceCarrier): ?>
                    <div>
                        <span class="font-medium text-text-primary">Insurance Carrier:</span>
                        <span class="ml-2 text-text-secondary"><?php echo e($insuranceCarrier); ?></span>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <!--[if BLOCK]><![endif]--><?php if($policyNumber): ?>
                    <div>
                        <span class="font-medium text-text-primary">Policy Number:</span>
                        <span class="ml-2 text-text-secondary"><?php echo e($policyNumber); ?></span>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <!--[if BLOCK]><![endif]--><?php if($coverageAmount): ?>
                    <div>
                        <span class="font-medium text-text-primary">Coverage Amount:</span>
                        <span class="ml-2 text-text-secondary"><?php echo e($coverageAmount); ?></span>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- E-Signature Section -->
    <div class="bg-white border border-border rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-text-primary mb-4">E-Signature</h3>

        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <p class="text-sm text-text-secondary">
                By checking the box below, you attest that the information provided is accurate and complete to the best of your knowledge. You authorize PayerReady to use this information to perform credentialing services on your behalf.
            </p>
        </div>

        <!-- Terms Agreement -->
        <div class="mb-6">
            <label class="flex items-start gap-3 cursor-pointer">
                <input
                    type="checkbox"
                    wire:model="agreeToTerms"
                    class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                />
                <span class="text-sm text-text-primary">
                    I agree to the terms and electronically sign this document.
                </span>
            </label>
            <?php if (isset($component)) { $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.error','data' => ['name' => 'agreeToTerms']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'agreeToTerms']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $attributes = $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $component = $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
        </div>

        <!-- Electronic Signature -->
        <div>
            <?php if (isset($component)) { $__componentOriginalb2c43a998f3174877f99993c62e16bb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb2c43a998f3174877f99993c62e16bb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.label','data' => ['for' => 'eSignature']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'eSignature']); ?>
                Type your full name to sign *
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $attributes = $__attributesOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $component = $__componentOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__componentOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.input.index','data' => ['type' => 'text','id' => 'eSignature','wire:model' => 'eSignature','placeholder' => 'Your Full Name']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','id' => 'eSignature','wire:model' => 'eSignature','placeholder' => 'Your Full Name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $attributes = $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $component = $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.error','data' => ['name' => 'eSignature']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'eSignature']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $attributes = $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $component = $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
        </div>
    </div>

    <!-- Final Submission Note -->
    <div class="bg-success-50 border border-success-200 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-success-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-success-800">Ready to Submit</h3>
                <p class="text-sm text-success-700 mt-1">Once you submit your profile, our team will begin the credentialing process. You'll receive email updates throughout the process and can track progress in your dashboard.</p>
            </div>
        </div>
    </div>
</div>
<?php /**PATH E:\payer-ready\resources\views/components/auth/review-sign-form.blade.php ENDPATH**/ ?>