<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use World\Countries\Seeds\WorldCountriesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(WorldCountriesTableSeeder::class);
        $this->call(IndustryTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(LeadTypeTableSeeder::class);
        User::factory()->create();
        Company::factory()->create();
        Campaign::factory()->create();
//        SaleFunnel::factory()->create();
//        Lead::factory()->create();
        $this->call(StagesTableSeeder::class);
        $this->call(ToolTableSeeder::class);
//        $this->call(LeadTableSeeder::class);
    }
}
