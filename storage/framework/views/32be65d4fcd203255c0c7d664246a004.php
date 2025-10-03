<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex gap-8">
            <!-- Smart Checklist Sidebar -->
            <div class="w-80 bg-white rounded-xl shadow-sm border border-border p-6 h-fit">
                <h3 class="text-lg font-bold text-text-primary mb-6">Your Smart Checklist</h3>
                <div class="space-y-3">
                    <!-- Step 1: Welcome & Core Profile -->
                    <div class="flex items-center gap-3 p-3 rounded-lg cursor-pointer <?php echo e($currentStep >= 1 ? 'bg-success-50' : 'bg-gray-50'); ?>"
                         wire:click="goToStep(1)">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center <?php echo e($currentStep > 1 ? 'bg-success-500 text-white' : ($currentStep == 1 ? 'bg-primary-500 text-white' : 'bg-gray-300 text-gray-500')); ?>">
                            <!--[if BLOCK]><![endif]--><?php if($currentStep > 1): ?>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            <?php else: ?>
                                1
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <span class="font-medium text-text-primary">Welcome & Core Profile</span>
                    </div>

                    <!-- Step 2: Personal & Contact -->
                    <div class="flex items-center gap-3 p-3 rounded-lg cursor-pointer <?php echo e($currentStep >= 2 ? 'bg-success-50' : 'bg-gray-50'); ?>"
                         wire:click="goToStep(2)">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center <?php echo e($currentStep > 2 ? 'bg-success-500 text-white' : ($currentStep == 2 ? 'bg-primary-500 text-white' : 'bg-gray-300 text-gray-500')); ?>">
                            <!--[if BLOCK]><![endif]--><?php if($currentStep > 2): ?>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            <?php else: ?>
                                2
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <span class="font-medium text-text-primary">Personal & Contact</span>
                    </div>

                    <!-- Step 3: Credentials & Licenses -->
                    <div class="flex items-center gap-3 p-3 rounded-lg cursor-pointer <?php echo e($currentStep >= 3 ? 'bg-success-50' : 'bg-gray-50'); ?>"
                         wire:click="goToStep(3)">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center <?php echo e($currentStep > 3 ? 'bg-success-500 text-white' : ($currentStep == 3 ? 'bg-primary-500 text-white' : 'bg-gray-300 text-gray-500')); ?>">
                            <!--[if BLOCK]><![endif]--><?php if($currentStep > 3): ?>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            <?php else: ?>
                                3
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <span class="font-medium text-text-primary">Credentials & Licenses</span>
                    </div>

                    <!-- Step 4: Professional History -->
                    <div class="flex items-center gap-3 p-3 rounded-lg cursor-pointer <?php echo e($currentStep >= 4 ? 'bg-success-50' : 'bg-gray-50'); ?>"
                         wire:click="goToStep(4)">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center <?php echo e($currentStep > 4 ? 'bg-success-500 text-white' : ($currentStep == 4 ? 'bg-primary-500 text-white' : 'bg-gray-300 text-gray-500')); ?>">
                            <!--[if BLOCK]><![endif]--><?php if($currentStep > 4): ?>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            <?php else: ?>
                                4
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <span class="font-medium text-text-primary">Professional History</span>
                    </div>

                    <!-- Step 5: Insurance & Attestation -->
                    <div class="flex items-center gap-3 p-3 rounded-lg cursor-pointer <?php echo e($currentStep >= 5 ? 'bg-success-50' : 'bg-gray-50'); ?>"
                         wire:click="goToStep(5)">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center <?php echo e($currentStep > 5 ? 'bg-success-500 text-white' : ($currentStep == 5 ? 'bg-primary-500 text-white' : 'bg-gray-300 text-gray-500')); ?>">
                            <!--[if BLOCK]><![endif]--><?php if($currentStep > 5): ?>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            <?php else: ?>
                                5
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <span class="font-medium text-text-primary">Insurance & Attestation</span>
                    </div>

                    <!-- Step 6: Document Upload -->
                    <div class="flex items-center gap-3 p-3 rounded-lg cursor-pointer <?php echo e($currentStep >= 6 ? 'bg-success-50' : 'bg-gray-50'); ?>"
                         wire:click="goToStep(6)">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center <?php echo e($currentStep > 6 ? 'bg-success-500 text-white' : ($currentStep == 6 ? 'bg-primary-500 text-white' : 'bg-gray-300 text-gray-500')); ?>">
                            <!--[if BLOCK]><![endif]--><?php if($currentStep > 6): ?>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            <?php else: ?>
                                6
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <span class="font-medium text-text-primary">Document Upload</span>
                    </div>

                    <!-- Step 7: Review & E-Sign -->
                    <div class="flex items-center gap-3 p-3 rounded-lg cursor-pointer <?php echo e($currentStep >= 7 ? 'bg-success-50' : 'bg-gray-50'); ?>"
                         wire:click="goToStep(7)">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center <?php echo e($currentStep > 7 ? 'bg-success-500 text-white' : ($currentStep == 7 ? 'bg-primary-500 text-white' : 'bg-gray-300 text-gray-500')); ?>">
                            <!--[if BLOCK]><![endif]--><?php if($currentStep > 7): ?>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            <?php else: ?>
                                7
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <span class="font-medium text-text-primary">Review & E-Sign</span>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1">
                <div class="bg-white rounded-xl shadow-sm border border-border p-8">
                    <!-- Optional Information Banner -->
                    <!--[if BLOCK]><![endif]--><?php if($currentStep != 7): ?>
                        <div class="bg-primary-50 border border-primary-200 rounded-lg p-4 mb-6">
                            <div class="flex">
                                <svg class="w-5 h-5 text-primary-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h3 class="text-sm font-medium text-primary-800">Optional Information</h3>
                                    <p class="text-sm text-primary-700 mt-1">Don't have the details handy? No problem. You can skip these for now and add them later from your dashboard.</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!-- Step Content -->
                    <div class="min-h-96">
                        <!--[if BLOCK]><![endif]--><?php if($currentStep == 1): ?>
                            <?php if (isset($component)) { $__componentOriginalfb4bf9120334bf610bcaf3fa153db8aa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfb4bf9120334bf610bcaf3fa153db8aa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth.organization-sign-up-form','data' => ['userType' => $userType,'specialties' => $specialties,'states' => $states,'errors' => $errors]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth.organization-sign-up-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['userType' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($userType),'specialties' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($specialties),'states' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($states),'errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfb4bf9120334bf610bcaf3fa153db8aa)): ?>
