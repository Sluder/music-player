<?php

Route::get('/', 'PageController@index')->name('index.show');

Route::post('/upload', 'MusicController@upload')->name('upload');
