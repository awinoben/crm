<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\SaleFunnel;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFunnelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SaleFunnel::class;

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
            'name' => 'Website Hook',
            'url' => config('app.url')
        ];
    }
}
