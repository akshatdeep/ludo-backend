<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('tournament/update/15min', 'Api\TournamentController@tournament15Min')->name('tournament15Min');
Route::get('tournament/update/30min', 'Api\TournamentController@tournament30Min')->name('tournament30Min');
Route::get('tournament/update/5min', 'Api\TournamentController@tournament5Min')->name('tournament5Min');
Route::get('tournament/update/3min', 'Api\TournamentController@tournament3Min')->name('tournament3Min');
Route::get('tournament/update/8min', 'Api\TournamentController@tournament8Min')->name('tournament8Min');
Route::get('tournament/update/10min', 'Api\TournamentController@tournament10Min')->name('tournament10Min');
Route::get('tournament/update/1min', 'Api\TournamentController@tournament1Min')->name('tournament1Min');

Route::middleware('auth:api')->group(function () {
    // our routes to be protected will go in here
    Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');

    Route::get('tournament/list', 'Api\TournamentController@tournamentList')->name('tournamentList.api');
    Route::post('tournament/update', 'Api\TournamentController@tournamentUpdate')->name('tournamentList.update');
    Route::post('tournament/registration', 'Api\TournamentController@tournamentRegistartion')->name('tournamentRegistartion');
    Route::post('tournament/registration/list', 'Api\TournamentController@tournamentRegistartionList')->name('tournamentRegistartionList');
    Route::post('tournament/registration/count', 'Api\TournamentController@tournamentRegistartionCount')->name('tournamentRegistartionCount');
    Route::post('tournament/registration/overall/list', 'Api\TournamentController@tournamentRegistartionOverallList')->name('tournamentRegistartionOverallList');

    Route::post('withdraw/request', 'Api\WalletController@withdrawRequestAdd')->name('withdrawRequestAdd');
    Route::post('wallet/load/amount', 'Api\WalletController@walletAmountLoad')->name('walletAmountLoad');
    Route::post('wallet/withdraw/amount', 'Api\WalletController@walletAmountWithdraw')->name('walletAmountWithdraw');
    Route::post('wallet/withdraw/request', 'Api\WalletController@walletWithdrawRequest')->name('walletWithdrawRequest');
    Route::post('wallet/game/load', 'Api\WalletController@walletGameLoad')->name('walletGameLoad');
    Route::post('wallet/history', 'Api\WalletController@walletHistory')->name('walletHistory');

    Route::post('bonus/wallet/load/amount', 'Api\WalletController@bonuswalletAmountLoad')->name('bonuswalletAmountLoad');
    Route::post('bonus/wallet/withdraw/amount', 'Api\WalletController@bonuswalletAmountWithdraw')->name('bonuswalletAmountWithdraw');



    Route::get('banner/list', 'Api\BannerController@bannerList')->name('bannerList');

    Route::post('support/request/add', 'Api\SupportController@supportRequestAdd')->name('supportRequestAdd');
    Route::post('support/list/{id}', 'Api\SupportController@supportList')->name('supportList');

    Route::post('get/referal', 'Api\PlayerController@referal_data')->name('referal_data.api');
    Route::prefix('players')->group(function () {
       
        Route::get('/list', 'Api\PlayerController@playersList')->name('playersList.api');
        Route::post('/create', 'Api\PlayerController@playersCreate')->name('playersCreate.api');
        Route::post('/update', 'Api\PlayerController@playersUpdate')->name('playersupdate.api');
        Route::post('/details', 'Api\PlayerController@playerDetails')->name('playersdetails.api');
        Route::post('/profile-image/save', 'Api\PlayerController@playersImageUpdate')->name('profileImageUpload.api');
        Route::post('/profile-image/get', 'Api\PlayerController@playersImageGet')->name('profileImageGet.api');

    });
       Route::prefix('game')->group(function () {
       
        
        Route::post('/create', 'Api\GamestateController@roomCreate')->name('roomCreate.api');
        Route::post('/update', 'Api\GamestateController@roomUpdate')->name('roomUpdate.api');
        Route::post('/state', 'Api\GamestateController@roomState')->name('roomState.api');
   

    });
});
Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login', 'Auth\ApiAuthController@login')->name('login.api');
    Route::post('/register','Auth\ApiAuthController@register')->name('register.api');

});
