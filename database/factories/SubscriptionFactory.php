<?php

use Faker\Generator as Faker;
use App\Models\Customer\Subscription\Subscription;

$factory->defineAs(Subscription::class, "active", function (Faker $faker) {
    return [
        'start_date' => $faker->dateTimeBetween("-1 years", "now"),
        'nextorder_date' => $faker->dateTimeBetween("-1 years", "+1 years"),
        'active' => 1,
        'day_iteration' => $faker->numberBetween(10, 90),
    ];
});

$factory->defineAs(Subscription::class, "non_active", function (Faker $faker) {
    return [
        'start_date' => $faker->dateTimeBetween("-1 years", "now"),
        'nextorder_date' => $faker->dateTimeBetween("-1 years", "+1 years"),
        'active' => 0,
        'day_iteration' => $faker->numberBetween(10, 90),
    ];
});