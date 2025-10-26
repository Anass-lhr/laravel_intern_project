<!doctype html>
<html>
<head>
    <title>Modifier un article</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
   <script>

        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: 'var(--primary-color, #1a9e9e)', // Utilise la variable CSS personnalisée
                            hover: 'var(--primary-color-hover, #25c4c4)',
                            dark: 'var(--primary-color-dark, #148585)',
                        },
                        danger: '#b91c1c',
                        warning: '#b45309',
                        success: '#10b981',
                        dark: {
                            DEFAULT: '#121212',
                            card: '#1e1e1e',
                            element: '#252525',
                            border: '#333333',
                        },
                    },
                    animation: {
                        'tag-delete': 'tagDelete 0.3s ease-in-out forwards',
                    },
                    keyframes: {
                        tagDelete: {
                            '0%': { transform: 'scale(1)', opacity: '1' },
                            '50%': { transform: 'scale(0.95)', opacity: '0.8' },
                            '100%': { transform: 'scale(0.9)', opacity: '0' },
                        }
                    }
                }
            }
        }
    </script>
     <style>
        /* Styles pour le multiselect personnalisé */
.multiselect-container {
    position: relative;
    background-color: var(--gray-bg);
    border: 1px solid var(--dark-border);
    border-radius: 0.5rem;
    min-height: 48px;
    cursor: pointer;
    transition: border-color 0.3s ease;
}

.multiselect-container:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 8px var(--article-shadow);
}

.multiselect-display {
    padding: 0.75rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    align-items: center;
    min-height: 48px;
}

.multiselect-placeholder {
    color: var(--gray-text);
}

.multiselect-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background-color: var(--gray-bg);
    border: 1px solid var(--dark-border);
    border-radius: 0.5rem;
    margin-top: 0.25rem;
    max-height: 200px;
    overflow-y: auto;
    z-index: 10;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

.multiselect-option {
    padding: 0.75rem;
    cursor: pointer;
    transition: background-color 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.multiselect-option:hover {
    background-color: var(--dark-element);
}

.multiselect-option.selected {
    background-color: var(--primary-color);
    color: var(--light-text);
}

.multiselect-checkbox {
    width: 16px;
    height: 16px;
    border: 2px solid var(--primary-color);
    border-radius: 3px;
    position: relative;
    background-color: transparent;
}

.multiselect-checkbox.checked {
    background-color: var(--primary-color);
}

.multiselect-checkbox.checked::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: var(--light-text);
    font-size: 12px;
    font-weight: bold;
}

.container {
    padding: 1rem 0.5rem;
}

.w-full.max-w-3xl {
    padding: 1.5rem;
}

/* CHAMPS DE SAISIE RESPONSIVE */
input[type="text"],
input[type="file"],
textarea,
#corps-editor {
    font-size: 16px !important; /* Évite le zoom iOS */
    min-height: 44px; /* Taille tactile minimale */
}

/* ÉDITEUR RESPONSIVE */
#editor-container {
    overflow-x: auto;
}

#editor-container .bg-darkbg {
    padding: 0.5rem;
    flex-wrap: wrap;
    gap: 0.25rem;
    overflow-x: auto;
}

#editor-container button,
#editor-container select {
    min-width: 32px;
    min-height: 32px;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

/* MULTISELECT RESPONSIVE */
.multiselect-container {
    min-height: 44px;
}

.multiselect-display {
    padding: 0.5rem;
    min-height: 44px;
    flex-wrap: wrap;
    gap: 0.25rem;
}

/* BOUTONS RESPONSIVE */
.btn {
    min-height: 44px;
    min-width: 44px;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
}

/* MODAUX RESPONSIVE */
.modal-content,
.bg-darkbg-light.rounded-lg.shadow-xl {
    margin: 1rem;
    max-width: calc(100vw - 2rem);
    max-height: calc(100vh - 2rem);
    overflow-y: auto;
}

/* MEDIA QUERIES */
@media (max-width: 480px) {
    .container {
        padding: 0.5rem 0.25rem;
    }

    .w-full.max-w-3xl {
        padding: 1rem;
        margin: 0.5rem auto;
    }

    /* Toolbar verticale sur très petit écran */
    #editor-container .bg-darkbg {
        flex-direction: column;
        align-items: stretch;
    }

    #editor-container .flex.gap-1 {
        justify-content: space-around;
        margin-bottom: 0.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #374151;
        border-right: none !important;
    }

    #editor-container button {
        flex: 1;
        min-width: 36px;
        font-size: 0.7rem;
    }

    #editor-container select {
        width: 100%;
        margin-bottom: 0.25rem;
    }

    /* Boutons empilés */
    .flex.items-center.justify-between {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }

    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
        justify-content: center;
    }

    /* Modaux plein écran */
    .modal-content,
    .bg-darkbg-light.rounded-lg.shadow-xl {
        margin: 0;
        width: 100vw;
        height: 100vh;
        max-width: 100vw;
        max-height: 100vh;
        border-radius: 0;
    }

    /* Multiselect mobile */
    .multiselect-dropdown {
        position: fixed !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        width: 90vw !important;
        max-height: 60vh !important;
        z-index: 9999 !important;
    }

    /* Réduction des tailles de texte */
    h1, .text-3xl {
        font-size: 1.5rem !important;
    }

    .text-lg {
        font-size: 1rem !important;
    }

    label {
        font-size: 0.9rem;
    }
}

@media (min-width: 481px) and (max-width: 768px) {
    .container {
        padding: 1rem 0.5rem;
    }

    #editor-container .border-r {
        border-right: none;
        border-bottom: 1px solid #374151;
        width: 100%;
        margin-bottom: 0.5rem;
        padding-bottom: 0.5rem;
    }

    .flex.items-center.justify-between {
        flex-wrap: wrap;
        gap: 1rem;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .w-full.max-w-3xl {
        max-width: 90%;
        padding: 2rem;
    }
}

/* Safari iOS fix */
@supports (-webkit-touch-callout: none) {
    input[type="text"],
    textarea,
    select {
        font-size: 16px !important;
    }
}

/* Scrollbars mobiles */
@media (max-width: 768px) {
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: var(--dark-bg);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: 3px;
    }
}
.selected-tag {
    display: inline-flex;
    align-items: center;
    background-color: var(--primary-color);
    color: var(--light-text);
    border-radius: 9999px;
    padding: 0.25rem 0.75rem;
    font-size: 0.75rem;
    gap: 0.5rem;
}

.selected-tag .remove-tag {
    cursor: pointer;
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    width: 16px;
    height: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    transition: background-color 0.2s ease;
}

