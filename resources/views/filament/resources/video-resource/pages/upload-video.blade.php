<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Upload Area --}}
        <div
            x-data="videoUploader()"
            x-init="init()"
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6"
        >
            {{-- Drop Zone --}}
            <div
                x-on:dragover.prevent="isDragging = true"
                x-on:dragleave.prevent="isDragging = false"
                x-on:drop.prevent="handleDrop($event)"
                :class="{ 'border-primary-500 bg-primary-50 dark:bg-primary-900/20': isDragging }"
                class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center transition-colors duration-200"
            >
                <template x-if="!isUploading && !uploadComplete">
                    <div>
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="mt-4">
                            <label for="video-file" class="cursor-pointer">
                                <span class="text-primary-600 hover:text-primary-500 font-medium">اختر ملف فيديو</span>
                                <span class="text-gray-500"> أو اسحبه هنا</span>
                            </label>
                            <input
                                type="file"
                                id="video-file"
                                accept="video/*"
                                class="hidden"
                                x-on:change="handleFileSelect($event)"
                            />
                        </div>
                        <p class="mt-2 text-xs text-gray-500">MP4, WebM, MOV حتى 10GB</p>
                    </div>
                </template>

                {{-- Uploading State --}}
                <template x-if="isUploading">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300" x-text="fileName"></span>
                            <span class="text-sm text-gray-500" x-text="formatBytes(fileSize)"></span>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                            <div
                                class="bg-primary-600 h-3 rounded-full transition-all duration-300"
                                :style="'width: ' + uploadProgress + '%'"
                            ></div>
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">
                                <span x-text="uploadProgress"></span>%
                            </span>
                            <span class="text-gray-500" x-text="uploadSpeed"></span>
                        </div>

                        <button
                            type="button"
                            x-on:click="cancelUpload()"
                            class="text-red-600 hover:text-red-700 text-sm font-medium"
                        >
                            إلغاء الرفع
                        </button>
                    </div>
                </template>

                {{-- Upload Complete --}}
                <template x-if="uploadComplete">
                    <div class="space-y-4">
                        <div class="flex items-center justify-center text-green-500">
                            <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="text-lg font-medium text-gray-900 dark:text-white">تم رفع الفيديو بنجاح!</p>
                        <p class="text-sm text-gray-500" x-text="fileName"></p>

                        {{-- Video Name Input --}}
                        <div class="max-w-md mx-auto">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">اسم الفيديو</label>
                            <input
                                type="text"
                                x-model="videoName"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            />
                        </div>

                        <div class="flex items-center justify-center gap-4 mt-4">
                            <button
                                type="button"
                                x-on:click="saveVideo()"
                                class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 font-medium"
                            >
                                حفظ الفيديو
                            </button>
                            <button
                                type="button"
                                x-on:click="resetUploader()"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium"
                            >
                                رفع فيديو آخر
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Error Message --}}
            <template x-if="errorMessage">
                <div class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                    <p class="text-red-600 dark:text-red-400 text-sm" x-text="errorMessage"></p>
                </div>
            </template>
        </div>

        {{-- Recently Uploaded Videos --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">الفيديوهات المرفوعة مؤخراً</h3>
            <p class="text-sm text-gray-500">
                <a href="{{ \App\Filament\Resources\VideoResource::getUrl('index') }}" class="text-primary-600 hover:text-primary-700">
                    عرض جميع الفيديوهات &larr;
                </a>
            </p>
        </div>
    </div>

    @push('scripts')
    <script>
        function videoUploader() {
            return {
                isDragging: false,
                isUploading: false,
                uploadComplete: false,
                uploadProgress: 0,
                uploadSpeed: '',
                fileName: '',
                fileSize: 0,
                videoName: '',
                videoId: null,
                signedUrl: null,
                publicUrl: null,
                errorMessage: null,
                xhr: null,
                startTime: null,

                init() {
                    // Initialize
                },

                handleDrop(event) {
                    this.isDragging = false;
                    const files = event.dataTransfer.files;
                    if (files.length > 0) {
                        this.processFile(files[0]);
                    }
                },

                handleFileSelect(event) {
                    const files = event.target.files;
                    if (files.length > 0) {
                        this.processFile(files[0]);
                    }
                },

                async processFile(file) {
                    // Validate file type
                    if (!file.type.startsWith('video/')) {
                        this.errorMessage = 'يرجى اختيار ملف فيديو صالح';
                        return;
                    }

                    // Validate file size (10GB max)
                    const maxSize = 10 * 1024 * 1024 * 1024;
                    if (file.size > maxSize) {
                        this.errorMessage = 'حجم الملف يتجاوز 10GB';
                        return;
                    }

                    this.errorMessage = null;
                    this.fileName = file.name;
                    this.fileSize = file.size;
                    this.videoName = file.name.replace(/\.[^/.]+$/, '');

                    try {
                        // Get signed URL from server
                        const response = await fetch('{{ route("videos.signed-url") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                file_name: file.name,
                                mime_type: file.type,
                                file_size: file.size,
                            }),
                        });

                        const data = await response.json();

                        if (!data.success) {
                            throw new Error(data.message || 'Failed to get upload URL');
                        }

                        this.videoId = data.video_id;
                        this.signedUrl = data.signed_url;
                        this.publicUrl = data.public_url;

                        // Start upload
                        this.uploadFile(file);

                    } catch (error) {
                        this.errorMessage = 'حدث خطأ: ' + error.message;
                    }
                },

                uploadFile(file) {
                    this.isUploading = true;
                    this.startTime = Date.now();

                    this.xhr = new XMLHttpRequest();

                    this.xhr.upload.addEventListener('progress', (event) => {
                        if (event.lengthComputable) {
                            this.uploadProgress = Math.round((event.loaded / event.total) * 100);

                            // Calculate upload speed
                            const elapsed = (Date.now() - this.startTime) / 1000;
                            const bytesPerSecond = event.loaded / elapsed;
                            this.uploadSpeed = this.formatBytes(bytesPerSecond) + '/s';
                        }
                    });

                    this.xhr.addEventListener('load', async () => {
                        if (this.xhr.status >= 200 && this.xhr.status < 300) {
                            this.isUploading = false;
                            this.uploadComplete = true;

                            // Confirm upload on server
                            try {
                                await fetch('{{ route("videos.confirm-upload") }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    },
                                    body: JSON.stringify({
                                        video_id: this.videoId,
                                    }),
                                });
                            } catch (error) {
                                console.error('Failed to confirm upload:', error);
                            }
                        } else {
                            this.handleUploadError('فشل رفع الملف');
                        }
                    });

                    this.xhr.addEventListener('error', () => {
                        this.handleUploadError('حدث خطأ أثناء الرفع');
                    });

                    this.xhr.addEventListener('abort', () => {
                        this.isUploading = false;
                        this.errorMessage = 'تم إلغاء الرفع';
                    });

                    this.xhr.open('PUT', this.signedUrl);
                    this.xhr.setRequestHeader('Content-Type', file.type);
                    this.xhr.send(file);
                },

                handleUploadError(message) {
                    this.isUploading = false;
                    this.errorMessage = message;

                    // Cancel on server
                    if (this.videoId) {
                        fetch('{{ route("videos.cancel-upload") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                video_id: this.videoId,
                            }),
                        });
                    }
                },

                cancelUpload() {
                    if (this.xhr) {
                        this.xhr.abort();
                    }

                    if (this.videoId) {
                        fetch('{{ route("videos.cancel-upload") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                video_id: this.videoId,
                            }),
                        });
                    }

                    this.resetUploader();
                },

                async saveVideo() {
                    // Update video name if changed
                    // For now, just redirect to the list
                    window.location.href = '{{ \App\Filament\Resources\VideoResource::getUrl("index") }}';
                },

                resetUploader() {
                    this.isUploading = false;
                    this.uploadComplete = false;
                    this.uploadProgress = 0;
                    this.uploadSpeed = '';
                    this.fileName = '';
                    this.fileSize = 0;
                    this.videoName = '';
                    this.videoId = null;
                    this.signedUrl = null;
                    this.publicUrl = null;
                    this.errorMessage = null;
                },

                formatBytes(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                }
            };
        }
    </script>
    @endpush
</x-filament-panels::page>
