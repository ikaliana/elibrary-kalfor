<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->insert([
            ['name' => 'Other'],
            ['name' => 'Publication'],
            ['name' => 'Raster'],
            ['name' => 'Vector'],
            ['name' => 'Module'],
        ]);
    }
}