.selected-tag .remove-tag:hover {
    background-color: rgba(255, 255, 255, 0.3);
}
        /* Variables CSS alignées avec la page de détail d'article */
        :root {
            @php
                $settings = App\Models\Setting::first();
                $primaryColor = $settings->primary_color ?? '#1EB5AD';
            @endphp
            --primary-color: {{ $primaryColor }};
            --primary-color-hover: color-mix(in srgb, var(--primary-color) 80%, #000000);
            --primary-color-dark: #148585;
            --dark-bg: #1A1D21;
            --darker-bg: #111315;
            --light-text: #ffffff;
            --gray-text: #9CA3AF;
            --gray-bg: #2A2D35;
            --highlight-color: #00f0ff;
            --article-shadow: rgba(0, 240, 255, 0.05);
            --dark-border: #333333;
            --dark-element: #252525;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: var(--darker-bg);
            color: var(--light-text);
            overflow-x: hidden;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        input[type="text"],
        input[type="file"],
        textarea,
        #corps-editor {
            background-color: var(--gray-bg);
            color: var(--primary-color); /* Utilise la couleur primaire configurée */
            border: 1px solid var(--dark-border);
            border-radius: 0.5rem;
            padding: 0.75rem;
            width: 100%;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="file"]:focus,
        textarea:focus,
        #corps-editor:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 8px var(--article-shadow);
        
        }

        label {
            color: var(--primary-color); /* Utilise la couleur primaire configurée */
            font-weight: bold;
            margin-bottom: 0.5rem;
            display: block;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--light-text);
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--primary-color-hover);
            transform: translateY(-2px);
        }

        .btn-outline {
            background: transparent;
            color: var(--light-text);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .btn-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .article-card {
            border: 1px solid var(--dark-border);
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            background-color: var(--dark-card);
        }

        .modal {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .modal-content {
            background-color: var(--gray-bg);
            padding: 1.5rem;
            border-radius: 0.75rem;
            max-width: 500px;
            width: 100%;
            border-top: 4px solid var(--primary-color);
        }

        .modal-button {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .modal-button-cancel {
            background-color: var(--dark-element);
            color: var(--light-text);
        }

        .modal-button-cancel:hover {
            background-color: var(--dark-border);
        }

        .modal-button-confirm {
            background-color: var(--primary-color); /* Utilise la couleur primaire configurée */
            color: var(--light-text);
            transform: translateY(-1px);
        }

        .modal-button-confirm:hover {
            background-color: var(--primary-color-hover);
            transform: translateY(-2px);
        }

        .modal-button-publish {
            background-color: var(--success);
        }

        .modal-button-publish:hover {
            background-color: var(--primary-color);
        }

        .modal-button-draft {
            background-color: var(--dark-element);
        }

        .modal-button-draft:hover {
            background-color: var(--dark-border);
        }

        .filter-select {
            background-color: var(--gray-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--light-text);
            padding: 0.5rem 2.5rem 0.5rem 0.75rem;
            border-radius: 0.5rem;
            appearance: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 8px var(--article-shadow);
        }

        .filter-select:hover {
            border-color: var(--primary-color);
        }

        .category-tag {
            display: inline-block;
            background-color: var(--dark-element);
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            font-weight: 500;
            border-radius: 9999px;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        #corps-editor {
            background-color: var(--gray-bg);
            color: var(--light-text);
            border: 1px solid var(--dark-border);
            border-radius: 0.5rem;
            padding: 1rem;
            min-height: 250px;
        }

        #corps-editor ul {
            list-style-type: disc !important;
            padding-left: 1.5em !important;
            margin-bottom: 1em !important;
        }

        #corps-editor ol {
            list-style-type: decimal !important;
            padding-left: 1.5em !important;
            margin-bottom: 1em !important;
        }

        #corps-editor li {
            display: list-item !important;
            margin-bottom: 0.5em !important;
        }

        .article-image-container {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .article-image {
            max-height: 200px;
            object-fit: cover;
            border-radius: 0.5rem;
        }    

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
        }

        @media (max-width: 576px) {
            .btn {
                font-size: 0.8rem;
                padding: 0.4rem 0.6rem;
            }

            .category-tag {
                font-size: 0.7rem;
            }
        }

        input{
            color: var(--light-text) !important;
        }

        #save-options-btn:hover{
          
            border-color: #ffff;
            color:#ffff;
            background: var( --gray-bg);
        
        }
        #enregistrer:hover,#confirmer:hover{
            background: var( --gray-bg);
        }
        .error-message {
            color: #E50914;
            text-align: center;
            padding: 20px;
            font-size: 1.1rem;
            background-color: #1A1A1A;
            border: 1px solid #E50914;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            margin: 20px auto;
            max-width: 1280px;
            transition: all 0.3s ease;
            animation: fadeIn 0.5s ease-out;
        }

        .error-message.temporary {
            animation: pulse-slow 1.8s ease-in-out infinite;
        }


    </style>
</head>
<body class="bg-darkbg text-gray-100">
    @if (isset($isBlocked) && $isBlocked || (auth()->check() && auth()->user()->role === 'admin' && !auth()->user()->is_active))
        <div class="error-message">
            Vous êtes bloqué et ne pouvez pas interagir avec le contenu. Si vous avez des questions, veuillez nous contacter : <a href="mailto:businessplus@gmail.com" class="text-accent-teal underline ">businessplus@gmail.com</a>.
        </div>
    @endif

