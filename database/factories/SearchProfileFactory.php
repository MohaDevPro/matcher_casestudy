<?php
namespace Database\Factories;

use App\Models\PropertyType;
use Illuminate\Database\Eloquent\Factories\Factory;

class SearchProfileFactory extends Factory
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
                $this->arrayOption(
                    $this->faker->randomFloat(2, 10, 2000000),
                    $this->faker->randomFloat(2, 10, 2000000)
                ),
            ]),

            "yearOfConstruction" => $this->faker->randomElement([
                $this->faker->date("Y"),
                $this->arrayOption(
                    $this->faker->date("Y"),
                    $this->faker->date("Y"),
                    null
                ),
            ]),

            "rooms" => $this->faker->randomElement([
                $this->faker->numberBetween(1, 20),
                $this->arrayOption(
                    $this->faker->numberBetween(1, 20),
                    $this->faker->numberBetween(1, 20)
                ),
                null,
            ]),

            "heatingType" => $this->faker->randomElement([
                $this->faker->randomElement(["gas2", "gas1"]),
                null,
            ]),

            "parking" => $this->faker->randomElement([
                $this->faker->boolean(),
                null,
            ]),

            "returnActual" => $this->faker->randomElement([
                $this->faker->numberBetween(10, 2000000),
                $this->arrayOption(
                    $this->faker->randomFloat(1, 10, 2000000),
                    $this->faker->randomFloat(1, 10, 2000000)
                ),
                null,
            ]),

            "price" => $this->faker->randomElement([
                $this->faker->randomFloat(0, 10, 2000000),
                $this->arrayOption(
                    $this->faker->numberBetween(10, 2000000),
                    $this->faker->numberBetween(10, 2000000)
                ),
                null,
            ]),

            "x1" => $this->faker->randomElement([
                $this->faker->randomFloat(2, 10, 2000000),
                null,
            ]),
            "x2" => $this->faker->randomElement([
                $this->faker->randomFloat(2, 10, 2000000),
                null,
            ]),
            "x3" => $this->faker->randomElement([
                $this->faker->randomFloat(2, 10, 2000000),
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
            "name" =>
                "Looking for any Awesome realestate! " . count($properties),
            "searchFields" => $properties,
        ];
    }

    public function arrayOption($val1, $val2)
    {
        return [
            $this->faker->randomElement([strval($val1), null]),
            $this->faker->randomElement([strval($val2), null]),
        ];
    }
}
