<?php


     Route::get('{user}/{id}/{type}', 'Api\AssetController@index');

Route::group([

    'prefix' => 'auth',
    'namespace' => 'Api\Auth',

], function () {

	/* ====================== Auth for Admin ====================== */
    Route::post('admin/login', 'AuthController@login');
    Route::post('admin/logout', 'AuthController@logout');
    Route::post('admin/refresh', 'AuthController@refresh');
    Route::post('admin/me', 'AuthController@me');
    Route::post('admin/register', 'AuthController@register');


    /* ====================== Auth for Customer ====================== */

    Route::post('customer/login', 'CustomerAuthController@login');
    Route::post('customer/register', 'CustomerAuthController@register');
    Route::post('customer/logout', 'CustomerAuthController@logout');
    Route::post('customer/refresh', 'CustomerAuthController@refresh');
    Route::post('customer/me', 'CustomerAuthController@me');


    /* ====================== Auth for Cleaner ====================== */


    Route::post('cleaner/login', 'CleanerAuthController@login');
    Route::post('cleaner/register', 'CleanerAuthController@register');
    Route::post('cleaner/logout', 'CleanerAuthController@logout');
    Route::post('cleaner/refresh', 'CleanerAuthController@refresh');
    Route::post('cleaner/me', 'CleanerAuthController@me');

});


Route::group([
 'prefix' => 'customer'
], function () {



     Route::group([       
                'prefix' => 'password'
            ], function () {    
                Route::post('create', 'api\Customer\PasswordResetController@create');
                Route::get('find/{token}', 'api\Customer\PasswordResetController@find');
                Route::post('reset', 'api\Customer\PasswordResetController@reset')->name('passwordresetcustomer');
            });

   
     //route binding here

    Route::group([

    'prefix' => 'profile',
    'namespace' => 'Api\Customer',

], function () {

        Route::post('/update', 'ProfileController@update');
    });

    /* ====================== CRUD Order ====================== */

Route::group([

    'prefix' => 'orders'

], function () {

    /* ====================== CRUD Order ====================== */
        Route::post('/create', 'api\Customer\OrderController@store');
        Route::post('/update/{id}', 'api\Customer\OrderController@update');//change order
        Route::delete('/delete/{order}', 'api\Customer\OrderController@delete');
        Route::get('/show/{order}', 'api\Customer\OrderController@show');
        Route::get('/index/{customer}', 'api\Customer\OrderController@index');// remove index

    });


 Route::group([

        'prefix' => 'proposal',
        'namespace' => 'Api\Customer',

    ], function () {

            Route::get('/{customer}/index', 'ProposalController@index');
                // customer/1/proposals

             Route::post('/reject', 'ProposalController@reject');

             Route::post('/approve', 'ProposalController@approve');

        });
});


        
  Route::group([
        'prefix' => 'cleaner'
        ], function () {

             Route::group([        
                'prefix' => 'notification',
                'namespace' => 'Api\Cleaner'
            ], function () {    
                Route::post('index', 'NotificationController@index');// change here
                Route::post('unread', 'NotificationController@unread');
                Route::post('read', 'NotificationController@read');
                Route::get('show/{notification}', 'NotificationController@show');
            });

            Route::group([        
                'prefix' => 'tracking',
                'namespace' => 'Api\Cleaner'
            ], function () {    
                Route::post('update', 'TrackingController@update');
            });

             Route::group([        
                'prefix' => 'availability',
                'namespace' => 'Api\Cleaner'
            ], function () {    
                Route::post('update', 'AvailabilityController@update');
            });


            Route::group([        
                'prefix' => 'password'
            ], function () {    
                Route::post('create', 'Api\Cleaner\PasswordResetController@create');
                Route::get('find/{token}', 'Api\Cleaner\PasswordResetController@find');
                Route::post('reset', 'Api\Cleaner\PasswordResetController@reset')->name('passwordresetcleaner');
            });



         Route::group([

                    'prefix' => 'orders'

                ],
                function () {
                    Route::get('/index', 'Api\Cleaner\OrderController@index');
                    Route::get('/show/{id}', 'Api\Cleaner\OrderController@show');

                });


          Route::group([

                'prefix' => 'profile/update',
                'namespace' => 'Api\Cleaner',

            ], function () {
                    Route::post('/personal', 'ProfileController@updatePersonalProfile');
                     Route::post('/professional', 'ProfileController@updateProfessionalProfile');

                });


            Route::group([

                'prefix' => 'proposal',
                'namespace' => 'Api\Cleaner',

            ], function () {

                    Route::post('/create', 'ProposalController@create');
                    Route::get('/index/{cleaner}', 'ProposalController@index');

                    Route::post('/withdraw', 'ProposalController@withdraw');
                });
    });