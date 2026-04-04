<template>
  <AppLayout>

    <!-- ═══ HERO ═══ -->
    <section class="blog-hero">
      <div class="badge">{{ t('blog.hero_label') }}</div>
      <h1>{{ t('blog.hero_title') }}<br><em>{{ t('blog.hero_title_em') }}</em></h1>
      <p class="hero-sub">{{ t('blog.hero_sub') }}</p>
    </section>

    <!-- ═══ FILTRES ═══ -->
    <div class="filters">
      <button v-for="f in filters" :key="f.key"
        class="fbtn" :class="{ active: activeFilter === f.key }"
        @click="activeFilter = f.key">{{ f.label }}</button>
    </div>

    <!-- ═══ GRILLE ARTICLES ═══ -->
    <div class="grid-wrap">
      <div class="agrid">
        <template v-if="backendPosts.length">
          <div v-for="post in filteredBackend" :key="post.id"
            class="article-card reveal"
            @click="openBackendPost(post)">
            <div class="card-img">
              <span class="card-cat">{{ post.category || 'Blog' }}</span>
              <span>{{ post.emoji || '📖' }}</span>
            </div>
            <div class="card-body">
              <div class="card-meta">
                <span>{{ formatDate(post.published_at) }}</span>
                <span>{{ post.read_time ? post.read_time + ' min de lecture' : '' }}</span>
              </div>
              <div class="card-title">{{ post.title }}</div>
              <div class="card-excerpt">{{ post.excerpt }}</div>
              <span class="read-more">{{ t('blog.read_more') }} →</span>
            </div>
          </div>
        </template>
        <template v-else>
          <div v-for="article in filteredStatic" :key="article.id"
            class="article-card reveal"
            @click="openStatic(article)">
            <div class="card-img">
              <span class="card-cat">{{ article.cat }}</span>
              <span>{{ article.emoji }}</span>
            </div>
            <div class="card-body">
              <div class="card-meta">
                <span>{{ article.date }}</span>
                <span>{{ article.readTime }}</span>
              </div>
              <div class="card-title">{{ article.title }}</div>
              <div class="card-excerpt">{{ article.excerpt }}</div>
              <span class="read-more">{{ t('blog.read_more') }} →</span>
            </div>
          </div>
        </template>
      </div>
    </div>

    <!-- ═══ NEWSLETTER ═══ -->
    <div class="nl-wrap">
      <div class="nl reveal">
        <h2>{{ t('blog.newsletter_title') }}</h2>
        <p>{{ t('blog.newsletter_sub') }}</p>
        <div class="nlf">
          <input v-model="nlEmail" type="email" :placeholder="t('blog.newsletter_placeholder')" />
          <button @click="nlSubmit">{{ nlDone ? '✓' : t('blog.newsletter_btn') }}</button>
        </div>
      </div>
    </div>

    <!-- ═══ MODAL ARTICLE ═══ -->
    <div class="modal-overlay" :class="{ open: modalOpen }" @click.self="closeModal">
      <div class="modal">
        <button class="mclose" @click="closeModal">✕</button>
        <div v-if="activeArticle">
          <div class="modal-cat">{{ activeArticle.cat }}</div>
          <h2 class="modal-title">{{ activeArticle.title }}</h2>
          <div class="modal-meta">
            <span>Dr. Éric Rosati</span>
            <span>{{ activeArticle.date }}</span>
            <span>{{ activeArticle.readTime }}</span>
          </div>
          <div class="modal-body" v-html="activeArticle.content"></div>
          <div class="mcta">
            <p>Trouvez votre protocole personnalisé</p>
            <a :href="route('shop')">Explorer les programmes →</a>
          </div>
        </div>
      </div>
    </div>

  </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useI18n } from '@/composables/useI18n'
const { t } = useI18n()

const props = defineProps({ posts: Object })

const activeFilter = ref('all')
const modalOpen = ref(false)
const activeArticle = ref(null)
const nlEmail = ref('')
const nlDone = ref(false)

