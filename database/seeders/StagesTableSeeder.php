<?php

namespace Database\Seeders;

use App\Models\Stage;
use Illuminate\Database\Seeder;

class StagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stages = array(
            'Prospect',
            'Qualification/Need Analysis',
            'Presentation',
            'Proposal/Budget',
            'Negotiation/Payment',
            'Closed'
        );

        $count = 1;

        foreach ($stages as $stage) {
            Stage::query()->create([
                'name' => $stage,
                'level' => $count++
            ]);
        }
    }
}
