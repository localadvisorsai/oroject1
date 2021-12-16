<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| MLS Routes
|--------------------------------------------------------------------------
|
| Here is where you can register MLS routes to power a directory of home listings. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "mls" middleware group.
*/

// ********************************************
// *********** PUBLIC ACCESS **************
// ********************************************

// HOMEPAGE ROUTES
//Route::get('/', 'HomeController@index');
//Route::get('home', 'HomeController@index')->name('home');
//Route::get('home/ads', 'HomeController@homePageAds');

// SITEMAP ROUTES
Route::get('sitemap.xml', 'SitemapController@index');
Route::get('sitemap_state.xml', 'SitemapController@state')->name('sitemap_state');
Route::get('sitemap_county.xml', 'SitemapController@county')->name('sitemap_county');
Route::get('sitemap_city.xml', 'SitemapController@city')->name('sitemap_city');
Route::get('sitemap_zip.xml', 'SitemapController@zip')->name('sitemap_zip');
Route::get('sitemap_neighborhood.xml', 'SitemapController@neighborhood')->name('sitemap_neighborhood');
Route::get('sitemap_listings.xml', 'SitemapController@listing')->name('sitemap_listing');

// DIRECTORY ROUTES
Route::get('listing/{type}', 'ListingController@call')->where('type', 'rentals|select');

foreach(config('list.state_codes') as $code => $state) {
    Route::get('houses-for-rent/' . strtolower($code), 'ListingController@state');
    Route::get('houses-for-rent/' . strtolower($code) . '/{county}-county', 'ListingController@county');
    Route::get('houses-for-rent/' . strtolower($code) . '/{city}', 'ListingController@city');
    Route::get('houses-for-rent/' . strtolower($code) . '/{city}/address/{address}', 'ListingController@address');
    Route::get('houses-for-rent/' . strtolower($code) . '/{city}/neighborhood/{neighborhood}', 'ListingController@neighborhood');
    Route::get('houses-for-rent/' . strtolower($code) . '/{city}/route/{route}', 'ListingController@route');
    Route::get('houses-for-rent/' . strtolower($code) . '/{city}/{address}/{id}', 'ListingController@address');
    Route::get('houses-for-sale/' . strtolower($code), 'ListingController@state');
    Route::get('houses-for-sale/' . strtolower($code) . '/{county}-county', 'ListingController@county');
    Route::get('houses-for-sale/' . strtolower($code) . '/{city}', 'ListingController@city');
    Route::get('houses-for-sale/' . strtolower($code) . '/{city}/address/{address}', 'ListingController@address');
    Route::get('houses-for-sale/' . strtolower($code) . '/{city}/neighborhood/{neighborhood}', 'ListingController@neighborhood');
    Route::get('houses-for-sale/' . strtolower($code) . '/{city}/route/{route}', 'ListingController@route');
    Route::get('houses-for-sale/' . strtolower($code) . '/{city}/{address}/{id}', 'ListingController@address');
    Route::get('land-for-sale/' . strtolower($code), 'ListingController@state');
    Route::get('land-for-sale/' . strtolower($code) . '/{county}-county', 'ListingController@county');
    Route::get('land-for-sale/' . strtolower($code) . '/{city}', 'ListingController@city');
    Route::get('land-for-sale/' . strtolower($code) . '/{city}/address/{address}', 'ListingController@address');
    Route::get('land-for-sale/' . strtolower($code) . '/{city}/neighborhood/{neighborhood}', 'ListingController@neighborhood');
    Route::get('land-for-sale/' . strtolower($code) . '/{city}/route/{route}', 'ListingController@route');
    Route::get('land-for-sale/' . strtolower($code) . '/{city}/{address}/{id}', 'ListingController@address');
}
Route::get('houses-for-rent/{postal}', 'ListingController@postal')->where('postal', '[0-9]+');
Route::get('houses-for-sale/{postal}', 'ListingController@postal')->where('postal', '[0-9]+');
Route::get('land-for-sale/{postal}', 'ListingController@postal')->where('postal', '[0-9]+');

//SEARCH ROUTES
Route::get('search', 'ListingController@search2');
Route::get('search/autocomplete', 'ListingController@autoComplete');
Route::post('search/mbr', 'ListingController@mbr');

