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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login','AuthController@authenticate');
    Route::post('/logout','AuthController@logout');
    Route::post('/check','AuthController@check');
//
//    Route::get('/activate/{token}','AuthController@activate');
    Route::post('/password','AuthController@password');
//    Route::post('/validate-password-reset','AuthController@validatePasswordReset');
//    Route::post('/reset','AuthController@reset');
//    Route::post('/social/token','SocialAuthController@getToken');
});

Route::group(['middleware' => ['jwt.auth']], function () {

    Route::get('/auth/user','AuthController@getAuthUser');
    Route::get('/isadminuser','UserController@isadminuser');
//  Route::post('/task','TaskController@store');
//  Route::get('/task','TaskController@index');
//  Route::delete('/task/{id}','TaskController@destroy');
//  Route::get('/task/{id}','TaskController@show');
//  Route::patch('/task/{id}','TaskController@update');
//  Route::post('/task/status','TaskController@toggleStatus');
    /**
     * user management
     */
    Route::get('/user','UserController@index');
    Route::post('/saveuser','UserController@saveuser');
    Route::post('/register','AuthController@register');
    Route::delete('/user/{id}','UserController@toggleStatus');
    Route::get('/user/dashboard','UserController@dashboard');

    Route::post('/query','QueryController@store');
    Route::post('/outbound','OutboundController@store');
    Route::get('/query','QueryController@index');
    Route::get('/sendsms','QueryController@sendsms');
    Route::delete('/query/{id}','QueryController@destroy');
    Route::get('/query/{id}','QueryController@show');
    Route::patch('/query/{id}','QueryController@update');
    Route::post('/query/status','QueryController@toggleStatus');
    Route::get('/query_search','QueryController@searchDetail');
    Route::get('/categorylist','QueryController@categoryList');
    Route::get('/subcategorylist','QueryController@subCategoryList');
    Route::get('/subcategorydesc','QueryController@subCategoryDesc');
    Route::get('/googleform','QueryController@googleForm');
    Route::get('/getcustomerhistory','QueryController@getCustomerHistory');

    Route::get('auth/callbackdata', 'EscalationController@index');
    Route::get('auth/countescalation', 'EscalationController@countEscalation');
    Route::get('auth/visit-agent-list', 'FormController@visitAgentList');
    Route::get('auth/payment-pending-list', 'FormController@paymentPendingList');
    Route::get('auth/bank-account-change-list', 'FormController@bankAccountChangelist');
    Route::get('auth/merchant-revisit-list', 'FormController@merchantRevisitList');
    Route::get('auth/data-search', 'FormController@dataSearch');
    Route::get('auth/data-export', 'FormController@dataExport');
    Route::get('auth/data-export-zip', 'FormController@dataExportZip');
    Route::post('auth/status-update', 'FormController@toggleStatus');
    Route::get('auth/escalationsearch','EscalationController@escalationSearch');
    Route::get('auth/dataexportOutbound','OutboundListController@exportOutbound');
    Route::get('auth/dataexportinbound','InboundListController@inBoundExport');
    Route::get('auth/escalationexport','EscalationController@escalationExport');
    Route::get('auth/get-merchant-images', 'FosController@getMerchantImages');
    Route::get('auth/getCityList', 'FosController@getCityList');
    Route::get('auth/datafosList','FosController@fosListExport');

    Route::get('chart/cout-payment', 'ChartController@countPayment');
    Route::get('chart/count-agent', 'ChartController@countAgent');
    Route::get('chart/count-bank', 'ChartController@countbankaccount');
    Route::get('chart/count-outbound', 'ChartController@outboundCount');
    Route::get('chart/count-escalation', 'ChartController@escalationCount');
    Route::get('chart/count-complaint', 'ChartController@countComplaint');
    Route::get('chart/count-query', 'ChartController@countQuery');
    
    Route::get('auth/alloutbounddata', 'OutboundListController@index');
    Route::get('auth/allinbounddata', 'InboundListController@index');
    Route::get('auth/alloutboundsearch', 'OutboundListController@outBoundSearch');
    Route::get('auth/allinboundsearch', 'InboundListController@inBoundSearch');
    Route::get('auth/allfos','FosController@index');
    Route::post('auth/fosstatus','FosController@updateStatus');
    Route::post('auth/reject','FosController@updaterejectStatus');

//    Route::get('/configuration/fetch','ConfigurationController@index');
//    Route::post('/configuration','ConfigurationController@store');


    Route::post('/user/change-password','AuthController@changePassword');
//    Route::post('/user/update-profile','UserController@updateProfile');
//    Route::post('/user/update-avatar','UserController@updateAvatar');
//    Route::post('/user/remove-avatar','UserController@removeAvatar');


//    Route::post('todo','TodoController@store');
//    Route::get('/todo','TodoController@index');
//    Route::delete('/todo/{id}','TodoController@destroy');
//    Route::post('/todo/status','TodoController@toggleStatus');
    Route::post('auth/status', 'EscalationController@toggleStatus');
});