<div class="container mx-auto px-4 py-8 overflow-x-hidden">
    <div class="main-container p-6 lg:p-8">
        @if ($errors->any())
            <div class="bg-red-900 border border-red-700 text-red-100 px-4 py-3 rounded relative mb-6" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" id="article-form">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="titre" class="block text-primary text-sm font-bold mb-2">Titre :</label>
                <input type="text" name="titre" id="titre" value="{{ old('titre', $article->titre) }}" required dir="auto"
                    class="shadow appearance-none bg-darkbg-lighter border border-gray-800 rounded w-full py-2 px-3 text-gray-100 leading-tight focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>

            <div class="mb-4">
                <label for="auteur" class="block text-primary text-sm font-bold mb-2">Auteur :</label>
                <input type="text" name="auteur" id="auteur" value="{{ old('auteur', $article->auteur) }}" dir="auto"
                    class="shadow appearance-none bg-darkbg-lighter border border-gray-800 rounded w-full py-2 px-3 text-gray-100 leading-tight focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-primary text-sm font-bold mb-2">Description :</label>
                <textarea name="description" id="description" rows="3" dir="auto"
                    class="shadow appearance-none bg-darkbg-lighter border border-gray-800 rounded w-full py-2 px-3 text-gray-100 leading-tight focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">{{ old('description', $article->description) }}</textarea>
            </div>

            <div class="mb-6">
                <label for="corps" class="block text-primary text-sm font-bold mb-2">Corps de l'article :</label>
                <input type="hidden" name="corps" id="corps" value="{{ old('corps', $article->corps) }}">
                
                <!-- Éditeur natif amélioré -->
                <div id="editor-container" class="border border-gray-800 rounded-md">
                    <div class="bg-darkbg p-2 border-b border-gray-800 flex flex-wrap gap-1 overflow-x-auto">
    <div class="flex flex-wrap gap-1 min-w-max">
        <div class="flex gap-1 border-r border-gray-800 pr-2 mr-2">
            <button type="button" title="Gras" onclick="execCommand('bold')" class="bg-darkbg-lighter border border-gray-800 rounded px-2 py-1 text-sm text-gray-200 hover:border-primary hover:text-primary"><b>G</b></button>
            <button type="button" title="Italique" onclick="execCommand('italic')" class="bg-darkbg-lighter border border-gray-800 rounded px-2 py-1 text-sm text-gray-200 hover:border-primary hover:text-primary"><i>I</i></button>
            <button type="button" title="Souligné" onclick="execCommand('underline')" class="bg-darkbg-lighter border border-gray-800 rounded px-2 py-1 text-sm text-gray-200 hover:border-primary hover:text-primary"><u>S</u></button>
            <button type="button" title="Barré" onclick="execCommand('strikeThrough')" class="bg-darkbg-lighter border border-gray-800 rounded px-2 py-1 text-sm text-gray-200 hover:border-primary hover:text-primary"><span style="text-decoration: line-through;">T</span></button>
        </div>
        <div class="flex gap-1 border-r border-gray-800 pr-2 mr-2">
            <button type="button" title="Liste numérotée" onclick="execCommand('insertOrderedList')" class="bg-darkbg-lighter border border-gray-800 rounded px-2 py-1 text-sm text-gray-200 hover:border-primary hover:text-primary">1.</button>
            <button type="button" title="Liste à puces" onclick="execCommand('insertUnorderedList')" class="bg-darkbg-lighter border border-gray-800 rounded px-2 py-1 text-sm text-gray-200 hover:border-primary hover:text-primary">•</button>
            <button type="button" title="Augmenter le retrait" onclick="execCommand('indent')" class="bg-darkbg-lighter border border-gray-800 rounded px-2 py-1 text-sm text-gray-200 hover:border-primary hover:text-primary">→</button>
            <button type="button" title="Diminuer le retrait" onclick="execCommand('outdent')" class="bg-darkbg-lighter border border-gray-800 rounded px-2 py-1 text-sm text-gray-200 hover:border-primary hover:text-primary">←</button>
        </div>
        <div class="flex gap-1 border-r border-gray-800 pr-2 mr-2">
            <button type="button" title="Aligner à gauche" onclick="execCommand('justifyLeft')" class="bg-darkbg-lighter border border-gray-800 rounded px-2 py-1 text-sm text-gray-200 hover:border-primary hover:text-primary">⬅️</button>
            <button type="button" title="Centrer" onclick="execCommand('justifyCenter')" class="bg-darkbg-lighter border border-gray-800 rounded px-2 py-1 text-sm text-gray-200 hover:border-primary hover:text-primary">↔️</button>
            <button type="button" title="Aligner à droite" onclick="execCommand('justifyRight')" class="bg-darkbg-lighter border border-gray-800 rounded px-2 py-1 text-sm text-gray-200 hover:border-primary hover:text-primary">➡️</button>
        </div>
        <div class="flex gap-1 border-r border-gray-800 pr-2 mr-2">
            <button type="button" title="Insérer un lien" onclick="createLink()" class="bg-darkbg-lighter border border-gray-800 rounded px-2 py-1 text-sm text-gray-200 hover:border-primary hover:text-primary">🔗</button>
            <button type="button" title="Insérer une image" onclick="document.getElementById('image-upload').click()" class="bg-darkbg-lighter border border-gray-800 rounded px-2 py-1 text-sm text-gray-200 hover:border-primary hover:text-primary">🖼️</button>
            <input type="file" id="image-upload" accept="image/*" style="display: none" onchange="insertImage(this)">
            <button type="button" title="Insérer un tableau" onclick="insertTable()" class="bg-darkbg-lighter border border-gray-800 rounded px-2 py-1 text-sm text-gray-200 hover:border-primary hover:text-primary">📊</button>
        </div>
        <div class="flex gap-1 border-r border-gray-800 pr-2 mr-2">
            <select onchange="execCommandWithArg('fontName', this.value)" class="bg-[var(--dark-border)] text-gray-200 border border-gray-800 rounded px-2 py-1 text-sm hover:border-primary">
                <option value="">Police</option>
                <option value="Arial">Arial</option>
                <option value="Courier New">Courier New</option>
                <option value="Georgia">Georgia</option>
                <option value="Times New Roman">Times New Roman</option>
                <option value="Verdana">Verdana</option>
            </select>
            <select onchange="execCommandWithArg('fontSize', this.value)" class="bg-[var(--dark-border)] text-gray-200 border border-gray-800 rounded px-2 py-1 text-sm hover:border-primary">
                <option value="">Taille</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
            </select>
            <select onchange="changeTextDirection(this.value)" class="bg-[var(--dark-border)] text-gray-200 border border-gray-800 rounded px-2 py-1 text-sm hover:border-primary">
                <option value="">Direction</option>
                <option value="ltr">De gauche à droite (LTR)</option>
                <option value="rtl">De droite à gauche (RTL)</option>
            </select>
        </div>
        <div class="flex gap-1 items-center">
            <div class="flex items-center">
                <label class="mr-1 text-xs text-primary">Texte:</label>
                <input type="color" onchange="execCommandWithArg('foreColor', this.value)" title="Couleur du texte" class="w-8 h-6 bg-darkbg-lighter border border-gray-800 rounded">
            </div>
            <div class="flex items-center ml-2">
                <label class="mr-1 text-xs text-primary">Fond:</label>
                <input type="color" onchange="execCommandWithArg('hiliteColor', this.value)" title="Couleur de fond" class="w-8 h-6 bg-darkbg-lighter border border-gray-800 rounded">
            </div>
            <button type="button" title="Annuler" onclick="execCommand('undo')" class="bg-darkbg-lighter border border-gray-800 rounded px-2 py-1 text-sm text-gray-200 hover:border-primary hover:text-primary">↩️</button>
            <button type="button" title="Rétablir" onclick="execCommand('redo')" class="bg-darkbg-lighter border border-gray-800 rounded px-2 py-1 text-sm text-gray-200 hover:border-primary hover:text-primary">↪️</button>
            <button type="button" title="Effacer la mise en forme" onclick="execCommand('removeFormat')" class="bg-darkbg-lighter border border-gray-800 rounded px-2 py-1 text-sm text-gray-200 hover:border-primary hover:text-primary">Effacer</button>
        </div>
    </div>
