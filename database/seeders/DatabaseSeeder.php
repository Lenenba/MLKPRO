<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use App\Models\Work;
use App\Models\WorkerRating;
use App\Models\ProductWork;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users
        $users = User::factory(10)->create();

        // Create product categories
        $categories = ProductCategory::factory(9)->create();

        // Create products and associate with categories and users
        Product::factory(20)
            ->recycle($categories)
            ->recycle($users)
            ->create();

        // Create customers and associate with users
        Customer::factory(10)
            ->recycle($users)
            ->create();

        // Create works and associate with users and customers
        $works = Work::factory(15)
            ->recycle($users)
            ->recycle(Customer::all())
            ->create();

        // Create product usage for works
        ProductWork::factory(30)
            ->recycle($works)
            ->recycle(Product::all())
            ->create();

        // Create worker ratings for works
        WorkerRating::factory(10)
            ->recycle($works)
            ->recycle($users)
            ->create();
    }
}
