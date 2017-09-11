@extends('layout.base')

@section('content')
    <div class="music-list">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <p class="song-title">Song Name</p>
                </div>
                <div class="col-md-2">
                    <p class="song-length">Length</p>
                </div>
                <div class="col-md-2">
                    <p class="song-date">Date Added</p>
                </div>
            </div>
            <ul class="list-group">
                @forelse ($songs as $key => $song)
                    <li class="list-group-item">
                        <div class="song-item" id="{{ 'row-' . $song->id }}" style="background-color: {{ $key % 2 == 0 ? "#3a3939" : "#2f2f2f" }}" onclick="play({{ '\'' . $song->id . '\'' }})">
                            <div class="row">
                                <div class="col-md-8">
                                    <p class="title">{{ $song->name }}</p>
                                </div>
                                <div class="col-md-2">
                                    <p class="length">{{ ltrim(date('h:i', strtotime($song->length)), '0') }}</p>
                                </div>
                                <div class="col-md-2">
                                    <p class="date-added">{{ $song->created_at->toFormattedDateString() }}</p>
                                </div>
                            </div>
                            <audio id="{{ $song->id }}" src="{{str_replace(' ', '_', '/music/' . $song->filename) }}"></audio>
                        </div>
                    </li>
                @empty
                    <li class="list-group-item">
                        <div class="song-item empty">
                            <div class="row">There are no songs to show</div>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        var songs = {!! json_encode($songs->toArray()) !!};
        var played_stack = [];
        var current_song = null;
        var song_id = null;

        {{-- upload-song-modal --}}
        $(document).ready(function(){
            $("#upload").change(function(){
                $(".upload-total").text($(this)[0].files.length + " songs selected");
            });

            $('#play-btn').click(function() {
                if (current_song !== null) {
                    current_song.play();
                    setPauseBtn();

                    played_stack = [];
                }
            });

            $('#pause-btn').click(function() {
                current_song.pause();
                setPlayBtn();
            });

            $('#prev-btn').click(function() {
                played_stack.pop();

                if (played_stack.length !== 0) {
                    play(played_stack.pop());
                }
            });

            $('#next-btn').click(function() {
                if (current_song !== null) {
                    var next = songs[Math.floor(Math.random() * songs.length)];

                    play(next['id']);
                }
            });
        });

        // Play selected song
        function play(audio_id)
        {
            played_stack.push(audio_id);

            if (current_song !== null) {
                current_song.pause();
                setPlayBtn();
            }

            $('#row-' + song_id).removeClass("playing");
            $('#row-' + audio_id).addClass("playing");
            song_id = audio_id;

            current_song = document.getElementById(audio_id);
            current_song.currentTime = 0;
            current_song.play();

            setPauseBtn();
        }

        // Sets controls to pause btn
        function setPauseBtn()
        {
            $('#play-btn').css("display", "none");
            $('#pause-btn').css("display", "inline-block");
        }

        // Sets controls to play btn
        function setPlayBtn()
        {
            $('#play-btn').css("display", "inline-block");
            $('#pause-btn').css("display", "none");
        }
    </script>
@endsection