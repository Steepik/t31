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
use Illuminate\Support\Facades\Redirect;

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::middleware('guest')->get('pre-register', 'Auth\RegisterController@index')->name('pre-register');
Route::get('/order-list', 'HomeController@orderList')->name('order-list');
Route::get('/tires', 'TireController@index')->name('tires');
Route::get('/wheels', 'WheelController@index')->name('wheels');
Route::get('/tires/podbor', 'TireController@podbor')->name('podbor');
Route::get('/wheels/podbor', 'WheelController@podbor')->name('podbor_wheels');
Route::post('/add_to_cart', 'CartController@addToCart')->name('addtocart');
Route::get('/cart', 'CartController@index')->name('cart');
Route::post('/refresh', 'CartController@refreshProductCount')->name('refresh');
Route::get('/make_order/{street}', 'CartController@makeOrder');
Route::post('/prod_action', 'HomeController@actionWithProduct')->name('prod_action');
Route::get('/order/{id}', 'OrderController@index')->name('order');
Route::get('/order-m/{id}', 'OrderController@showMergedOrder')->name('order-m');
Route::post('/add_comment', 'OrderController@addComment')->name('add_comment');
Route::get('/bill/{id}', 'OrderController@orderBill')->name('bill');
Route::get('/bill-m/{id}', 'OrderController@orderMergeBill')->name('bill-m');
Route::get('/tires/{id}', 'TireController@show');
Route::get('/wheels/{id}', 'WheelController@show');

//ROUTE USE FOR SELECT BY CAR
Route::get('/car/{fvendor}/{fcar}/{fyear}/{fmod}', 'SelByCar@index')->name('bycar');
Route::post('/fvendor', 'SelByCar@getCarModels');
Route::post('/fcar', 'SelByCar@getCarYear');
Route::post('/fmod', 'SelByCar@getCarMod');

Route::get('/{url}', function ($url) {
    return Redirect::to('/');
})->where('url', '(add_to_cart|prod_action|add_comment)');

Route::middleware('auth')->get('access', function(){
    if(Auth::check() and Auth::user()->access) return Redirect::to('/');
    return view('access.index');
});

//** Profile **/
Route::middleware(['auth'])->group(function(){
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile/update_info', 'ProfileController@updateInfo')->name('profile_update');
    Route::put('/profile/update_pass', 'ProfileController@updatePass')->name('profile_up_pass');
    Route::get('/excel-download', function() {
        return view('profile.excel-upload');
    });
    Route::get('/excel-download/{type}', 'ProfileController@excelDownload')->name('excel-download');
});

