<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Lead;
use App\Models\LeadType;
use App\Models\SaleFunnel;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Webpatser\Uuid\Uuid;
use World\Countries\Model\Country;

class LeadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lead::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'sale_funnel_id' => SaleFunnel::query()->first()->id,
            'company_id' => Company::query()->oldest()->first()->id,
            'country_id' => Country::query()->inRandomOrder()->first()->id,
            'lead_type_id' => LeadType::query()->first()->id,
            'name' => 'Test Lead',
            'email' => 'dev.techguy@gmail.com',
            'phone_number' => '0713255791',
            'location' => $this->faker->city,
            'professional' => $this->faker->title
        ];
    }
}
