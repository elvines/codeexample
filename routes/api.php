<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('customer/collection/withPaidOrder', 'Api\Customer\CustomerController@getCollectionWithPaidOrder')
    ->name("api.customer.collection.withPaidOrder");

Route::get('customer/collection/withActiveSubscriptionAndPaidOrder', 'Api\Customer\CustomerController@getCollectionWithActiveSubscriptionAndPaidOrder')
    ->name("api.customer.collection.withActiveSubscriptionAndPaidOrder");


Route::post('customer/order/store/basedOnSubscription', 'Api\Customer\OrderController@storeBasedOnSubscriptionDate')
    ->name("api.customer.order.store.basedOnSubscription");

Route::get('customer/{id}/order/get/lastPaidOrder', 'Api\Customer\OrderController@getLastPaidOrder')
    ->name("api.customer.order.get.lastPaidOrder");

Route::post('customer/subscription/update/nextOrderDate', 'Api\Customer\SubscriptionController@updateNextOrderDate')
    ->name("api.customer.subscription.update.nextOrderDate");

Route::post('customer/subscription/update/dayIteration', 'Api\Customer\SubscriptionController@updateDayIteration')
    ->name("api.customer.subscription.update.dayIteration");

