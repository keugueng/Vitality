<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $cats = Category::all()->keyBy('slug');

        $programs = [
            /* ─── LOCOMOTOR ─── */
            ['cat' => 'locomotor', 'emoji' => '🦴', 'title' => 'Lumbago & Back Pain', 'title_fr' => 'Lombalgie & Douleurs Dorsales',
             'short_desc' => 'Targeted frequency protocol for acute and chronic lower back pain, muscle tension, and spinal inflammation.',
             'short_desc_fr' => 'Protocole fréquentiel ciblé pour les douleurs lombaires aiguës et chroniques.',
             'session_duration' => '25 min', 'cure_duration' => '21 days', 'price' => 29.90, 'is_bestseller' => true, 'is_featured' => true,
             'benefits' => ['Reduces acute pain episodes', 'Relaxes paravertebral muscles', 'Supports disc regeneration', 'Improves posture alignment'],
             'tags' => ['back', 'lumbago', 'spine', 'pain']],

            ['cat' => 'locomotor', 'emoji' => '🦵', 'title' => 'Osteoarthritis', 'title_fr' => 'Arthrose',
             'short_desc' => 'Slows articular cartilage degradation and reduces joint inflammation for osteoarthritis sufferers.',
             'short_desc_fr' => 'Ralentit la dégradation du cartilage articulaire et réduit l\'inflammation.',
             'session_duration' => '25 min', 'cure_duration' => '30 days', 'price' => 29.90,
             'benefits' => ['Anti-inflammatory effect', 'Cartilage protection frequencies', 'Pain reduction', 'Improved joint mobility'],
             'tags' => ['arthritis', 'joints', 'cartilage']],

            ['cat' => 'locomotor', 'emoji' => '💪', 'title' => 'Tendinitis & Tendinopathy', 'title_fr' => 'Tendinite & Tendinopathie',
             'short_desc' => 'Regenerative frequencies for tendon tissue repair, inflammation reduction, and return to activity.',
             'short_desc_fr' => 'Fréquences régénératives pour la réparation des tendons et la réduction de l\'inflammation.',
             'session_duration' => '20 min', 'cure_duration' => '21 days', 'price' => 29.90,
             'benefits' => ['Tendon tissue regeneration', 'Inflammation reduction', 'Accelerated healing', 'Prevention of recurrence'],
             'tags' => ['tendon', 'inflammation', 'sport', 'recovery']],

            ['cat' => 'locomotor', 'emoji' => '🧘', 'title' => 'Cervical Pain & Neck', 'title_fr' => 'Douleurs Cervicales & Nuque',
             'short_desc' => 'Relief protocol for neck stiffness, cervical arthritis, tension headaches originating from the neck.',
             'short_desc_fr' => 'Protocole soulagement pour cervicalgies, raideur, céphalées de tension cervicales.',
             'session_duration' => '20 min', 'cure_duration' => '21 days', 'price' => 29.90,
             'benefits' => ['Cervical muscle relaxation', 'Tension headache reduction', 'Improved neck mobility', 'Anti-inflammatory'],
             'tags' => ['neck', 'cervical', 'headache', 'tension']],

            ['cat' => 'locomotor', 'emoji' => '⚡', 'title' => 'Sciatica', 'title_fr' => 'Sciatique',
             'short_desc' => 'Targeted protocol for sciatic nerve inflammation, irradiating leg pain, and lumbar nerve compression.',
             'short_desc_fr' => 'Protocole ciblé pour l\'inflammation du nerf sciatique et les douleurs irradiantes.',
             'session_duration' => '25 min', 'cure_duration' => '21 days', 'price' => 29.90, 'is_bestseller' => true,
             'benefits' => ['Sciatic nerve decompression frequencies', 'Pain pathway modulation', 'Anti-inflammatory', 'Muscle tension release'],
             'tags' => ['sciatica', 'nerve', 'back', 'pain']],

            ['cat' => 'locomotor', 'emoji' => '🦿', 'title' => 'Fibromyalgia', 'title_fr' => 'Fibromyalgie',
             'short_desc' => 'Whole-body frequency protocol for fibromyalgia — addressing widespread pain, fatigue, and sleep disruption.',
             'short_desc_fr' => 'Protocole corps entier pour fibromyalgie, douleurs diffuses, fatigue et troubles du sommeil.',
             'session_duration' => '30 min', 'cure_duration' => '30 days', 'price' => 34.90,
             'benefits' => ['Widespread pain reduction', 'Sleep quality improvement', 'Energy restoration', 'Central sensitization modulation'],
             'tags' => ['fibromyalgia', 'chronic pain', 'fatigue', 'sleep']],

            ['cat' => 'locomotor', 'emoji' => '🏃', 'title' => 'Sports Recovery', 'title_fr' => 'Récupération Sportive',
             'short_desc' => 'Post-training recovery protocol. Accelerates muscle repair, reduces DOMS, and optimizes athletic recovery.',
             'short_desc_fr' => 'Protocole récupération post-entraînement. Accélère la réparation musculaire, réduit les courbatures.',
             'session_duration' => '20 min', 'cure_duration' => '21 days', 'price' => 29.90,
             'benefits' => ['Accelerated muscle repair', 'DOMS reduction', 'Lactic acid clearance frequencies', 'Performance optimization'],
             'tags' => ['sport', 'recovery', 'muscle', 'performance']],

            /* ─── DIGESTIVE ─── */
            ['cat' => 'digestive', 'emoji' => '🫁', 'title' => 'Constipation', 'title_fr' => 'Constipation',
             'short_desc' => 'Stimulates intestinal peristalsis and colon motility through targeted bio-frequency resonance.',
             'short_desc_fr' => 'Stimule le péristaltisme intestinal et la motilité du côlon par résonance bio-fréquentielle.',
             'session_duration' => '20 min', 'cure_duration' => '21 days', 'price' => 29.90,
             'benefits' => ['Intestinal motility stimulation', 'Microbiome balance support', 'Natural transit regulation', 'Bloating reduction'],
             'tags' => ['constipation', 'digestion', 'colon', 'transit']],

            ['cat' => 'digestive', 'emoji' => '🔥', 'title' => 'Gastric Acidity & GERD', 'title_fr' => 'Acidité Gastrique & RGO',
             'short_desc' => 'Regulates stomach acid production, heals gastric mucosa, and reduces acid reflux episodes.',
             'short_desc_fr' => 'Régule la production d\'acide gastrique, guérit la muqueuse et réduit le reflux.',
             'session_duration' => '20 min', 'cure_duration' => '21 days', 'price' => 29.90,
             'benefits' => ['Gastric acid regulation', 'Mucosa healing frequencies', 'Reflux reduction', 'Digestive comfort'],
             'tags' => ['acidity', 'GERD', 'reflux', 'stomach']],

            ['cat' => 'digestive', 'emoji' => '🌿', 'title' => 'Liver Detox & Drainage', 'title_fr' => 'Drainage Hépatique',
             'short_desc' => 'Supports liver cell regeneration, bile flow, and hepatic detoxification pathways.',
             'short_desc_fr' => 'Soutient la régénération hépatique, le flux biliaire et les voies de détoxification.',
             'session_duration' => '25 min', 'cure_duration' => '30 days', 'price' => 29.90,
             'benefits' => ['Liver cell regeneration', 'Bile flow optimization', 'Toxin elimination support', 'Energy metabolism'],
             'tags' => ['liver', 'detox', 'drainage', 'bile']],

            ['cat' => 'digestive', 'emoji' => '💨', 'title' => 'Irritable Bowel Syndrome', 'title_fr' => 'Syndrome de l\'Intestin Irritable',
             'short_desc' => 'Multi-target protocol addressing IBS symptoms: pain, bloating, irregular transit, and gut-brain axis.',
             'short_desc_fr' => 'Protocole multi-cible pour le SII: douleur, ballonnements, transit irrégulier, axe intestin-cerveau.',
             'session_duration' => '25 min', 'cure_duration' => '30 days', 'price' => 29.90, 'is_bestseller' => true,
             'benefits' => ['Gut-brain axis regulation', 'Intestinal pain reduction', 'Transit normalization', 'Microbiome support'],
             'tags' => ['IBS', 'colon', 'bloating', 'gut']],

            ['cat' => 'digestive', 'emoji' => '🧹', 'title' => 'Colon Cleanse & Reset', 'title_fr' => 'Nettoyage du Côlon',
             'short_desc' => 'Deep colon cleansing protocol. Resets intestinal flora, eliminates toxins, and restores digestive balance.',
             'short_desc_fr' => 'Protocole de nettoyage profond du côlon. Réinitialise la flore intestinale.',
             'session_duration' => '25 min', 'cure_duration' => '21 days', 'price' => 29.90,
             'benefits' => ['Colon toxin elimination', 'Flora rebalancing', 'Digestive reset', 'Inflammatory reduction'],
             'tags' => ['colon', 'cleanse', 'flora', 'detox']],

            /* ─── EMOTIONAL ─── */
            ['cat' => 'emotional', 'emoji' => '😌', 'title' => 'Anti-Stress', 'title_fr' => 'Anti-Stress',
             'short_desc' => 'Rebalances the nervous system and lowers cortisol through deep theta and delta frequency waves.',
             'short_desc_fr' => 'Rééquilibre le système nerveux et abaisse le cortisol par des ondes thêta et delta profondes.',
             'session_duration' => '25 min', 'cure_duration' => '21 days', 'price' => 29.90, 'is_bestseller' => true, 'is_featured' => true,
             'benefits' => ['Cortisol reduction', 'Nervous system rebalancing', 'Emotional resilience', 'Daily stress management'],
             'tags' => ['stress', 'cortisol', 'nervous system', 'relaxation']],

            ['cat' => 'emotional', 'emoji' => '🧘', 'title' => 'Anxiety & Panic', 'title_fr' => 'Anxiété & Crises de Panique',
             'short_desc' => 'Calms the amygdala response and retrains anxious neural pathways through targeted frequency protocols.',
             'short_desc_fr' => 'Calme la réponse amygdalienne et reconditionne les voies neurales anxieuses.',
             'session_duration' => '25 min', 'cure_duration' => '30 days', 'price' => 29.90, 'is_bestseller' => true, 'is_featured' => true,
             'benefits' => ['Amygdala calming', 'Panic attack frequency reduction', 'Neural pathway retraining', 'Emotional stability'],
             'tags' => ['anxiety', 'panic', 'amygdala', 'fear']],

            ['cat' => 'emotional', 'emoji' => '🔥', 'title' => 'Burn-Out Recovery', 'title_fr' => 'Récupération du Burn-Out',
             'short_desc' => 'Restores adrenal function, mental energy, and emotional reserves after professional or personal burnout.',
             'short_desc_fr' => 'Restaure la fonction surrénalienne, l\'énergie mentale après un burn-out professionnel.',
             'session_duration' => '30 min', 'cure_duration' => '30 days', 'price' => 34.90, 'is_bestseller' => true, 'is_featured' => true,
             'benefits' => ['Adrenal recovery', 'Mental energy restoration', 'Emotional resilience rebuild', 'Sleep quality improvement'],
             'tags' => ['burnout', 'fatigue', 'adrenal', 'recovery']],

            ['cat' => 'emotional', 'emoji' => '🌧️', 'title' => 'Depression & Low Mood', 'title_fr' => 'Dépression & Humeur Basse',
             'short_desc' => 'Stimulates serotonin and dopamine pathways to lift mood, restore motivation, and fight depressive episodes.',
             'short_desc_fr' => 'Stimule les voies sérotonine et dopamine pour remonter l\'humeur et combattre la dépression.',
             'session_duration' => '30 min', 'cure_duration' => '30 days', 'price' => 34.90,
             'benefits' => ['Serotonin pathway stimulation', 'Dopamine regulation', 'Mood elevation', 'Motivation restoration'],
             'tags' => ['depression', 'serotonin', 'dopamine', 'mood']],

            ['cat' => 'emotional', 'emoji' => '💪', 'title' => 'Self-Confidence', 'title_fr' => 'Confiance en Soi',
             'short_desc' => 'Strengthens the internal sense of value, reduces self-doubt, and builds emotional resilience through neural reconditioning.',
             'short_desc_fr' => 'Renforce l\'estime de soi, réduit le doute et construit la résilience émotionnelle.',
             'session_duration' => '20 min', 'cure_duration' => '21 days', 'price' => 29.90, 'is_featured' => true,
             'benefits' => ['Self-esteem neural reconditioning', 'Fear of judgment reduction', 'Inner security building', 'Assertiveness'],
             'tags' => ['confidence', 'self-esteem', 'mindset', 'resilience']],

            ['cat' => 'emotional', 'emoji' => '💔', 'title' => 'Emotional Trauma Release', 'title_fr' => 'Libération Traumatique',
             'short_desc' => 'Processes stored emotional trauma and childhood wounds using deep oscillating frequency protocols.',
             'short_desc_fr' => 'Traite les traumatismes émotionnels et blessures d\'enfance par des protocoles fréquentiels oscillants.',
             'session_duration' => '30 min', 'cure_duration' => '30 days', 'price' => 34.90,
             'benefits' => ['Trauma memory processing', 'Emotional release facilitation', 'Nervous system safety', 'Post-traumatic growth'],
             'tags' => ['trauma', 'PTSD', 'emotional', 'healing']],

            ['cat' => 'emotional', 'emoji' => '😤', 'title' => 'Anger & Frustration', 'title_fr' => 'Colère & Frustration',
             'short_desc' => 'Regulates the emotional brain circuits behind reactive anger and chronic frustration patterns.',
             'short_desc_fr' => 'Régule les circuits émotionnels cérébraux derrière la colère réactive et la frustration chronique.',
             'session_duration' => '20 min', 'cure_duration' => '21 days', 'price' => 29.90,
             'benefits' => ['Emotional regulation circuits', 'Impulse control support', 'Frustration tolerance', 'Calm response'],
             'tags' => ['anger', 'frustration', 'emotional control']],

            /* ─── ENT & IMMUNITY ─── */
            ['cat' => 'ent-immunity', 'emoji' => '🌸', 'title' => 'Allergy & Hay Fever', 'title_fr' => 'Allergie & Rhume des Foins',
             'short_desc' => 'Modulates the allergic immune response, reducing sensitivity to pollen, dust mites, and environmental allergens.',
             'short_desc_fr' => 'Module la réponse immune allergique pour réduire la sensibilité aux pollens et allergènes.',
             'session_duration' => '20 min', 'cure_duration' => '21 days', 'price' => 29.90, 'is_bestseller' => true, 'is_featured' => true,
             'benefits' => ['IgE pathway modulation', 'Histamine response reduction', 'Seasonal allergy management', 'Respiratory relief'],
             'tags' => ['allergy', 'pollen', 'immune', 'histamine']],

            ['cat' => 'ent-immunity', 'emoji' => '😴', 'title' => 'Sleep Apnea Support', 'title_fr' => 'Apnée du Sommeil',
             'short_desc' => 'Tones respiratory muscles and regulates sleep-breathing neurological patterns to support apnea management.',
             'short_desc_fr' => 'Tonifie les muscles respiratoires et régule les patterns neurologiques respiratoires durant le sommeil.',
             'session_duration' => '25 min', 'cure_duration' => '30 days', 'price' => 34.90,
             'benefits' => ['Respiratory muscle toning', 'Sleep breathing pattern regulation', 'Oxygen saturation support', 'Snoring reduction'],
             'tags' => ['sleep apnea', 'snoring', 'breathing', 'sleep']],

            ['cat' => 'ent-immunity', 'emoji' => '🛡️', 'title' => 'Immune Defence Boost', 'title_fr' => 'Renforcement Immunitaire',
             'short_desc' => 'Stimulates natural killer cell activity and strengthens the immune system against viruses and pathogens.',
             'short_desc_fr' => 'Stimule l\'activité des cellules natural killer et renforce l\'immunité contre les virus.',
             'session_duration' => '20 min', 'cure_duration' => '21 days', 'price' => 29.90,
             'benefits' => ['NK cell activation', 'T-lymphocyte stimulation', 'Anti-viral defence', 'Seasonal illness prevention'],
             'tags' => ['immunity', 'virus', 'NK cells', 'defence']],

            ['cat' => 'ent-immunity', 'emoji' => '👂', 'title' => 'Tinnitus', 'title_fr' => 'Acouphènes',
             'short_desc' => 'Auditory frequency retraining protocol to reduce tinnitus perception and central auditory sensitization.',
             'short_desc_fr' => 'Protocole de rééducation fréquentielle auditive pour réduire la perception des acouphènes.',
             'session_duration' => '20 min', 'cure_duration' => '30 days', 'price' => 34.90,
             'benefits' => ['Central auditory sensitization reduction', 'Tinnitus perception habituation', 'Stress-tinnitus link reduction', 'Sleep improvement'],
             'tags' => ['tinnitus', 'hearing', 'auditory', 'ringing']],

            ['cat' => 'ent-immunity', 'emoji' => '🤧', 'title' => 'Chronic Sinusitis', 'title_fr' => 'Sinusite Chronique',
             'short_desc' => 'Anti-inflammatory frequencies for chronic sinusitis, nasal polyp reduction, and sinus drainage restoration.',
             'short_desc_fr' => 'Fréquences anti-inflammatoires pour sinusite chronique et restauration du drainage sinusal.',
             'session_duration' => '20 min', 'cure_duration' => '21 days', 'price' => 29.90,
             'benefits' => ['Sinus inflammation reduction', 'Mucosal healing', 'Drainage restoration', 'Breathing improvement'],
             'tags' => ['sinusitis', 'sinus', 'nasal', 'inflammation']],

            ['cat' => 'ent-immunity', 'emoji' => '😮‍💨', 'title' => 'Chronic Fatigue', 'title_fr' => 'Fatigue Chronique',
             'short_desc' => 'Deep cellular energy restoration protocol for ME/CFS and persistent post-viral fatigue.',
             'short_desc_fr' => 'Protocole de restauration énergétique cellulaire profonde pour l\'asthénie et la fatigue post-virale.',
             'session_duration' => '30 min', 'cure_duration' => '30 days', 'price' => 34.90, 'is_bestseller' => true,
             'benefits' => ['Mitochondrial energy support', 'Post-viral recovery', 'Adrenal restoration', 'Cellular ATP regeneration'],
             'tags' => ['fatigue', 'CFS', 'energy', 'mitochondria']],

            /* ─── HORMONAL ─── */
            ['cat' => 'hormonal', 'emoji' => '🌙', 'title' => 'Menstrual Pain & PMS', 'title_fr' => 'Douleurs Menstruelles & SPM',
             'short_desc' => 'Regulates prostaglandin production, reduces uterine contractions, and addresses PMS hormonal imbalances.',
             'short_desc_fr' => 'Régule la production de prostaglandines et réduit les contractions utérines douloureuses.',
             'session_duration' => '20 min', 'cure_duration' => '21 days', 'price' => 29.90, 'is_bestseller' => true, 'is_featured' => true,
             'benefits' => ['Prostaglandin regulation', 'Uterine spasm reduction', 'PMS emotional symptoms', 'Hormonal cycle balance'],
             'tags' => ['menstrual', 'PMS', 'cramps', 'hormones']],

            ['cat' => 'hormonal', 'emoji' => '🌡️', 'title' => 'Menopause & Perimenopause', 'title_fr' => 'Ménopause & Périménopause',
             'short_desc' => 'Supports the hormonal transition of menopause — hot flashes, mood swings, sleep disruption, and libido.',
             'short_desc_fr' => 'Soutient la transition hormonale de la ménopause: bouffées de chaleur, humeur, sommeil.',
             'session_duration' => '25 min', 'cure_duration' => '30 days', 'price' => 34.90,
             'benefits' => ['Estrogen transition support', 'Hot flash reduction', 'Mood stabilization', 'Sleep quality improvement'],
             'tags' => ['menopause', 'estrogen', 'hormones', 'hot flashes']],

            ['cat' => 'hormonal', 'emoji' => '❤️‍🔥', 'title' => 'Libido & Sexual Vitality', 'title_fr' => 'Libido & Vitalité Sexuelle',
             'short_desc' => 'Rebalances sexual hormones and stimulates desire through pelvic and endocrine frequency protocols.',
             'short_desc_fr' => 'Rééquilibre les hormones sexuelles et stimule le désir par des protocoles pelviens et endocriniens.',
             'session_duration' => '20 min', 'cure_duration' => '21 days', 'price' => 29.90,
             'benefits' => ['Sexual hormone rebalancing', 'Desire stimulation', 'Pelvic circulation', 'Relationship vitality'],
             'tags' => ['libido', 'hormones', 'sexual', 'vitality']],

            ['cat' => 'hormonal', 'emoji' => '⚖️', 'title' => 'Weight & Metabolism', 'title_fr' => 'Poids & Métabolisme',
             'short_desc' => 'Regulates metabolic rate, reduces emotional eating triggers, and supports healthy weight management.',
             'short_desc_fr' => 'Régule le métabolisme, réduit les déclencheurs émotionnels de la faim.',
             'session_duration' => '25 min', 'cure_duration' => '30 days', 'price' => 34.90, 'is_bestseller' => true,
             'benefits' => ['Metabolic rate optimization', 'Emotional hunger reduction', 'Insulin sensitivity', 'Fat-burning pathway support'],
             'tags' => ['weight', 'metabolism', 'insulin', 'slimming']],

            ['cat' => 'hormonal', 'emoji' => '🦋', 'title' => 'Thyroid Balance', 'title_fr' => 'Équilibre Thyroïdien',
             'short_desc' => 'Supports thyroid hormone production and regulation for both hypo and hyperthyroid tendencies.',
             'short_desc_fr' => 'Soutient la production et régulation des hormones thyroïdiennes pour hypo et hyperthyroïdie.',
             'session_duration' => '25 min', 'cure_duration' => '30 days', 'price' => 34.90,
             'benefits' => ['Thyroid frequency stimulation', 'T3/T4 regulation support', 'Energy and metabolism', 'Temperature regulation'],
             'tags' => ['thyroid', 'T3', 'T4', 'metabolism']],

            ['cat' => 'hormonal', 'emoji' => '💪', 'title' => 'Testosterone & Vitality (Men)', 'title_fr' => 'Testostérone & Vitalité Masculine',
             'short_desc' => 'Stimulates natural testosterone production, boosts energy, libido, muscle tone, and mental drive.',
             'short_desc_fr' => 'Stimule la production naturelle de testostérone, booste l\'énergie, la libido et le tonus musculaire.',
             'session_duration' => '25 min', 'cure_duration' => '30 days', 'price' => 34.90,
             'benefits' => ['Natural testosterone support', 'Energy and drive', 'Muscle tone optimization', 'Male vitality'],
             'tags' => ['testosterone', 'men', 'vitality', 'hormones']],

            /* ─── NEUROLOGICAL ─── */
            ['cat' => 'neurological', 'emoji' => '😴', 'title' => 'Insomnia & Sleep', 'title_fr' => 'Insomnie & Troubles du Sommeil',
             'short_desc' => 'Delta-wave entrainment protocol to reset your sleep architecture, reduce sleep latency, and improve sleep depth.',
             'short_desc_fr' => 'Protocole d\'entraînement delta pour réinitialiser l\'architecture du sommeil.',
             'session_duration' => '30 min', 'cure_duration' => '21 days', 'price' => 29.90, 'is_bestseller' => true, 'is_featured' => true,
             'benefits' => ['Sleep architecture reset', 'Sleep latency reduction', 'Deep sleep stage increase', 'Morning recovery'],
             'tags' => ['insomnia', 'sleep', 'delta waves', 'melatonin']],

            ['cat' => 'neurological', 'emoji' => '🧠', 'title' => 'Memory & Cognitive Function', 'title_fr' => 'Mémoire & Cognition',
             'short_desc' => 'Enhances synaptic plasticity and memory consolidation through targeted gamma and beta frequency protocols.',
             'short_desc_fr' => 'Améliore la plasticité synaptique et la consolidation mémorielle par des protocoles gamma et bêta.',
             'session_duration' => '25 min', 'cure_duration' => '21 days', 'price' => 29.90,
             'benefits' => ['Synaptic plasticity enhancement', 'Memory consolidation', 'Learning speed', 'Mental clarity'],
             'tags' => ['memory', 'cognitive', 'focus', 'brain']],

            ['cat' => 'neurological', 'emoji' => '🤕', 'title' => 'Migraine', 'title_fr' => 'Migraine',
             'short_desc' => 'Prevents migraine onset and reduces severity through vascular tone regulation and cortical frequency protocols.',
             'short_desc_fr' => 'Prévient les migraines et réduit l\'intensité par la régulation du tonus vasculaire.',
             'session_duration' => '20 min', 'cure_duration' => '30 days', 'price' => 29.90,
             'benefits' => ['Migraine frequency reduction', 'Vascular tone regulation', 'Photosensitivity improvement', 'Pain management'],
             'tags' => ['migraine', 'headache', 'vascular', 'pain']],

            ['cat' => 'neurological', 'emoji' => '⚡', 'title' => 'Focus & Concentration (ADD)', 'title_fr' => 'Focus & Concentration (TDA)',
             'short_desc' => 'Trains the prefrontal cortex and executive function through SMR and beta frequency protocols for focus.',
             'short_desc_fr' => 'Entraîne le cortex préfrontal et les fonctions exécutives par des protocoles SMR et bêta.',
             'session_duration' => '20 min', 'cure_duration' => '21 days', 'price' => 29.90, 'is_featured' => true,
             'benefits' => ['Prefrontal cortex training', 'Attention span improvement', 'Impulsivity reduction', 'Academic/professional performance'],
             'tags' => ['focus', 'ADD', 'ADHD', 'concentration']],

            ['cat' => 'neurological', 'emoji' => '🌀', 'title' => 'Vertigo & Dizziness', 'title_fr' => 'Vertiges & Étourdissements',
             'short_desc' => 'Restores vestibular system balance and reduces chronic vertigo, dizziness, and balance disorders.',
             'short_desc_fr' => 'Restaure l\'équilibre vestibulaire et réduit les vertiges chroniques.',
             'session_duration' => '20 min', 'cure_duration' => '21 days', 'price' => 29.90,
             'benefits' => ['Vestibular rebalancing', 'Inner ear frequency support', 'Balance system reset', 'Nausea reduction'],
             'tags' => ['vertigo', 'dizziness', 'vestibular', 'balance']],

            ['cat' => 'neurological', 'emoji' => '✨', 'title' => 'Brain Detox & Clarity', 'title_fr' => 'Détox Cérébrale & Clarté Mentale',
             'short_desc' => 'Supports glymphatic system activity and brain toxin clearance for sharper mental clarity and reduced brain fog.',
             'short_desc_fr' => 'Soutient le système glymphatique et l\'élimination des toxines cérébrales.',
             'session_duration' => '30 min', 'cure_duration' => '21 days', 'price' => 29.90,
             'benefits' => ['Glymphatic system support', 'Brain fog reduction', 'Mental clarity enhancement', 'Neurological toxin clearance'],
             'tags' => ['brain fog', 'clarity', 'detox', 'cognition']],
        ];

        $sort = 1;
        foreach ($programs as $p) {
            $catModel = $cats->get($p['cat']);
            if (!$catModel) continue;

            Program::updateOrCreate(
                ['slug' => Str::slug($p['title'])],
                [
                    'category_id'      => $catModel->id,
                    'title'            => $p['title'],
                    'title_fr'         => $p['title_fr'],
                    'slug'             => Str::slug($p['title']),
                    'emoji'            => $p['emoji'],
                    'short_desc'       => $p['short_desc'],
                    'short_desc_fr'    => $p['short_desc_fr'],
                    'session_duration' => $p['session_duration'],
                    'cure_duration'    => $p['cure_duration'],
                    'price'            => $p['price'],
                    'is_bestseller'    => $p['is_bestseller'] ?? false,
                    'is_featured'      => $p['is_featured'] ?? false,
                    'is_active'        => true,
                    'benefits'         => $p['benefits'] ?? [],
                    'tags'             => $p['tags'] ?? [],
                    'sort_order'       => $sort++,
                ]
            );
        }
    }
}
