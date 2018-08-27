<?php

use Faker\Generator as Faker;
use App\Models\Customer\Order\Order;

$factory->defineAs(Order::class, Order::STATUS_CREATED, function (Faker $faker) {
    return [
        'status' => Order::STATUS_CREATED,
        'paid_date' => $faker->dateTimeBetween('-2 years', 'now'),
        'total' => $faker->numberBetween(10, 300),
    ];
});

$factory->defineAs(Order::class, Order::STATUS_PAID, function (Faker $faker) {
    return [
        'status' => Order::STATUS_PAID,
        'paid_date' => $faker->dateTimeBetween('-2 years', 'now'),
        'total' => $faker->numberBetween(10, 300),
    ];
});

$factory->defineAs(Order::class, Order::STATUS_FAILED, function (Faker $faker) {
    return [
        'status' => Order::STATUS_FAILED,
        'paid_date' => $faker->dateTimeBetween('-2 years', 'now'),
        'total' => $faker->numberBetween(10, 300),
    ];
});
