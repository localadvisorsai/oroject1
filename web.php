<?php

/////////////////////////////////////////////
/////////////// PUBLIC ACCESS ///////////////
/////////////////////////////////////////////

Route::get('/', function () {
  return redirect()->route('login');
});

//    // STRIPE ROUTES
Route::get('checkout/test', 'CheckoutController@test');
//    Route::get('checkout/success', 'CheckoutController@success');
//    Route::get('checkout/canceled', 'CheckoutController@cancel');
//    Route::get('subscription/createUser', 'SubscriptionController@createUsers');
//    Route::get('subscription/create/{planId}/{productId}/{quantity?}', 'SubscrriptionController@create');
//    Route::get('subscription/createMultipleSubscription/{c}/{productId}/{quantity?}', 'SubscrriptionController@createMultipleSubscription');
//    Route::get('subscription/cancel/{planId}/{productId}', 'SubscrriptionController@cancel');
//    Route::get('subscription/resume/{planId}/{productId}', 'SubscrriptionController@resume');
//    Route::get('subscription/swap/{existingPlanId}/{newPlanId}/{productId}', 'SubscrriptionController@swap');
//    Route::get('subscription/{productId}', 'PaymentController@show');

// DIALER ROUTES
Route::get('voice', 'Com\ClientController@voiceResponse');

//LEAD LANDING PAGES
Route::post('lead/creation/success', 'LeadController@landingPageUpdate');
Route::post('lead/update/additional-info', 'LeadController@landingPageStore');
Route::get('lead/create/{type}/{source_id}', 'LeadController@landingPageCreate')->where('type', 'buyer|seller');

Route::post('subscriptions/dm/authorize', 'SubscriptionController@dmAuthorize');
Route::get('subscriptions/dm/authorize', 'SubscriptionController@dmAuthorize');
Route::get('subscriptions/{module}', 'SubscriptionController@call')->where('module', 'pm|crm|dm');

//ADOBE PUBLIC ROUTES
Route::get('adobe/document/access/{uuid}', 'DocumentController@feedDocumentStream');
Route::get('adobe/signing/success/{signing_id}', 'DocumentController@status');
Route::get('adobe/token/access', 'DocumentController@setAccessToken');

Auth::routes(['verify' => true]);
Route::get('account/setup', 'EnterpriseController@create')->middleware('verified');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('user/verifymobile/{mobile}', 'UserController@verifymobile');

//Twilio routes
Route::post('token', ['uses' => 'Com\TokenController@generate', 'as' => 'token-generate']);
Route::get('token/{uuid}', 'Com\ClientController@generateToken');


//////////////////////////////////////////////
/////////////// PRIVATE ACCESS ///////////////
//////////////////////////////////////////////

