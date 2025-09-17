@if($show)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 wire:click="close"
                 aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle {{ $this->getSizeClasses() }} w-full">
                @if($title || $closable)
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            @if($title)
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    {{ $title }}
                                </h3>
                            @endif
                            @if($closable)
                                <button wire:click="close" class="text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600 transition ease-in-out duration-150">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Modal content -->
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                    {{ $slot }}
                </div>

                @if(isset($footer))
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
