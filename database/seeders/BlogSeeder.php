<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@vitalityinside.com')->first();

        $posts = [
            [
                'title'    => 'What is Bio-Energy Frequency Therapy?',
                'title_fr' => 'Qu\'est-ce que la Thérapie Bio-Énergétique par Fréquences?',
                'excerpt'  => 'An introduction to the science of vibrational medicine and how bio-resonance frequencies interact with the human body at the cellular level.',
                'excerpt_fr' => 'Une introduction à la science de la médecine vibratoire et comment les fréquences de bio-résonance interagissent avec le corps humain.',
                'content'  => '<p>Bio-energy frequency therapy is based on a fundamental principle of quantum biology: every cell, tissue, and organ in the human body has a natural oscillation frequency. When this frequency is disrupted — by stress, illness, toxins, or emotional trauma — the body loses its ability to self-regulate and heal.</p><p>Dr. Éric Rosati has spent over 25 years studying and cataloguing these frequencies. His method involves using specially encoded audio signals, delivered through bone-conduction headphones, to entrain the body\'s cellular systems back to their optimal oscillation states.</p><h2>The Science Behind It</h2><p>This is not new-age speculation. The field of bioelectromagnetics has produced significant peer-reviewed research on the effects of electromagnetic frequencies on biological tissue. Studies have shown that specific frequency ranges can influence gene expression, cellular metabolism, inflammatory pathways, and even neural plasticity.</p>',
                'content_fr' => '<p>La thérapie bio-énergétique par fréquences est basée sur un principe fondamental de la biologie quantique : chaque cellule, tissu et organe du corps humain possède une fréquence d\'oscillation naturelle.</p>',
                'category' => 'Science',
                'read_time' => 8,
                'is_published' => true,
            ],
            [
                'title'    => 'The 5 Most Common Signs of Adrenal Fatigue (And What To Do)',
                'title_fr' => 'Les 5 Signes les Plus Courants de Fatigue Surrénalienne',
                'excerpt'  => 'Constant exhaustion, inability to handle stress, salt cravings, brain fog — could you be suffering from adrenal fatigue? Learn the signs and the solution.',
                'excerpt_fr' => 'Épuisement constant, incapacité à gérer le stress, envies de sel, brouillard mental — souffrez-vous de fatigue surrénalienne?',
                'content'  => '<p>Adrenal fatigue is one of the most misunderstood and underdiagnosed conditions in modern medicine. The adrenal glands — two small glands sitting atop your kidneys — produce cortisol, adrenaline, and DHEA. When they become exhausted from chronic stress, the consequences ripple through every system in the body.</p><h2>Sign #1: You\'re tired all the time but wired at night</h2><p>The classic paradox of adrenal fatigue: profound daytime exhaustion that mysteriously turns into restless wakefulness after 9pm. This is your cortisol rhythm flipped upside down.</p><h2>Sign #2: You crave salt</h2><p>The adrenals regulate aldosterone, which controls sodium retention. When they\'re depleted, you lose sodium and your body signals this through intense salt cravings.</p>',
                'content_fr' => '<p>La fatigue surrénalienne est l\'une des conditions les plus incomprises et sous-diagnostiquées en médecine moderne.</p>',
                'category' => 'Wellness',
                'read_time' => 6,
                'is_published' => true,
            ],
            [
                'title'    => 'Sleep Architecture: Why You\'re Tired Even After 8 Hours',
                'title_fr' => 'Architecture du Sommeil: Pourquoi Vous Êtes Fatigué Même Après 8 Heures',
                'excerpt'  => 'Getting 8 hours but still waking exhausted? The problem may not be duration — it\'s the quality of your deep sleep stages. Here\'s what science says.',
                'excerpt_fr' => 'Vous dormez 8 heures mais vous réveillez épuisé? Le problème n\'est peut-être pas la durée, mais la qualité de vos phases de sommeil profond.',
                'content'  => '<p>Most people understand sleep as a binary state: you\'re either awake or asleep. The reality is that sleep is a complex, cyclical architecture of 4-5 distinct stages, each with critical biological functions. Getting all of your hours in the lighter stages while missing deep N3 sleep and REM is like charging your phone but leaving it on airplane mode — the numbers look right, but the function isn\'t there.</p><h2>The 5 Stages of Sleep</h2><p>Sleep cycles through: N1 (light sleep), N2 (sleep onset), N3 (deep/slow-wave sleep), and REM (rapid eye movement). Each 90-minute cycle contains all stages, with deep sleep predominating early in the night and REM increasing toward morning.</p>',
                'content_fr' => '<p>La plupart des gens comprennent le sommeil comme un état binaire : vous êtes soit éveillé soit endormi. La réalité est que le sommeil est une architecture complexe de 4-5 étapes distinctes.</p>',
                'category' => 'Sleep',
                'read_time' => 7,
                'is_published' => true,
            ],
            [
                'title'    => 'Frequency Medicine: The Next Frontier of Healthcare',
                'title_fr' => 'La Médecine par Fréquences : La Prochaine Frontière des Soins de Santé',
                'excerpt'  => 'From Royal Rife\'s early research to modern quantum biology, frequency medicine is gaining serious scientific attention. Here\'s why.',
                'excerpt_fr' => 'Des premières recherches de Royal Rife à la biologie quantique moderne, la médecine par fréquences attire une attention scientifique sérieuse.',
                'content'  => '<p>The history of frequency medicine is a fascinating story of visionary science that ran decades ahead of mainstream acceptance. Royal Rife, an American scientist, demonstrated in the 1930s that specific electromagnetic frequencies could devitalize pathogens without harming surrounding tissue. His work was dismissed by the medical establishment of his time, but modern researchers are now revisiting his findings with more sophisticated tools.</p>',
                'content_fr' => '<p>L\'histoire de la médecine par fréquences est une histoire fascinante de science visionnaire qui a devancé l\'acceptation courante de plusieurs décennies.</p>',
                'category' => 'Science',
                'read_time' => 10,
                'is_published' => true,
            ],
            [
                'title'    => 'How to Get the Most from Your Vitality Protocol',
                'title_fr' => 'Comment Tirer le Maximum de Votre Protocole Vitality',
                'excerpt'  => 'Practical tips for optimizing your Vitality Inside program: timing, environment, headphone setup, and what to expect week by week.',
                'excerpt_fr' => 'Conseils pratiques pour optimiser votre programme Vitality Inside : timing, environnement, configuration des écouteurs.',
                'content'  => '<p>Getting results from your Vitality Inside program is not complicated — but like any therapeutic protocol, the quality of your practice determines the quality of your outcomes. Here are the key principles Dr. Rosati recommends for every patient.</p><h2>The Right Headphones</h2><p>Bone-conduction headphones are not optional — they are essential. The Vitality wave is designed to be transmitted through bone vibration, bypassing the air-to-cochlea pathway entirely. Any bone-conduction model will work, but we recommend Shokz OpenRun for its comfort and frequency response.</p><h2>Session Timing</h2><p>Most protocols are most effective when done in the morning (within 2 hours of waking) or in the early evening. Avoid immediately before bed for energizing programs, and avoid immediately after heavy meals.</p>',
                'content_fr' => '<p>Obtenir des résultats de votre programme Vitality Inside n\'est pas compliqué - mais comme tout protocole thérapeutique, la qualité de votre pratique détermine la qualité de vos résultats.</p>',
                'category' => 'Protocol',
                'read_time' => 5,
                'is_published' => true,
            ],
        ];

        foreach ($posts as $p) {
            BlogPost::updateOrCreate(
                ['slug' => Str::slug($p['title'])],
                array_merge($p, [
                    'slug'         => Str::slug($p['title']),
                    'author_id'    => $admin?->id,
                    'tags'         => [],
                    'published_at' => now()->subDays(rand(1, 90)),
                ])
            );
        }
    }
}