Route::middleware('auth')->group(function () {

  // ROUTES
  //Route::get('choose/{type}', 'PageController@choice')->where('type', 'contacts|email|imports|inventory|listing|routing');

  // PHONE VERIFICATION ROUTES
  Route::view('phone/verify', 'phone-verification');
  Route::post('phone/verify/check', 'Com\VerifyController@verifyPhone')->name('verify-phone');
  Route::post('phone/verify/code', 'Com\VerifyController@verifyCode')->name('verify-code');

  // SUBSCRIPTION ROUTES

  Route::get('subscription/expire', 'SubscriptionController@expire');

  Route::get('documents/compliance_review', 'DocumentController@complianceReview');

  Route::get('listing/{type}', 'ListingController@call')->where('type', 'rentals|select');

  Route::get('template/{type}', 'TemplateController@call')->where('type', 'champions');
  Route::get('template/variants/{uuid}', 'TemplateController@variants');

  // Contacts
  Route::get('contacts/load', 'ContactController@load');
  Route::post('contacts/{uuid}', 'ContactController@update');

  //Leads
  Route::get('lead/claim/{id}', 'LeadController@claimLead');

  //Opportunity
  Route::post('opportunity/{uuid}', 'OpportunityController@update');

  //Template
  Route::get('templates/create', 'TemplateController@create');
  Route::post('templates/store', 'TemplateController@store');
  Route::get('templates/edit/{uuid}', 'TemplateController@edit');
  Route::post('templates/update/{uuid}', 'TemplateController@update');

  // Payment
  //Route::get('payment/viewcards', 'WalletController@viewcards');

  // Kanban

  // Funnel
  Route::get('flow/funnel/{uuid}', 'FlowController@funnel');
  Route::get('flow/kanban', 'FlowController@kanban');

  ///////////////////////////////////////////////////////////
  ///////// DOCUMENT MANAGEMENT SUBSCRIPTION ACCESS /////////
  ///////////////////////////////////////////////////////////

  Route::middleware('subscription:dm', 'tokenrefresh:dm')->group(function () {

    Route::get('document/data', 'DocumentController@autoFill');

    Route::post('documents/builder/{instance}', 'DocumentController@builder');
    Route::get('documents/create/{instance}', 'DocumentController@create');
    Route::get('documents/create/{uuid}/{type}', 'DocumentController@create')->where('type', 'listing|property');
    Route::post('documents/fill/{instance}', 'DocumentController@fill');
    Route::post('documents/participants/manual/{instance}', 'DocumentController@manualParticipants');
    Route::post('documents/participants/{instance}', 'DocumentController@participants');
    Route::get('documents/participants/{instance}', 'DocumentController@participants');
    Route::get('documents/modal/listing', 'DocumentController@listingSelect');
    Route::post('documents/review/{instance}', 'DocumentController@review');
    Route::post('forms/builder', 'FormController@builder');

    Route::resource('documents', 'DocumentController')->except(['index', 'show']);
    Route::resource('forms', 'FormController')->except(['index', 'show']);
  });

  ///////////////////////////////////////////
  ///////// CRM SUBSCRIPTION ACCESS /////////
  ///////////////////////////////////////////

  Route::middleware('subscription:crm')->group(function () {

    Route::get('agreements/calendar',             'AgreementController@calendar');

    Route::get('conversations', 'ConversationController@index');
    //Route::get('form/old', 'ApplicationController@oldform');
    Route::get('source/index', 'SourceController@index');

    // Message Paths
    Route::get('call', 'Com\CallController@dial');
    Route::get('call/status', 'Com\CallController@status');
    Route::get('call/receive', 'Com\CallController@inbound');
    //        Route::get('/messages/inbox', 'Com\MessageController@index');
    //        Route::get('/messages/status', 'Com\MessageController@status');
    //        Route::get('/messages/timeline', 'Com\MessagesController@timeline');

    // Import Paths
    //                Route::get('import', 'ImportController@index');
    //                Route::get('import/auth', 'ImportController@auth');
    //                Route::get('import/contacts', 'ImportController@contacts');
    //                Route::get('leads/approval', 'LeadController@approval');

    // Route::get('users/{uuid}', 'UserController@organization');

    // Pipelines
    //                Route::get('pipelines/{uuid}/edit', 'PipelineController@edit');
    //                Route::get('pipelines/kanban', 'PipelineController@kanban');

    // Campaigns
    //Route::get('campaigns/{uuid}/edit', 'CampaignController@edit');

    // Libraries
    Route::get('library', 'LibraryController@index');

    // Payment
    //Route::get('payment/viewcards', 'WalletController@viewcards');

    //Contacts
    Route::post('contacts/importFromFile', 'ContactController@importFromFile');
    Route::get('contacts/imported', 'ContactController@imported');
    Route::get('contacts/rollback', 'ContactController@rollback');
    Route::post('contacts/rollback', 'ContactController@rollback');
    Route::post('contact/commit', 'ContactController@commit');
    Route::get('contacts/list', 'ContactController@list');
    Route::get('contacts/calendar', 'ContactController@calendar');

    Route::get('numbers/acquire/{number}', 'Com\NumberController@provision');

    // Resource routes
    Route::resources([
      //'campaigns' => 'CampaignController',
      'conversations' => 'ConversationController',
      'flows' => 'FlowController',

      'messages' => 'Com\MessageController',
      'numbers' => 'Com\NumberController',
      //'pipelines' => 'PipelineController',

      'segments' => 'SegmentController',
      'sources' => 'SourceController',
      'tasks' => 'TaskController',
      'templates' => 'TemplateController',
      //'variants' => 'VariantController',
      //'payment' => 'PaymentController',
    ]);
  });

  ///////////////////////////////////////////
  ////////// ADMINISTRATOR ACCESS ///////////
  ///////////////////////////////////////////

  //            Route::middleware('role:mreadmin')->group( function () {
  //
  //
  //            });

  //Non-subscription resource routes
  Route::resources([
    'contacts' => 'ContactController',
    'enterprises' => 'EnterpriseController',
    'leads' => 'LeadController',
    'opportunities' => 'OpportunityController',
    'subscriptions' => 'SubscriptionController',
    'users' => 'UserController'
  ]);
  Route::resource('leads', 'LeadController')->except(['store', 'update']);
  Route::resource('documents', 'DocumentController')->only(['index', 'show']);
  Route::resource('forms', 'FormController')->only(['index', 'show']);

  // Agreements
  Route::get('agreements', 'AgreementController@index');

  // Test
  Route::resource('test', 'TestController');
  Route::get('tests/tabs', 'TestController@tabs');
  Route::get('tests/geo', 'TestController@geo_test');
});

//test
Route::get('test', 'ContactController@test');
