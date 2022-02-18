<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faqs')->insert([
            [
                'ask' => "Wat is de levertermijn van mijn meubels?",
                "reponse" => "Bel ons op +32 468 04 02 37 of stuur een e-mail via ons mailsysteem onderaan de pagina om de leverdatum te kennen van jouw meubels.",
                'ask_fr' => "Quel est le délai de livraison de mes meubles?",
                "reponse_fr" => "Appelez-nous au +32 468 04 02 37 ou envoyez un e-mail via notre système de messagerie en bas de page pour connaître la date de livraison de votre mobilier.",
                'ask_en' => "How long does it take to deliver my furniture?",
                "reponse_en" => "Call us at +32 468 04 02 37 or send an e-mail via our messaging system at the bottom of the page to know the delivery date of your furniture.",
                "created_at" => now()
            ],
            [
                'ask' => "Kan ik mijn nieuwe meubels afhalen?",
                "reponse" => "Ja, je haalt je meubels ook zelf af, in het depot van Innova furniture, vlak achter de woonwinkel. Laat ons weten wanneer je komt via +32 468 04 02 37. Dan zetten wij je meubels klaar en helpen we bij het inladen.",
                'ask_fr' => "Puis-je récupérer mes nouveaux meubles?",
                "reponse_fr" => "Oui, vous pouvez aussi venir chercher vos meubles vous-même, dans le dépôt de meubles Innova, juste derrière le magasin de meubles. Faites-nous savoir quand vous venez via +32 468 04 02 37. Nous préparons ensuite votre mobilier et vous aidons à le charger.",
                'ask_en' => "Can I get my new furniture back?",
                "reponse_en" => "Yes, you can also come and pick up your furniture yourself, in the Innova furniture warehouse, just behind the furniture store. Let us know when you come via +32 468 04 02 37. We will then prepare your furniture and help you load it.",
                "created_at" => now()
            ],
            [
                'ask' => "Hoe zit het met mijn garantie op meubels?",
                "reponse" => "Bij Innova furniture hanteren we de testaankoopgarantie tenzij de leverancier deze nog overtreft. Je vindt meer details bij je factuur. Merk je een fout of schade aan je meubels? Neem dan meteen contact met ons op via +32 468 04 02 37 of info@innovafurniture.be. Ook na de garantieperiode helpen we je graag verder.",
                'ask_fr' => "Et ma garantie sur les meubles?",
                "reponse_fr" => "Chez Innova furniture, nous appliquons la garantie du test achat, à moins que le fournisseur ne dépasse cette garantie. Vous trouverez plus de détails avec votre facture. Remarquez-vous une erreur ou un dommage à votre mobilier ? Contactez-nous alors immédiatement au +32 468 04 02 37 ou à info@innovafurniture.be. Nous serons également heureux de vous aider après la période de garantie.",
                'ask_en' => "What about my furniture warranty?",
                "reponse_en" => "At Innova furniture, we apply the guarantee of the test purchase, unless the supplier exceeds this guarantee. You will find more details with your invoice. Do you notice a mistake or damage to your furniture? Then contact us immediately at +32 468 04 02 37 or info@innovafurniture.be. We will also be happy to help you after the warranty period..",
                "created_at" => now()
            ]
        ]);
        
    }
}