// *** Admin Routes *** //
Route::middleware(['auth', 'is_admin'])->group(function(){
    Route::get('control', 'Admin\AdminController@index')->name('control');
    Route::get('control/moder/access', 'Admin\AdminController@userModeration')->name('moder');
    Route::post('control/moder/give_access', 'Admin\AdminController@giveAccess');
    Route::get('control/moder/pcheck', 'Admin\AdminController@productModeration')->name('pcheck');
    Route::post('control/moder/productAction', 'Admin\AdminController@productAction');
    Route::get('control/buyers', 'Admin\BuyerController@index')->name('buyers');
    Route::get('control/texts', 'Admin\TextController@index')->name('texts');
    Route::get('control/texts/{id}', 'Admin\TextController@show')->name('text_edit');
    Route::post('control/texts', 'Admin\TextController@save')->name('text_save');
    Route::get('control/orders', 'Admin\OrderController@index')->name('admin_order');
    Route::put('control/order_change/{id}', 'Admin\OrderController@update')->name('order_change');
    Route::post('control/orders/changeOrderStatus', 'Admin\OrderController@changeOrderStatus');
    Route::get('/control/import', 'Admin\ImportController@index')->name('import');
    Route::post('control/import/upload', 'Admin\ImportController@uploadExcel')->name('upload');
    Route::get('control/order-m/{id}', 'Admin\OrderController@showMergeOrder')->name('order_show_merge');
    Route::get('control/order/{id}', 'Admin\OrderController@showOrder')->name('order_show');
    Route::post('control/order/{id}/addComment', 'Admin\OrderController@addComment')->name('admin_add_comment');
    Route::get('control/invoice/{id}', 'Admin\OrderController@invoice')->name('invoice');
    Route::get('control/invoice_merged/{id}', 'Admin\OrderController@invoice_merged')->name('invoice_merged');
    Route::get('control/stats', 'Admin\StatsController@index')->name('stats');
    Route::get('control/reserve', 'Admin\ReserveController@index')->name('reserve');
    Route::post('control/reserve/add/', 'Admin\ReserveController@addToReserve')->name('reserve-add');
    Route::post('control/reserve/delete/', 'Admin\ReserveController@deleteFromReserve')->name('reserve-delete');
    Route::post('control/order_action', 'Admin\OrderController@orderAction')->name('orders_action');
    Route::post('control/changeOrderCount', 'Admin\OrderController@AjaxChangeOrderCount');
    Route::post('control/delOrderInMerged', 'Admin\OrderController@ajaxDeletePositionFromMergedOrder');
    Route::get('control/best-deals', 'Admin\BestDealsController@index')->name('best-deals');
    Route::post('control/best-deals/add/', 'Admin\BestDealsController@addToBestDeals')->name('bestdeals-add');
    Route::post('control/best-deals/delete/', 'Admin\BestDealsController@deleteFromBestDeals')->name('bestdeals-delete');
});

// ** Settings **//
Route::middleware(['auth', 'is_admin'])->group(function(){
    Route::get('/control/settings', 'Admin\SettingsController@index')->name('settings');
    Route::get('control/settings/brand-view-access', 'Admin\SettingsController@pageBrandAccess')->name('brand-view-access');
    Route::post('control/settings/access-brand-store', 'Admin\SettingsController@accessBrandStore')->name('access-brand-store');
    Route::post('control/settings/getBannedBrandView', 'Admin\SettingsController@getBannedBrandView');
    Route::post('control/settings/deleteFromBrandAccess', 'Admin\SettingsController@deleteFromBrandAccess');
    Route::get('control/settings/brand-view-percent', 'Admin\SettingsController@pageBrandPercent')->name('brand-view-percent');
    Route::post('control/settings/percent-brand-store', 'Admin\SettingsController@percentBrandStore')->name('percent-brand-store');
    Route::post('control/settings/getPercentBrandView', 'Admin\SettingsController@getPercentBrandView');
    Route::post('control/settings/deleteFromBrandPercent', 'Admin\SettingsController@deleteFromBrandPercent');
    Route::post('control/settings/toggle-retail-price', 'Admin\SettingsController@toggleRetailPrice')->name('toggle_retail_price');
    Route::post('control/settings/toggle-opt-price', 'Admin\SettingsController@toggleOptPrice')->name('toggle_opt_price');
});

// *** AUTOPITER PRICE-LIST ***//
Route::middleware(['auth', 'is_admin'])->group(function(){
    Route::get('/control/autopiter', 'Admin\ImportController@autopiter');
});

// *** PAGES ***//
Route::get('/contact', 'PageController@contact')->name('contact');
Route::get('/delivery', 'PageController@delivery')->name('delivery');
Route::get('/sezonnoe-hranenie', 'PageController@season_save')->name('season_save');
Route::get('/pravka-diskov', 'PageController@repair_wheels')->name('repair_wheels');
Route::get('/tires-rassrochka', 'PageController@tires_rassrochka')->name('tires_rassrochka');
Route::get('/trade-in', 'PageController@trade_in')->name('trade_in');

// *** YML FOR YANDEX MARKET ***//
Route::get('yandex-price-list', 'YMLController@index');