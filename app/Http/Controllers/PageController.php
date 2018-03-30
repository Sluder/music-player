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
        $songs = Song::orderBy('created_at', 'desc')->get();

        return view('pages.music-list', compact('songs'));
    }

}

