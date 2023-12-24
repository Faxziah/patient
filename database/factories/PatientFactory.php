<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $arFields = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'birthday' => $this->faker->dateTimeBetween('-99 years')->format('Y-m-d'),
        ];

        $patient = new Patient($arFields);
        $patient->setAdditionalAgeData();

        $arFields['age'] = $patient->age;
        $arFields['age_type'] = $patient->age_type;

        return $arFields;
    }
}
