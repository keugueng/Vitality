<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Program;
use App\Models\Testimonial;
use App\Models\BlogPost;
use Inertia\Inertia;

class PageController extends Controller
{
    public function home()
    {
        $featuredPrograms = Program::with('category')
            ->where('is_featured', true)->where('is_active', true)
            ->orderBy('sort_order')->take(4)->get();

        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->get();

        return Inertia::render('Home', compact('featuredPrograms', 'categories', 'testimonials'));
    }

    public function about()
    {
        return Inertia::render('About');
    }

    public function consultation()
    {
        return Inertia::render('Consultation');
    }

    public function blog()
    {
        $posts = BlogPost::where('is_published', true)
            ->latest('published_at')->paginate(9);
        return Inertia::render('Blog', ['posts' => $posts]);
    }

    public function blogShow(BlogPost $post)
    {
        if (!$post->is_published) abort(404);
        return Inertia::render('BlogShow', ['post' => $post]);
    }

    public function legalNotice()
    {
        return Inertia::render('LegalNotice');
    }

    public function myProgram()
    {
        return Inertia::render('MyProgram');
    }
}
