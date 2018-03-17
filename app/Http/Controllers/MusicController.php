<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    /**
     * Handler for uploading songs
     */
    public function upload(Request $request)
    {
        if ($request->has('songs')) {
            foreach ($request->file('songs') as $song) {
                if (!Song::where('name', explode('.', $song->getClientOriginalName())[0])->exists()) {
                    $filename = str_replace(' ', '_', $song->getClientOriginalName());
                    $song->move(public_path('music/'), $filename);

                    $getID3 = new \getID3();
                    $duration = $getID3->analyze(public_path('music/') . $filename)['playtime_string'];

                    Song::create([
                        'name' => explode('.', $song->getClientOriginalName())[0],
                        'filename' => $filename,
                        'length' => $duration
                    ]);
                }
            }

            return redirect()->route('show.index');
        }
    }

    /**
     * Converts Youtube URL to MP3 and adds to music list
     */
    public function convert()
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://savedeo.p.mashape.com/download');
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'X-Mashape-Key: 2j5ILBSm54mshmu5faroGNBKsEG2p1FG0YCjsnrUWXUIfL6NAH',
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json',
        ]);

        dd(json_decode(curl_exec($curl))->result);
    }

}
