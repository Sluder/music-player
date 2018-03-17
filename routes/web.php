<?php

Route::get('/', 'PageController@index')->name('show.index');

Route::post('/upload', 'MusicController@upload')->name('upload');
Route::post('/convert', 'MusicController@convert')->name('convert');
