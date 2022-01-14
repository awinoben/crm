<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\Company;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Campaign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::query()->oldest()->first()->id,
            'name' => config('app.name') . ' Campaign',
            'description' => $this->faker->realText(300),
            'url' => url('/')
        ];
    }
}
