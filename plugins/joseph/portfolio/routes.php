<?php

use Joseph\Portfolio\Models\Gallery;


use Illuminate\Http\Request;

Route::options('/{any}', function() {
    $headers = [
        'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
        'Access-Control-Allow-Headers'=> 'X-Requested-With, Content-Type, X-Auth-Token, Origin, Authorization'
    ];
    return \Response::make('You are connected to the API', 200, $headers);
})->where('any', '.*');

Route::get('api/gallery', function() {
    $gallery = Gallery::with(['photo'])->get();

    return $gallery;
});