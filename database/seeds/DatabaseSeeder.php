<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        factory(\App\Video::class, 60)->create()->each(function($video){
            $video->tags()->save(factory(\App\Tag::class)->make());
        });

        Model::reguard();
    }
}