</div>
                    <div id="corps-editor" contenteditable="true" dir="auto" class="bg-darkbg-light text-gray-100 p-3 min-h-[250px] outline-none"></div>
                    <div id="editor-status" class="text-xs text-gray-400 mt-1 ml-2"></div>
                </div>
                
                <!-- Compteur de mots et caractères -->
                <div class="flex justify-end mt-2 text-sm text-primary">
                    <span id="word-count">0</span> mots | <span id="char-count">0</span> caractères
                </div>
            </div>

            <!-- Section Catégories avec sélection multiple -->
            <div class="mb-4">
                <label class="block text-primary text-sm font-bold mb-2">Catégories</label>
    
                <!-- Conteneur personnalisé pour le multiselect -->
                <div class="multiselect-container" id="multiselect-container" 
                            role="combobox" 
                            aria-expanded="false" 
                            aria-haspopup="listbox"
                            tabindex="0">
                    <div class="multiselect-display" id="multiselect-display">
                        <span class="multiselect-placeholder" id="multiselect-placeholder">Sélectionnez une ou plusieurs catégories</span>
                    </div>
        
                    <!-- Menu déroulant -->
                    <div class="multiselect-dropdown hidden" id="multiselect-dropdown">
                        <div class="multiselect-option" data-value="technologie" role="option" aria-selected="false">
                            <div class="multiselect-checkbox"></div>
                            <span>Technologie</span>
                        </div>
                        <div class="multiselect-option" data-value="science" role="option" aria-selected="false">
                            <div class="multiselect-checkbox"></div>
                            <span>Science</span>
                        </div>
                        <div class="multiselect-option" data-value="sante" role="option" aria-selected="false">
                            <div class="multiselect-checkbox"></div>
                            <span>Santé</span>
                        </div>
                        <div class="multiselect-option" data-value="education" role="option" aria-selected="false">
                            <div class="multiselect-checkbox"></div>
                            <span>Éducation</span>
                        </div>
                        <div class="multiselect-option" data-value="sport" role="option" aria-selected="false">
                            <div class="multiselect-checkbox"></div>
                            <span>Sport</span>
                        </div>
                        <div class="multiselect-option" data-value="culture" role="option" aria-selected="false">
                            <div class="multiselect-checkbox"></div>
                            <span>Culture</span>
                        </div>
                        <div class="multiselect-option" data-value="economie" role="option" aria-selected="false">
                            <div class="multiselect-checkbox"></div>
                            <span>Économie</span>
                        </div>
                        <div class="multiselect-option" data-value="politique" role="option" aria-selected="false">
                            <div class="multiselect-checkbox"></div>
                            <span>Politique</span>
                        </div>
                        <div class="multiselect-option" data-value="environnement" role="option" aria-selected="false">
                            <div class="multiselect-checkbox"></div>
                            <span>Environnement</span>
                        </div>
                        <div class="multiselect-option" data-value="voyage" role="option" aria-selected="false">
                            <div class="multiselect-checkbox"></div>
                            <span>Voyage</span>
                        </div>
                        <div class="multiselect-option" data-value="cuisine" role="option" aria-selected="false">
                            <div class="multiselect-checkbox"></div>
                            <span>Cuisine</span>
                        </div>
                        <div class="multiselect-option" data-value="divertissement" role="option" aria-selected="false">
                            <div class="multiselect-checkbox"></div>
                            <span>Divertissement</span>
                        </div>
                    </div>
                </div>
                <!-- Champs cachés pour envoyer les catégories sélectionnées -->
                <div id="hidden-categories"></div>
                <input type="hidden" name="categories-json" id="categories-json" value="{{ old('categorie', json_encode($article->categorie ?? [])) }}">
                <input type="hidden" name="text_direction" id="text-direction-input" value="{{ $article->text_direction ?? 'auto' }}">
            </div>

            <div class="mb-6">
                <label for="image" class="block text-primary text-sm font-bold mb-2">Image :</label>
                <input type="file" name="image" id="image" accept=".jpeg,.jpg,.png"
                    class="block w-full text-sm text-gray-300 
                    file:mr-4 file:py-2 file:px-4
                    file:rounded file:border-0
                    file:text-sm file:font-semibold
                    file:bg-darkbg-lighter file:text-primary
                    hover:file:bg-darkbg-light">
                <p class="text-primary text-xs mt-1">
                    Formats supportés: JPEG, JPG, PNG (max 20Mo)
                </p>
                
                <!-- Prévisualisation de l'image -->
                <div id="image-preview" class="mt-3 hidden">
                    <img id="preview-img" src="#" alt="Prévisualisation" class="max-h-40 rounded border border-gray-800">
                    <button type="button" onclick="removeImagePreview()" class="mt-1 text-sm text-red-400 hover:text-red-300">Supprimer</button>
                </div>
                
                @if ($article->image)
                    <div class="mt-2">
                        <p class="mb-1 text-primary">Image actuelle :</p>
                        <div class="flex items-center">
                            <img src="{{ $article->image }}" alt="{{ $article->titre }}" class="max-h-40 rounded border border-gray-800">
                            <label class="ml-4 text-sm text-primary">
                                <input type="checkbox" name="supprimer_image" value="1" class="rounded bg-darkbg-lighter border-gray-800 text-primary focus:ring-primary"> Supprimer cette image
                            </label>
                        </div>
                    </div>
                @endif
            </div>
            @if(Auth::check() && Auth::user()->is_active)
                <div class="flex items-center justify-between button-container">
                    <div>
                        <a href="{{ route('articles.index') }}" class="bg-darkbg-lighter hover:bg-darkbg-light text-gray-200 font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-opacity-50 mr-2 border border-gray-800">
                            Annuler
                        </a>
                        <button type="button" id="save-options-btn" class="bg-primary hover:bg-primary-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 border border-primary-dark">
                            Enregistrer
                        </button>
                    </div>
                    <button type="button" onclick="previewArticle()" class="bg-darkbg-lighter hover:bg-darkbg-light text-primary font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 border border-primary">
                        Prévisualiser
                    </button>
                </div>
            @endif
        </form>
    </div>
    
    <!-- Modal pour choisir le type d'enregistrement -->
    <div id="saveOptionsModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 bg-black bg-opacity-80 hidden flex items-center justify-center z-50">
        <div class="bg-darkbg-light rounded-lg shadow-xl w-full max-w-md mx-auto border border-gray-800">
            <div class="p-6 text-center bg-[var(--dark-bg)]">
                <p class="text-lg text-gray-200 mb-6">Comment souhaitez-vous enregistrer cet article ?</p>
                
                <div class="flex flex-col gap-4">
                    <button type="button" id="enregistrer" onclick="showPublishConfirmation()" class="w-full px-4 py-3 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark transition-colors">
                        Enregistrer et publier
                    </button>
                    
                    <button type="button" onclick="showDraftConfirmation()" class="w-full px-4 py-3 bg-darkbg-lighter text-white font-medium rounded-lg hover:bg-darkbg-light transition-colors border border-gray-700">
                        Enregistrer et mettre en brouillon
                    </button>
                    
                    <button type="button" onclick="toggleSaveOptionsModal()" class="w-full px-4 py-2 bg-darkbg border border-gray-700 text-gray-300 font-medium rounded-lg hover:bg-darkbg-lighter transition-colors">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de publication -->
    <div id="publishConfirmModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 bg-black bg-opacity-80 hidden flex items-center justify-center z-50">
        <div class="bg-darkbg-light rounded-lg shadow-xl w-full max-w-md mx-auto border border-gray-800">
            <div class="p-6 text-center bg-[var(--dark-bg)]">
                <p class="text-lg text-gray-200 mb-6">Êtes-vous sûr de vouloir publier cet article ?</p>
                
                <div class="flex justify-center gap-4">
                    <button type="button" onclick="togglePublishConfirmModal()" class="px-6 py-2 bg-darkbg-lighter text-gray-300 font-medium rounded-lg hover:bg-darkbg-light transition-colors border border-gray-700">
                        Annuler
                    </button>
                    <button type="button" id="confirmer" onclick="submitPublish()" class="px-6 py-2 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark transition-colors">
                        Confirmer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation pour mettre en brouillon -->
    <div id="draftConfirmModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 bg-black bg-opacity-80 hidden flex items-center justify-center z-50">
        <div class="bg-darkbg-light rounded-lg shadow-xl w-full max-w-md mx-auto border border-gray-800">
            <div class="p-6 text-center">
                <p class="text-lg text-gray-200 mb-6">Êtes-vous sûr de vouloir mettre cet article en brouillon ?</p>
                
                <div class="flex justify-center gap-4">
                    <button type="button" onclick="toggleDraftConfirmModal()" class="px-6 py-2 bg-darkbg-lighter text-gray-300 font-medium rounded-lg hover:bg-darkbg-light transition-colors border border-gray-700">
                        Annuler
                    </button>
                    <button type="button" onclick="submitToDraft()" class="px-6 py-2 bg-darkbg-lighter text-white font-medium rounded-lg hover:bg-darkbg-light transition-colors">
                        Confirmer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form id="to-draft-form" action="{{ route('articles.to-draft', $article->id) }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Modal de prévisualisation modifié -->
<div id="preview-modal" class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50 overflow-auto py-10" onclick="closePreviewOnOutsideClick(event)">
    <div class="bg-darkbg rounded-lg shadow-xl w-3/4 max-w-4xl max-h-[90vh] overflow-auto border border-gray-800">
        <div class="text-gray-200 bg-darkbg" id="preview-content"></div>
        <div class="border-t border-gray-800 px-6 py-4 flex justify-end bg-[var(--dark-bg)] sticky bottom-0">
            <button onclick="closePreview()" class="px-4 py-2 bg-[var(--dark-bg)] text-gray-200 rounded hover:bg-darkbg-light border border-gray-700">Fermer</button>
        </div>
    </div>
</div>
</div>
<script>
    // Tableau pour stocker les catégories sélectionnées
let selectedCategories = [];

