<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attribute;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Attribute::factory(10)->create(); //if with factory
        Attribute::create([
            'name' => 'start_date',
            'type' => 'date'
        ]);
        Attribute::create([
            'name' => 'end_date',
            'type' => 'date'
        ]);
         Attribute::create([
            'name' => 'department',
            'type' => 'text'
        ]);
        Attribute::create([
            'name' => 'members',
            'type' => 'number'
        ]);
        Attribute::create([
            'name' => 'budget',
            'type' => 'number'
        ]);
        Attribute::create([
            'name' => 'manager_name',
            'type' => 'text'
        ]);
    }
}
