@extends('layouts.app')

@section('title', 'Répondre à la question')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">Répondre à la question</h1>
                <a href="{{ route('questions.admin') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour à la liste
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Question Details -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Détails de la question</h2>
                    
                    <!-- Question Title -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Titre</label>
                        <p class="text-gray-900 font-medium">{{ $question->title }}</p>
                    </div>

                    <!-- Question Content -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contenu</label>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-800 whitespace-pre-wrap">{{ $question->content }}</p>
                        </div>
                    </div>

                    <!-- Question Meta -->
                    <div class="space-y-3 text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span><strong>Posée par:</strong> {{ $question->user->name ?? 'Utilisateur supprimé' }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span><strong>Date:</strong> {{ $question->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span><strong>Status:</strong> 
                                @if($question->is_answered)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Répondue
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        En attente
                                    </span>
                                @endif
                            </span>
                        </div>
                        @if($question->is_answered)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span><strong>Visibilité:</strong> 
                                    @if($question->is_public)
                                        <span class="text-green-600">Publique</span>
                                    @else
                                        <span class="text-red-600">Privée</span>
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Answer Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">
                        @if($question->is_answered)
                            Modifier la réponse
                        @else
                            Répondre à la question
                        @endif
                    </h2>

                    <form id="answerForm" action="{{ route('questions.answer', $question) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Answer Content -->
                        <div class="mb-6">
                            <label for="answer_content" class="block text-sm font-medium text-gray-700 mb-2">
                                Réponse <span class="text-red-500">*</span>
                            </label>
                            <textarea id="answer_content" name="answer_content" rows="8" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('answer_content') border-red-300 @enderror"
                                placeholder="Saisissez votre réponse ici..." required>{{ old('answer_content', $question->answer_content) }}</textarea>
                            @error('answer_content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Images (if editing) -->
                        @if($question->is_answered && $question->answer_images)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Images actuelles</label>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @foreach($question->answer_images_urls as $imageUrl)
                                        <div class="relative group">
                                            <img src="{{ $imageUrl }}" alt="Image de réponse" class="w-full h-24 object-cover rounded-lg">
                                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                                <span class="text-white text-xs">Image existante</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-sm text-gray-500 mt-2">Les nouvelles images remplaceront les images existantes.</p>
                            </div>
                        @endif

                        <!-- Image Upload -->
                        <div class="mb-6">
                            <label for="answer_images" class="block text-sm font-medium text-gray-700 mb-2">Images (optionnel)</label>
                            <input type="file" id="answer_images" name="answer_images[]" multiple accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('answer_images.*') border-red-300 @enderror">
                            <p class="text-sm text-gray-500 mt-1">Formats acceptés: JPEG, PNG, JPG, GIF. Taille max: 2MB par image.</p>
                            @error('answer_images.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            
                            <!-- Image Preview -->
                            <div id="imagePreview" class="mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 hidden"></div>
                        </div>

                        <!-- Current Videos (if editing) -->
                        @if($question->is_answered && $question->answer_videos)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Vidéos actuelles</label>
                                <div class="space-y-4">
                                    @foreach($question->answer_videos_urls as $videoUrl)
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <video controls class="w-full h-48 rounded-lg">
                                                <source src="{{ $videoUrl }}" type="video/mp4">
                                                Votre navigateur ne supporte pas la lecture vidéo.
                                            </video>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-sm text-gray-500 mt-2">Les nouvelles vidéos remplaceront les vidéos existantes.</p>
                            </div>
                        @endif

                        <!-- Video Upload -->
                        <div class="mb-6">
                            <label for="answer_videos" class="block text-sm font-medium text-gray-700 mb-2">Vidéos (optionnel)</label>
                            <input type="file" id="answer_videos" name="answer_videos[]" multiple accept="video/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('answer_videos.*') border-red-300 @enderror">
                            <p class="text-sm text-gray-500 mt-1">Formats acceptés: MP4, AVI, MOV, WMV. Taille max: 10MB par vidéo.</p>
                            @error('answer_videos.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Visibility Toggle -->
                        <div class="mb-6">
                            <div class="flex items-center">
                                <input type="checkbox" id="is_public" name="is_public" value="1" 
                                    {{ old('is_public', $question->is_public ?? true) ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_public" class="ml-2 block text-sm text-gray-900">
                                    Rendre cette réponse publique
                                </label>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Si coché, cette question et sa réponse seront visibles sur la page publique.</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4">
                            <button type="button" onclick="window.history.back()" 
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition duration-150 ease-in-out">
                                Annuler
                            </button>
                            <button type="submit" id="submitBtn"
                                class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                @if($question->is_answered)
                                    Modifier la réponse
                                @else
                                    Publier la réponse
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm mx-auto">
        <div class="flex items-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-900">Enregistrement en cours...</span>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('answerForm');
    const submitBtn = document.getElementById('submitBtn');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const imageInput = document.getElementById('answer_images');
    const imagePreview = document.getElementById('imagePreview');

    // Handle image preview
    imageInput.addEventListener('change', function(e) {
        const files = e.target.files;
        imagePreview.innerHTML = '';
        
        if (files.length > 0) {
            imagePreview.classList.remove('hidden');
            
            Array.from(files).forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative group';
                        div.innerHTML = `
                            <img src="${e.target.result}" alt="Aperçu ${index + 1}" class="w-full h-24 object-cover rounded-lg">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                <span class="text-white text-xs">Nouvelle image</span>
                            </div>
                        `;
                        imagePreview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                }
            });
        } else {
            imagePreview.classList.add('hidden');
        }
    });

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading overlay
        loadingOverlay.classList.remove('hidden');
        loadingOverlay.classList.add('flex');
        submitBtn.disabled = true;

        // Create FormData object
        const formData = new FormData(form);

        // Submit via fetch
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showNotification(data.message, 'success');
                
                // Redirect after a short delay
                setTimeout(() => {
                    window.location.href = '{{ route("questions.admin") }}';
                }, 1500);
            } else {
                throw new Error(data.message || 'Une erreur est survenue');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Une erreur est survenue. Veuillez réessayer.', 'error');
        })
        .finally(() => {
            // Hide loading overlay
            loadingOverlay.classList.add('hidden');
            loadingOverlay.classList.remove('flex');
            submitBtn.disabled = false;
        });
    });

    // Notification function
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 max-w-sm w-full p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${
            type === 'success' ? 'bg-green-500 text-white' : 
            type === 'error' ? 'bg-red-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        
        notification.innerHTML = `
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    ${type === 'success' ? 
                        '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>' :
                        '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>'
                    }
                </div>
                <div class="ml-3">
                    <p class="font-medium">${message}</p>
                </div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 5000);
    }
});
</script>
@endsection