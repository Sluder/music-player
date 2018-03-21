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

                    Song::updateOrCreate(['name'], [
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
        $filename = str_replace(' ', '_', request('song_name'));

        shell_exec("youtube-dl -x -o ./music/\"" . $filename . ".%(ext)s\" --audio-format mp3 " . request('youtube_url'));

        $getID3 = new \getID3();
        $duration = $getID3->analyze(public_path('music/') . $filename . ".mp3")['playtime_string'];

        Song::create([
            'name' => request('song_name'),
            'filename' => $filename . ".mp3",
            'length' => $duration
        ]);

        return redirect()->route('show.index');
    }

    /**
     * Delete song from playlist
     */
    public function delete(Song $song)
    {
        $song->delete();

        unlink(public_path('music/') . $song->filename);

        return redirect()->route('show.index');
    }

    /**
     * Update song from playlist
     */
    public function update(Song $song)
    {
        $song->update([
            'name' => request('song_name')
        ]);

        return redirect()->route('show.index');
    }

}
