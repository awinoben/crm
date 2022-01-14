<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Industry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use World\Countries\Model\Country;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'industry_id' => Industry::query()->firstWhere('name', 'Sales Industry')->id,
            'country_id' => Country::query()->firstWhere('slug', 'kenya')->id,
            'user_id' => User::query()->first()->id,
            'name' => config('app.name'),
            'email' => 'accounts@blueprintsalesafrica.com',
            'phone_number' => '0751211512',
        ];
    }
}
