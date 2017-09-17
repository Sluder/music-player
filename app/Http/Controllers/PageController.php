<?php

namespace App\Http\Controllers;

use App\Song;

class PageController extends Controller
{
    public function index()
    {
        $songs = Song::all();

        return view('pages.music-list', compact('songs'));
    }

}

