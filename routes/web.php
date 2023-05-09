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
*/


Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', array(function () {
    return view('welcome');
}));

Route::post('login', [ 'as' => 'login', 'uses' => 'LoginController@login']);
Route::get('/logout', 'LoginController@logout');

Route::get('/home', 'HomeController@index');


Route::get('/completions_report/grid/', 'HomeController@CompletionsReportGrid');
Route::get('/completions_report', 'HomeController@CompletionsReport');

//Route::get('/downloadFile/{fileName}', 'HomeController@downloadFile');
//Route::get('/manufacturingreceipts', 'HomeController@getManufacturingReceipts');
//Route::post('/manufacturingreceipts', 'HomeController@uploadManufacturingReceipts');

Route::get('/manufacturingreceipts/export', 'ManufacturingReceiptsController@exportManufacturingReceipts');
Route::post('/manufacturingreceipts/import', 'ManufacturingReceiptsController@importManufacturingReceipts');
Route::post('/manufacturingreceipts/grid', 'ManufacturingReceiptsController@grid');
Route::resource('/manufacturingreceipts', 'ManufacturingReceiptsController');

//VerifiedShipments
/*Route::post('/verifiedshipments/exportVerifiedShipments', 'HomeController@exportVerifiedShipments');
Route::get('/verifiedshipments/{id}/download', 'HomeController@downloadVerifiedShipments');
Route::post('/verifiedshipments/grid', 'HomeController@getVerifiedShipmentsGrid');
Route::get('/verifiedshipments', 'HomeController@getVerifiedShipments');*/

//

//OutboundLoads
/*Route::post('/outboundloads/exportOutboundLoads', 'HomeController@exportOutboundLoads');
Route::get('/outboundloads/{id}/download', 'HomeController@downloadOutboundLoads');
Route::post('/outboundloads/grid', 'HomeController@getOutboundLoadsGrid');
Route::get('/outboundloads', 'HomeController@getOutboundLoads');*/

//

//InventoryHistory
/*Route::get('/inventoryhistory/{id}/download', 'HomeController@downloadInventoryHistory');
Route::post('/inventoryhistory/grid', 'HomeController@getInventoryHistoryGrid');
Route::get('/inventoryhistory', 'HomeController@getInventoryHistory');*/

//
Route::post('/owmitem/updateExpMethod/{owmitem}', 'OwmItemController@updateExpMethod');
Route::post('/owmitem/import', 'OwmItemController@importWarehouseItems');
Route::post('/owmitem/grid', 'OwmItemController@grid');
Route::resource('/owmitem', 'OwmItemController');

Route::post('/order/import', 'OrderController@importOrders');
Route::resource('/order', 'OrderController');


Route::get('/processreceipts/testviewpdf/{id}', 'ProcessReceiptsController@TestViewPdf');

Route::get('/processreceipts/print-label/{id}', 'ProcessReceiptsController@index');

Route::post('/processreceipts/print-label/{id}', 'ProcessReceiptsController@PrintLabel');
Route::post('/processreceipts/updateQty/{id}', 'ProcessReceiptsController@updateQty');
Route::post('/processreceipts/pdf/{id}', 'ProcessReceiptsController@Pdf');
Route::post('/processreceipts/print', 'ProcessReceiptsController@Print');
Route::post('/processreceipts/re-print/{id}', 'ProcessReceiptsController@rePrint');
Route::get('/processreceipts/viewlpns', 'ProcessReceiptsController@viewLpns');
Route::resource('/processreceipts', 'ProcessReceiptsController');


Route::get('/freezerlpn', 'FreezerController@index');
Route::post('/freezerlpn', 'FreezerController@Process');



Route::group(['middleware' => ['admin']], function()
{
	Route::get('/users/grid', 'UserController@grid');
	Route::resource('/users', 'UserController');
	
	Route::get('/parameter/grid', 'ParameterController@grid');
	Route::resource('/parameter', 'ParameterController');
});



