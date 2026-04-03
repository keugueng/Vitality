<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        return Inertia::render('Admin/Orders', [
            'orders' => Order::with('items','user')->latest()->paginate(20),
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

    /* ─── Blog ─── */
    public function blogPosts()
    {
        return Inertia::render('Admin/BlogPosts', [
            'posts' => BlogPost::with('author')->latest()->paginate(20),
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
        return Inertia::render('Admin/Users', [
            'users' => User::with('roles')->latest()->paginate(20),
        ]);
    }

    /* ─── Settings ─── */
    public function settings()
    {
        return Inertia::render('Admin/Settings', [
            'settings' => Setting::all()->keyBy('key'),
        ]);
    }

    public function updateSettings(Request $request)
    {
        foreach ($request->settings as $key => $value) {
            Setting::set($key, $value);
        }
        return back()->with('success', 'Paramètres enregistrés.');
    }
}
