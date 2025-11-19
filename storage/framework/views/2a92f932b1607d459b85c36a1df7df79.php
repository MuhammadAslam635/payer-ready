    <div class="relative">
        <!-- Cart Icon with Badge -->
        <div class="relative inline-flex items-center">
            <button 
                type="button" 
                class="relative p-2 text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-full"
                title="Invoice Cart"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0h15M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                </svg>
                
                <!-- Cart Count Badge -->
                <!--[if BLOCK]><![endif]--><?php if($cartCount > 0): ?>
                    <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full min-w-[1.25rem] h-5">
                        <?php echo e($cartCount); ?>

                    </span>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </button>
        </div>

        <!-- Cart Summary Tooltip (appears on hover) -->
        <!--[if BLOCK]><![endif]--><?php if($cartCount > 0): ?>
            <div class="absolute right-0 top-full mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 pointer-events-none">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-900">Invoice Cart</h3>
                        <span class="text-xs text-gray-500"><?php echo e($cartCount); ?> <?php echo e($cartCount === 1 ? 'item' : 'items'); ?></span>
                    </div>
                    
                    <div class="space-y-2 mb-3">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = Cart::instance($cartInstance)->content(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-700 truncate flex-1 mr-2"><?php echo e($item->name); ?></span>
                                <span class="text-gray-900 font-medium">$<?php echo e(number_format($item->price, 2)); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    
                    <div class="border-t border-gray-200 pt-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-semibold text-gray-900">Total:</span>
                            <span class="text-sm font-bold text-indigo-600">$<?php echo e(number_format($cartTotal, 2)); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- Success Notification -->
        <!--[if BLOCK]><![endif]--><?php if($showNotification): ?>
            <div 
                class="fixed top-4 right-4 z-50 max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden"
                x-data="{ show: true }"
                x-show="show"
                x-transition:enter="transform ease-out duration-300 transition"
                x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                x-init="setTimeout(() => show = false, 3000)"
            >
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-gray-900">Item Added!</p>
                            <p class="mt-1 text-sm text-gray-500">Item has been added to your invoice cart.</p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button 
                                class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                wire:click="hideNotification"
                            >
                                <span class="sr-only">Close</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/livewire/components/cart-notification-component.blade.php ENDPATH**/ ?>