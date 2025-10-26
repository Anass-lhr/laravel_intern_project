<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Post - BUSINESS+ Talk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Variables CSS pour les couleurs */
        :root {
            @php
                $settings = App\Models\Setting::first();
                $primaryColor = $settings->primary_color ?? '#1EB5AD';
            @endphp
            --primary-color: {{ $primaryColor }};
            --dark-bg: #1A1D21;
            --darker-bg: #111315;
            --light-text: #ffffff;
            --gray-text: #9CA3AF;
            --gray-bg: #2A2D35;
        }
         #delete-post{
            width: 100%;
         }
        /* Réinitialisation des marges et styles de base */
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

        /* Conteneur principal */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Titre et lien de retour */
        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .back-link {
            display: block;
            color: var(--primary-color);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: color-mix(in srgb, var(--primary-color) 80%, #ffffff);
            text-decoration: underline;
        }

        /* Onglets */
        .tabs {
            display: flex;
            margin-bottom: 1rem;
        }

        .tab-button {
            padding: 0.5rem 1rem;
            border-top: 1px solid #333333;
            border-radius: 0.5rem;
            color: var(--gray-text);
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
            background-color: transparent; 
        }

        .tab-button:hover {
            color: var(--light-text);
            border-bottom-color: color-mix(in srgb, var(--primary-color) 100%, transparent);
        }
        .tab-button:focus {
            outline: none;
            border-bottom: 2px solid var(--primary-color);
         }
        .tab-button.active {
            color: var(--light-text);
            border-bottom-color: var(--primary-color);
        }

        /* Contenu des onglets */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Formulaires */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            color: var(--gray-text);
            margin-bottom: 0.25rem;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.5rem;
            background-color: var(--dark-bg);
            color: var(--light-text);
            border: 1px solid #333333;
            border-radius: 0.5rem;
            font-size: 0.85rem;
        }

        .form-group input[type="file"] {
            padding: 0.25rem;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* Section du sondage */
        .poll-section {
            margin-top: 1.5rem;
        }

        .poll-section h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .poll-options {
            margin-bottom: 1rem;
        }

        .poll-options .option-row {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .add-option-btn {
            padding: 0.5rem 1rem;
            background-color:var(--primary-color);
            border: none;
            color: var(--light-text);
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        .add-option-btn:hover {
            border: var(--primary-color) 1px solid;
            background-color: var(--dark-bg);
            transform: translateY(-1px);
        }

        /* Boutons de soumission */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-cancel {
            border: none;
            background-color: var(--gray-text);
            color: var(--light-text);
        }

        .btn-cancel:hover {
            border: var(--primary-color) 1px solid;
            background-color: var(--dark-bg);
            transform: translateY(-1px);
        }

        .btn-submit {
            background-color: var(--primary-color);
            color: var(--light-text);
            border: none;
        }

        .btn-submit:hover {
            border: var(--primary-color) 1px solid;
            background-color: var(--dark-bg);
            transform: translateY(-1px);
        }

        .poll-option-input{
            border: none;
            border-radius: 0.5rem;
            padding: 4px 8px;
        }
        .optionN{
            border: none;
            border-radius: 0.5rem;   
            height: 2rem;
            padding: 4px 8px;

        }
        .optionN:focus{
            outline: none;
        }

        .poll-option-input:focus{
            outline: none;
        }
        
        /* Ajustements responsifs */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            h1 {
                font-size: 1.25rem;
            }

            .tab-button {
                font-size: 0.85rem;
                padding: 0.25rem 0.75rem;
            }

            .form-group input,
            .form-group textarea,
            .form-group select {
                font-size: 0.8rem;
            }

            .poll-section h2 {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 576px) {
            h1 {
                font-size: 1.1rem;
            }

            .tab-button {
                font-size: 0.8rem;
                padding: 0.25rem 0.5rem;
            }

            .form-group label {
                font-size: 0.8rem;
            }

            .form-group input,
            .form-group textarea,
            .form-group select {
                font-size: 0.75rem;
            }

            .poll-section h2 {
                font-size: 1rem;
            }

            .form-actions {
                flex-direction: column;
                gap: 0.5rem;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Créer un Post</h1>
        <a href="{{ route('forum.index') }}" class="back-link">← Retour au Forum</a>

        <!-- Onglets pour choisir le type de post -->
        <div class="tabs">
            <button type="button" onclick="showTab('text')" class="tab-button active">Texte</button>
            <button type="button" onclick="showTab('image')" class="tab-button">Images</button>
            <button type="button" onclick="showTab('link')" class="tab-button">Lien</button>
        </div>

        <!-- Contenu des formulaires -->
        <div id="text" class="tab-content active">
            <form action="{{ route('post.create') }}" method="POST">
                @csrf
                <input type="hidden" name="post_type" value="text">
                <div class="form-group">
                    <label for="title_text">Titre *</label>
                    <input type="text" name="title" id="title_text">
                </div>
                <div class="form-group">
                    <label for="content_text">Corps de texte (facultatif)</label>
                    <textarea name="content" id="content_text" rows="5"></textarea>
                </div>
                <div class="poll-section">
                    <h2>Ajouter un sondage (facultatif)</h2>
                    <div class="form-group">
                        <label for="poll_question_text">Question du sondage</label>
                        <input type="text" name="poll_question" id="poll_question_text">
                    </div>
                    <div class="form-group">
                        <label for="poll_type_text">Type de sondage</label>
                        <select name="poll_type" id="poll_type_text">
                            <option value="single">Choix unique</option>
                            <option value="multiple">Choix multiple</option>
                        </select>
                    </div>
                    <div id="poll-options-text" class="poll-options">
                        <label>Options du sondage</label>
                        <div class="option-row">
                            <input type="text" name="poll_options[]" placeholder="Option 1" class="poll-option-input">
                            <button type="button" onclick="addPollOption('text')" class="add-option-btn"><strong>+</strong></button>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <a href="{{ route('forum.index') }}" class="btn btn-cancel">Annuler</a>
                    <button type="submit" class="btn btn-submit">Publier</button>
                </div>
            </form>
        </div>

        <div id="image" class="tab-content">
            <form action="{{ route('post.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="post_type" value="image">
                <div class="form-group">
                    <label for="title_image">Titre *</label>
                    <input type="text" name="title" id="title_image">
                </div>
                <div class="form-group">
                    <label for="image">Image *</label>
                    <input type="file" name="image" id="image" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="description_image">Description (facultatif)</label>
                    <textarea name="description" id="description_image" rows="5"></textarea>
                </div>
                <div class="poll-section">
                    <h2>Ajouter un sondage (facultatif)</h2>
                    <div class="form-group">
                        <label for="poll_question_image">Question du sondage</label>
                        <input type="text" name="poll_question" id="poll_question_image">
                    </div>
                    <div class="form-group">
                        <label for="poll_type_image">Type de sondage</label>
                        <select name="poll_type" id="poll_type_image">
                            <option value="single">Choix unique</option>
                            <option value="multiple">Choix multiple</option>
                        </select>
                    </div>
                    <div id="poll-options-image" class="poll-options">
                        <label>Options du sondage</label>
                        <div class="option-row">
                            <input type="text" name="poll_options[]" placeholder="Option 1" class="poll-option-input">
                            <button type="button" onclick="addPollOption('image')" class="add-option-btn">+</button>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <a href="{{ route('forum.index') }}" class="btn btn-cancel">Annuler</a>
                    <button type="submit" class="btn btn-submit">Publier</button>
                </div>
            </form>
        </div>

        <div id="link" class="tab-content">
            <form action="{{ route('post.create') }}" method="POST">
                @csrf
                <input type="hidden" name="post_type" value="link">
                <div class="form-group">
                    <label for="title_link">Titre *</label>
                    <input type="text" name="title" id="title_link">
                </div>
                <div class="form-group">
                    <label for="media_url">URL du lien *</label>
                    <input type="url" name="media_url" id="media_url">
                </div>
                <div class="form-group">
                    <label for="description_link">Description (facultatif)</label>
                    <textarea name="description" id="description_link" rows="5"></textarea>
                </div>
                <div class="poll-section">
                    <h2>Ajouter un sondage (facultatif)</h2>
                    <div class="form-group">
                        <label for="poll_question_link">Question du sondage</label>
                        <input type="text" name="poll_question" id="poll_question_link">
                    </div>
                    <div class="form-group">
                        <label for="poll_type_link">Type de sondage</label>
                        <select name="poll_type" id="poll_type_link">
                            <option value="single">Choix unique</option>
                            <option value="multiple">Choix multiple</option>
                        </select>
                    </div>
                    <div id="poll-options-link" class="poll-options"> 
                        <label>Options du sondage</label>
                        <div class="option-row">
                            <input type="text" name="poll_options[]" placeholder="Option 1" class="poll-option-input">
                            <button type="button" onclick="addPollOption('link')" class="add-option-btn">+</button>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <a href="{{ route('forum.index') }}" class="btn btn-cancel">Annuler</a>
                    <button type="submit" class="btn btn-submit">Publier</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
            document.querySelectorAll('.tab-button').forEach(button => button.classList.remove('active'));
            document.querySelector(`button[onclick="showTab('${tabId}')"]`).classList.add('active');
        }

        function addPollOption(tabId) {
            const container = document.getElementById(`poll-options-${tabId}`);
            const newOption = document.createElement('div');
            newOption.className = 'option-row';
            newOption.innerHTML = `<input class="optionN" type="text" name="poll_options[]" placeholder="Option ${container.children.length }">`;
            container.appendChild(newOption);
        }

        // Afficher l'onglet "Texte" par défaut
        showTab('text');
    </script>
</body>
</html>