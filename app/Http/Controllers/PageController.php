<?php

namespace App\Http\Controllers;

use App\Models\Song;

class PageController extends Controller
{
    /**
     * Music list showing all songs
     */
    public function index()
    {
        $songs = Song::all();

        return view('pages.music-list', compact('songs'));
    }

}

