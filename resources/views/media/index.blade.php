@extends('layouts.admin')

@php
    $title = 'Media Library';
    $breadcrumb = 'Upload and manage image files';
@endphp

@section('content')

<div x-data="mediaManager()" class="space-y-6">

    {{-- Header Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Files</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">{{ $media->total() }}</p>
                </div>
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500 font-medium">Storage Used</p>
                    <p class="text-2xl font-bold text-slate-900 mt-1">
                        @php
                            $totalSize = $media->sum(fn($m) => \Storage::disk('public')->size($m->file_path) ?? 0);
                            echo number_format($totalSize / (1024 * 1024), 1) . ' MB';
                        @endphp
                    </p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10a2 2 0 002 2h12a2 2 0 002-2V7m0 0V5a2 2 0 00-2-2H6a2 2 0 00-2 2v2m14 0h2m-2 0h-5m-5 0H9"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Upload Zone --}}
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-transparent">
            <h3 class="text-sm font-semibold text-slate-900">Upload New Images</h3>
            <p class="text-xs text-slate-500 mt-0.5">JPG, PNG, GIF, WebP — Max 5 MB per file</p>
        </div>

        <form method="POST"
              action="{{ route('media.store') }}"
              enctype="multipart/form-data"
              class="p-6"
              id="upload-form"
              @submit.prevent="submitForm">
            @csrf

            {{-- Drag & Drop Zone --}}
            <div class="relative group">
                <div id="drop-zone"
                     @dragover.prevent="dragActive = true"
                     @dragleave.prevent="dragActive = false"
                     @drop.prevent="handleDrop"
                     :class="[
                         'relative border-2 border-dashed rounded-2xl p-8 sm:p-12 text-center',
                         'transition-all duration-200 cursor-pointer',
                         dragActive 
                             ? 'border-indigo-400 bg-indigo-50 scale-[1.02]' 
                             : 'border-slate-300 hover:border-indigo-300 hover:bg-indigo-50/30'
                     ]"
                     @click="triggerFileInput()">

                    <input type="file"
                           id="file-input"
                           name="file"
                           accept="image/*"
                           class="sr-only"
                           @change="handleFileSelect">

                    <div id="upload-placeholder" :class="{ hidden: selectedFile }">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:shadow-lg transition-all">
                            <svg class="w-8 h-8 text-indigo-600 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-slate-700 mb-1">
                            Drag images here or click to browse
                        </p>
                        <p class="text-xs text-slate-400">PNG, JPG, GIF, WebP up to 5MB</p>
                    </div>

                    <div id="file-preview" :class="{ hidden: !selectedFile }" class="space-y-4">
                        <div class="flex justify-center">
                            <img :src="selectedFile?.preview" 
                                 alt="Preview" 
                                 class="max-h-48 rounded-xl object-contain shadow-md">
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-semibold text-slate-700" x-text="selectedFile?.name"></p>
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <span id="file-size"></span>
                                <span class="text-slate-300">•</span>
                                <span id="file-type"></span>
                            </div>
                        </div>
                    </div>
                </div>

                @error('file')
                    <p class="mt-3 text-xs text-red-600 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-3 mt-6 flex-col sm:flex-row">
                <button type="submit"
                        id="upload-btn"
                        :disabled="!selectedFile || uploading"
                        :class="[
                            'px-6 py-2.5 text-white text-sm font-semibold rounded-xl transition-all',
                            'flex items-center justify-center gap-2',
                            uploading ? 'bg-indigo-500' : 'bg-indigo-600 hover:bg-indigo-700 hover:shadow-lg',
                            (!selectedFile || uploading) ? 'opacity-50 cursor-not-allowed' : ''
                        ]">
                    <svg v-if="uploading" class="animate-spin w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                    </svg>
                    <span v-if="uploading">Uploading...</span>
                    <span v-else>Upload Image</span>
                </button>
                <button type="button"
                        @click="clearFile()"
                        v-show="selectedFile"
                        class="px-5 py-2.5 text-sm text-slate-700 font-medium bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Clear
                </button>
            </div>

        </form>
    </div>

    {{-- Media Grid Section --}}
    @if($media->isEmpty())
        <div class="bg-white rounded-xl border border-slate-200 py-16 px-8">
            <div class="w-20 h-20 bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-slate-700 mb-1">No media yet</h3>
            <p class="text-sm text-slate-500">Upload your first image above to get started</p>
        </div>
    @else
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-slate-900">Gallery</h3>
                <span class="text-xs text-slate-500 font-medium">{{ $media->count() }} of {{ $media->total() }} files</span>
            </div>

            {{-- Responsive Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4 sm:gap-6">
                @foreach($media as $item)
                    <div class="group relative bg-white rounded-xl border border-slate-200 overflow-hidden hover:border-slate-300 hover:shadow-md transition-all duration-200"
                         x-data="{ showActions: false }">

                        {{-- Thumbnail Container --}}
                        <div class="aspect-square bg-gradient-to-br from-slate-100 to-slate-50 overflow-hidden relative"
                             @mouseenter="showActions = true"
                             @mouseleave="showActions = false">
                            <img src="{{ $item->url }}"
                                 alt="{{ $item->original_name ?? 'Media' }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                 loading="lazy">

                            {{-- Overlay Actions (Desktop) --}}
                            <div :class="[
                                'absolute inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center gap-2',
                                'transition-opacity duration-200',
                                showActions ? 'opacity-100' : 'opacity-0 sm:pointer-events-none'
                            ]"
                                 class="hidden sm:flex">
                                {{-- Copy URL --}}
                                <button type="button"
                                        @click="copyUrl('{{ $item->url }}')"
                                        title="Copy URL"
                                        class="p-2.5 bg-white/90 hover:bg-white text-indigo-600 rounded-lg transition-all hover:scale-110 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>

                                {{-- Delete --}}
                                <button type="button"
                                        @click="confirmDelete('{{ $item->id }}', '{{ $item->original_name }}')"
                                        title="Delete"
                                        class="p-2.5 bg-red-500/90 hover:bg-red-600 text-white rounded-lg transition-all hover:scale-110 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Info Card --}}
                        <div class="p-3">
                            <p class="text-xs text-slate-600 truncate font-medium mb-2"
                               title="{{ $item->original_name }}">
                                {{ \Str::limit($item->original_name ?? 'image', 20) }}
                            </p>

                            {{-- Mobile Actions --}}
                            <div class="flex items-center gap-2 sm:hidden">
                                <button type="button"
                                        @click="copyUrl('{{ $item->url }}')"
                                        class="flex-1 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors">
                                    Copy
                                </button>
                                <button type="button"
                                        @click="confirmDelete('{{ $item->id }}', '{{ $item->original_name }}')"
                                        class="flex-1 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                    Delete
                                </button>
                            </div>

                            {{-- Company Badge (Super Admin) --}}
                            @if(auth()->user()->role === 'super_admin')
                                <p class="text-xs text-slate-400 mt-2 truncate">
                                    <span class="text-slate-300">@</span> {{ $item->company->name ?? '—' }}
                                </p>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($media->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $media->links() }}
                </div>
            @endif
        </div>
    @endif

