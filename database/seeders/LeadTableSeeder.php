<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Company;
use App\Models\Lead;
use App\Models\LeadType;
use App\Models\SaleFunnel;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;
use World\Countries\Model\Country;

class LeadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($x = 0; $x <= 20; $x++) {
            Lead::query()->create([
                'sale_funnel_id' => SaleFunnel::query()->first()->id,
                'company_id' => Company::query()->oldest()->first()->id,
                'country_id' => Country::query()->inRandomOrder()->first()->id,
                'lead_type_id' => LeadType::query()->first()->id,
                'name' => Factory::create()->company,
                'email' => Factory::create()->unique()->email,
                'phone_number' => Factory::create()->unique()->phoneNumber,
                'location' => Factory::create()->city,
                'professional' => Factory::create()->jobTitle,
                'is_lead' => Factory::create()->boolean,
                'is_contact' => Factory::create()->boolean,
                'is_customer' => Factory::create()->boolean
            ]);
        }
    }
}
