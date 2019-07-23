<?php

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
        $this->call(UsersTableSeeder::class);
    //    factory(\App\Models\Category::class, 10)->create()->each(function ($user) {
    //        $user->products()->save(factory(\App\Models\Product::class)->make());
    //    });
    }
}
