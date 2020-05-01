<?php

Auth::routes();

        /*------------------- admin ---------------------*/
Route::group(['as' => 'admin.','prefix' => 'admin', 'namespace' => 'Admin', 'middleware'=>['auth', 'admin']], function (){

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    // Product controller routes
    Route::get('product', 'ProductController@index')->name('product');
    Route::post('product/insert', 'ProductController@productInsert')->name('productInsert');
    Route::get('product/edit/{product_id}', 'ProductController@productEdit');
    Route::post('product/edit/{id}', 'ProductController@productUpdate');
    Route::get('product/delete/{product_id}', 'ProductController@productDelete');
    Route::get('product/active/{product_id}', 'ProductController@active');
    Route::get('product/deactive/{product_id}', 'ProductController@deactive');


    // DiscountRules controller routes
    Route::get('discountrule', 'DiscountruleController@index')->name('discountrule');
    Route::post('discountrule/insert', 'DiscountruleController@discountruleInsert')->name('discountruleInsert');
    Route::get('discountrule/edit/{discountrule_id}', 'DiscountruleController@discountruleEdit');
    Route::post('discountrule/edit/{id}', 'DiscountruleController@discountruleUpdate');
    Route::get('discountrule/delete/{discountrule_id}', 'DiscountruleController@discountruleDelete');
    Route::get('discountrule/active/{discountrule_id}', 'DiscountruleController@active');
    Route::get('discountrule/deactive/{discountrule_id}', 'DiscountruleController@deactive');


    // packages controller routes
    Route::get('packages', 'PackagesController@index')->name('packages');
    Route::post('packages/insert', 'PackagesController@packagesInsert')->name('packagesInsert');
    Route::get('packages/edit/{packages_id}', 'PackagesController@packagesEdit');
    Route::post('packages/edit/{id}', 'PackagesController@packagesUpdate');
    Route::get('packages/delete/{packages_id}', 'PackagesController@packagesDelete');

    //marketing controller routes
    Route::get('marketing', 'MarketingController@index')->name('marketing');

    //Setting routes
    Route::get('setting', 'SettingController@index')->name('setting');
    Route::post('setting/insert', 'SettingController@settingInsert')->name('settingInsert');
    Route::get('setting/edit/{setting_id}', 'SettingController@settingEdit');
    Route::post('setting/edit/{id}', 'SettingController@settingUpdate');
    Route::get('setting/delete/{setting_id}', 'SettingController@settingDelete');

    //Coupon route
    Route::get('coupon', 'CouponController@index')->name('coupon');
    Route::post('coupon/insert', 'CouponController@couponInsert')->name('couponInsert');
    Route::get('coupon/edit/{coupon_id}', 'CouponController@couponEdit');
    Route::post('coupon/edit/{id}', 'CouponController@couponUpdate');
    Route::get('coupon/delete/{coupon_id}', 'CouponController@couponDelete');

    // Order or Invoice route
    Route::get('order', 'OrderController@index')->name('order');
    Route::get('invoice/{id}', 'OrderController@generateInvoice')->name('order.invoice');
    Route::get('order/delete/{order_id}', 'OrderController@orderDelete');


});
        // ------------------- Frontend ---------------------

//FrontendController Routes
Route::get('/' , 'FrontendController@index')->name('frontend.home');

Route::group(['middleware' => ['auth', 'user']], function (){

    Route::get('user/profile' , 'FrontendController@userProfile')->name('user.profile');
    Route::post('user/profile/edit/{id}', 'UserProfileController@profileEdit');

    Route::get('package/buy/{id}' , 'BuyController@index')->name('package.buy');

    Route::get('package/buy/{id}/{coupon_code}' , 'BuyController@index')->name('packageBuyCoupon');

    Route::get('package/buy/{id}/{coupon_code1}/{coupon_code2}' , 'BuyController@doubleCoupon');

    Route::post('package/store' , 'BuyController@packageStore')->name('package.store');
    Route::get('package/order-thanks' , 'BuyController@orderThanks')->name('order.thanks');


//    Route::get('package/buy/{id}/quantity/{quantity}' , 'BuyController@updateQuantity');
    Route::get('calculateQty/{quantity?}' , 'BuyController@updateQuantity')->name('calculateQty');



});






