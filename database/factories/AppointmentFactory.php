<?php

use Faker\Generator as Faker;
use Carbon\Carbon;
use App\User;

$factory->define(App\Appointment::class, function (Faker $faker) {
    $id = rand(1, 10);
    $direktorid = User::where('id', $id)->get()->pluck('direktor');
    return [
        'salutation' => $faker->randomElement(['Herr', 'Frau']),
        'first_name' => $faker->firstName,
        'lat' => 1,
        'lng' => 1,
        'post_code' => $faker->numberBetween(1000, 9999),
        'canton' => $faker->randomElement(['Aargau', 'Appenzell Ausserrhoden', 'Appenzell Innerrhoden', 'Basel-Stadt', 'Basel-Landschaft', 'Bern', 'Fribourg', 'Geneva', 'Glarus', 'Graubünden', 'Jura', 'Lucerne', 'Neuchâtel', 'Nidwalden', 'Obwalden', 'Schaffhausen', 'Schwyz', 'Solothurn', 'St. Gallen', 'Thurgau', 'Ticino', 'Uri', 'Valais', 'Vaud', 'Zug', 'Zürich']),
        'time' => $faker->time('H:i'),
        'last_name' => $faker->lastName,
        'street' => $faker->streetAddress,
        'language' => $faker->randomElement(['DE', 'FR', 'IT', 'AL', 'ESP', 'SRB', 'TR', 'Other']),
        'krankenkassen' => 'CSS',
        'members_count' => 0,
        'mobile_number' => $faker->tollFreePhoneNumber,
        'phone_number' => $faker->tollFreePhoneNumber,
        'house_number' => $faker->numberBetween(1000, 9999),
        'user_id' => $id,
        'assigned_to' => $id,
        'appointment_direktor' => $direktorid[0],
        'date' => $faker->dateTimeBetween('+0 days', '+2 years')->format('Y-m-d'),
        'date_for_search' => $faker->dateTimeBetween('+0 days', '+2 years')->format('d/m/Y'),
        'created_at_filter' => $faker->dateTimeBetween('+0 days', '+2 years')->format('Y-m-d'),
    ];
});
