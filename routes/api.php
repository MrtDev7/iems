
<?php

use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'services'], function () {

    Route::group(['prefix' => 'linode'], function () {

        Route::get('/', 'LinodeController@getLinodes');
        Route::get('/{linodeId}', 'LinodeController@getLinodeById');
        Route::post('/create', 'LinodeController@create');
        Route::post('/update/{accountId}', 'LinodeController@update');
        Route::delete('{linodeId}', 'LinodeController@delete');

    });

    Route::group(['prefix' => 'hetzner'], function () {

      Route::get('/', 'HetznerController@getAccounts');
      Route::post('/create' ,  'HetznerController@create');
      Route::post('/update/{id}' ,  'HetznerController@update');
      Route::delete('/{id}' ,  'HetznerController@delete');

    });

    Route::group(['prefix' => 'ips'], function () {

        Route::post('testIp', 'IpController@testIp');
        Route::post('configIp', 'IpController@configIp');
        Route::post('config-hetzner-server' , 'IpController@configHetznerServer');
        Route::post('test-hetzner-server' , 'IpController@testHetznerServer');

    });

});

Route::group(['prefix' => 'tools'], function () {
   Route::post('/spam-clause', 'ToolsContoller@spamClause');
});

