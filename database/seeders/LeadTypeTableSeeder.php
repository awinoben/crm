<?php

namespace Database\Seeders;

use App\Models\LeadType;
use Exception;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class LeadTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $leadTypes = array('Company', 'Individual');
        foreach ($leadTypes as $leadType) {
            LeadType::query()->create([
                'id' => Uuid::generate()->string,
                'name' => $leadType,
            ]);
        }
    }
}
