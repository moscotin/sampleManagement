<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sample Details: ') . $sample->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Sample Information</h3>
                    <dl class="grid grid-cols-1 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $sample->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Wafer</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="{{ route('wafers.show', $sample->wafer) }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $sample->wafer->name }}
                                </a>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $sample->description ?? 'N/A' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $sample->created_at->format('Y-m-d H:i:s') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Images</h3>
                    
                    <!-- Upload Form -->
                    <form action="{{ route('sample-images.store', $sample) }}" method="POST" enctype="multipart/form-data" class="mb-6">
                        @csrf
                        <div class="flex items-end gap-3">
                            <div class="flex-1">
                                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Upload Images</label>
                                <input type="file" name="images[]" id="images" multiple accept="image/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                @error('images.*')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded whitespace-nowrap">
                                Upload
                            </button>
                        </div>
                    </form>

                    <!-- Image Gallery -->
                    @if($sample->images->isEmpty())
                        <p class="text-gray-500">No images uploaded yet.</p>
                    @else
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            @foreach($sample->images as $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $image->path) }}" 
                                         alt="{{ $image->original_filename }}"
                                         class="w-full h-32 object-cover rounded cursor-pointer hover:opacity-75 transition-opacity"
                                         onclick="openLightbox('{{ asset('storage/' . $image->path) }}', '{{ $image->original_filename }}')"
                                         title="{{ $image->original_filename }}">
                                    <form action="{{ route('sample-images.destroy', $image) }}" method="POST" class="absolute top-1 right-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this image?')"
                                            class="bg-red-500 hover:bg-red-700 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Lightbox -->
            <div id="lightbox" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4" onclick="closeLightbox()">
                <div class="relative max-w-7xl max-h-full">
                    <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <img id="lightbox-image" src="" alt="Full size image" class="max-w-full max-h-[90vh] object-contain" onclick="event.stopPropagation()">
                    <p id="lightbox-caption" class="text-white text-center mt-2"></p>
                </div>
            </div>

            <script>
                function openLightbox(imageSrc, caption) {
                    document.getElementById('lightbox').classList.remove('hidden');
                    document.getElementById('lightbox-image').src = imageSrc;
                    document.getElementById('lightbox-caption').textContent = caption;
                    document.body.style.overflow = 'hidden';
                }

                function closeLightbox() {
                    document.getElementById('lightbox').classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }

                // Close lightbox on Escape key
                document.addEventListener('keydown', function(event) {
                    if (event.key === 'Escape') {
                        closeLightbox();
                    }
                });
            </script>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Fabrication Steps</h3>
                        <a href="{{ route('fabrication-steps.create', $sample) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add Fabrication Step
                        </a>
                    </div>
                    @if($sample->fabricationSteps->isEmpty())
                        <p class="text-gray-500">No fabrication steps recorded yet.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($sample->fabricationSteps as $step)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $step->performed_at->format('Y-m-d H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $step->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $step->activity_name }}</td>
                                        <td class="px-6 py-4">{{ Str::limit($step->description, 50) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('fabrication-steps.edit', $step) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            <form action="{{ route('fabrication-steps.destroy', $step) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <div class="mt-6 flex space-x-3">
                <a href="{{ route('samples.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Back to List
                </a>
                <a href="{{ route('samples.edit', $sample) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Sample
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
