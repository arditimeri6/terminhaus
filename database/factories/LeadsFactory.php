<?php

use Faker\Generator as Faker;
use Carbon\Carbon;
use App\User;

$factory->define(App\Lead::class, function (Faker $faker) {
    $id = rand(1, 10);
    $direktorid = User::where('id', $id)->get()->pluck('direktor');
    return [
        'kunden_type' => $faker->randomElement(['Privatgelände', 'Unternehmen']),
        'salutation' => $faker->randomElement(['Herr', 'Frau']),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'year' => $faker->year,
        'mobile_number' => $faker->tollFreePhoneNumber,
        'house_number' => $faker->numberBetween(1000, 9999),
        'street' => $faker->streetAddress,
        'post_code' => $faker->numberBetween(1000, 9999),
        'place' => $faker->city,
        'canton' => $faker->randomElement(['Aargau', 'Appenzell Ausserrhoden', 'Appenzell Innerrhoden', 'Basel-Stadt', 'Basel-Landschaft', 'Bern', 'Fribourg', 'Geneva', 'Glarus', 'Graubünden', 'Jura', 'Lucerne', 'Neuchâtel', 'Nidwalden', 'Obwalden', 'Schaffhausen', 'Schwyz', 'Solothurn', 'St. Gallen', 'Thurgau', 'Ticino', 'Uri', 'Valais', 'Vaud', 'Zug', 'Zürich']),
        'company_name' => $faker->company,
        'comment' => $faker->sentence(10),
        'autoversicherung' => $faker->randomElement(['Keine', 'Alliany', 'AXA', 'Basler', 'Click2drive', 'Dextra', 'Mobiliar', 'ELVIA', 'Generali', 'Helvetia', 'Smile', 'Sympany', 'TCS', 'PostFinance', 'Vaudoise', 'Zurich']),
        'hausrat_privathaftpflicht' => $faker->randomElement(['Keine', 'Allianz', 'AXA', 'CSS', 'ELVIA', 'Generali', 'Helvetia', 'Smile', 'Visana', 'Zurich']),
        'lebensversicherung' => $faker->randomElement(['Andere', 'Allianz', 'AXA', 'Generali', 'Groupe Mutuel', 'Helvetia', 'Liechtenstein', 'Skandia', 'Swiss Life', 'PAX']),
        'rechtsschutzversicherung' => $faker->randomElement(['Andere', 'AXA', 'Basler', 'CAP', 'CSS', 'Coop', 'DAS', 'Dextra', 'Fortuna', 'Groupe Mutuel', 'National Siusse', 'Justis', 'TCS', 'Orion', 'Protekta']),
        'krankenversicherung' => 'CSS',
        'vertrag_seit_wann' => $faker->sentence(4),
        'letzte_optimierung' => $faker->sentence(4),
        'anzahl_personen' => $faker->sentence(4),
        'anruf_erwünscht' => $faker->time('H:i'),
        'ereichbar' => $faker->randomElement(['Vormittag', 'Nachmittag', 'Abend']),
        'user_id' => $id,
        'assigned_to' => $id,
        'leads_direktor' => $direktorid[0],
        'created_at_filter' => $faker->dateTimeBetween('+0 days', '+2 years')->format('Y-m-d'),
    ];
});
