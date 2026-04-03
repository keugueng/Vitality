<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Program;
use App\Models\Testimonial;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Program::with('category')->where('is_active', true);

        if ($request->category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('title_fr', 'like', "%{$request->search}%")
                  ->orWhere('short_desc', 'like', "%{$request->search}%");
            });
        }

        $programs    = $query->orderBy('sort_order')->get();
        $categories  = Category::where('is_active', true)->orderBy('sort_order')->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->get();

        return Inertia::render('Shop', compact('programs', 'categories', 'testimonials'));
    }

    public function show(Program $program)
    {
        if (!$program->is_active) abort(404);
        $program->load('category');
        $related = Program::where('category_id', $program->category_id)
            ->where('id', '!=', $program->id)
            ->where('is_active', true)->take(3)->get();

        return Inertia::render('ProgramDetail', compact('program', 'related'));
    }
}
