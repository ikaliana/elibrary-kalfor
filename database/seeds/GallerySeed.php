<?php

use Illuminate\Database\Seeder;
use App\Models\Gallery;
use App\Models\Document;

class GallerySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$galleries = factory(Gallery::class, 50)->create();

        factory(Gallery::class, 15)->create()->each(function($c) {
            $c->documents()->saveMany(
                factory(Document::class, 3)->make(['gallery_id' => NULL])
            );
        });
    }
}
