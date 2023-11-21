<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Servers',
            ],
            [
                'name' => 'Laptops',
            ],
        ];

        $suppliers = [
            [
                'name' => 'itGateway',
                'email' => 'admin@itgatewaymm.com',
                'phone' => '0934234244',
                'address' => 'ThuWaNa',
            ],
            [
                'name' => 'greenIT',
                'email' => 'admin@greenitmm.com',
                'phone' => '0934234244',
                'address' => 'Kamaryut',
            ],
        ];

        Category::insert($categories);
        Supplier::insert($suppliers);
    }
}
