<?php

namespace Database\Seeders;

use App\Models\Artigo;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Categoria::factory(3)->create();
        Artigo::factory(5)->create();
    }
}
