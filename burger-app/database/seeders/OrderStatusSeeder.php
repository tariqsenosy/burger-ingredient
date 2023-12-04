<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderStatus;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::create(['name' => 'new']);
        OrderStatus::create(['name' => 'received']);
        OrderStatus::create(['name' => 'canceled']);
        OrderStatus::create(['name' => 'refunded']);
    }
}