</div>

{{-- Delete Confirmation Modal --}}
<div id="delete-modal"
     class="fixed inset-0 z-50 hidden flex items-center justify-center p-4"
     x-data="{ open: false, itemId: null, itemName: '' }"
     :class="{ hidden: !open }">
    <div class="absolute inset-0 bg-black/50" @click="open = false"></div>
    <div class="relative bg-white rounded-xl shadow-xl p-6 max-w-sm w-full">
        <div class="flex items-start gap-4 mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4v2m0 4v2M6.34 20H17.66a2 2 0 001.97-2.5L19.54 8h2.92a.5.5 0 00.493-.607l-.47-2.8a.5.5 0 00-.486-.393H4.3l-.5-3A.5.5 0 003.3 1H1.5a.5.5 0 000 1h1.6l1.7 10.2a2 2 0 001.97 1.6h9.6a2 2 0 001.97-1.5l1.6-9.6"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-semibold text-slate-900">Delete image?</h3>
                <p class="text-xs text-slate-500 mt-1" x-text="itemName"></p>
            </div>
        </div>
        <p class="text-sm text-slate-600 mb-6">This action cannot be undone. The image will be permanently deleted.</p>
        <div class="flex gap-3">
            <button type="button"
                    @click="open = false"
                    class="flex-1 px-4 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                Cancel
            </button>
            <form :action="`/media/${itemId}`" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full px-4 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Notification Toast --}}
<div id="notification-toast"
     class="fixed bottom-6 right-6 z-50 px-4 py-3 bg-slate-900 text-white text-sm font-medium rounded-lg shadow-xl opacity-0 transition-opacity duration-300 pointer-events-none"
     x-data="{ message: '', show(msg) { this.message = msg; this.$el.classList.remove('opacity-0'); setTimeout(() => { this.$el.classList.add('opacity-0'); }, 3000); } }">
    <div class="flex items-center gap-2">
        <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span x-text="message"></span>
    </div>
</div>

<script>
function mediaManager() {
    return {
        dragActive: false,
        selectedFile: null,
        uploading: false,

        triggerFileInput() {
            document.getElementById('file-input').click();
        },

        handleFileSelect(e) {
            const file = e.target.files?.[0];
            if (file) this.showPreview(file);
        },

        handleDrop(e) {
            this.dragActive = false;
            const file = e.dataTransfer?.files?.[0];
            if (file) {
                document.getElementById('file-input').files = e.dataTransfer.files;
                this.showPreview(file);
            }
        },

        showPreview(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.selectedFile = {
                    name: file.name,
                    preview: e.target.result,
                    type: file.type,
                    size: file.size
                };
                document.getElementById('file-size').textContent = this.formatFileSize(file.size);
                document.getElementById('file-type').textContent = file.type || 'Unknown';
            };
            reader.readAsDataURL(file);
        },

        clearFile() {
            this.selectedFile = null;
            document.getElementById('file-input').value = '';
        },

        formatFileSize(bytes) {
            if (bytes === 0) return '0 B';
            const k = 1024;
            const sizes = ['B', 'KB', 'MB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        },

        async submitForm(e) {
            e.preventDefault();
            this.uploading = true;

            const form = document.getElementById('upload-form');
            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    window.location.reload();
                } else {
                    alert('Upload failed. Please try again.');
                }
            } catch (error) {
                alert('Upload error: ' + error.message);
            } finally {
                this.uploading = false;
            }
        },

        copyUrl(url) {
            navigator.clipboard.writeText(url).then(() => {
                const toast = document.getElementById('notification-toast');
                toast.querySelector('span').textContent = '✓ URL copied to clipboard!';
                toast.classList.remove('opacity-0');
                setTimeout(() => {
                    toast.classList.add('opacity-0');
                }, 3000);
            });
        },

        confirmDelete(itemId, itemName) {
            const modal = document.getElementById('delete-modal');
            const alpineComponent = Alpine.getElementOnlyData(modal);
            if (alpineComponent) {
                alpineComponent.open = true;
                alpineComponent.itemId = itemId;
                alpineComponent.itemName = itemName;
            }
        }
    };
}
</script>

@endsection
