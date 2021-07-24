<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ORM: Elequent Model
        Category::create([
            'name' => 'Model Category',
            'slug' => 'model-category',
            'status' => 'active'
        ]);


        // Query Builder
        // DB::connection('mysql')->table('categories')->insert([...]);
        // connection('mysql') => is default => عادي لو ما كتبتها
        DB::connection('mysql')->table('categories')->insert([
            'name' => 'My First Category',
            'slug' => 'my-first-category',
            'status' => 'active'
        ]);
        
        // مثلا ما بدي أكتب ميثود الكونيكشن هان
        DB::table('categories')->insert([
            'name' => 'Sub Category',
            'slug' => 'sub-category',
            'parent_id' => 1,
            'status' => 'active'
        ]);


        // SQL Commands
        DB::statement("INSERT INTO categories (name, slug, status)
        VALUES ('My First Category', 'my-first-category', 'active')");
    }
}
