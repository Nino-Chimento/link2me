<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// users
Route::get('/link2me/user/{id}', 'Link2MeUserController@getUser')->name('getUser');
Route::post("/link2me/user/delete/{id}",'Link2MeUserController@deleteUser')->name("deleteUser");
Route::post("/link2me/user/add",'Link2MeUserController@addUser')->name("addUser");
Route::post("/link2me/user/update",'Link2MeUserController@updateUser')->name("updateUser");
// users

// contacts
Route::post("/link2me/user/{id}/contact/add",'Link2MeUserController@addContact')->name("addContatc");
Route::post("/link2me/user/contact/delete",'Link2MeUserController@addContact')->name("removeContatc");
Route::post("/link2me/user/contact/search",'Link2MeUserController@searchContact')->name("searchContatc");
Route::get("/link2me/department/{department}",'Link2MeUserController@searchByDepartment')->name("searchByDepartment");
// contacts

// bonus distance
Route::get('/link2me/user/{id}/contacts/distance', 'Link2MeUserController@distanceContacts')->name('distanceContacts');