<?php

namespace App\Http\Controllers;

use App\Song;
use Illuminate\Http\Request;
use wapmorgan\Mp3Info\Mp3Info;

class MusicController extends Controller
{
    // Handler for uploading songs
    public function upload(Request $request)
    {
        if ($request->has('songs')) {
            foreach ($request->file('songs') as $song) {
                if (!Song::where('name', explode('.', $song->getClientOriginalName())[0])->exists()) {
                    $filename = time() . '_' . str_replace(' ', '_', $song->getClientOriginalName());
                    $song->move(public_path('music/'), $filename);

                    $audio_info = new Mp3Info(public_path('music/') . $filename, true);

                    Song::create([
                        'name' => explode('.', $song->getClientOriginalName())[0],
                        'filename' => $filename,
                        'length' => floor($audio_info->duration / 60) . ':' . floor($audio_info->duration % 60)
                    ]);
                }
            }

            return redirect()->route('index.show');
        }
    }

}