<?php $attributes = $__attributesOriginalfb4bf9120334bf610bcaf3fa153db8aa; ?>
<?php unset($__attributesOriginalfb4bf9120334bf610bcaf3fa153db8aa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfb4bf9120334bf610bcaf3fa153db8aa)): ?>
<?php $component = $__componentOriginalfb4bf9120334bf610bcaf3fa153db8aa; ?>
<?php unset($__componentOriginalfb4bf9120334bf610bcaf3fa153db8aa); ?>
<?php endif; ?>
                        <?php elseif($currentStep == 2): ?>
                            <?php if (isset($component)) { $__componentOriginal746bd44ff6fd1d4f90f83c94b9bf7263 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal746bd44ff6fd1d4f90f83c94b9bf7263 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth.personal-form','data' => ['userType' => $userType]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth.personal-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['userType' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($userType)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal746bd44ff6fd1d4f90f83c94b9bf7263)): ?>
<?php $attributes = $__attributesOriginal746bd44ff6fd1d4f90f83c94b9bf7263; ?>
<?php unset($__attributesOriginal746bd44ff6fd1d4f90f83c94b9bf7263); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal746bd44ff6fd1d4f90f83c94b9bf7263)): ?>
<?php $component = $__componentOriginal746bd44ff6fd1d4f90f83c94b9bf7263; ?>
<?php unset($__componentOriginal746bd44ff6fd1d4f90f83c94b9bf7263); ?>
<?php endif; ?>
                        <?php elseif($currentStep == 3): ?>
                            <?php if (isset($component)) { $__componentOriginal8867bf4ffd5666d862b72546be328dc3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8867bf4ffd5666d862b72546be328dc3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth.cred-license-form','data' => ['userType' => $userType,'stateLicenses' => $stateLicenses,'states' => $states,'educations' => $educations]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth.cred-license-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['userType' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($userType),'stateLicenses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stateLicenses),'states' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($states),'educations' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($educations)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8867bf4ffd5666d862b72546be328dc3)): ?>