const filters = [
  { key: 'all',      label: 'Tous les articles' },
  { key: 'science',  label: 'Science' },
  { key: 'stress',   label: 'Stress et Burn-out' },
  { key: 'hormonal', label: 'Hormonal' },
  { key: 'sommeil',  label: 'Sommeil' },
  { key: 'douleur',  label: 'Douleur' },
]

const staticArticles = [
  {
    id: 'bio', catKey: 'science', cat: 'Science', emoji: '🔬',
    date: '15 mars 2025', readTime: '8 min de lecture',
    title: 'La bio-résonance : quand le son guérit les cellules',
    excerpt: 'Comment des fréquences sonores spécifiques restaurent le potentiel de membrane cellulaire et relancent les mécanismes naturels de guérison.',
    content: `<h3>Le langage électrique des cellules</h3>
<p>Votre corps contient environ 70 000 milliards de cellules, chacune fonctionnant comme une pile électrique sophistiquée. Chaque cellule maintient une différence de potentiel entre son intérieur et son extérieur, générant un champ bio-électrique mesurable. Ce réseau de signaux électriques constitue le véritable système de communication de votre organisme.</p>
<h3>Comment fonctionne la bio-résonance ?</h3>
<p>La thérapie par fréquences bio-énergétiques repose sur un principe fondamental de la physique quantique : tout atome, toute molécule, tout organe vibre à une fréquence spécifique. Lorsque ces fréquences se désynchronisent sous l'effet du stress, des toxines ou des traumatismes, des dysfonctionnements apparaissent. La bio-résonance utilise des fréquences précises pour restaurer ces oscillations naturelles.</p>
<p>Le Dr Éric Rosati, après 25 ans de recherche clinique, a identifié les signatures fréquentielles de plus de 200 pathologies. Ses protocoles audio ciblent les tissus malades avec une précision remarquable, activant les mécanismes d'auto-guérison inhérents à chaque organisme.</p>
<h3>Les preuves scientifiques</h3>
<p>Des études récentes en biophysique ont documenté l'influence des champs électromagnétiques sur la prolifération cellulaire, la régénération tissulaire et même l'expression génétique. Des institutions comme l'Université de Californie et le Max Planck Institute publient régulièrement des travaux confirmant que les cellules vivantes émettent et reçoivent des signaux photoniques ultra-faibles.</p>
<h3>Pourquoi les écouteurs à conduction osseuse ?</h3>
<p>Les protocoles Vitality Inside utilisent exclusivement des écouteurs à conduction osseuse car ils transmettent les vibrations directement au système osseux, contournant la membrane du tympan. Cette voie privilégiée permet une diffusion plus profonde et plus efficace des fréquences thérapeutiques vers les structures internes de l'organisme.</p>`,
  },
  {
    id: 'burn', catKey: 'stress', cat: 'Stress & Burn-out', emoji: '🧠',
    date: '28 fév. 2025', readTime: '6 min de lecture',
    title: 'Burn-out : reconstruire le système nerveux par les fréquences',
    excerpt: "Le burn-out n'est pas une faiblesse — c'est un effondrement neurologique mesurable que les fréquences peuvent reconstruire.",
    content: `<h3>Le burn-out comme phénomène neurologique</h3>
<p>Le burn-out n'est pas une faiblesse de caractère ni un simple surmenage. C'est un effondrement neurobiologique mesurable, caractérisé par une dysrégulation de l'axe hypothalamo-hypophyso-surrénalien, un épuisement des réserves de neurotransmetteurs et une altération structurelle de plusieurs régions cérébrales.</p>
<h3>Ce que le burn-out fait à votre cerveau</h3>
<p>Les études d'imagerie cérébrale montrent que le burn-out chronique réduit le volume du cortex préfrontal, la région responsable de la prise de décision, de la régulation émotionnelle et de la planification. Le cortisol, hormone du stress secrétée en excès pendant des mois, détruit littéralement les neurones de l'hippocampe, affectant la mémoire et la capacité d'apprentissage.</p>
<h3>Le protocole Vitality Inside pour le burn-out</h3>
<p>Notre protocole spécifique au burn-out combine plusieurs approches fréquentielles. Les fréquences delta (0.5-4 Hz) induisent un sommeil profond réparateur et stimulent la production de l'hormone de croissance, essentielle à la régénération neurologique. Les fréquences thêta (4-8 Hz) favorisent les états méditatifs et accélèrent la restauration des réserves émotionnelles.</p>
<h3>Témoignages de guérison</h3>
<p>Aurore, 38 ans, cadre supérieure : <em>"Après 6 mois d'arrêt maladie pour burn-out sévère, aucun traitement médical n'avait réussi à me redonner de l'énergie. En 30 jours de protocole Vitality Inside, j'ai progressivement retrouvé la capacité de me lever le matin avec envie."</em></p>`,
  },
  {
    id: 'meno', catKey: 'hormonal', cat: 'Hormonal', emoji: '🌸',
    date: '10 fév. 2025', readTime: '7 min de lecture',
    title: 'Ménopause et bio-résonance : rééquilibrer sans hormones',
    excerpt: 'Les bouffées de chaleur et les troubles du sommeil de la ménopause ont une origine bio-énergétique précise.',
    content: `<h3>La ménopause comme transition bio-énergétique</h3>
<p>Au-delà de la chimie hormonale, la ménopause est une transformation profonde du champ bio-énergétique féminin. L'arrêt de la production cyclique d'œstrogènes et de progestérone modifie non seulement le métabolisme, mais aussi le système nerveux autonome, le cerveau émotionnel et la thermorégulation centrale.</p>
<h3>Comprendre les mécanismes des bouffées de chaleur</h3>
<p>Les bouffées de chaleur résultent d'une hypersensibilité de l'hypothalamus, notre thermostat central, devenu dysfonctionnel en l'absence d'œstrogènes. Les fréquences bio-énergétiques ciblent spécifiquement l'hypothalamus pour restaurer cette zone neutre et réduire la fréquence et l'intensité des bouffées de chaleur. Des essais cliniques observationnels ont montré une réduction de 60 à 70% des épisodes vasomoteurs après 6 semaines de protocole.</p>
<h3>L'approche naturelle sans risques</h3>
<p>Contrairement au traitement hormonal substitutif (THS) qui présente des risques documentés, la thérapie par fréquences n'a aucun effet secondaire. Elle stimule la production naturelle d'hormones par les glandes surrénales, sans introduire d'hormones exogènes.</p>
<p>Michèle, 53 ans : <em>"Les protocoles Vitality Inside ont été ma bouée de sauvetage. En 3 semaines, les bouffées de chaleur nocturnes ont cessé et j'ai retrouvé un sommeil continu pour la première fois depuis 2 ans."</em></p>`,
  },
  {
    id: 'stress', catKey: 'stress', cat: 'Stress & Burn-out', emoji: '💊',
    date: '25 janv. 2025', readTime: '5 min de lecture',
    title: 'Stress chronique : ce que font vraiment les fréquences à vos cellules',
    excerpt: 'Le stress chronique dégrade le potentiel de membrane cellulaire de façon mesurable — voici comment les fréquences inversent ce processus.',
    content: `<h3>Le stress comme perturbateur électrique</h3>
<p>Le stress chronique compromet l'intégrité des membranes cellulaires, perturbe la transmission synaptique et désynchronise les rythmes cérébraux. Comprendre ces mécanismes permet d'agir précisément avec les fréquences bio-énergétiques appropriées.</p>
<h3>La cascade du stress : du cerveau aux cellules</h3>
<p>Lorsque vous percevez une menace, votre amygdale déclenche une alarme en quelques millisecondes. Cette alarme active l'axe HPA, libérant en cascade CRH, ACTH puis cortisol. En situation de stress chronique, cette cascade ne s'éteint plus, maintenant votre organisme dans un état d'urgence permanent physiologiquement destructeur.</p>
<h3>Comment les fréquences alpha contrecarrent le stress</h3>
<p>Les fréquences alpha (8-12 Hz) sont les ondes cérébrales caractéristiques de la relaxation vigilante. Elles signalent au système limbique que la menace est passée, déclenchant une cascade de relaxation : diminution du cortisol, augmentation de la sérotonine et de la GABA, activation du système parasympathique.</p>
<p>Thomas, 42 ans : <em>"Sous supervision médicale, j'ai pu réduire progressivement mes benzodiazépines tout en utilisant les protocoles Vitality Inside. Mon psychiatre a été surpris par la rapidité du sevrage sans symptômes de manque."</em></p>`,
  },
  {
    id: 'sleep', catKey: 'sommeil', cat: 'Sommeil', emoji: '🌙',
    date: '12 janv. 2025', readTime: '6 min de lecture',
    title: "Troubles du sommeil : restaurer l'architecture naturelle du sommeil",
    excerpt: "L'insomnie est une dysrégulation de l'architecture cérébrale du sommeil que les fréquences peuvent recalibrer précisément.",
    content: `<h3>L'architecture du sommeil restaurée par les fréquences</h3>
<p>Un sommeil réparateur suit des cycles de 90 minutes alternant sommeil léger, sommeil profond et sommeil paradoxal (REM). En une nuit typique, vous traversez 4 à 6 de ces cycles. La moindre perturbation de cette architecture précise compromet la récupération physique et cognitive.</p>
<h3>Pourquoi le sommeil profond est crucial</h3>
<p>Le sommeil profond est le moment où l'hormone de croissance est secrétée en grande quantité, permettant la réparation tissulaire. C'est aussi pendant ces stades que le système glymphatique du cerveau s'active, éliminant les déchets métaboliques accumulés pendant la journée, dont les protéines amyloïdes associées à la maladie d'Alzheimer.</p>
<h3>Les fréquences delta pour induire le sommeil profond</h3>
<p>Les fréquences delta (0.5-4 Hz) caractérisent l'activité cérébrale du sommeil profond. En les diffusant par conduction osseuse au moment de s'endormir, vous guidez votre cerveau vers cet état réparateur en court-circuitant les ruminations et l'hypervigilance nocturne.</p>
<p>Monique, 58 ans : <em>"Insomniaque depuis ma ménopause il y a 8 ans. Dès la première semaine du protocole Vitality Inside, j'ai dormi 6 heures d'affilée. En 3 semaines, je dormais 7-8 heures sans interruption."</em></p>`,
  },
  {
    id: 'pain', catKey: 'douleur', cat: 'Douleur', emoji: '🦴',
    date: '5 janv. 2025', readTime: '7 min de lecture',
    title: 'Douleur chronique : effacer la mémoire douloureuse du système nerveux',
    excerpt: 'La douleur chronique est une mémoire encodée dans le système nerveux. La bio-résonance peut la réécrire.',
    content: `<h3>La douleur chronique : mémoire pathologique et guérison par les fréquences</h3>
<p>La douleur chronique est une mémoire pathologique du système nerveux. Contrairement à la douleur aiguë qui signale une lésion réelle, la douleur chronique persiste après guérison des tissus, entretenue par des circuits neuronaux devenus autonomes.</p>
<h3>Neuroplasticité douloureuse : comment la douleur s'installe</h3>
<p>En situation de douleur persistante, le système nerveux subit une "sensibilisation centrale" : les neurones de la moelle épinière et du cerveau baissent leur seuil d'activation, amplifiant tous les signaux. Ce phénomène explique pourquoi des stimuli normalement indolores deviennent douloureux (allodynie).</p>
<h3>Comment les fréquences brisent le cycle douloureux</h3>
<p>Les fréquences thêta (4-8 Hz) activent les voies inhibitrices descendantes, qui "ferment le portillon" de la douleur au niveau spinal. Ces voies utilisent des opioïdes endogènes (endorphines, enképhalines) comme neurotransmetteurs.</p>
<p>Geneviève, 67 ans : <em>"Je marchais avec une canne depuis 2 ans. Après 4 semaines de protocole, j'ai rangé la canne. Mon rhumatologue a noté une amélioration significative à l'échographie."</em></p>`,
  },
]