// Fonction pour initialiser le multiselect avec les catégories existantes
function initMultiselectWithExistingData() {
    // Récupérer les catégories existantes de l'article
    @if(isset($article->categorie))
        @if(is_array($article->categorie))
            const existingCategories = @json($article->categorie);
        @elseif(is_string($article->categorie) && !empty($article->categorie))
            let existingCategories;
            try {
                const catJSON = @json($article->categorie);
                if (catJSON.startsWith('[') || catJSON.startsWith('{')) {
                    existingCategories = JSON.parse(catJSON);
                    if (!Array.isArray(existingCategories)) {
                        existingCategories = [catJSON];
                    }
                } else {
                    existingCategories = [catJSON];
                }
            } catch (e) {
                existingCategories = [@json($article->categorie)];
            }
        @else
            const existingCategories = [];
        @endif
    @else
        const existingCategories = [];
    @endif

    // Mapper les catégories existantes vers le format du multiselect
    const categoryMapping = {
        'technologie': 'Technologie',
        'science': 'Science',
        'sante': 'Santé',
        'education': 'Éducation',
        'sport': 'Sport',
        'culture': 'Culture',
        'economie': 'Économie',
        'politique': 'Politique',
        'environnement': 'Environnement',
        'voyage': 'Voyage',
        'cuisine': 'Cuisine',
        'divertissement': 'Divertissement'
    };

    // Convertir les catégories existantes vers le nouveau format
    existingCategories.forEach(category => {
        const normalizedCategory = category.toLowerCase();
        if (categoryMapping[normalizedCategory]) {
            selectedCategories.push({
                value: normalizedCategory,
                text: categoryMapping[normalizedCategory]
            });
        } else {
            // Pour les catégories personnalisées, essayer de trouver une correspondance
            const foundKey = Object.keys(categoryMapping).find(key => 
                categoryMapping[key].toLowerCase() === category.toLowerCase()
            );
            if (foundKey) {
                selectedCategories.push({
                    value: foundKey,
                    text: categoryMapping[foundKey]
                });
            }
        }
    });

    // Initialiser le multiselect
    initMultiselect();
    
    // Mettre à jour l'affichage et marquer les options sélectionnées
    updateMultiselectDisplay();
    markSelectedOptions();
}

// Fonction pour initialiser le multiselect
function initMultiselect() {
    const container = document.getElementById('multiselect-container');
    const dropdown = document.getElementById('multiselect-dropdown');
    const display = document.getElementById('multiselect-display');
    
    // Ouvrir/fermer le dropdown
    container.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.classList.toggle('hidden');
    });
    // Ajustement mobile
    if (isMobile() && !dropdown.classList.contains('hidden')) {
        adjustMultiselectForMobile();
    }
    // Fermer le dropdown quand on clique ailleurs
    document.addEventListener('click', function() {
        dropdown.classList.add('hidden');
    });
    
    // Empêcher la fermeture quand on clique dans le dropdown
    dropdown.addEventListener('click', function(e) {
        e.stopPropagation();
    });
    
    // Gérer la sélection des options
    const options = dropdown.querySelectorAll('.multiselect-option');
    options.forEach(option => {
        option.addEventListener('click', function() {
            const value = this.dataset.value;
            const text = this.querySelector('span').textContent;
            const checkbox = this.querySelector('.multiselect-checkbox');
            
            if (selectedCategories.some(cat => cat.value === value)) {
                // Désélectionner
                selectedCategories = selectedCategories.filter(cat => cat.value !== value);
                checkbox.classList.remove('checked');
                this.classList.remove('selected');
            } else {
                // Sélectionner
                selectedCategories.push({ value: value, text: text });
                checkbox.classList.add('checked');
                this.classList.add('selected');
            }
            
            updateMultiselectDisplay();
        });
    });
}

// Fonction pour marquer les options déjà sélectionnées
function markSelectedOptions() {
    const options = document.querySelectorAll('.multiselect-option');
    options.forEach(option => {
        const value = option.dataset.value;
        if (selectedCategories.some(cat => cat.value === value)) {
            const checkbox = option.querySelector('.multiselect-checkbox');
            checkbox.classList.add('checked');
            option.classList.add('selected');
        }
    });
}

// Fonction pour mettre à jour l'affichage du multiselect
function updateMultiselectDisplay() {
    const display = document.getElementById('multiselect-display');
    const hiddenContainer = document.getElementById('hidden-categories');
    
    // Vider le conteneur
    display.innerHTML = '';
    hiddenContainer.innerHTML = '';
    
    if (selectedCategories.length === 0) {
        // Afficher le placeholder
        const placeholderSpan = document.createElement('span');
        placeholderSpan.className = 'multiselect-placeholder';
        placeholderSpan.id = 'multiselect-placeholder';
        placeholderSpan.textContent = 'Sélectionnez une ou plusieurs catégories';
        display.appendChild(placeholderSpan);
    } else {
        // Afficher les catégories sélectionnées
        selectedCategories.forEach((category, index) => {
            // Créer le tag visuel
            const tag = document.createElement('div');
            tag.className = 'selected-tag';
            tag.innerHTML = `
                <span>${category.text}</span>
                <span class="remove-tag" data-index="${index}">×</span>
            `;
            display.appendChild(tag);
            
            // Créer le champ caché pour le formulaire
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'categorie[]';
            hiddenInput.value = category.value;
            hiddenContainer.appendChild(hiddenInput);
        });
        
        // Ajouter les écouteurs pour supprimer les tags
        display.querySelectorAll('.remove-tag').forEach(removeBtn => {
            removeBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const index = parseInt(this.dataset.index);
                removeSelectedCategory(index);
            });
        });
    }
    
    // Mettre à jour le champ JSON
    document.getElementById('categories-json').value = JSON.stringify(selectedCategories.map(cat => cat.value));
}

function isMobile() {
    return window.innerWidth <= 768;
}

function adjustEditorForDevice() {
    const editor = document.getElementById('corps-editor');
    if (isMobile()) {
        editor.style.minHeight = '200px';
    } else {
        editor.style.minHeight = '250px';
    }
}

// Amélioration du multiselect pour mobile
// AJOUTER cette fonction améliorée après la fonction adjustMultiselectForMobile existante :
function adjustMultiselectForMobile() {
    const dropdown = document.getElementById('multiselect-dropdown');
    if (isMobile() && !dropdown.classList.contains('hidden')) {
        dropdown.classList.add('mobile-active');
        dropdown.style.position = 'fixed';
        dropdown.style.top = '50%';
        dropdown.style.left = '50%';
        dropdown.style.transform = 'translate(-50%, -50%)';
        dropdown.style.width = '90vw';
        dropdown.style.maxHeight = '60vh';
        dropdown.style.zIndex = '9999';
        dropdown.style.borderRadius = '0.75rem';
        dropdown.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.5)';
    } else {
        dropdown.classList.remove('mobile-active');
        dropdown.style.position = '';
        dropdown.style.top = '';
        dropdown.style.left = '';
        dropdown.style.transform = '';
        dropdown.style.width = '';
        dropdown.style.maxHeight = '';
        dropdown.style.zIndex = '';
        dropdown.style.borderRadius = '';
        dropdown.style.boxShadow = '';
    }
}
// Fonction pour supprimer une catégorie sélectionnée
function removeSelectedCategory(index) {
    const categoryToRemove = selectedCategories[index];
    
    // Supprimer de la liste
    selectedCategories.splice(index, 1);
    
    // Mettre à jour l'état dans le dropdown
    const options = document.querySelectorAll('.multiselect-option');
    options.forEach(option => {
        if (option.dataset.value === categoryToRemove.value) {
            const checkbox = option.querySelector('.multiselect-checkbox');
            checkbox.classList.remove('checked');
            option.classList.remove('selected');
        }
    });
    
    // Mettre à jour l'affichage
    updateMultiselectDisplay();
}

// Fonction pour valider les catégories (pour la prévisualisation)
function validateCategories() {
    return selectedCategories.length > 0;
}

