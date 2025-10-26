<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:500',
        ]);

        // Récupérer le dernier échange depuis la session (question et réponse précédentes)
        $previousConversation = session()->get('previous_conversation', []);

        // Préparer le message système
        $systemPrompt = [
            'role' => 'system',
            'content' => 'Vous êtes un assistant spécialisé exclusivement en business, entrepreneuriat, économie et finance. Vous avez une expertise approfondie dans l’accélération de startups, inspirée par Media Digital Invest (MDI), un accélérateur de croissance basé à Casablanca, Maroc. MDI aide les startups à fort potentiel disruptif à transformer leurs ambitions en succès industriel en fournissant des compétences et des ressources pour obtenir des financements auprès de Business Angels, VCs et LPs internationaux. MDI propose des programmes comme FundXcelerate (pour maîtriser la collecte de fonds), ExpansionX (pour la mise à l’échelle), et MomentumX (pour accélérer la croissance via des ressources et des réseaux). MDI, fondé par Abderrazak Yousfi, a contribué à des réussites notables, comme la première sortie de startup au Maroc avec Moteur.ma. Pour les questions sur les coordonnées de MDI, fournissez les informations suivantes : Adresse : Mega Business Center, Florida Center Park, Boulevard Zoulikha Nasri, Lot. N#2, 4th Floor, Office #19, Sidi Maarouf, Casablanca 20520, Maroc. E-mail : Consultez mediadigitalinvest.com pour le formulaire de contact ou utilisez des outils comme RocketReach pour les e-mails professionnels. Téléphone : Disponible sur mediadigitalinvest.com (section contact) ou via le Mega Business Center. Réseaux sociaux : Facebook (facebook.com/Media-Digital-Invest-101054672041586), LinkedIn (ma.linkedin.com/company/media-digital-invest, 2 987 abonnés). Twitter/X non spécifié, vérifier sur mediadigitalinvest.com. MDI collabore avec des partenaires comme Morocco.AI pour des initiatives telles que l’AI Summer School. Fournissez des réponses précises, utiles et intelligentes, strictement limitées aux domaines du business, de l’entrepreneuriat, de l’économie et de la finance, en intégrant cette expertise lorsque pertinent. Ignorez toute question hors de ces domaines.'
        ];

        // Ajouter la nouvelle question
        $newMessage = ['role' => 'user', 'content' => $request->input('question')];

        // Combiner le message système, le dernier échange (s'il existe) et la nouvelle question
        $messages = array_merge([$systemPrompt], $previousConversation, [$newMessage]);

        try {
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => $messages,
                'max_tokens' => 200,
            ]);

            $answer = $response->choices[0]->message->content;

            // Stocker la question et la réponse actuelles comme dernier échange dans la session
            $previousConversation = [
                ['role' => 'user', 'content' => $request->input('question')],
                ['role' => 'assistant', 'content' => $answer],
            ];
            session()->put('previous_conversation', $previousConversation);

        } catch (\Exception $e) {
            return response()->json([
                'question' => $request->input('question'),
                'error' => 'Impossible de contacter l\'API OpenAI : ' . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'question' => $request->input('question'),
            'answer' => $answer,
        ]);
    }
}