<?php $attributes = $__attributesOriginal8867bf4ffd5666d862b72546be328dc3; ?>
<?php unset($__attributesOriginal8867bf4ffd5666d862b72546be328dc3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8867bf4ffd5666d862b72546be328dc3)): ?>
<?php $component = $__componentOriginal8867bf4ffd5666d862b72546be328dc3; ?>
<?php unset($__componentOriginal8867bf4ffd5666d862b72546be328dc3); ?>
<?php endif; ?>
                        <?php elseif($currentStep == 4): ?>
                            <?php if (isset($component)) { $__componentOriginal314f66f3f1ddc2fb4725e4abf53871a9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal314f66f3f1ddc2fb4725e4abf53871a9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth.history-form','data' => ['userType' => $userType,'workHistory' => $workHistory,'references' => $references]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth.history-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['userType' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($userType),'workHistory' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($workHistory),'references' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($references)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal314f66f3f1ddc2fb4725e4abf53871a9)): ?>
<?php $attributes = $__attributesOriginal314f66f3f1ddc2fb4725e4abf53871a9; ?>
<?php unset($__attributesOriginal314f66f3f1ddc2fb4725e4abf53871a9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal314f66f3f1ddc2fb4725e4abf53871a9)): ?>
<?php $component = $__componentOriginal314f66f3f1ddc2fb4725e4abf53871a9; ?>
<?php unset($__componentOriginal314f66f3f1ddc2fb4725e4abf53871a9); ?>
<?php endif; ?>
                        <?php elseif($currentStep == 5): ?>
                            <?php if (isset($component)) { $__componentOriginald0827fada63cfcddb43c40ebb2d1178d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0827fada63cfcddb43c40ebb2d1178d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth.insurance-form','data' => ['userType' => $userType]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth.insurance-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['userType' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($userType)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0827fada63cfcddb43c40ebb2d1178d)): ?>
<?php $attributes = $__attributesOriginald0827fada63cfcddb43c40ebb2d1178d; ?>
<?php unset($__attributesOriginald0827fada63cfcddb43c40ebb2d1178d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0827fada63cfcddb43c40ebb2d1178d)): ?>
<?php $component = $__componentOriginald0827fada63cfcddb43c40ebb2d1178d; ?>
<?php unset($__componentOriginald0827fada63cfcddb43c40ebb2d1178d); ?>
<?php endif; ?>
                        <?php elseif($currentStep == 6): ?>
                            <?php if (isset($component)) { $__componentOriginal9526654b5cb8cc6e1466d36a39c84e0e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9526654b5cb8cc6e1466d36a39c84e0e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth.document-from','data' => ['userType' => $userType,'cv' => $cv,'professionalLicense' => $professionalLicense,'pictureId' => $pictureId,'socialSecurityCard' => $socialSecurityCard,'certificateOfLiabilityInsurance' => $certificateOfLiabilityInsurance,'copiesOfDiplomasCertifications' => $copiesOfDiplomasCertifications,'stateCredentialingApplication' => $stateCredentialingApplication,'passportStylePhoto' => $passportStylePhoto,'ecfmgCertificate' => $ecfmgCertificate,'boardCertificate' => $boardCertificate,'procedureLog' => $procedureLog,'cmeCs' => $cmeCs,'immunizationShotRecords' => $immunizationShotRecords,'aclsBlsCertificate' => $aclsBlsCertificate]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth.document-from'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['userType' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($userType),'cv' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($cv),'professionalLicense' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($professionalLicense),'pictureId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pictureId),'socialSecurityCard' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($socialSecurityCard),'certificateOfLiabilityInsurance' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($certificateOfLiabilityInsurance),'copiesOfDiplomasCertifications' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($copiesOfDiplomasCertifications),'stateCredentialingApplication' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stateCredentialingApplication),'passportStylePhoto' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($passportStylePhoto),'ecfmgCertificate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ecfmgCertificate),'boardCertificate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($boardCertificate),'procedureLog' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($procedureLog),'cmeCs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($cmeCs),'immunizationShotRecords' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($immunizationShotRecords),'aclsBlsCertificate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($aclsBlsCertificate)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9526654b5cb8cc6e1466d36a39c84e0e)): ?>
<?php $attributes = $__attributesOriginal9526654b5cb8cc6e1466d36a39c84e0e; ?>
<?php unset($__attributesOriginal9526654b5cb8cc6e1466d36a39c84e0e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9526654b5cb8cc6e1466d36a39c84e0e)): ?>
<?php $component = $__componentOriginal9526654b5cb8cc6e1466d36a39c84e0e; ?>
<?php unset($__componentOriginal9526654b5cb8cc6e1466d36a39c84e0e); ?>
<?php endif; ?>
                        <?php elseif($currentStep == 7): ?>
                            <?php if (isset($component)) { $__componentOriginalda4ac66dfc329b5ce9f49d927db9924e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalda4ac66dfc329b5ce9f49d927db9924e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth.review-sign-form','data' => ['userType' => $userType,'name' => $name,'email' => $email,'organizationName' => $organizationName,'primarySpecialty' => $primarySpecialty,'primaryState' => $primaryState,'specialties' => $specialties,'dateOfBirth' => $dateOfBirth,'ssn' => $ssn,'homeAddress' => $homeAddress,'practiceAddress' => $practiceAddress,'phoneNumber' => $phoneNumber,'npiNumber' => $npiNumber,'caqhId' => $caqhId,'caqhLogin' => $caqhLogin,'caqhPassword' => $caqhPassword,'pecosLogin' => $pecosLogin,'pecosPassword' => $pecosPassword,'stateLicenses' => $stateLicenses,'educations' => $educations,'deaNumber' => $deaNumber,'deaExpiration' => $deaExpiration,'workHistory' => $workHistory,'references' => $references,'insuranceCarrier' => $insuranceCarrier,'policyNumber' => $policyNumber,'coverageAmount' => $coverageAmount,'policyEffectiveDate' => $policyEffectiveDate,'policyExpirationDate' => $policyExpirationDate,'licenseSuspended' => $licenseSuspended,'felonyConviction' => $felonyConviction,'malpracticeClaims' => $malpracticeClaims,'states' => $states]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth.review-sign-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['userType' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($userType),'name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($name),'email' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($email),'organizationName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($organizationName),'primarySpecialty' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($primarySpecialty),'primaryState' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($primaryState),'specialties' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($specialties),'dateOfBirth' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dateOfBirth),'ssn' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ssn),'homeAddress' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($homeAddress),'practiceAddress' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($practiceAddress),'phoneNumber' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($phoneNumber),'npiNumber' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($npiNumber),'caqhId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($caqhId),'caqhLogin' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($caqhLogin),'caqhPassword' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($caqhPassword),'pecosLogin' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pecosLogin),'pecosPassword' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pecosPassword),'stateLicenses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stateLicenses),'educations' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($educations),'deaNumber' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($deaNumber),'deaExpiration' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($deaExpiration),'workHistory' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($workHistory),'references' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($references),'insuranceCarrier' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($insuranceCarrier),'policyNumber' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($policyNumber),'coverageAmount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($coverageAmount),'policyEffectiveDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($policyEffectiveDate),'policyExpirationDate' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($policyExpirationDate),'licenseSuspended' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($licenseSuspended),'felonyConviction' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($felonyConviction),'malpracticeClaims' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($malpracticeClaims),'states' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($states)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalda4ac66dfc329b5ce9f49d927db9924e)): ?>
