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
    return redirect()->route('login');
});

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
Auth::routes();
Route::get('login', 'LoginController@LoginForm')->name('login');
Route::post('loginpost', 'LoginController@LoginPost');
Route::get('logout', 'LoginController@logout')->name('logout');
Route::get('password/reset', 'LoginController@showLinkRequestForm')->name('owner.password.request');
Route::post('password/email', 'LoginController@sendResetLinkEmail')->name('owner.password.email');
Route::get('password/reset/{token}', 'LoginController@showResetForm')->name('password.reset.link');
Route::post('reset/password', 'LoginController@reset')->name('owner.password.update');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth:backend']], function () {

    Route::get('/admin/dashboard','DashboardController@index')->name('admin.dashboard');
    Route::get('/settings','DashboardController@settings')->name('user.edit');
    Route::post('/settings/update/{id}','DashboardController@settingsUpdate')->name('user.update');
    Route::post('/settings/updatePassword/{id}','DashboardController@updatePassword')->name('user.updatePassword');
    Route::post('/settings/updateLogo','DashboardController@updateLogo')->name('user.updateLogo');
    Route::post('/settings/updateAppName','DashboardController@updateAppName')->name('user.updateAppName');


    Route::get('/notification/send','NotificationController@index')->name('notification.send');
    Route::post('/notification/sending','NotificationController@sendNotification')->name('notification.sending');

    Route::resource('players','PlayerController');
    Route::post('/player/create','PlayerController@create');
    Route::get('/player/list','PlayerController@index')->name('player.list');
    Route::get('/player/delete/{id}', 'PlayerController@delete')->name('player.delete');
    Route::get('/player/edit/{id}', 'PlayerController@edit')->name('player.edit');
    Route::post('/player/update/{id}','PlayerController@update')->name('player.update');
    Route::get('/player/detail/{id}','PlayerController@playerDetail')->name('player.detail');
    Route::get('get/player/view','PlayerController@get_player_view')->name('player.get_player_view');

    Route::post('/boat_control/store','BoatControlController@store')->name('boat_control.store');
    Route::get('/boat_control/list','BoatControlController@index')->name('boat_control.list');
    Route::get('/boat_control/delete/{id}', 'BoatControlController@delete')->name('boat_control.delete');
    Route::get('/boat_control/edit/{id}', 'BoatControlController@edit')->name('boat_control.edit');

    Route::post('/version_control/store','VersionControlController@store')->name('version_control.store');
    Route::get('/version_control/list','VersionControlController@index')->name('version_control.list');
    Route::get('/version_control/delete/{id}', 'VersionControlController@delete')->name('version_control.delete');
    Route::get('/version_control/edit/{id}', 'VersionControlController@edit')->name('version_control.edit');


    Route::get('tournament/list','TournamentController@list');
    Route::get('tournament/create','TournamentController@create')->name('create');
    Route::post('tournament/save','TournamentController@save')->name('tournamentSave');
    Route::get('tournament/edit/{id}', 'TournamentController@edit')->name('tournamentEdit');
    Route::get('tournament/delete/{id}', 'TournamentController@delete')->name('tournamentdelete');
    Route::post('tournament/update/{id}', 'TournamentController@update')->name('tournamentUpdate');

    Route::get('banner/list','BannerController@list');
    Route::get('banner/create','BannerController@create')->name('create');
    Route::post('banner/save','BannerController@save')->name('bannerSave');
    Route::get('banner/edit/{id}', 'BannerController@edit')->name('bannerEdit');
    Route::get('banner/delete/{id}', 'BannerController@delete')->name('bannerdelete');
    Route::post('banner/update/{id}', 'BannerController@update')->name('bannerUpdate');

    Route::get('wallet/withdraw/list','WalletController@list')->name('withdraw.list');
    Route::get('wallet/withdraw/edit/{id}', 'WalletController@edit')->name('walletWithdrawEdit');
    Route::get('wallet/withdraw/reject/{id}', 'WalletController@reject')->name('walletWithdrawReject');
    Route::post('wallet/withdraw/update/{id}', 'WalletController@update')->name('walletWithdrawUpdate');
    Route::post('/wallet/modify', 'WalletController@modifyPlayerWallet')->name('modifyPlayerWallet');
    Route::get('/wallet/show/{id}', 'WalletController@getPlayerWallet')->name('getPlayerWallet');
     Route::get('/bonuswallet/show/{id}', 'WalletController@getPlayerBonusWallet')->name('getPlayerBonusWallet');
    Route::get('/wallet/showPage', 'WalletController@showPage')->name('showWalletPage');

    Route::get('support/request/list','SupportController@list')->name('support.list');
    Route::get('support/request/edit/{id}', 'SupportController@edit')->name('supportRequestEdit');
    Route::get('support/request/reject/{id}', 'SupportController@reject')->name('supportRequestReject');
    Route::post('support/request/update/{id}', 'SupportController@update')->name('supportRequestUpdate');

    Route::get('report/players','ReportsController@playerReport')->name('report.playersList');
    Route::get('report/support','ReportsController@supportReport')->name('report.support');
    Route::get('report/bannedPlayers','ReportsController@bannedPlayerReport')->name('report.bannedPlayers');  
    Route::get('report/players/withdraw/{id}','ReportsController@withdrawHistory')->name('withdrawHistory');
    Route::get('report/activity','ReportsController@transactionActivity')->name('report.activity');
    Route::get('report/recharge','ReportsController@rechargeActivity')->name('report.recharge');
    Route::get('report/approvedwithdraw','ReportsController@approvedwithdraw')->name('report.approvedwithdraw');
    Route::get('report/rejectedwithdraw','ReportsController@rejectedwithdraw')->name('report.rejectedwithdraw');
});


