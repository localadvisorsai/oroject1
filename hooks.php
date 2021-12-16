<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Webhook Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Webhooks routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "hook" middleware group. Enjoy building your Webhooks!
|
*/

// ********************************************
// *********** RESTRICTED ACCESS **************
// ********************************************


//  Adobe Doument Signature Hooks

Route::middleware('hook.adobe')->group(function () {
    Route::post('adobe/agreement/signing/start', 'DocumentController@startSigning');
});

// Facebook Leads Hooks

Route::middleware('hook.facebook')->group(function () {
    Route::match(['get', 'post'], 'facebook/lead/create', 'LeadController@facebookCreateLead');
    //Route::post('facebook/lead/test', 'LeadController@test');
});


// Forte Hooks

Route::middleware('hook.forte')->group(function () {
    //Route::post('forte/payment_update', 'PaymentController@updatePayment');
    //
});

// Facebook Messenger Hooks

Route::middleware('hook.messenger')->group(function () {
    //
});

// Nylas Hooks

Route::middleware('hook.nylas')->group(function () {
    //
});

// Twilio Hooks

Route::middleware('hook.twilio')->group(function () {
    Route::post('interaction/call/received', 'ConversationController@call');
    Route::post('interaction/sms/received', 'ConversationController@sms');
});

// Twitter Hooks

Route::middleware('hook.twitter')->group(function () {
});

// Stripe Hooks

Route::middleware('hook.stripe')->group(function () {
    //
    Route::match(['get', 'post'], 'checkout/status', 'CheckoutController@status');
});