const backendPosts = computed(() => props.posts?.data ?? [])

const filteredBackend = computed(() => {
  if (activeFilter.value === 'all') return backendPosts.value
  return backendPosts.value.filter(p => (p.category_key || p.category || '').toLowerCase() === activeFilter.value)
})

const filteredStatic = computed(() => {
  if (activeFilter.value === 'all') return staticArticles
  return staticArticles.filter(a => a.catKey === activeFilter.value)
})

function openStatic(article) {
  activeArticle.value = article
  modalOpen.value = true
  document.body.style.overflow = 'hidden'
}

function openBackendPost(post) {
  activeArticle.value = {
    cat: post.category || 'Blog',
    title: post.title,
    date: formatDate(post.published_at),
    readTime: post.read_time ? post.read_time + ' min de lecture' : '',
    content: post.content || post.excerpt || '',
  }
  modalOpen.value = true
  document.body.style.overflow = 'hidden'
}

function closeModal() {
  modalOpen.value = false
  document.body.style.overflow = ''
}

function nlSubmit() {
  if (nlEmail.value) nlDone.value = true
}

const formatDate = (d) => d ? new Date(d).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' }) : ''

onMounted(() => {
  const obs = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => {
      if (e.isIntersecting) setTimeout(() => e.target.classList.add('visible'), i * 80)
    })
  }, { threshold: 0.05 })
  document.querySelectorAll('.reveal').forEach(el => obs.observe(el))

  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal() })
})
</script>

