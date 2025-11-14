<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Document Management</h1>
            <p class="text-slate-600 mt-1">Upload and manage your professional documents</p>
        </div>
        <x-ui.button
            type="button"
            color="teal"
            variant="primary"
            icon="cloud-arrow-up"
            class="!px-5 uppercase tracking-wide text-xs"
            wire:click="openUploadModal">
            Upload Document
        </x-ui.button>
    </div>

    <!-- Documents Table -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Your Documents</h3>
        </div>
        
        @if($documents->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Document Type
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                File Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Upload Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Size
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @foreach($documents as $document)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-900">
                                        {{ $document->documentType->name ?? 'Unknown' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-900">{{ $document->original_filename }}</div>
                                    @if($document->notes)
                                        <div class="text-xs text-slate-500 mt-1">{{ Str::limit($document->notes, 50) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ $document->upload_date?->format('M d, Y') ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $document->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $document->is_verified ? 'Verified' : 'Pending' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ $this->formatFileSize($document->file_size_bytes) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <x-ui.button
                                            type="button"
                                            variant="ghost"
                                            size="sm"
                                            squared
                                            icon="arrow-down-tray"
                                            class="border border-slate-300 text-slate-700 hover:text-slate-900"
                                            wire:click="downloadDocument({{ $document->id }})" />
                                        <x-ui.button
                                            type="button"
                                            variant="ghost"
                                            size="sm"
                                            squared
                                            icon="pencil-square"
                                            class="border border-slate-300 text-slate-700 hover:text-slate-900"
                                            wire:click="openEditModal({{ $document->id }})" />
                                        <x-ui.button
                                            type="button"
                                            variant="ghost"
                                            size="sm"
                                            squared
                                            icon="trash"
                                            class="border border-slate-300 text-slate-700 hover:text-red-700"
                                            onclick="return confirm('Are you sure you want to delete this document?')"
                                            wire:click="deleteDocument({{ $document->id }})" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-6 text-center">
                <svg class="w-12 h-12 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-lg font-medium text-slate-900 mb-2">No documents uploaded</h3>
                <p class="text-slate-500 mb-4">Upload your first document to get started.</p>
                <x-ui.button
                    type="button"
                    color="teal"
                    variant="primary"
                    icon="cloud-arrow-up"
                    class="!px-5 uppercase tracking-wide text-xs"
                    wire:click="openUploadModal">
                    Upload Document
                </x-ui.button>
            </div>
        @endif
    </div>

    <!-- Upload Modal -->
    @if($showUploadModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeUploadModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-slate-900">Upload Document</h3>
                            <x-ui.button
                                type="button"
                                variant="ghost"
                                squared
                                size="sm"
                                icon="x-mark"
                                class="text-slate-400 hover:text-slate-600"
                                wire:click="closeUploadModal" />
                        </div>

                        <form wire:submit.prevent="uploadDocument">
                            <div class="space-y-4">
                                <!-- Document Type Selection -->
                                <div>
                                    <label for="selectedDocumentType" class="block text-sm font-medium text-slate-700 mb-1">
                                        Document Type <span class="text-red-500">*</span>
                                    </label>
                                    <select wire:model="selectedDocumentType" id="selectedDocumentType" 
                                        class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm">
                                        <option value="">Choose document type...</option>
                                        @foreach($documentTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedDocumentType') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                    @enderror
                                </div>

                                <!-- File Upload -->
                                <div>
                                    <label for="documentFile" class="block text-sm font-medium text-slate-700 mb-1">
                                        Document File <span class="text-red-500">*</span>
                                    </label>
                                    <input wire:model="documentFile" type="file" id="documentFile" 
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                        class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" />
                                    <p class="mt-1 text-sm text-slate-500">Supported formats: PDF, DOC, DOCX, JPG, PNG (Max: 10MB)</p>
                                    @error('documentFile') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                    @enderror
                                </div>

                                <!-- Notes -->
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-slate-700 mb-1">
                                        Notes (Optional)
                                    </label>
                                    <textarea wire:model="notes" id="notes" rows="3" 
                                        placeholder="Add any additional notes about this document..."
                                        class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"></textarea>
                                    @error('notes') 
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 mt-6">
                                <x-ui.button
                                    type="button"
                                    variant="outline"
                                    color="slate"
                                    wire:click="closeUploadModal">
                                    Cancel
                                </x-ui.button>
                                <x-ui.button
                                    type="submit"
                                    color="teal"
                                    variant="primary"
                                    icon="cloud-arrow-up">
                                    Upload Document
                                </x-ui.button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeEditModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-slate-900">Edit Document</h3>
                            <x-ui.button
                                type="button"
                                variant="ghost"
                                squared
                                size="sm"
                                icon="x-mark"
                                class="text-slate-400 hover:text-slate-600"
                                wire:click="closeEditModal" />
                        </div>

                        @if($editingDocument)
                            <form wire:submit.prevent="updateDocument">
                                <div class="space-y-4">
                                    <!-- Document Info -->
                                    <div class="bg-slate-50 rounded-lg p-4">
                                        <h4 class="font-medium text-slate-900 mb-2">Document Information</h4>
                                        <div class="grid grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <span class="text-slate-500">Type:</span>
                                                <span class="text-slate-900">{{ $editingDocument->documentType->name ?? 'Unknown' }}</span>
                                            </div>
                                            <div>
                                                <span class="text-slate-500">File:</span>
                                                <span class="text-slate-900">{{ $editingDocument->original_filename }}</span>
                                            </div>
                                            <div>
                                                <span class="text-slate-500">Upload Date:</span>
                                                <span class="text-slate-900">{{ $editingDocument->upload_date?->format('M d, Y') ?? 'N/A' }}</span>
                                            </div>
                                            <div>
                                                <span class="text-slate-500">Status:</span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                    {{ $editingDocument->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $editingDocument->is_verified ? 'Verified' : 'Pending' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Notes -->
                                    <div>
                                        <label for="editNotes" class="block text-sm font-medium text-slate-700 mb-1">
                                            Notes
                                        </label>
                                        <textarea wire:model="editNotes" id="editNotes" rows="3" 
                                            placeholder="Add or update notes about this document..."
                                            class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"></textarea>
                                        @error('editNotes') 
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex justify-end space-x-3 mt-6">
                                    <x-ui.button
                                        type="button"
                                        variant="outline"
                                        color="slate"
                                        wire:click="closeEditModal">
                                        Cancel
                                    </x-ui.button>
                                    <x-ui.button
                                        type="submit"
                                        color="teal"
                                        variant="primary"
                                        icon="check">
                                        Update Document
                                    </x-ui.button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>