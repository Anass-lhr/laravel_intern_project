<!DOCTYPE html>
<html lang="fr">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">

    <title>Mon Profil  </title>
    <style>
        body, html {
            background-color: #121212;
            color: #ffffff;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }

        .header-bar {
            background-color: #000000;
            padding: 15px 0;
            text-align: center;
            border-bottom: 1px solid #333;
        }

        .profile-container {
            min-height: calc(100vh - 60px);
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        .avatar-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 0;
            position: relative;
            background-color: #1a1a1a;
        }

        .avatar-container {
            position: relative;
            width: 200px;
            height: 200px;
            margin-bottom: 20px;
            cursor: pointer;
        }

        .avatar-ring {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 4px solid #ff0000;
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.6);
            overflow: hidden;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .initial-avatar {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 4px solid #ff0000;
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.6);
            background-color: #2a2a2a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 80px;
            font-weight: bold;
            color: #ffffff;
            text-transform: uppercase;
        }

        .user-info {
            text-align: center;
        }

        .user-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .user-email {
            color: #aaa;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .user-since {
            color: #777;
            font-size: 14px;
        }

        .form-section {
            padding: 30px;
            background-color: #1a1a1a;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            background-color: #ffffff;
            color: #000000;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-input[readonly] {
            background-color: #2a2a2a;
            color: #aaa;
            cursor: not-allowed;
        }

        .save-button {
            background-color: #16a34a !important;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            float: right;
            display: flex;
            align-items: center;
        }

        .save-icon {
            margin-right: 8px;
        }

        .account-actions {
            padding: 20px 30px;
            background-color: #1a1a1a;
            border-top: 1px solid #333;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .logout-button, .delete-button {
            color: white;
            border: none;
            padding: 12px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .logout-button {
            background-color: #4b5563 !important;
        }

        .delete-button {
            background-color: #dc2626 !important;
        }

        .button-icon {
            margin-right: 8px;
        }

        /* Context Menu Styles */
        .context-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #1a1a1a;
            border: 1px solid #333;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            min-width: 150px;
            margin-top: 10px;
        }

        .context-menu-item {
            padding: 10px 15px;
            color: #ffffff;
            background-color: transparent;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .context-menu-item:hover {
            background-color: #333;
        }

        .context-menu-item svg {
            margin-right: 8px;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            border: 1px solid #333;
        }

        .modal-content p {
            font-size: 18px;
            margin-bottom: 20px;
            color: #ffffff;
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .modal-button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            color: white;
        }

        .modal-button.yes {
            background-color: #dc2626;
        }

        .modal-button.no {
            background-color: #4b5563;
        }

        .modal-button:hover {
            opacity: 0.9;
        }

        /* Toast Notification Styles */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
        }

        .toast {
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: white;
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 300px;
            transform: translateX(400px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 4px solid #22c55e;
            backdrop-filter: blur(10px);
        }

        .toast.show {
            transform: translateX(0);
            opacity: 1;
        }

        .toast-icon {
            width: 24px;
            height: 24px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 2px;
        }

        .toast-message {
            font-size: 14px;
            opacity: 0.9;
        }

        .toast-close {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .toast-close:hover {
            opacity: 1;
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Progress bar for auto-dismiss */
        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 0 0 8px 8px;
            transition: width linear;
        }

        /* Responsive Design for Smaller Screens */
        @media (max-width: 600px) {
            .action-buttons {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .logout-button, .delete-button {
                padding: 8px;
                font-size: 14px;
                min-height: 40px;
            }

            .button-icon {
                margin-right: 6px;
                width: 14px;
                height: 14px;
            }

            .form-section {
                padding: 20px;
            }

            .account-actions {
                padding: 15px 20px;
            }

            .avatar-container, .avatar-ring, .initial-avatar {
                width: 150px;
                height: 150px;
            }

            .initial-avatar {
                font-size: 60px;
            }

            .context-menu {
                min-width: 120px;
            }

            .context-menu-item {
                padding: 8px 12px;
                font-size: 12px;
            }

            .toast-container {
                top: 10px;
                right: 10px;
                left: 10px;
            }

            .toast {
                min-width: auto;
                width: 100%;
            }
        }
    </style>

    <div class="header-bar">
        <h2 class="font-semibold text-xl text-white">Mon Profil</h2>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toast-container"></div>

    <div class="profile-container">
        <div class="main-content">
            <!-- Section Avatar -->
            <div class="avatar-section">
                <div class="avatar-container" id="avatar-container">
                    @if (auth()->user()->avatar)
                        <div class="avatar-ring">
                            <img class="avatar-img" src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" id="avatar-image">
                        </div>
                    @elseif (auth()->user()->provider)
                        <div class="avatar-ring">
                            <img class="avatar-img" src="{{ auth()->user()->provider == 'facebook' ? 'https://graph.facebook.com/' . auth()->user()->provider_id . '/picture?type=large' : 'https://lh3.googleusercontent.com/a-/' . auth()->user()->provider_id . '?sz=150' }}" alt="Avatar" id="avatar-image">
                        </div>
                    @else
                        <div class="initial-avatar" id="initial-avatar">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                    <!-- Context Menu -->
                    @if (!auth()->user()->provider)
                        <div class="context-menu" id="avatar-context-menu">
                            <button class="context-menu-item" onclick="document.getElementById('avatar-input').click();">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9"></path>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                </svg>
                                Choisir une photo
                            </button>
                            @if (auth()->user()->avatar)
                                <form method="POST" action="{{ route('profile.remove-avatar') }}" id="remove-avatar-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="context-menu-item" onclick="showDeleteAvatarModal()">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                        Supprimer la photo
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="user-info">
                    <h3 class="user-name">{{ auth()->user()->name }}</h3>
                    <p class="user-email">{{ auth()->user()->email }}</p>
                    <p class="user-since">
                        @php
                            \Carbon\Carbon::setLocale('fr');
                        @endphp
                        Membre depuis {{ auth()->user()->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>

            <!-- Section Formulaire -->
            <div class="form-section">
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-900 bg-opacity-20 p-3 rounded-md border-l-4 border-green-500">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 font-medium text-sm text-red-600 bg-red-900 bg-opacity-20 p-3 rounded-md border-l-4 border-red-500">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 font-medium text-sm text-red-600 bg-red-900 bg-opacity-20 p-3 rounded-md border-l-4 border-red-500">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profile-form">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="name" class="form-label">Nom</label>
                        <input id="name" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" readonly class="form-input">
                    </div>

                    @if (!auth()->user()->provider)
<input id="avatar-input" type="file" name="avatar" class="hidden" accept="image/*" onchange="previewAvatar(event)" style="display: none;">                    @endif

                    <div style="text-align: right; margin-top: 30px;">
                        <button type="submit" class="save-button">
                            <svg class="save-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                <polyline points="7 3 7 8 15 8"></polyline>
                            </svg>
                            Sauvegarder les modifications
                        </button>
                    </div>
                </form>
            </div>

            <!-- Section Actions -->
            <div class="account-actions">
                <h3 class="section-title">Actions de compte</h3>
                <div class="action-buttons">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-button">
                            <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            Se déconnecter
                        </button>
                    </form>

                    <form method="POST" action="{{ route('profile.destroy') }}" id="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="delete-button" onclick="showDeleteModal()">
                            <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                            Supprimer le compte
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Deletion Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <p>Voulez-vous vraiment supprimer votre compte ?</p>
            <div class="modal-buttons">
                <button class="modal-button yes" onclick="submitDeleteForm()">Oui</button>
                <button class="modal-button no" onclick="closeDeleteModal()">Non</button>
            </div>
        </div>
    </div>

    <!-- Avatar Deletion Modal (seulement pour les utilisateurs non sociaux) -->
    @if (!auth()->user()->provider)
        <div class="modal" id="deleteAvatarModal">
            <div class="modal-content">
                <p>Voulez-vous vraiment supprimer votre photo ?</p>
                <div class="modal-buttons">
                    <button class="modal-button yes" onclick="submitDeleteAvatarForm()">Oui</button>
                    <button class="modal-button no" onclick="closeDeleteAvatarModal()">Non</button>
                </div>
            </div>
        </div>
    @endif

    <script>
        // Toast Notification Function
        function showToast(title, message, type = 'success', duration = 5000) {
            const toastContainer = document.getElementById('toast-container');
            
            // Create toast element
            const toast = document.createElement('div');
            toast.className = 'toast';
            
            // Create toast content
            toast.innerHTML = `
                <div class="toast-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close" onclick="closeToast(this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
                <div class="toast-progress"></div>
            `;
            
            // Add toast to container
            toastContainer.appendChild(toast);
            
            // Show toast with animation
            setTimeout(() => {
                toast.classList.add('show');
            }, 100);
            
            // Auto dismiss
            const progressBar = toast.querySelector('.toast-progress');
            progressBar.style.width = '100%';
            progressBar.style.transitionDuration = duration + 'ms';
            
            setTimeout(() => {
                progressBar.style.width = '0%';
            }, 100);
            
            setTimeout(() => {
                closeToast(toast.querySelector('.toast-close'));
            }, duration);
        }

        function closeToast(button) {
            const toast = button.closest('.toast');
            toast.classList.remove('show');
            setTimeout(() => {
                toast.remove();
            }, 400);
        }

        // Check for session messages and show toast
        @if (session('status'))
            document.addEventListener('DOMContentLoaded', function() {
                showToast('Succès !', 'Profil mis à jour avec succès !', 'success');
            });
        @endif

        @if (session('avatar_updated'))
            document.addEventListener('DOMContentLoaded', function() {
                showToast('Photo mise à jour !', 'Votre photo de profil a été mise à jour avec succès !', 'success');
            });
        @endif

        @if (session('avatar_removed'))
            document.addEventListener('DOMContentLoaded', function() {
                showToast('Photo supprimée !', 'Votre photo de profil a été supprimée avec succès !', 'success');
            });
        @endif

        // Avatar preview function (seulement pour les utilisateurs non sociaux)
        function previewAvatar(event) {
            const file = event.target.files[0];
            const avatarImage = document.getElementById('avatar-image');
            const initialAvatar = document.getElementById('initial-avatar');
            const avatarContainer = document.querySelector('.avatar-container');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Si un avatar existant est affiché
                    if (avatarImage) {
                        avatarImage.src = e.target.result;
                    } else {
                        // Si un avatar initial (lettre) est affiché, le remplacer par une image
                        if (initialAvatar) {
                            initialAvatar.remove();
                        }
                        const newAvatarRing = document.createElement('div');
                        newAvatarRing.className = 'avatar-ring';
                        const newAvatarImg = document.createElement('img');
                        newAvatarImg.className = 'avatar-img';
                        newAvatarImg.id = 'avatar-image';
                        newAvatarImg.src = e.target.result;
                        newAvatarImg.alt = 'Avatar';
                        newAvatarRing.appendChild(newAvatarImg);
                        avatarContainer.prepend(newAvatarRing);
                    }
                };

                reader.readAsDataURL(file);
            }
        }

        // Context Menu Handling (seulement pour les utilisateurs non sociaux)
        @if (!auth()->user()->provider)
            const avatarContainer = document.getElementById('avatar-container');
            const contextMenu = document.getElementById('avatar-context-menu');

            avatarContainer.addEventListener('click', function(e) {
                e.preventDefault();
                contextMenu.style.display = 'block';
            });

            // Close context menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!avatarContainer.contains(e.target) && !contextMenu.contains(e.target)) {
                    contextMenu.style.display = 'none';
                }
            });
        @endif

        // Account Deletion Modal Functions
        function showDeleteModal() {
            const modal = document.getElementById('deleteModal');
            if (modal) {
                modal.style.display = 'flex';
                console.log('Account deletion modal displayed');
            } else {
                console.error('Account deletion modal element not found');
            }
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            if (modal) {
                modal.style.display = 'none';
                console.log('Account deletion modal closed');
            } else {
                console.error('Account deletion modal element not found');
            }
        }

        function submitDeleteForm() {
            const form = document.getElementById('delete-form');
            if (form) {
                console.log('Submitting account deletion form');
                form.submit();
            } else {
                console.error('Account deletion form not found');
            }
        }

        // Avatar Deletion Modal Functions (seulement pour les utilisateurs non sociaux)
        @if (!auth()->user()->provider)
            function showDeleteAvatarModal() {
                const modal = document.getElementById('deleteAvatarModal');
                if (modal) {
                    modal.style.display = 'flex';
                    contextMenu.style.display = 'none';
                    console.log('Avatar deletion modal displayed');
                } else {
                    console.error('Avatar deletion modal element not found');
                }
            }

            function closeDeleteAvatarModal() {
                const modal = document.getElementById('deleteAvatarModal');
                if (modal) {
                    modal.style.display = 'none';
                    console.log('Avatar deletion modal closed');
                } else {
                    console.error('Avatar deletion modal element not found');
                }
            }

            function submitDeleteAvatarForm() {
                const form = document.getElementById('remove-avatar-form');
                if (form) {
                    console.log('Submitting avatar deletion form');
                    form.submit();
                } else {
                    console.error('Avatar deletion form not found');
                }
            }
        @endif
    </script>
</body>
</html>