<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FixAvatars extends Command
{
    protected $signature = 'avatars:fix';
    protected $description = 'Corrige les avatars stockés sous forme d\'URLs en les téléchargeant localement';

    public function handle()
    {
        $this->info('Début de la correction des avatars...');

        // Récupérer tous les utilisateurs ayant un avatar commençant par "http" (URLs externes)
        $users = User::where('avatar', 'like', 'https://%')->get();

        if ($users->isEmpty()) {
            $this->info('Aucun avatar à corriger.');
            return;
        }

        foreach ($users as $user) {
            $this->info("Traitement de l'utilisateur : {$user->email}");

            try {
                // Télécharger l'image depuis l'URL
                $fileContent = @file_get_contents($user->avatar, false, stream_context_create(['http' => ['timeout' => 10]]));
                if ($fileContent === false) {
                    throw new \Exception("Échec du téléchargement de l'avatar pour {$user->email}");
                }

                // Générer un nom de fichier unique
                $fileName = time() . '_' . Str::random(10) . '.jpg';
                // Stocker l'image dans storage/app/public/avatars/
                Storage::put('public/avatars/' . $fileName, $fileContent);

                // Mettre à jour le chemin dans la base de données
                $user->avatar = 'avatars/' . $fileName;
                $user->save();

                $this->info("Avatar mis à jour avec succès pour {$user->email} : avatars/{$fileName}");
            } catch (\Exception $e) {
                $this->error("Erreur pour {$user->email} : {$e->getMessage()}");
            }
        }

        $this->info('Correction des avatars terminée.');
    }
}