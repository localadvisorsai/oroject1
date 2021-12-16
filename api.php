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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('user/sendOtp', 'UserController@sendVerificationCode');
Route::post('user/validateOtp', 'UserController@validateVerificationCode');

// ROUTES
Route::middleware('auth.basic.once')->group(function () {


});

// GEOS
Route::get('geo/states','GeoController@states');
Route::get('geo/counties/{state}','GeoController@counties');
Route::get('geo/localities/{county}','GeoController@localities');


Route::middleware('auth:api')->group(function () {

// EVENTS (aka CALENDAR)
    Route::get('tasks//{uuid}/calendar', 'TaskController@calendar');

Route::get('agreements/expirations', 'AgreementController@expirations');
Route::get('agreements/renewals', 'AgreementController@renewals');
Route::get('agreements/pipeline', 'AgreementController@pipeline');


// FILTERS
    Route::get('flows/where/{mame}/[operator}/{value}', 'FlowController@where');

// RELATIONSHIPS
    Route::get('contacts/{uuid}/agreements', 'ContactController@agreements');
    Route::get('contacts/{uuid}/opportunities', 'ContactController@opportunities');
    Route::get('contacts/{uuid}/tasks', 'ContactController@tasks');
    Route::get('contacts/{uuid}/segments', 'ContactController@segments');
    Route::get('contacts/{uuid}/stats', 'ContactController@stats');
    Route::get('contacts/{uuid}/notes', 'ContactController@notes');
    Route::get('flows/{uuid}/templates', 'FlowController@templates');
    //Route::get('match/leads', 'MatchController@leads');
    Route::get('segments/{uuid}/contacts', 'SegmentController@contacts');
Route::get('segment', 'SegmentController@leads');
    Route::get('source/opportunities', 'SourceController@opportunities');

// NOTES
    Route::get('contacts/{uuid}/notes', 'ContactController@notes');
    Route::get('leads/{uuid}/notes', 'LeadController@notes');
    Route::get('opportunities/{uuid}/notes', 'OpportunityController@notes');


// STATS
    Route::get('contacts/{uuid}/stats','ContactController@stats');
    Route::get('segments/{uuid}/stats','SegmentController@stats');
    Route::get('sources/{uuid}/stats','SourceController@stats');
    Route::get('templates/{uuid}/stats','TemplateController@stats');


    // SELECTS
//    Route::get('campaigns/select', 'CampaignController@select');
    Route::get('enterprises/select', 'EnterpriseController@select');
    Route::get('forms/select/{id?}', 'FormController@select');
    //Route::get('pipelines/select', 'PipelineController@select');
    Route::get('segments/select', 'SegmentController@select');
    Route::get('sources/select', 'SourceController@select');
    Route::get('templates/select/{type}', 'Com\TemplateController@select');
    Route::get('users/select', 'UserController@select');

// FILTERS
    Route::get('flows/select', 'FlowController@select'); //campaignns

    Route::get('enterprises/select', 'EnterpriseController@select');
    Route::get('forms/select/{id?}', 'FormController@select');
    //Route::get('pipelines/select', 'PipelineController@select');
    Route::get('segments/select', 'SegmentController@select');
    Route::get('sources/select', 'SourceController@select');
    Route::get('templates/select/{type}', 'Com\TemplateController@select');
    Route::get('users/select', 'UserController@select');

    // extended Rest API (relationships)
    Route::get('campaigns/templates', 'FLowController@templates');
    Route::get('segments/mmbers', 'SegmentController@members');

    // RESOURCES
    Route::apiResources([
        'agreements' => 'AgreementController',
        'contacts' => 'ContactController',
        'documents' => 'DocumentController',
        'flows' => 'FlowController',
        'forms' => 'FormController',
        'layouts' => 'LayoutController',
        'leads' => 'LeadController',
        'opportunities' => 'OpportunityController',
        'segments' => 'SegmentController',
        'sources' => 'SourceController',
        'tasks' => 'TaskController',
        'users' => 'UserController',
        //'campaigns' => 'CampaignController',
        //'pipelines' => 'PipelineController',
        'templates' => 'TemplateController',
        'com/messages' => 'Com\MessageController',
        'com/numbers' => 'Com\NumberController',
        'router/activity' => 'Router\ActivityController',
        'router/channels' => 'Router\ChannelController',
        'router/events' => 'Router\EventsController',
        'router/queues' => 'Router\QueueController',
        'router/statistics' => 'Router\StatisticsController',
        'router/tasks' => 'Router\TaskController',
        'router/workers' => 'Router\WorkerController',
        'router/workspaces' => 'Router\WorkspaceController'
    ]);

});