<style scoped>
/* HERO */
.blog-hero {
  padding: 140px 40px 60px; text-align: center;
  background: radial-gradient(ellipse 70% 50% at 50% 0%, rgba(13,115,119,.15) 0%, transparent 65%), #0a1628;
}
.badge {
  display: inline-flex; background: rgba(200,169,110,.1); border: 1px solid rgba(200,169,110,.25);
  border-radius: 50px; padding: 8px 18px; font-size: .72rem; letter-spacing: .15em;
  color: #c8a96e; text-transform: uppercase; margin-bottom: 32px;
}
.blog-hero h1 {
  font-family: 'Cormorant Garamond', serif; font-size: clamp(2.5rem, 6vw, 4rem);
  font-weight: 300; line-height: 1.1; margin-bottom: 20px; color: #fff;
}
.blog-hero h1 em { color: #c8a96e; font-style: italic; }
.hero-sub { font-size: 1.05rem; color: rgba(255,255,255,.5); max-width: 600px; margin: 0 auto; line-height: 1.7; }

/* FILTERS */
.filters { padding: 20px 40px 40px; display: flex; justify-content: center; flex-wrap: wrap; gap: 10px; }
.fbtn {
  background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.12);
  color: rgba(255,255,255,.7); padding: 9px 20px; border-radius: 50px; cursor: pointer;
  font-size: .8rem; font-family: 'DM Sans', sans-serif; transition: all .2s;
}
.fbtn:hover, .fbtn.active {
  background: rgba(200,169,110,.15); border-color: rgba(200,169,110,.4); color: #c8a96e;
}

