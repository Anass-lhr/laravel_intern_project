<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Business Plus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1EB5AD;
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
            --success: #10b981;
            --danger: #b91c1c;
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

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 2rem;
        }

        .form-container {
            background-color: var(--dark-bg);
            border: 1px solid var(--dark-border);
            border-radius: 1rem;
            padding: 2rem;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: var(--gray-text);
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 100%;
            background-color: var(--gray-bg);
            color: var(--light-text);
            border: 1px solid var(--dark-border);
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 8px var(--article-shadow);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--light-text);
            width: 100%;
        }

        .btn-primary:hover {
            background-color: var(--primary-color-hover);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: var(--dark-element);
            color: var(--light-text);
            border: 1px solid var(--dark-border);
        }

        .btn-secondary:hover {
            background-color: var(--dark-border);
            border-color: var(--primary-color);
        }

        .back-button {
            margin-bottom: 2rem;
        }

        .contact-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .contact-option {
            background-color: var(--dark-element);
            border: 1px solid var(--dark-border);
            border-radius: 0.5rem;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .contact-option:hover {
            border-color: var(--primary-color);
            background-color: var(--gray-bg);
        }

        .contact-option i {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .contact-option h3 {
            color: var(--light-text);
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .contact-option p {
            color: var(--gray-text);
            font-size: 0.8rem;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 2rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--dark-border);
        }

        .divider span {
            padding: 0 1rem;
            color: var(--gray-text);
            font-size: 0.9rem;
        }

        .info-box {
            background-color: var(--dark-element);
            border: 1px solid var(--dark-border);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .info-box h4 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .info-box p {
            color: var(--gray-text);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .form-container {
                padding: 1.5rem;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .contact-options {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Back Button -->
        <div class="back-button">
            <a href="/" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Retour à l'accueil
            </a>
        </div>

        <div class="form-container">
            <!-- Header -->
            <div class="header">
                <h1><i class="fas fa-envelope"></i> Nous Contacter</h1>
                <p>Avez-vous des questions ? Nous sommes là pour vous aider !</p>
            </div>

            <!-- Contact Options -->
            <div class="contact-options">
                <div class="contact-option" onclick="openGmailCompose()">
                    <i class="fas fa-paper-plane"></i>
                    <h3>Email Direct</h3>
                    <p>Ouvrir Gmail</p>
                </div>
                <div class="contact-option" onclick="copyEmailToClipboard()">
                    <i class="fas fa-copy"></i>
                    <h3>Copier l'email</h3>
                    <p>businessplus@gmail.com</p>
                </div>
            </div>

            <!-- Info Box -->
            <div class="info-box">
                <h4><i class="fas fa-info-circle"></i> Information</h4>
                <p>Cliquez sur "Email Direct" pour ouvrir Gmail avec un email pré-rempli, ou copiez notre adresse email pour l'utiliser dans votre client email préféré.</p>
            </div>

            <!-- Divider -->
            <div class="divider">
                <span>ou remplissez le formulaire ci-dessous</span>
            </div>

            <!-- Contact Form -->
            <form id="contactForm">
                <div class="form-group">
                    <label for="name">
                        <i class="fas fa-user"></i> Nom complet
                    </label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i> Email
                    </label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="phone">
                        <i class="fas fa-phone"></i> Téléphone (optionnel)
                    </label>
                    <input type="tel" id="phone" name="phone">
                </div>

                <div class="form-group">
                    <label for="subject">
                        <i class="fas fa-tag"></i> Sujet
                    </label>
                    <input type="text" id="subject" name="subject" required>
                </div>

                <div class="form-group">
                    <label for="message">
                        <i class="fas fa-comment"></i> Message
                    </label>
                    <textarea id="message" name="message" required placeholder="Décrivez votre question ou demande..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i>
                    Envoyer le message
                </button>
            </form>
        </div>
    </div>

    <script>
        function openGmailCompose() {
            const email = 'businessplus@gmail.com';
            const subject = 'Contact depuis le site Business Plus';
            const body = `Bonjour,

Je vous contacte depuis votre site web.

Nom: 
Email: 
Téléphone: 

Message:


Cordialement,`;
            
            const gmailUrl = `https://mail.google.com/mail/?view=cm&to=${email}&su=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
            window.open(gmailUrl, '_blank');
        }

        function copyEmailToClipboard() {
            const email = 'businessplus@gmail.com';
            navigator.clipboard.writeText(email).then(() => {
                // Show success feedback
                const btn = event.currentTarget;
                const originalContent = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i><h3>Copié !</h3><p>businessplus@gmail.com</p>';
                btn.style.borderColor = 'var(--success)';
                
                setTimeout(() => {
                    btn.innerHTML = originalContent;
                    btn.style.borderColor = 'var(--dark-border)';
                }, 2000);
            }).catch(() => {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = email;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                // Show success feedback
                const btn = event.currentTarget;
                const originalContent = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i><h3>Copié !</h3><p>businessplus@gmail.com</p>';
                btn.style.borderColor = 'var(--success)';
                
                setTimeout(() => {
                    btn.innerHTML = originalContent;
                    btn.style.borderColor = 'var(--dark-border)';
                }, 2000);
            });
        }

        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const name = formData.get('name');
            const email = formData.get('email');
            const phone = formData.get('phone');
            const subject = formData.get('subject');
            const message = formData.get('message');
            
            // Compose email
            const emailSubject = `[Site Web] ${subject}`;
            const emailBody = `Nouveau message depuis le site web:

Nom: ${name}
Email: ${email}
Téléphone: ${phone || 'Non renseigné'}

Message:
${message}

---
Envoyé depuis le formulaire de contact du site Business Plus`;
            
            const gmailUrl = `https://mail.google.com/mail/?view=cm&to=businessplus@gmail.com&su=${encodeURIComponent(emailSubject)}&body=${encodeURIComponent(emailBody)}`;
            window.open(gmailUrl, '_blank');
            
            // Reset form
            this.reset();
            
            // Show success message
        });
    </script>
</body>
</html>