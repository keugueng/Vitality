<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            ['name' => 'Marie-Claire D.', 'program' => 'Anti-Stress', 'rating' => 5,
             'content' => "After 3 weeks with the Anti-Stress protocol, I sleep through the night for the first time in years. My cortisol levels dropped significantly on my next blood test. Remarkable.",
             'content_fr' => "Après 3 semaines avec le protocole Anti-Stress, je dors toute la nuit pour la première fois depuis des années. Mes niveaux de cortisol ont chuté de manière significative.",
             'sort_order' => 1],

            ['name' => 'Jean-Pierre M.', 'program' => 'Lumbago & Back Pain', 'rating' => 5,
             'content' => "I had chronic lower back pain for 8 years. Tried everything. After the 21-day lumbago protocol, the pain is gone. I can't explain it scientifically but the results speak.",
             'content_fr' => "J'avais des douleurs lombaires chroniques depuis 8 ans. Tout essayé. Après le protocole 21 jours, la douleur a disparu.",
             'sort_order' => 2],

            ['name' => 'Sophie L.', 'program' => 'Anxiety & Panic', 'rating' => 5,
             'content' => "My panic attacks were daily. After 30 days with the Anxiety protocol, they dropped to maybe once a week. Now I feel I have a tool to calm myself. Life-changing.",
             'content_fr' => "Mes crises de panique étaient quotidiennes. Après 30 jours avec le protocole Anxiété, elles sont tombées à environ une par semaine.",
             'sort_order' => 3],

            ['name' => 'Thomas B.', 'program' => 'Burn-Out Recovery', 'rating' => 5,
             'content' => "I was completely burnt out — couldn't get out of bed. After 3 months with Dr. Rosati's protocol, I'm back at work and feel better than I did 10 years ago.",
             'content_fr' => "J'étais complètement en burn-out. Après 3 mois avec le protocole du Dr Rosati, je suis de retour au travail et je me sens mieux qu'il y a 10 ans.",
             'sort_order' => 4],

            ['name' => 'Isabelle K.', 'program' => 'Insomnia & Sleep', 'rating' => 5,
             'content' => "I've struggled with insomnia for 15 years. The sleep protocol reset something in my brain — I now fall asleep within 20 minutes every night. My family noticed the difference.",
             'content_fr' => "Je souffre d'insomnie depuis 15 ans. Le protocole sommeil a réinitialisé quelque chose dans mon cerveau.",
             'sort_order' => 5],

            ['name' => 'Aurore P.', 'program' => 'Menstrual Pain & PMS', 'rating' => 5,
             'content' => "My periods used to be debilitating — I'd miss 2 days of work every month. After this protocol, the pain went from a 9/10 to a 2/10. I wish I had found this sooner.",
             'content_fr' => "Mes règles étaient invalidantes - je ratais 2 jours de travail chaque mois. Après ce protocole, la douleur est passée de 9/10 à 2/10.",
             'sort_order' => 6],

            ['name' => 'Marc R.', 'program' => 'Allergy & Hay Fever', 'rating' => 5,
             'content' => "Spring used to be hell for me — constant sneezing, watery eyes, antihistamines every day. After the allergy protocol, I went through this spring with almost no symptoms.",
             'content_fr' => "Le printemps était l'enfer pour moi. Après le protocole allergie, j'ai passé ce printemps avec presque aucun symptôme.",
             'sort_order' => 7],

            ['name' => 'Nathalie V.', 'program' => 'Weight & Metabolism', 'rating' => 4,
             'content' => "Combined with eating better, the metabolism protocol helped me lose 8 kilos in 30 days. But more importantly — the emotional eating trigger just disappeared. That was the real win.",
             'content_fr' => "Combiné à une meilleure alimentation, le protocole métabolisme m'a aidé à perdre 8 kilos en 30 jours.",
             'sort_order' => 8],

            ['name' => 'Henri C.', 'program' => 'Memory & Cognitive Function', 'rating' => 5,
             'content' => "I'm 58 and noticed serious cognitive decline — forgetting names, slow thinking. After 21 days of the memory protocol, my colleagues noticed I was sharper. My wife says I'm a different man.",
             'content_fr' => "J'avais 58 ans et remarquais un déclin cognitif sérieux. Après 21 jours du protocole mémoire, mes collègues ont noté que j'étais plus vif.",
             'sort_order' => 9],

            ['name' => 'Caroline F.', 'program' => 'Chronic Fatigue', 'rating' => 5,
             'content' => "ME/CFS for 3 years. Doctors said there was nothing more to do. Dr. Rosati's chronic fatigue protocol gave me back 60% of my energy. I can now go for walks again.",
             'content_fr' => "Syndrome de fatigue chronique depuis 3 ans. Le protocole m'a redonné 60% de mon énergie.",
             'sort_order' => 10],

            ['name' => 'Fabrice T.', 'program' => 'Sciatica', 'rating' => 5,
             'content' => "Sciatica for 2 years — I tried physiotherapy, osteopathy, cortisone injections. The sciatica protocol resolved it in 3 weeks. I was skeptical but the results were undeniable.",
             'content_fr' => "Sciatique depuis 2 ans, essayé kiné, ostéopathie, cortisone. Le protocole sciatique l'a résolu en 3 semaines.",
             'sort_order' => 11],

            ['name' => 'Elise M.', 'program' => 'Self-Confidence', 'rating' => 5,
             'content' => "Social anxiety ruled my life. After the confidence protocol, something shifted — I started speaking up in meetings, accepted a promotion, and finally booked that trip alone. Thank you.",
             'content_fr' => "L'anxiété sociale dirigeait ma vie. Après le protocole confiance, quelque chose a changé - j'ai commencé à parler en réunion.",
             'sort_order' => 12],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(
                ['name' => $t['name'], 'program' => $t['program']],
                array_merge($t, ['is_active' => true])
            );
        }
    }
}
