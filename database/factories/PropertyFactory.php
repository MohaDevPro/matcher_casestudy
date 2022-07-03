<?php

namespace Database\Factories;

use App\Models\PropertyType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $field_names = [
            "area" => $this->faker->randomElement([
                $this->faker->numberBetween(10, 1000),
                null,
            ]),
            "yearOfConstruction" => $this->faker->randomElement([
                $this->faker->date("Y"),
                null,
            ]),
            "rooms" => $this->faker->randomElement([
                $this->faker->numberBetween(1, 20),
                null,
            ]),
            "heatingType" => $this->faker->randomElement([
                "gas1",
                "gas2",
                null,
            ]),
            "parking" => $this->faker->randomElement([
                $this->faker->boolean(),
                null,
            ]),
            "returnActual" => $this->faker->randomElement([
                $this->faker->randomFloat(1, 10, 300),
                null,
            ]),
            "price" => $this->faker->randomElement([
                $this->faker->numberBetween(2, 10, 2000000),
                null,
            ]),
        ];

        $properties = [];
        for (
            $i = 0;
            $i < $this->faker->numberBetween(1, count($field_names));
            $i++
        ) {
            $random_choice = $this->faker->randomElement(
                array_keys($field_names)
            );
            $properties[$random_choice] = $field_names[$random_choice];
        }

        return [
            // 'property_type_id'=> PropertyType::all()->random()->id,
            "property_type_id" => $this->faker->randomElement(
                PropertyType::all()->pluck("id")
            ),
            "name" => $this->faker->name(),
            "address" => $this->faker->address(),
            "fields" => $properties,
        ];
    }
}
