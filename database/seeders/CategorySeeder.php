<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Locomotor',        'name_fr' => 'Locomoteur',          'slug' => 'locomotor',   'emoji' => '🦴', 'color' => '#22d3ee', 'sort_order' => 1],
            ['name' => 'Digestive',        'name_fr' => 'Digestif',            'slug' => 'digestive',   'emoji' => '🫁', 'color' => '#a78bfa', 'sort_order' => 2],
            ['name' => 'Emotional',        'name_fr' => 'Émotionnel',          'slug' => 'emotional',   'emoji' => '💚', 'color' => '#4ade80', 'sort_order' => 3],
            ['name' => 'ENT & Immunity',   'name_fr' => 'ORL & Immunité',      'slug' => 'ent-immunity','emoji' => '👂', 'color' => '#fb923c', 'sort_order' => 4],
            ['name' => 'Hormonal',         'name_fr' => 'Hormonal',            'slug' => 'hormonal',    'emoji' => '⚡', 'color' => '#f59e0b', 'sort_order' => 5],
            ['name' => 'Neurological',     'name_fr' => 'Neurologique',        'slug' => 'neurological','emoji' => '🧠', 'color' => '#e879f9', 'sort_order' => 6],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], array_merge($cat, ['is_active' => true]));
        }
    }
}
