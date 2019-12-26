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

//https://documenter.getpostman.com/view/6265407/SVfRv8hW?version=latest
Route::post('pending_offers_contracts/','api\ReportController@get_pending_offers_contracts');
Route::post('positions_list/','api\ReportController@positions_list');
Route::get('pending_summary/','api\ReportController@pending_summary');

Route::match(['get', 'post'], 'get_Token', 'api\ReportController@get_Token');
Route::match(['get', 'post'], 'get_userinfo', 'api\ReportController@get_userinfo');



//WFG apis
Route::match(['get', 'post'], 'save_visa_info', 'api\WFGController@save_visa_info');
Route::match(['get', 'post'], 'get_wfg_requests', 'api\WFGController@get_wfg_requests');
Route::match(['get', 'post'], 'get_wfg_actions', 'api\WFGController@get_wfg_actions');
Route::post('WFG/CorrespondenceReplyForm','api\WFGController@SaveCorrespondenceReply');
Route::get('WFG/CorrespondenceAddresses','api\WFGController@CorrespondenceAddresses');
Route::match(['get', 'post'], 'WFG/getDepartments', 'api\WFGController@getDepartments');


//new apis
Route::match(['get', 'post'],'correlative_map/','api\GeneralController@correlative_map');