<?php $attributes = $__attributesOriginalda4ac66dfc329b5ce9f49d927db9924e; ?>
<?php unset($__attributesOriginalda4ac66dfc329b5ce9f49d927db9924e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalda4ac66dfc329b5ce9f49d927db9924e)): ?>
<?php $component = $__componentOriginalda4ac66dfc329b5ce9f49d927db9924e; ?>
<?php unset($__componentOriginalda4ac66dfc329b5ce9f49d927db9924e); ?>
<?php endif; ?>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between items-center mt-8 pt-6 border-t border-border">
                        <!--[if BLOCK]><![endif]--><?php if($currentStep > 1): ?>
                            <button type="button" wire:click="prevStep" wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
                                    class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold rounded-lg transition-colors">
                                Back
                            </button>
                        <?php else: ?>
                            <div></div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <div class="flex items-center gap-4">
                            <!--[if BLOCK]><![endif]--><?php if($currentStep < 7): ?>
                                <!--[if BLOCK]><![endif]--><?php if($currentStep > 1): ?>
                                    <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'button','wire:click' => 'skipStep','wire:loading.attr' => 'disabled','wire:target' => 'skipStep','wire:loading.class' => 'opacity-50 cursor-not-allowed','xOn:click' => 'setTimeout(() => window.scrollTo({top: 0, behavior: \'smooth\'}), 100)','class' => 'px-6 py-2 text-text-secondary hover:text-primary-600 transition-colors']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','wire:click' => 'skipStep','wire:loading.attr' => 'disabled','wire:target' => 'skipStep','wire:loading.class' => 'opacity-50 cursor-not-allowed','x-on:click' => 'setTimeout(() => window.scrollTo({top: 0, behavior: \'smooth\'}), 100)','class' => 'px-6 py-2 text-text-secondary hover:text-primary-600 transition-colors']); ?>
                                        Skip for now
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $attributes = $__attributesOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__attributesOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $component = $__componentOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__componentOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'button','wire:click' => 'nextStep','wire:loading.attr' => 'disabled','wire:target' => 'nextStep','wire:loading.class' => 'opacity-50 cursor-not-allowed','xOn:click' => 'setTimeout(() => window.scrollTo({top: 0, behavior: \'smooth\'}), 100)','class' => 'px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','wire:click' => 'nextStep','wire:loading.attr' => 'disabled','wire:target' => 'nextStep','wire:loading.class' => 'opacity-50 cursor-not-allowed','x-on:click' => 'setTimeout(() => window.scrollTo({top: 0, behavior: \'smooth\'}), 100)','class' => 'px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors']); ?>
                                    Continue
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $attributes = $__attributesOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__attributesOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $component = $__componentOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__componentOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
                            <?php else: ?>
                                <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'submit','wire:click' => 'submitForm','wire:loading.attr' => 'disabled','wire:target' => 'submitForm','wire:loading.class' => 'opacity-50 cursor-not-allowed','xOn:click' => 'setTimeout(() => window.scrollTo({top: 0, behavior: \'smooth\'}), 100)','class' => 'px-8 py-3 bg-success-600 hover:bg-success-700 text-white font-semibold rounded-lg transition-colors']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','wire:click' => 'submitForm','wire:loading.attr' => 'disabled','wire:target' => 'submitForm','wire:loading.class' => 'opacity-50 cursor-not-allowed','x-on:click' => 'setTimeout(() => window.scrollTo({top: 0, behavior: \'smooth\'}), 100)','class' => 'px-8 py-3 bg-success-600 hover:bg-success-700 text-white font-semibold rounded-lg transition-colors']); ?>
                                    <span wire:loading.remove wire:target="submitForm">Submit Profile</span>
                                    <span wire:loading wire:target="submitForm" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Submitting...
                                    </span>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $attributes = $__attributesOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__attributesOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $component = $__componentOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__componentOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php /**PATH E:\payer-ready\resources\views/livewire/organization-registration.blade.php ENDPATH**/ ?>