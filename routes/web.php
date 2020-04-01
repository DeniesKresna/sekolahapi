<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*//*
Route::get('/test', function(){
    return view('coba');
});*/

//Route::get('/forecasts', 'v1\User\ForecastController@index');
Route::get('widget/forecasts','v1\User\WidgetController@forecasts');

Route::get('widget/prayhours','v1\User\WidgetController@prayhours');
/*use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'User\HomeController@index')->name('welcome');
Route::get('/home/{page?}', 'User\HomeController@index')->name('welcome');
Route::get('/about', 'User\HomeController@about')->name('about');
Route::group(['prefix' => 'account'],function () {
    Route::any('/', 'User\UserController@index')->name('user.account');
    Route::any('/ajax/{action?}', 'User\UserController@ajax')->name('user.account.ajax');
    Route::post('/update', 'User\UserController@update')->name('user.account.update');
    Route::post('/password', 'User\UserController@password')->name('user.account.password');
    Route::get('/transaction', 'User\TransactionController@index')->name('user.account.transaction');
});
Route::group(['prefix' => 'submission'],function () {
    Route::any('/', 'User\SubmissionController@index')->name('submission');
    Route::get('/unavailable', 'User\SubmissionController@unavailable')->name('submission.unavailable');
    Route::get('/add', 'User\SubmissionController@form')->name('submission.form');
    Route::post('/add', 'User\SubmissionController@create')->name('submission.add');

    Route::get('/edit/{id}', 'User\SubmissionController@edit')->name('submission.edit');
    Route::any('/update/{id}', 'User\SubmissionController@update')->name('submission.update');
    Route::any('/ajax/{action?}', 'User\SubmissionController@ajax')->name('submission.ajax');

    Route::any('/preview', 'User\SubmissionController@preview')->name('submission.preview');
});
Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['role:superadmin,hrdadmin,useradmin,shopadmin']],function () {
    Route::get('/home', 'Admin\HomeController@index')->name('admin.home');
    Route::group(['prefix' => 'submission'],function () {
        Route::any('/list', 'Admin\ResearchSubmissionController@index')->name('admin.submission');
        Route::any('/ajax/{action?}', 'Admin\ResearchSubmissionController@ajax')->name('admin.submission.ajax');
        Route::any('/download/{action?}', 'Admin\ResearchSubmissionController@download')->name('admin.submission.download');
    });
    Route::group(['prefix' => 'user', 'middleware' => ['role:superadmin,useradmin']],function () {
        Route::get('/', 'Admin\UserController@index')->name('admin.user');
        Route::any('/ajax/{action?}', 'Admin\UserController@ajax')->name('admin.user.ajax');
        Route::post('/add', 'Admin\UserController@create')->name('admin.user.add');
        Route::get('/detail/{id?}', 'Admin\UserController@detail')->name('admin.user.detail');
        Route::post('/update', 'Admin\UserController@update')->name('admin.user.update');
        Route::post('/password', 'Admin\UserController@password')->name('admin.user.password');
        Route::get('/delete/{id?}', 'Admin\UserController@delete')->name('admin.user.delete');
    });
    Route::group(['prefix' => 'setting', 'middleware' => ['role:superadmin,useradmin']],function () {
        Route::get('/', 'Admin\SettingController@index')->name('admin.setting');
        Route::any('/ajax/{action?}', 'Admin\SettingController@ajax')->name('admin.setting.ajax');
        Route::post('/add', 'Admin\SettingController@create')->name('admin.setting.add');
        Route::post('/update', 'Admin\SettingController@update')->name('admin.setting.update');
        Route::get('/detail/{id?}', 'Admin\SettingController@detail')->name('admin.setting.detail');
        Route::get('/delete/{id}', 'Admin\SettingController@delete')->name('admin.setting.delete');
    });
    Route::group(['prefix' => 'offices', 'middleware' => ['role:superadmin,useradmin']],function () {
        Route::get('/', 'Admin\OfficeDataController@index')->name('admin.office');
        Route::any('/ajax/{action?}', 'Admin\OfficeDataController@ajax')->name('admin.office.ajax');
        Route::post('/add', 'Admin\OfficeDataController@create')->name('admin.office.add');
        Route::post('/update', 'Admin\OfficeDataController@update')->name('admin.office.update');
        Route::get('/detail/{id?}', 'Admin\OfficeDataController@detail')->name('admin.office.detail');
        Route::get('/delete/{id?}', 'Admin\OfficeDataController@delete')->name('admin.office.delete');
    });

    Route::group(['prefix' => 'research_field', 'middleware' => ['role:superadmin,useradmin']],function () {
        Route::get('/', 'Admin\ResearchFieldController@index')->name('admin.research_field');
        Route::any('/ajax/{action?}', 'Admin\ResearchFieldController@ajax')->name('admin.research_field.ajax');
        Route::post('/add', 'Admin\ResearchFieldController@create')->name('admin.research_field.add');
        Route::post('/update', 'Admin\ResearchFieldController@update')->name('admin.research_field.update');
        Route::get('/detail/{id?}', 'Admin\ResearchFieldController@detail')->name('admin.research_field.detail');
        Route::get('/delete/{id?}', 'Admin\ResearchFieldController@delete')->name('admin.research_field.delete');
    });

    Route::group(['prefix' => 'carousel', 'middleware' => ['role:superadmin,useradmin']],function () {
        Route::get('/', 'Admin\CarouselController@index')->name('admin.carousel');
        Route::post('/add', 'Admin\CarouselController@create')->name('admin.carousel.add');
        Route::get('/{id}', 'Admin\CarouselController@detail')->name('admin.carousel.detail');
        Route::get('/status/{id}/{active}', 'Admin\CarouselController@status')->name('admin.carousel.status');
        Route::get('/delete/{id}', 'Admin\CarouselController@delete')->name('admin.carousel.delete');
    });

});*/
