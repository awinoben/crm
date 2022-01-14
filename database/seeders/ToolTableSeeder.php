<?php

namespace Database\Seeders;

use App\Models\Tool;
use Illuminate\Database\Seeder;

class ToolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tools = array(
            'SMS',
            'EMAIL',
            'FACEBOOK',
            'TWITTER',
            'YOUTUBE',
            'INSTAGRAM'
        );

        foreach ($tools as $tool) {
            Tool::query()->create([
                'name' => $tool
            ]);
        }
    }
}