// Fonction pour obtenir les catégories sélectionnées (pour la prévisualisation)
function getSelectedCategories() {
    return selectedCategories.map(cat => cat.text);
}

    // Fonction pour exécuter les commandes d'édition
    function execCommand(command) {
        document.execCommand(command, false, null);
        
        // Correction spécifique pour les listes
        if (command === 'insertOrderedList' || command === 'insertUnorderedList') {
            // Force le rendu correct des listes
            const editor = document.getElementById('corps-editor');
            const selection = window.getSelection();
            const range = selection.getRangeAt(0);
            
            // Vérifier si la liste a été créée correctement
            const listElement = range.commonAncestorContainer.closest('ol, ul');
            if (!listElement) {
                // Si la liste n'a pas été créée correctement, on la crée manuellement
                if (command === 'insertOrderedList') {
                    document.execCommand('insertHTML', false, '<ol><li>&nbsp;</li></ol>');
                } else {
                    document.execCommand('insertHTML', false, '<ul><li>&nbsp;</li></ul>');
                }
            }
        }
        
        document.getElementById('corps-editor').focus();
        updateWordCount();
        updateEditorStatus('Modification appliquée');
    }
    
    // Fonction pour exécuter les commandes avec arguments
    function execCommandWithArg(command, value) {
        document.execCommand(command, false, value);
        document.getElementById('corps-editor').focus();
        updateWordCount();
        updateEditorStatus('Modification appliquée');
    }
    
    // Fonction pour changer la direction du texte
    function changeTextDirection(direction) {
    if (direction) {
        // Appliquer la direction du texte à tous les champs texte principaux
        document.getElementById('corps-editor').dir = direction;
        document.getElementById('titre').dir = direction;
        document.getElementById('description').dir = direction;
        
        // Garder l'auteur toujours en LTR
        document.getElementById('auteur').dir = 'ltr';
        
        // Enregistrer la direction pour l'enregistrement
        document.getElementById('text-direction-input').value = direction;
        
        updateEditorStatus('Direction du texte modifiée pour tous les champs');
    }
}
    // NOUVELLE FONCTION
    function updatePreviewDirection(direction) {
        const previewModal = document.getElementById('preview-modal');
        if (!previewModal.classList.contains('hidden')) {
            // Relancer la prévisualisation avec la nouvelle direction
            previewArticle();
        }
    }
    
    // Fonction pour créer un lien
    function createLink() {
        const selection = window.getSelection();
        const url = prompt("Entrez l'URL du lien:", "https://");
        
        if (url && url !== "https://") {
            if (selection.toString().length > 0) {
                document.execCommand('createLink', false, url);
            } else {
                const linkText = prompt("Entrez le texte du lien:", "");
                if (linkText) {
                    document.execCommand('insertHTML', false, '<a href="' + url + '" target="_blank">' + linkText + '</a>');
                }
            }
            updateEditorStatus('Lien inséré');
        }
    }
    
    // Fonction pour insérer une image dans l'éditeur
    function insertImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.execCommand('insertImage', false, e.target.result);
                updateEditorStatus('Image insérée');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Fonction pour insérer un tableau
    function insertTable() {
        const rows = prompt("Nombre de lignes:", "3");
        const cols = prompt("Nombre de colonnes:", "3");
        
        if (rows && cols) {
            let tableHTML = '<table style="border-collapse: collapse; width: 100%;">';
            for (let i = 0; i < parseInt(rows); i++) {
                tableHTML += '<tr>';
                for (let j = 0; j < parseInt(cols); j++) {
                    if (i === 0) {
                        tableHTML += '<th style="border: 1px solid #ddd; padding: 8px; text-align: left;">En-tête</th>';
                    } else {
                        tableHTML += '<td style="border: 1px solid #ddd; padding: 8px;">Cellule</td>';
                    }
                }
                tableHTML += '</tr>';
            }
            tableHTML += '</table><br>';
            
            document.execCommand('insertHTML', false, tableHTML);
            updateEditorStatus('Tableau inséré');
        }
    }
    
    // Fonction pour mettre à jour le compteur de mots et caractères
    function updateWordCount() {
        const editorContent = document.getElementById('corps-editor').innerText;
        const charCount = editorContent.length;
        
        // Amélioration du comptage de mots pour supporter différentes langues
        const wordCount = editorContent.trim() ? 
            editorContent.trim().split(/\s+/).filter(word => word.length > 0).length : 0;
        
        document.getElementById('word-count').textContent = wordCount;
        document.getElementById('char-count').textContent = charCount;
    }
    
    // Fonction pour mettre à jour le statut de l'éditeur
    function updateEditorStatus(message) {
        const statusElement = document.getElementById('editor-status');
        statusElement.textContent = message + ' - ' + new Date().toLocaleTimeString();
        
        // Effacer le message après 3 secondes
        setTimeout(() => {
            statusElement.textContent = '';
        }, 3000);
    }
    
    // Prévisualisation de l'image
document.getElementById('image').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const fileType = file.type;
        
        // Réinitialiser la prévisualisation
        document.getElementById('image-preview').classList.add('hidden');
        
        if (fileType.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('image-preview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
});

// Suppression de prévisualisation d'image
function removeImagePreview() {
    document.getElementById('image').value = '';
    document.getElementById('image-preview').classList.add('hidden');
}
    
    // Fonction de prévisualisation de l'article
function previewArticle() {
    const title = document.getElementById('titre').value || 'Sans titre';
    const author = document.getElementById('auteur').value || 'Anonyme';
    const description = document.getElementById('description').value || 'Pas de description';
    const content = document.getElementById('corps-editor').innerHTML;
    const textDirection = getCurrentTextDirection();
    console.log('Direction détectée:', textDirection);
    
    // Construire le HTML de prévisualisation dans le style de show.blade.php
    let previewHTML = `
        <div class="article-container bg-[var(--dark-bg)] p-6 rounded-lg" dir="${textDirection}">
            <!-- Titre avec direction -->
            <h1 class="text-3xl font-bold mb-4 text-gray-100" dir="${textDirection}">${title}</h1>
            
            <!-- Métadonnées -->
            <div class="flex flex-wrap gap-4 text-sm text-gray-400 mb-4" dir="${textDirection}">
                <span>📅 ${new Date().toLocaleDateString()}</span>
                <span id="preview-categories"></span>
                <span dir="ltr">Auteur: ${author}</span>            </div>
            
            <!-- Description avec direction et bordure adaptative -->
            <div class="description-container bg-darkbg p-4 rounded-lg mb-6 border-l-4 border-primary" dir="${textDirection}">
                <h2 class="text-primary text-lg mb-2">Description</h2>
                <p class="text-gray-300">${description}</p>
            </div>
            
            <!-- Corps avec direction -->
            <div class="article-body mt-6 text-gray-200 leading-relaxed" dir="${textDirection}">
                ${content}
            </div>
        </div>
    `;
    
    document.getElementById('preview-content').innerHTML = previewHTML;
    
    // Afficher les catégories si elles existent
    const categoriesContainer = document.getElementById('preview-categories');
    if (categoriesContainer && selectedCategories.length > 0) {
        categoriesContainer.innerHTML = `Catégorie: ${getSelectedCategories().join(', ')}`;
    } else if (categoriesContainer) {
        categoriesContainer.style.display = 'none';
    }
    
    // Ajout de l'image en haut de la prévisualisation
    insertImageInPreview();
    
    // Ajouter des styles spécifiques pour la prévisualisation
    const styleElement = document.createElement('style');
    styleElement.textContent = `
        .article-body ul {
            list-style-type: disc !important;
            padding-left: 1.5em !important;
            margin-bottom: 1em !important;
        }
        .article-body ol {
            list-style-type: decimal !important;
            padding-left: 1.5em !important;
            margin-bottom: 1em !important;
        }
        .article-body li {
            display: list-item !important;
            margin-bottom: 0.5em !important;
        }
        .article-body table {
            border-collapse: collapse !important;
            width: 100% !important;
            margin-bottom: 1em !important;
        } 
        .article-body th, 
        .article-body td {
            border: 1px solid #333 !important;
            padding: 8px !important;
        }
        .article-body th {
            background-color: #222 !important;
        }
        .article-body img {
            max-width: 100% !important;
            height: auto !important;
            margin: 10px 0 !important;
            border-radius: 5px !important;
        }
        .article-body a {
            color: #1a9e9e !important;
            text-decoration: underline !important;
        }
        .article-body blockquote {
            border-left: 3px solid #1a9e9e !important;
            padding-left: 1em !important;
            margin-left: 0 !important;
            color: #aaa !important;
        }
        .article-image-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            width: 100%;
        }
        .article-image {
            max-height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }
        
        /* STYLES POUR LA DESCRIPTION SELON LA DIRECTION - RENFORCÉS */
.description-container[dir="ltr"] {
    border-left: 4px solid var(--primary-color) !important;
    border-right: none !important;
}

.description-container[dir="rtl"] {
    border-right: 4px solid var(--primary-color) !important;
    border-left: none !important;
    text-align: right !important;
}

.description-container[dir="auto"] {
    border-left: 4px solid var(--primary-color) !important;
}

/* STYLES GÉNÉRAUX RTL/LTR POUR LA PRÉVISUALISATION - RENFORCÉS */
.article-container[dir="rtl"] {
    text-align: right !important;
}

.article-container[dir="rtl"] .flex {
    flex-direction: row-reverse !important;
}

.article-container[dir="ltr"] {
    text-align: left !important;
}
        
        /* ALIGNEMENT DES LISTES SELON LA DIRECTION */
        .article-body[dir="rtl"] ul,
        .article-body[dir="rtl"] ol {
            padding-right: 1.5em !important;
            padding-left: 0 !important;
        }
        
        .article-body[dir="ltr"] ul,
        .article-body[dir="ltr"] ol {
            padding-left: 1.5em !important;
            padding-right: 0 !important;
        }
        
        /* CORRECTION POUR LES BLOCKQUOTES EN RTL */
        .article-body[dir="rtl"] blockquote {
            border-left: none !important;
            border-right: 3px solid #1a9e9e !important;
            padding-left: 0 !important;
            padding-right: 1em !important;
        }
        
        /* SUPPRIMER LA BARRE DE DÉFILEMENT */
        #preview-modal .bg-darkbg {
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }
        
        #preview-modal .bg-darkbg::-webkit-scrollbar {
            display: none; /* Chrome, Safari and Opera */
        }
    `;
    document.getElementById('preview-content').appendChild(styleElement);
    
    // Afficher le modal de prévisualisation
    openPreview();
}