/* GRID */
.grid-wrap { padding: 0 40px 80px; max-width: 1200px; margin: 0 auto; }
.agrid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 28px; }

/* ARTICLE CARD */
.article-card {
  background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08);
  border-radius: 16px; overflow: hidden; cursor: pointer; transition: all .3s;
}
.article-card:hover { border-color: rgba(200,169,110,.3); transform: translateY(-4px); }
.card-img {
  height: 200px;
  background: linear-gradient(135deg, #0d2444, #0d3355);
  position: relative; display: flex; align-items: center; justify-content: center; font-size: 3.5rem;
}
.card-cat {
  position: absolute; top: 12px; left: 12px;
  background: rgba(200,169,110,.2); border: 1px solid rgba(200,169,110,.3);
  color: #c8a96e; padding: 4px 12px; border-radius: 20px; font-size: .7rem; text-transform: uppercase;
}
.card-body { padding: 24px; }
.card-meta { display: flex; gap: 12px; font-size: .75rem; color: rgba(255,255,255,.5); margin-bottom: 12px; }
.card-title { font-family: 'Cormorant Garamond', serif; font-size: 1.35rem; font-weight: 400; margin-bottom: 10px; line-height: 1.3; color: #fff; }
.card-excerpt { font-size: .85rem; color: rgba(255,255,255,.5); line-height: 1.6; margin-bottom: 16px; }
.read-more { color: #14a8a0; font-size: .8rem; font-weight: 500; }

/* NEWSLETTER */
.nl-wrap { padding: 0 40px 80px; }
.nl {
  background: rgba(13,115,119,.08); border: 1px solid rgba(13,115,119,.2);
  border-radius: 20px; padding: 48px; text-align: center; max-width: 800px; margin: 0 auto;
}
.nl h2 { font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; font-weight: 300; color: #fff; margin-bottom: 12px; }
.nl p { color: rgba(255,255,255,.5); margin-bottom: 24px; font-size: .95rem; }
.nlf { display: flex; gap: 12px; max-width: 440px; margin: 0 auto; }
.nlf input {
  flex: 1; background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.15);
  color: #fff; padding: 12px 18px; border-radius: 50px; font-family: 'DM Sans', sans-serif;
  font-size: .9rem; outline: none;
}
.nlf input::placeholder { color: rgba(255,255,255,.3); }
.nlf button {
  background: #c8a96e; color: #0a1628; border: none; padding: 12px 24px;
  border-radius: 50px; cursor: pointer; font-weight: 600; font-family: 'DM Sans', sans-serif;
  font-size: .88rem; transition: background .2s;
}
.nlf button:hover { background: #e8d5a3; }

/* MODAL */
.modal-overlay {
  position: fixed; inset: 0; background: rgba(0,0,0,.85); z-index: 500;
  display: none; align-items: flex-start; justify-content: center;
  padding: 60px 20px; overflow-y: auto;
}
.modal-overlay.open { display: flex; }
.modal {
  background: #0a1628; border: 1px solid rgba(200,169,110,.2);
  border-radius: 20px; max-width: 780px; width: 100%; padding: 48px; position: relative;
  margin: auto;
}
.mclose {
  position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,.08);
  border: none; color: #fff; width: 36px; height: 36px; border-radius: 50%;
  cursor: pointer; font-size: 1.1rem; display: flex; align-items: center; justify-content: center;
  transition: background .2s;
}
.mclose:hover { background: rgba(255,255,255,.15); }
.modal-cat { font-size: .72rem; text-transform: uppercase; letter-spacing: .12em; color: #c8a96e; margin-bottom: 8px; }
.modal-title { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 300; color: #fff; margin-bottom: 16px; line-height: 1.2; }
.modal-meta {
  display: flex; gap: 16px; font-size: .8rem; color: rgba(255,255,255,.5);
  margin-bottom: 28px; padding-bottom: 28px; border-bottom: 1px solid rgba(255,255,255,.08);
}
.modal-body { font-size: .95rem; line-height: 1.8; color: rgba(255,255,255,.8); }
.modal-body :deep(h3) { font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; color: #c8a96e; margin: 24px 0 10px; }
.modal-body :deep(p) { margin-bottom: 14px; }
.modal-body :deep(ul) { padding-left: 20px; margin-bottom: 14px; }
.modal-body :deep(li) { margin-bottom: 6px; }
.modal-body :deep(em) { color: rgba(200,169,110,.9); font-style: italic; }
.mcta {
  margin-top: 28px; padding-top: 24px; border-top: 1px solid rgba(255,255,255,.08); text-align: center;
}
.mcta p { color: rgba(255,255,255,.6); font-size: .9rem; margin-bottom: 16px; }
.mcta a {
  display: inline-block; background: linear-gradient(135deg, #0d7377, #14a8a0);
  color: #fff; padding: 14px 36px; border-radius: 50px; text-decoration: none;
  font-size: .9rem; font-weight: 500; transition: box-shadow .2s;
}
.mcta a:hover { box-shadow: 0 8px 32px rgba(13,115,119,.4); }

/* REVEAL ANIMATION */
.reveal { opacity: 0; transform: translateY(24px); transition: opacity .6s, transform .6s; }
.reveal.visible { opacity: 1; transform: none; }

@media (max-width: 768px) {
  .blog-hero { padding: 100px 20px 50px; }
  .filters, .grid-wrap, .nl-wrap { padding-left: 20px; padding-right: 20px; }
  .agrid { grid-template-columns: 1fr; }
  .modal { padding: 28px; }
  .nlf { flex-direction: column; }
}
</style>
