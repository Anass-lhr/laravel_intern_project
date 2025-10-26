<style>
    .comment-card {
        background-color: var(--darker-bg);
        padding: 1rem;
        border-radius: 0.75rem;
        transition: transform 0.2s ease;
        border: 1px solid #333333;
    }

    .comment-card:hover {
        transform: translateY(-3px);
        border: 1px solid var(--primary-color);
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
        position: relative;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary-color);
    }

    .initial-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid var(--primary-color);
        background-color: var(--gray-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: bold;
        color: var(--light-text);
        text-transform: uppercase;
    }

    .user-details .username {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--light-text);
    }

    .user-details .post-date {
        font-size: 0.75rem;
        color: var(--gray-text);
    }

    .more-actions-btn {
        background: none;
        border: none;
        color: var(--gray-text);
        font-size: 1.2rem;
        cursor: pointer;
        padding: 2px;
        transition: color 0.2s ease;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .more-actions-btn:hover {
        color: var(--light-text);
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background-color: var(--gray-bg);
        border: 1px solid #333333;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        border-radius: 4px;
        display: none;
        z-index: 10;
        min-width: 120px;
        padding: 2px 0;
    }

    .dropdown-item {
        padding: 8px 12px;
        font-size: 14px;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.2s ease;
        width: 100%;
        text-align: left;
        border: 1px solid #333333;
    }

    .dropdown-item:hover {
        background-color: rgb(255, 0, 0);
        color: #fff;
    }

    .dropdown-item.delete {
        background-color: var(--gray-bg);
        border:none;
        border-radius: 4px;
        color: #fff;
    }


    .dropdown-item.delete:hover {
        background-color: rgb(255, 0, 0);
        color: #fff;
    }

    .dropdown-item.report {
        border-radius: 4px;
        color: #fff;
    }

    .dropdown-item.report:hover {
        background-color: rgb(255, 0, 0);
        color: #fff;
    }

    .report-form-container {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #2d2d2d;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        z-index: 1000;
        color: #ffffff;
        font-family: Arial, sans-serif;
        width: 400px;
        max-width: 90%;
    }

    .report-form-container label {
        display: block;
        font-size: 0.875rem;
        margin-bottom: 5px;
    }

    .report-form-container select,
    .report-form-container textarea {
        width: 100%;
        padding: 8px;
        background-color: #1a1a1a;
        color: #ffffff;
        border: 1px solid #444;
        border-radius: 4px;
        font-size: 0.875rem;
        margin-bottom: 10px;
    }

    .report-form-container textarea {
        resize: vertical;
        min-height: 80px;
    }

    .report-form-container .btn {
        padding: 8px 16px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
    }

    .report-form-container .btn-submit {
        background-color: #e53e3e;
        color: #ffffff;
        border: none;
    }

    .report-form-container .btn-submit:hover {
        background-color: #c53030;
    }

    .report-form-container .btn-cancel {
        background-color: #6b7280;
        color: #ffffff;
        border: none;
    }

    .report-form-container .btn-cancel:hover {
        background-color: #4b5563;
    }

    .report-form-container .flex {
        display: flex;
        justify-content: center;
        gap: 10px;
    }



    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* NOUVEAU : Style pour les boutons désactivés */
    .disabled-btn {
        background-color: #2a2a2a !important;
        cursor: not-allowed !important;
        opacity: 0.6;
    }

    .comment-content {
        font-size: 0.9rem;
        color: var(--gray-text);
        line-height: 1.5;
        margin-bottom: 0.75rem;
    }

    .comment-interactions {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.85rem;
        color: var(--gray-text);
        margin-top: 0.5rem;
    }

    .vote-buttons {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .vote-buttons button {
        background: none;
        border: none;
        color: var(--gray-text);
        font-size: 0.9rem;
        transition: color 0.2s ease;
    }

    .vote-buttons button:hover {
        color: var(--light-text);
    }

    .vote-score {
        font-weight: 600;
        color: var(--light-text);
    }

    .reply-button, .replies-toggle {
        background: none;
        border: none;
        color: var(--primary-color);
        font-size: 0.85rem;
        transition: color 0.2s ease;
    }

    .reply-button:hover, .replies-toggle:hover {
        color: color-mix(in srgb, var(--primary-color) 80%, #ffffff);
    }

    .reply-form {
        margin-top: 0.75rem;
    }

    .reply-form textarea {
        width: 100%;
        padding: 0.5rem;
        background-color: var(--dark-bg);
        color: var(--light-text);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 0.5rem;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        resize: vertical;
    }

    .reply-form .submit-reply {
        padding: 0.5rem 1rem;
        background-color: var(--primary-color);
        color: var(--light-text);
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .reply-form .submit-reply:hover {
        background-color: color-mix(in srgb, var(--primary-color) 80%, #000000);
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
    }

    .replies-container {
        margin-top: 1rem;
    }

    .confirm-modal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: var(--gray-bg);
        border: 1px solid var(--dark-bg);
        border-radius: 8px;
        padding: 20px;
        z-index: 1000;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        max-width: 400px;
        width: 90%;
    }

    .confirm-modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        z-index: 999;
    }

    .confirm-modal-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--light-text);
    }

    .confirm-modal-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .confirm-modal-buttons button {
        padding: 8px 16px;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .confirm-modal-cancel {
        background: transparent;
        border: 1px solid var(--gray-text);
        color: var(--light-text);
    }

    .confirm-modal-confirm {
        background: #e53e3e;
        border: none;
        color: var(--light-text);
    }

    .confirm-modal-cancel:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .confirm-modal-confirm:hover {
        background: #c53030;
    }

    @media (max-width: 768px) {
        .comment-card {
            padding: 0.75rem;
        }

        .user-avatar, .initial-avatar {
            width: 35px;
            height: 35px;
            font-size: 14px;
        }

        .user-details .username {
            font-size: 0.85rem;
        }

        .user-details .post-date {
            font-size: 0.7rem;
        }

        .comment-content {
            font-size: 0.85rem;
        }

        .comment-interactions {
            font-size: 0.8rem;
        }
    }

    @media (max-width: 576px) {
        .user-avatar, .initial-avatar {
            width: 35px;
            height: 35px;
            font-size: 14px;
        }

        .user-details .username {
            font-size: 0.85rem;
        }

        .user-details .post-date {
            font-size: 0.7rem;
        }

        .comment-content {
            font-size: 0.8rem;
        }

        .reply-form textarea {
            font-size: 0.8rem;
        }

        .reply-form .submit-reply {
            width: 100%;
            text-align: center;
        }
    }

        #delete-post{
            width: 100%;
        }
</style>

<div class="comment-card mb-2">
    <div class="comment-header">
        <div class="user-info">
            @if ($comment->user->avatar)
                <img src="{{ Storage::url($comment->user->avatar) }}" alt="User Avatar" class="user-avatar">
            @elseif ($comment->user->provider)
                <img src="https://via.placeholder.com/150" alt="User Avatar" class="user-avatar">
            @else
                <div class="initial-avatar">{{ substr($comment->user->name, 0, 1) }}</div>
            @endif
            <div class="user-details">
                <span class="username">{{ $comment->user->name }}</span>
                <p class="post-date">le {{ $comment->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        
        <!-- MODIFIÉ : Gestion du blocage pour le menu à trois points -->
        @auth
            @if (!(isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active)))
                <div class="relative">
                    <button class="more-actions-btn" onclick="toggleDropdown('comment-menu-{{ $comment->id }}')">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="6" r="2" fill="currentColor"/>
                            <circle cx="12" cy="12" r="2" fill="currentColor"/>
                            <circle cx="12" cy="18" r="2" fill="currentColor"/>
                        </svg>
                    </button>
                    <div id="comment-menu-{{ $comment->id }}" class="dropdown-menu">
                        @if (Auth::id() === $comment->user_id || Auth::user()->canManageForum())
                            <form id="delete-comment-{{ $comment->id }}" action="{{ route('comment.delete', $comment) }}" method="POST" class="inline-block"  id="delete-post">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmAction(event, this.form, 'Êtes-vous sûr de vouloir supprimer ce commentaire ?', 'Supprimer')" class="dropdown-item delete">Supprimer</button>
                            </form>
                        @endif
                        @if (Auth::id() !== $comment->user_id)
                            <div class="dropdown-item report" onclick="toggleReportForm('comment-report-{{ $comment->id }}')">Signaler</div>
                        @endif
                    </div>
                </div>

            @endif
        @endauth
    </div>

    <!-- MODIFIÉ : Formulaire de signalement désactivé pour les utilisateurs bloqués -->
    @auth
        @if (Auth::id() !== $comment->user_id && !(isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active)))
            <div id="comment-report-{{ $comment->id }}" class="report-form-container">
                <form action="{{ route('report.submit', ['type' => 'comment', 'id' => $comment->id]) }}" method="POST">
                    @csrf
                    <label for="reason_category">Raison du signalement</label>
                    <select name="reason_category" id="reason_category" required>
                        <option value="" disabled selected>Choisir une raison</option>
                        <option value="Contenu inapproprié">Contenu inapproprié</option>
                        <option value="Spam">Spam</option>
                        <option value="Harcèlement">Harcèlement</option>
                        <option value="Informations fausses ou trompeuses">Informations fausses ou trompeuses</option>
                        <option value="Autre">Autre</option>
                    </select>
                    <textarea name="reason_details" rows="2" placeholder="Expliquez la situation..." required></textarea>
                    <div class="flex">
                        <button type="submit" class="btn btn-submit">Envoyer</button>
                        <button type="button" onclick="toggleReportForm('comment-report-{{ $comment->id }}')" class="btn btn-cancel">Annuler</button>
                    </div>
                </form>
            </div>
        @endif
    @endauth

    <p class="comment-content">{{ $comment->content }}</p>

    <div class="comment-interactions">
        <div class="vote-buttons">
            <!-- MODIFIÉ : Désactiver les boutons de vote pour les utilisateurs bloqués -->
            @if (isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active))
                <button type="button" class="disabled-btn" disabled><i class="fas fa-arrow-up"></i></button>
                <span class="vote-score">{{ $comment->vote_score }}</span>
                <button type="button" class="disabled-btn" disabled><i class="fas fa-arrow-down"></i></button>
            @else
                <form action="{{ route('comment.vote', $comment) }}" method="POST">
                    @csrf
                    <input type="hidden" name="is_upvote" value="1">
                    <button type="submit"><i class="fas fa-arrow-up"></i></button>
                </form>
                <span class="vote-score">{{ $comment->vote_score }}</span>
                <form action="{{ route('comment.vote', $comment) }}" method="POST">
                    @csrf
                    <input type="hidden" name="is_upvote" value="0">
                    <button type="submit"><i class="fas fa-arrow-down"></i></button>
                </form>
            @endif
        </div>

        <!-- MODIFIÉ : Désactiver le bouton de réponse pour les utilisateurs bloqués -->
        @auth
            @if (!(isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active)))
                <button onclick="toggleReplyForm({{ $comment->id }})" class="reply-button">Répondre</button>
            @else
                <button class="reply-button disabled-btn" disabled>Répondre</button>
            @endif
        @endauth

        @if ($comment->replies->count() > 0)
            <button id="toggle-replies-{{ $comment->id }}" onclick="toggleReplies({{ $comment->id }})" class="replies-toggle">
                {{ $comment->replies->count() }} Réponse(s)
            </button>
        @endif
    </div>

    <!-- MODIFIÉ : Gestion du blocage pour le formulaire de réponse -->
    @auth
        @if (!(isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active)))
            <div id="reply-form-{{ $comment->id }}" class="reply-form hidden">
                <form action="{{ route('post.comment', $comment->post) }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <textarea name="content" rows="2" placeholder="Écrire une réponse..." required></textarea>
                    <button type="submit" class="submit-reply">Répondre</button>
                </form>
            </div>
        @else
            <div id="reply-form-{{ $comment->id }}" class="reply-form hidden">
                <textarea rows="2" readonly placeholder="Vous êtes bloqué et ne pouvez pas répondre." class="cursor-not-allowed bg-[#2a2a2a] opacity-60"></textarea>
                <button type="button" class="submit-reply disabled-btn" disabled>Répondre</button>
            </div>
        @endif
    @endauth

    @if ($comment->replies->count() > 0)
        <div id="replies-{{ $comment->id }}" class="replies-container hidden">
            @foreach ($comment->replies as $reply)
                @include('forum.comment', ['comment' => $reply, 'level' => $level + 1])
            @endforeach
        </div>
    @endif
</div>
<br>