<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Customer;
use \App\Models\Item;
use \App\Models\Purchase;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ItemSeeder::class,
        ]);

        Customer::factory(1000)->create();

        $items = Item::all();
        Purchase::factory(100)
            ->create()
            ->each(
                function (Purchase $purchase) use ($items) {
                    $items->random(rand(1,3))->each(
                        function (Item $item) use ($purchase) {
                            $purchase->items()->attach(
                                [ $item->id ],
                                [ 'quantity' => rand(1,5)]
                            );
                        }
                    );
                }
            );

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
