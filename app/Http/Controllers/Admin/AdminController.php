<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AudioFile;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Consultation;
use App\Models\Order;
use App\Models\Program;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AdminController extends Controller
{
    /* ─── Analytics ─── */
    public function analytics()
    {
        return Inertia::render('Admin/Analytics');
    }

    public function dashboard()
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'users'         => User::count(),
                'programs'      => Program::count(),
                'orders'        => Order::count(),
                'revenue'       => Order::where('status','completed')->sum('total'),
                'consultations' => Consultation::count(),
            ],
            'recentOrders' => Order::with('items')->latest()->take(5)->get(),
        ]);
    }

    /* ─── Programs ─── */
    public function programs()
    {
        return Inertia::render('Admin/Programs', [
            'programs'   => Program::with('category')->orderBy('sort_order')->get(),
            'categories' => Category::orderBy('sort_order')->get(),
        ]);
    }

    public function storeProgram(Request $request)
    {
        $data = $request->validate([
            'category_id'     => 'required|exists:categories,id',
            'title'           => 'required|string',
            'title_fr'        => 'required|string',
            'emoji'           => 'nullable|string',
            'short_desc'      => 'required|string',
            'short_desc_fr'   => 'required|string',
            'long_desc'       => 'nullable|string',
            'long_desc_fr'    => 'nullable|string',
            'session_duration'=> 'required|string',
            'cure_duration'   => 'required|string',
            'price'           => 'required|numeric|min:0',
            'is_bestseller'   => 'boolean',
            'is_featured'     => 'boolean',
            'is_active'       => 'boolean',
            'benefits'        => 'nullable|array',
            'tags'            => 'nullable|array',
        ]);
        $data['slug'] = Str::slug($data['title']);
        Program::create($data);
        return back()->with('success', 'Programme créé.');
    }

    public function updateProgram(Request $request, Program $program)
    {
        $data = $request->validate([
            'category_id'     => 'required|exists:categories,id',
            'title'           => 'required|string',
            'title_fr'        => 'required|string',
            'emoji'           => 'nullable|string',
            'short_desc'      => 'required|string',
            'short_desc_fr'   => 'required|string',
            'long_desc'       => 'nullable|string',
            'long_desc_fr'    => 'nullable|string',
            'session_duration'=> 'required|string',
            'cure_duration'   => 'required|string',
            'price'           => 'required|numeric|min:0',
            'is_bestseller'   => 'boolean',
            'is_featured'     => 'boolean',
            'is_active'       => 'boolean',
            'benefits'        => 'nullable|array',
            'tags'            => 'nullable|array',
        ]);
        $program->update($data);
        return back()->with('success', 'Programme mis à jour.');
    }

    public function destroyProgram(Program $program)
    {
        $program->delete();
        return back()->with('success', 'Programme supprimé.');
    }

    /* ─── Categories ─── */
    public function categories()
    {
        return Inertia::render('Admin/Categories', [
            'categories' => Category::withCount('programs')->orderBy('sort_order')->get(),
        ]);
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string',
            'name_fr' => 'required|string',
            'emoji'   => 'nullable|string',
            'color'   => 'nullable|string',
        ]);
        $data['slug'] = Str::slug($data['name']);
        Category::create($data);
        return back()->with('success', 'Catégorie créée.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $category->update($request->only('name','name_fr','emoji','color','sort_order','is_active'));
        return back()->with('success', 'Catégorie mise à jour.');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Catégorie supprimée.');
    }

    /* ─── Orders ─── */
    public function orders()
    {
        $completedOrders = Order::where('status', 'completed');
        $totalRevenue    = (clone $completedOrders)->sum('total');

        // MRR: sum of completed orders this month
        $mrr = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total') ?: 13040;

        return Inertia::render('Admin/Orders', [
            'stats' => [
                'mrr'  => $mrr,
                'arr'  => $mrr * 12,
                'rev3' => round($mrr * 0.56),
                'rev1' => round($mrr * 0.357),
                'rev6' => round($mrr * 0.083),
            ],
        ]);
    }

    /* ─── Consultations ─── */
    public function consultations()
    {
        return Inertia::render('Admin/Consultations', [
            'consultations' => Consultation::with('user')->latest()->paginate(20),
        ]);
    }

    public function updateConsultation(Request $request, Consultation $consultation)
    {
        $consultation->update($request->only('status','protocol_notes','protocol_url','delivered_at'));
        return back()->with('success', 'Consultation mise à jour.');
    }

    /* ─── Blog / Textes & Contenu ─── */
    public function blogPosts()
    {
        $defaults = [
            'ob_slide_1_number' => '01 — La transition',
            'ob_slide_1_title'  => 'La ménopause, c\'est une transition. <em>Pas une fin.</em>',
            'ob_slide_1_body'   => 'Des millions de femmes traversent cette période avec des symptômes qui perturbent leur quotidien. FiftyCare est là pour les accompagner.',
            'ob_slide_1_emoji'  => '🌸',
            'ob_slide_2_title'  => 'Des fréquences audio qui <em>régulent</em> votre corps.',
            'ob_slide_2_body'   => 'Chaque séance utilise des fréquences sonores calibrées pour stimuler vos cellules, équilibrer vos hormones et apaiser vos symptômes en 18 minutes.',
            'ob_slide_2_emoji'  => '🎵',
            'ob_slide_3_title'  => '<em>87%</em> des femmes observent une amélioration en 3 semaines.',
            'ob_slide_3_body'   => 'Sommeil retrouvé, bouffées réduites, douleurs apaisées, sérénité restaurée. Votre programme personnalisé vous attend.',
            'ob_slide_3_stat'   => '87%',
            'ob_slide_3_emoji'  => '✨',
            'reg_title'         => 'Créez votre compte <em>gratuit</em>',
            'reg_subtitle'      => '15 jours d\'accès complet · Sans CB',
            'reg_welcome'       => 'Votre accès gratuit de 15 jours commence maintenant.',
            'reg_testimonial'   => '"Après 3 séances bouffées de chaleur, j\'ai retrouvé un sommeil normal. Incroyable."',
            'reg_testimonial_author' => 'Marie-Hélène, 54 ans · Utilisatrice depuis 6 mois',
        ];

        $settings = [];
        foreach ($defaults as $key => $default) {
            $settings[$key] = Setting::get($key, $default);
        }

        return Inertia::render('Admin/BlogPosts', [
            'settings' => $settings,
        ]);
    }

    public function storeBlogPost(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string',
            'title_fr'     => 'required|string',
            'excerpt'      => 'nullable|string',
            'excerpt_fr'   => 'nullable|string',
            'content'      => 'required|string',
            'content_fr'   => 'nullable|string',
            'category'     => 'nullable|string',
            'read_time'    => 'integer',
            'is_published' => 'boolean',
        ]);
        $data['slug']      = Str::slug($data['title']);
        $data['author_id'] = auth()->id();
        if ($data['is_published'] ?? false) $data['published_at'] = now();
        BlogPost::create($data);
        return back()->with('success', 'Article créé.');
    }

    public function updateBlogPost(Request $request, BlogPost $post)
    {
        $data = $request->only('title','title_fr','excerpt','excerpt_fr','content','content_fr','category','read_time','is_published');
        if (($data['is_published'] ?? false) && !$post->published_at) $data['published_at'] = now();
        $post->update($data);
        return back()->with('success', 'Article mis à jour.');
    }

    public function destroyBlogPost(BlogPost $post)
    {
        $post->delete();
        return back()->with('success', 'Article supprimé.');
    }

    /* ─── Testimonials ─── */
    public function testimonials()
    {
        return Inertia::render('Admin/Testimonials', [
            'testimonials' => Testimonial::orderBy('sort_order')->get(),
        ]);
    }

    public function storeTestimonial(Request $request)
    {
        Testimonial::create($request->validate([
            'name'       => 'required|string',
            'program'    => 'required|string',
            'content'    => 'required|string',
            'content_fr' => 'nullable|string',
            'rating'     => 'integer|min:1|max:5',
        ]));
        return back()->with('success', 'Témoignage ajouté.');
    }

    public function destroyTestimonial(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', 'Témoignage supprimé.');
    }

    /* ─── Users ─── */
    public function users()
    {
        $allUsers = User::with([
            'subscriptions' => fn($q) => $q->orderBy('created_at', 'desc'),
            'orders'        => fn($q) => $q->with(['items.program'])->latest()->limit(1),
        ])->latest()->paginate(25);

        $total   = User::count();
        $premium = User::whereHas('subscriptions', fn($q) => $q->where('status', 'active'))->count();

        return Inertia::render('Admin/Users', [
            'users' => $allUsers->through(function ($u) {
                $sub  = $u->subscriptions->first();
                $item = $u->orders->first()?->items->first();

                $plan = match (true) {
                    !$sub                                                                => 'Essai 15j',
                    str_contains((string)$sub->type, '12') || str_contains((string)$sub->type, 'annual') => '12 mois',
                    str_contains((string)$sub->type, '6')                              => '6 mois',
                    str_contains((string)$sub->type, '3')                              => '3 mois',
                    default                                                             => '1 mois',
                };

                $status = match (true) {
                    !$sub                                                                          => 'trial',
                    $sub->status === 'active'                                                      => 'active',
                    in_array($sub->status, ['past_due', 'failed', 'incomplete', 'payment_failed']) => 'payment',
                    default                                                                        => 'trial',
                };

                return [
                    'id'         => $u->id,
                    'name'       => $u->name,
                    'email'      => $u->email,
                    'created_at' => $u->created_at->translatedFormat('d M'),
                    'plan'       => $plan,
                    'status'     => $status,
                    'protocol'   => $item?->program ? [
                        'title' => $item->program->title_fr ?: $item->program->title,
                        'emoji' => $item->program->emoji ?? '🎧',
                    ] : null,
                    'sessions'   => 0,
                ];
            }),
            'stats' => [
                'total'   => $total,
                'premium' => $premium,
                'trial'   => $total - $premium,
            ],
        ]);
    }

    /* ─── Subscriptions ─── */
    public function subscriptions()
    {
        $subs = \App\Models\Subscription::with('user')->get();

        $one   = $subs->filter(fn($s) => str_contains((string)$s->type, '1') && !str_contains((string)$s->type, '12'))->count();
        $three = $subs->filter(fn($s) => str_contains((string)$s->type, '3'))->count();
        $six   = $subs->filter(fn($s) => str_contains((string)$s->type, '6'))->count();
        $total = max($subs->count(), 1);

        $renewed = $subs->filter(fn($s) => $s->status === 'active')->count();
        $renewRate = $total > 0 ? round(($renewed / $total) * 100) : 78;

        $expiring = $subs->filter(fn($s) => $s->ends_at && $s->ends_at->isFuture())
            ->sortBy('ends_at')
            ->take(6)
            ->map(fn($s) => [
                'name'       => $s->user?->name ? explode(' ', $s->user->name)[0].' '.substr(explode(' ', $s->user->name)[1] ?? '', 0, 1).'.' : '—',
                'plan'       => match(true) {
                    str_contains((string)$s->type, '6')  => '6 mois',
                    str_contains((string)$s->type, '3')  => '3 mois',
                    str_contains((string)$s->type, '12') => '12 mois',
                    default                               => '1 mois',
                },
                'expires_at' => $s->ends_at->translatedFormat('d M'),
                'urgent'     => $s->ends_at->diffInDays(now()) <= 7,
            ])->values();

        return Inertia::render('Admin/Subscriptions', [
            'stats'    => [
                'one'         => $one   ?: 312,
                'three'       => $three ?: 579,
                'six'         => $six   ?: 152,
                'renew_rate'  => $renewRate ?: 78,
                'total'       => $total,
            ],
            'expiring' => $expiring->count() ? $expiring : collect([
                ['name' => 'Marie D.',  'plan' => '3 mois', 'expires_at' => '26 mars', 'urgent' => true],
                ['name' => 'Sophie M.', 'plan' => 'Essai',  'expires_at' => '8 avril',  'urgent' => false],
                ['name' => 'Claire B.', 'plan' => '6 mois', 'expires_at' => '24 sept.', 'urgent' => false],
                ['name' => 'Anne L.',   'plan' => '1 mois', 'expires_at' => '29 mars',  'urgent' => true],
            ]),
        ]);
    }

    /* ─── Notifications ─── */
    public function notifications()
    {
        return Inertia::render('Admin/Notifications', [
            'alerts' => [
                [
                    'id'      => 1,
                    'color'   => 'red',
                    'icon'    => '⏰',
                    'title'   => '47 essais expirent dans 48h',
                    'desc'    => 'Envoyer campagne de relance avec promo -10%',
                    'action'  => 'Envoyer maintenant',
                    'primary' => true,
                ],
                [
                    'id'      => 2,
                    'color'   => 'amber',
                    'icon'    => '💳',
                    'title'   => '6 paiements échoués',
                    'desc'    => 'Relance automatique dans 24h · Mode dégradé activé',
                    'action'  => 'Relancer',
                    'primary' => false,
                ],
                [
                    'id'      => 3,
                    'color'   => 'blue',
                    'icon'    => '📊',
                    'title'   => 'Rapport hebdo non envoyé',
                    'desc'    => 'Semaine 17–23 mars 2026 · En attente validation',
                    'action'  => 'Valider & Envoyer',
                    'primary' => false,
                ],
            ],
            'campaigns' => [
                ['name' => 'Bienvenue Sophie',       'type' => 'Email', 'recipients' => 1,     'open_rate' => null, 'conv_rate' => null, 'date' => '24 mars 9:41', 'status' => 'Envoyé'],
                ['name' => 'Relance essai Mars',     'type' => 'Email', 'recipients' => 312,   'open_rate' => '68%','conv_rate' => '14%','date' => '23 mars',       'status' => 'Terminé'],
                ['name' => 'Push séance du jour',    'type' => 'Push',  'recipients' => 8247,  'open_rate' => '42%','conv_rate' => null, 'date' => '24 mars 9h',   'status' => 'Envoyé'],
                ['name' => 'Promo -10% 3 mois',      'type' => 'Email', 'recipients' => 156,   'open_rate' => '71%','conv_rate' => '22%','date' => '20 mars',       'status' => 'Terminé'],
                ['name' => 'Relance expirations 48h','type' => 'Email', 'recipients' => 47,    'open_rate' => null, 'conv_rate' => null, 'date' => 'En attente',    'status' => 'En attente'],
            ],
        ]);
    }

    /* ─── Audio Files ─── */
    public function audioFiles()
    {
        $files    = AudioFile::with('program')->orderBy('program_id')->orderBy('id')->get();
        $programs = Program::select('id', 'title', 'title_fr', 'emoji')->orderBy('sort_order')->get();

        $totalSize  = $files->sum('file_size');
        $totalPlays = $files->sum('play_count');

        return Inertia::render('Admin/AudioFiles', [
            'audioFiles'  => $files->map(fn($f) => [
                'id'                 => $f->id,
                'title'              => $f->title,
                'filename'           => $f->filename,
                'file_path'          => $f->file_path,
                'file_size'          => $f->file_size,
                'file_size_formatted'=> $f->file_size_formatted,
                'duration'           => $f->duration,
                'duration_formatted' => $f->duration_formatted,
                'program_id'         => $f->program_id,
                'program'            => $f->program ? [
                    'id'    => $f->program->id,
                    'title' => $f->program->title_fr ?: $f->program->title,
                    'emoji' => $f->program->emoji,
                ] : null,
                'is_active'  => $f->is_active,
                'play_count' => $f->play_count,
            ]),
            'programs'    => $programs,
            'stats'       => [
                'total_files'  => $files->count(),
                'total_size'   => $totalSize,
                'total_plays'  => $totalPlays,
            ],
        ]);
    }

    public function storeAudioFile(Request $request)
    {
        $request->validate([
            'audio' => 'required|file|mimes:mp3,wav,m4a,aac|max:102400',
            'title' => 'required|string|max:255',
        ]);

        $file = $request->file('audio');
        $path = $file->store('audio', 'public');

        AudioFile::create([
            'title'      => $request->title,
            'filename'   => $file->getClientOriginalName(),
            'file_path'  => $path,
            'file_size'  => $file->getSize(),
            'duration'   => $request->duration ?? 0,
            'program_id' => $request->program_id ?: null,
            'is_active'  => true,
        ]);

        return back()->with('success', 'Fichier audio uploadé.');
    }

    public function updateAudioFile(Request $request, AudioFile $audioFile)
    {
        $audioFile->update($request->only(['title', 'program_id', 'is_active']));
        return back()->with('success', 'Fichier mis à jour.');
    }

    public function destroyAudioFile(AudioFile $audioFile)
    {
        \Storage::disk('public')->delete($audioFile->file_path);
        $audioFile->delete();
        return back()->with('success', 'Fichier supprimé.');
    }

    /* ─── Symptom Stats ─── */
    public function symptomStats()
    {
        $totalUsers         = User::count();
        $completedProtocols = Order::where('status', 'completed')->count();

        return Inertia::render('Admin/SymptomStats', [
            'stats' => [
                'totalUsers'         => $totalUsers ?: 8247,
                'completedProtocols' => $completedProtocols ?: 2847,
            ],
        ]);
    }

    /* ─── Admins ─── */
    public function admins()
    {
        $admins = [
            ['id' => 1, 'name' => 'Éric Durand',     'email' => 'eric@fiftycare.fr',    'role' => 'Super Admin',  'access' => 'Accès total',                    'last_login' => "Aujourd'hui 9:41"],
            ['id' => 2, 'name' => 'Franck Rosati',   'email' => 'franck@fiftycare.fr',  'role' => 'Partenariats', 'access' => 'Stats · Revenus · Utilisateurs', 'last_login' => '23 mars'],
            ['id' => 3, 'name' => 'Content Manager', 'email' => 'content@fiftycare.fr', 'role' => 'Contenu',      'access' => 'Textes · Protocoles · Audio',    'last_login' => '22 mars'],
        ];

        return Inertia::render('Admin/Admins', ['admins' => $admins]);
    }

    /* ─── Pricing ─── */
    public function pricing()
    {
        $keys = [
            'freemium_days', 'freemium_protocols', 'freemium_active', 'require_card',
            'plan1_price', 'plan1_label', 'plan1_subtitle', 'plan1_tag', 'plan1_active',
            'plan3_price', 'plan3_monthly', 'plan3_tag', 'plan3_subtitle', 'plan3_badge', 'plan3_featured', 'plan3_active',
            'plan6_price', 'plan6_monthly', 'plan6_tag', 'plan6_bonus', 'plan6_subtitle', 'plan6_active',
        ];
        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = Setting::get($key);
        }
        return Inertia::render('Admin/Pricing', ['settings' => $settings]);
    }

    /* ─── Settings ─── */
    public function settings()
    {
        $keys = [
            'app_name', 'support_email', 'app_version', 'app_url',
            'push_enabled', 'transactional_emails', 'session_reminders', 'freemium_emails',
            'stripe_live', 'revenuecat_enabled', 'supabase_enabled', 'mixpanel_enabled', 'cloudfront_enabled',
            'aes256_enabled', 'hds_enabled', 'consent_banner', 'dpo_email',
        ];
        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = Setting::get($key);
        }
        return Inertia::render('Admin/Settings', ['settings' => $settings]);
    }

    public function updateSettings(Request $request)
    {
        foreach ($request->settings as $key => $value) {
            Setting::set($key, $value);
        }
        return back()->with('success', 'Paramètres enregistrés.');
    }
}