// Fonction pour détecter la direction du texte
function detectTextDirection(text) {
    // Regex pour détecter les caractères arabes, hébreux, etc.
    const rtlChars = /[\u0590-\u05FF\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF\uFB50-\uFDFF\uFE70-\uFEFF]/;
    
    // Si le texte contient des caractères RTL, retourner 'rtl'
    if (rtlChars.test(text)) {
        return 'rtl';
    }
    
    return 'ltr';
}

function getCurrentTextDirection() {
    // 1. Vérifier d'abord le select de direction
    const directionSelect = document.querySelector('select[onchange*="changeTextDirection"]');
    if (directionSelect && directionSelect.value && directionSelect.value !== '') {
        return directionSelect.value;
    }
    
    // 2. Vérifier l'input caché
    const hiddenInput = document.getElementById('text-direction-input');
    if (hiddenInput && hiddenInput.value && hiddenInput.value !== 'auto') {
        return hiddenInput.value;
    }
    
    // 3. Détecter automatiquement basé sur le contenu (sans l'auteur)
    const title = document.getElementById('titre').value || '';
    const description = document.getElementById('description').value || '';
    const content = document.getElementById('corps-editor').innerText || '';

    // Combiner tout le texte pour la détection (l'auteur est exclu)
    const allText = title + ' ' + description + ' ' + content;
    // Si auto ou pas de valeur, détecter automatiquement
    return detectTextDirection(allText);
}

// Fonction séparée pour gérer l'insertion de l'image en prévisualisation
function insertImageInPreview() {
    // Créer le conteneur et l'élément image
    const imageContainer = document.createElement('div');
    imageContainer.className = 'article-image-container';
    
    const image = document.createElement('img');
    image.className = 'article-image';
    image.alt = document.getElementById('titre').value || 'Image de l\'article';
    
    // Chercher l'image à afficher dans l'ordre de priorité
    let imageFound = false;
    
    // 1. Vérifier si une nouvelle image a été sélectionnée
    const imageInput = document.getElementById('image');
    if (imageInput && imageInput.files && imageInput.files[0]) {
        const fileReader = new FileReader();
        fileReader.onload = function(e) {
            image.src = e.target.result;
            
            // Insérer au début de la prévisualisation
            const previewContentDiv = document.getElementById('preview-content').querySelector('.article-container');
            if (previewContentDiv) {
                previewContentDiv.insertBefore(imageContainer, previewContentDiv.firstChild);
            }
        };
        fileReader.readAsDataURL(imageInput.files[0]);
        imageFound = true;
    }
    
    // 2. Sinon, vérifier l'image en prévisualisation
    if (!imageFound) {
        const previewImg = document.querySelector('#image-preview:not(.hidden) img');
        if (previewImg && previewImg.src) {
            image.src = previewImg.src;
            imageContainer.appendChild(image);
            
            // Insérer au début de la prévisualisation
            const previewContentDiv = document.getElementById('preview-content').querySelector('.article-container');
            if (previewContentDiv) {
                previewContentDiv.insertBefore(imageContainer, previewContentDiv.firstChild);
            }
            imageFound = true;
        }
    }
    
    // 3. Sinon, vérifier s'il y a une image existante
    if (!imageFound && document.querySelector('img[src*="{{ $article->image }}"]')) {
        const existingImg = document.querySelector('img[src*="{{ $article->image }}"]');
        if (existingImg && existingImg.src) {
            image.src = existingImg.src;
            imageContainer.appendChild(image);
            
            // Insérer au début de la prévisualisation
            const previewContentDiv = document.getElementById('preview-content').querySelector('.article-container');
            if (previewContentDiv) {
                previewContentDiv.insertBefore(imageContainer, previewContentDiv.firstChild);
            }
        }
    }
}

// Fonction pour ouvrir la prévisualisation
function openPreview() {
    const previewModal = document.getElementById('preview-modal');
    previewModal.classList.remove('hidden');
    previewModal.classList.add('flex');
}

// Fermer la prévisualisation
function closePreview() {
    document.getElementById('preview-modal').classList.add('hidden');
    document.getElementById('preview-modal').classList.remove('flex');
}

// Fermer la prévisualisation quand on clique en dehors de la carte
function closePreviewOnOutsideClick(event) {
    const previewContent = event.target.closest('.bg-darkbg');
    const previewHeader = event.target.closest('.sticky');
    const closeBtn = event.target.closest('button');
    
    // Si on clique en dehors de la carte de prévisualisation
    if (!previewContent && !previewHeader && !closeBtn) {
        closePreview();
    }
}
    
// Fermer la prévisualisation
function closePreview() {
    document.getElementById('preview-modal').classList.add('hidden');
    document.getElementById('preview-modal').classList.remove('flex');
}

// Fermer la prévisualisation quand on clique en dehors de la carte
function closePreviewOnOutsideClick(event) {
    const previewContent = event.target.closest('.bg-darkbg');
    const previewHeader = event.target.closest('.sticky');
    const closeBtn = event.target.closest('button');
    
    // Si on clique en dehors de la carte de prévisualisation
    if (!previewContent && !previewHeader && !closeBtn) {
        closePreview();
    }
}

