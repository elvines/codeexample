<?php
use Faker\Generator as Faker;

$factory->define(App\Models\Customer\Customer::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->email,
        'name' => $faker->name,
        'subscriptions' => $faker->randomDigit,
        'active' => $faker->boolean
    ];
});

$factory->defineAs(App\Models\Customer\Customer::class, 'without_subscriptions', function ($faker) use ($factory) {
    $customer = $factory->raw(App\Models\Customer\Customer::class);

    return array_merge($customer, ['subscriptions' => null]);
});