// Modification de la fonction d'ouverture pour ajouter la classe flex
function openPreview() {
    const previewModal = document.getElementById('preview-modal');
    previewModal.classList.remove('hidden');
    previewModal.classList.add('flex');
}

    // Fonction pour sanitizer le HTML (sécurité)
    function sanitizeHTML(html) {
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        
        // Supprimer les attributs événementiels JavaScript (on*)
        const allElements = tempDiv.getElementsByTagName('*');
        for (let i = 0; i < allElements.length; i++) {
            const attributes = allElements[i].attributes;
            for (let j = attributes.length - 1; j >= 0; j--) {
                const attrName = attributes[j].name;
                if (attrName.startsWith('on')) {
                    allElements[i].removeAttribute(attrName);
                }
            }
        }
        
        return tempDiv.innerHTML;
    }

    // Fonction pour afficher/masquer le modal des options d'enregistrement
    function toggleSaveOptionsModal() {
        const modal = document.getElementById('saveOptionsModal');
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        } else {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    // Fonction pour afficher le modal de confirmation de publication
    function showPublishConfirmation() {
        toggleSaveOptionsModal(); // Fermer le modal des options
        togglePublishConfirmModal(); // Ouvrir le modal de confirmation de publication
    }

    // Fonction pour afficher le modal de confirmation de brouillon
    function showDraftConfirmation() {
        toggleSaveOptionsModal(); // Fermer le modal des options
        toggleDraftConfirmModal(); // Ouvrir le modal de confirmation de brouillon
    }

    // Fonction pour afficher/masquer le modal de confirmation de publication
    function togglePublishConfirmModal() {
        const modal = document.getElementById('publishConfirmModal');
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        } else {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    // Fonction pour afficher/masquer le modal de confirmation de brouillon
    function toggleDraftConfirmModal() {
        const modal = document.getElementById('draftConfirmModal');
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        } else {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    // Fonction pour soumettre le formulaire pour publication
    function submitPublish() {
        // Mettre à jour le champ caché avec le contenu de l'éditeur
        const editorContent = document.getElementById('corps-editor').innerHTML;
        document.getElementById('corps').value = sanitizeHTML(editorContent);
        
        // Ajouter un champ caché temporaire pour indiquer l'action
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'status';
        actionInput.value = 'published';
        document.getElementById('article-form').appendChild(actionInput);
        
        // Soumettre le formulaire principal
        document.getElementById('article-form').submit();
    }

    // Fonction pour soumettre le formulaire pour brouillon
    function submitToDraft() {
    // Mettre à jour le champ caché avec le contenu de l'éditeur
    const editorContent = document.getElementById('corps-editor').innerHTML;
    document.getElementById('corps').value = sanitizeHTML(editorContent);
    
    // Ajouter un champ caché temporaire pour indiquer l'action
    const actionInput = document.createElement('input');
    actionInput.type = 'hidden';
    actionInput.name = 'status';
    actionInput.value = 'draft';
    document.getElementById('article-form').appendChild(actionInput);
    
    // Soumettre le formulaire principal
    document.getElementById('article-form').submit();
}

    // Mettre à jour le champ caché avant la soumission
    document.getElementById('article-form').addEventListener('submit', function() {
        const editorContent = document.getElementById('corps-editor').innerHTML;
        document.getElementById('corps').value = sanitizeHTML(editorContent);
    });

    // Initialiser l'éditeur avec le contenu existant
    document.addEventListener('DOMContentLoaded', function() {
        const savedContent = document.getElementById('corps').value;
        if (savedContent) {
            document.getElementById('corps-editor').innerHTML = savedContent;
        }
        updateWordCount();
        
        // Définir la détection automatique de direction pour le texte
        document.getElementById('corps-editor').dir = 'auto';

        // Activer l'autosave
        document.getElementById('corps-editor').addEventListener('input', function() {
            updateWordCount();
        });
        
        // Ajouter des styles CSS pour améliorer l'affichage des listes dans l'éditeur
        const styleElement = document.createElement('style');
        styleElement.textContent = `
            #corps-editor ul {
                list-style-type: disc !important;
                margin-left: 1.5em !important;
                padding-left: 1em !important;
            }
            #corps-editor ol {
                list-style-type: decimal !important;
                margin-left: 1.5em !important;
                padding-left: 1em !important;
            }
            #corps-editor li {
                display: list-item !important;
                margin-bottom: 0.5em !important;
            }
            .article-container[dir="rtl"] {
                text-align: right;
            }
    
            .article-container[dir="rtl"] .border-l-4 {
                border-left: none !important;
                border-right: 4px solid var(--primary-color) !important;
            }
    
            .article-container[dir="rtl"] .flex {
                flex-direction: row-reverse;
            }
    
            .article-container[dir="ltr"] {
                text-align: left;
            }
    
            /* Alignement des listes selon la direction */
            .article-body[dir="rtl"] ul,
            .article-body[dir="rtl"] ol {
                padding-right: 1.5em !important;
                padding-left: 0 !important;
            }
    
            .article-body[dir="ltr"] ul,
            .article-body[dir="ltr"] ol {
                padding-left: 1.5em !important;
                padding-right: 0 !important;
            }
        `;
        document.head.appendChild(styleElement);
        
        // Correction pour les listes ordonnées et non ordonnées
        document.getElementById('corps-editor').addEventListener('keydown', function(e) {
            // Vérifier si on est dans une liste
            const selection = window.getSelection();
            if (selection && selection.rangeCount > 0) {
                const range = selection.getRangeAt(0);
                const parentElement = range.startContainer.parentNode;
                
                // Vérifier si on est dans une liste et qu'on appuie sur Tab
                if ((parentElement.closest('li') || parentElement.nodeName === 'LI') && e.key === 'Tab') {
                    e.preventDefault();
                    
                    // Indenter ou désindenter la liste selon la touche Maj
                    if (e.shiftKey) {
                        document.execCommand('outdent', false, null);
                    } else {
                        document.execCommand('indent', false, null);
                    }
                }
                
                // Support pour la touche Entrée dans les listes
                if ((parentElement.closest('li') || parentElement.nodeName === 'LI') && e.key === 'Enter' && !e.shiftKey) {
                    // Laisser le comportement par défaut mais s'assurer que le rendu est correct
                    setTimeout(() => {
                        const currentLists = document.getElementById('corps-editor').querySelectorAll('ol, ul');
                        currentLists.forEach(list => {
                            if (list.childNodes.length === 0) {
                                // Ajouter un élément li si la liste est vide
                                const li = document.createElement('li');
                                li.innerHTML = '&nbsp;';
                                list.appendChild(li);
                            }
                        });
                    }, 0);
                }
            }
        });
        
        // Initialiser le multiselect avec les données existantes
        initMultiselectWithExistingData();
        
        // Gestionnaire pour le bouton d'options d'enregistrement
        const saveOptionsBtn = document.getElementById('save-options-btn');
        if (saveOptionsBtn) {
            saveOptionsBtn.addEventListener('click', function(event) {
                event.preventDefault();
                toggleSaveOptionsModal();
            });
        }
        
        const savedDirection = document.getElementById('text-direction-input').value;
        if (savedDirection && savedDirection !== 'auto') {
            // Appliquer à tous les champs texte
            ['titre', 'auteur', 'description', 'corps-editor'].forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.dir = savedDirection;
                }
            });
        
            // Sélectionner la bonne option dans le select
            const directionSelect = document.querySelector('select[onchange*="changeTextDirection"]');
            if (directionSelect) {
                directionSelect.value = savedDirection;
            }
        }
        
        // Mettre à jour le compteur de mots lorsque l'utilisateur tape
        document.getElementById('corps-editor').addEventListener('input', updateWordCount);
    
        // Ajustements responsifs
        window.addEventListener('load', adjustEditorForDevice);
        window.addEventListener('resize', adjustEditorForDevice);
        window.addEventListener('resize', function() {
        if (!document.getElementById('multiselect-dropdown').classList.contains('hidden')) {
                adjustMultiselectForMobile();
            }
        });
    });
    function highlightMissingMultiselect() {
    const multiselectContainer = document.getElementById('multiselect-container');
    multiselectContainer.classList.add('border-red-500');
    const errorMsg = document.createElement('p');
    errorMsg.className = 'text-red-500 text-xs mt-1 field-error';
    errorMsg.textContent = 'Au moins une catégorie est obligatoire';
    const existingError = multiselectContainer.parentNode.querySelector('.field-error');
    if (!existingError) {
        multiselectContainer.parentNode.appendChild(errorMsg);
    }
}
</script>
</body>
</html>