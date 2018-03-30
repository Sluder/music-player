@extends('layout.base')

@section('content')
    <div class="container">
        {{-- Youtube to MP3 conversion --}}
        @if (Auth::check())
            <div class="row hidden-xs">
                <div class="converter">
                    <form action="{{ route('convert') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="youtube_url" class="grey">Youtube URL</label>
                                {{ Form::text('youtube_url', null, ['class' => 'form-control', 'autofocus']) }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="song_name" class="grey">Song Name</label>
                                {{ Form::text('song_name', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button class="btn" type="submit">Convert</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- Music list --}}
        <div class="row">
            <div class="col-md-12">
                <div class="music-list">
                    <div class="row hidden-xs">
                        <div class="col-md-{{ Auth::check() ? 6 : 8 }}">
                            <p class="song-title grey">Song Name</p>
                        </div>
                        <div class="col-md-2">
                            <p class="song-length grey">Length</p>
                        </div>
                        <div class="col-md-2">
                            <p class="song-date grey">Date Added</p>
                        </div>
                    </div>
                    <ul class="list-group">
                        @forelse ($songs as $key => $song)
                            <li class="list-group-item">
                                <div class="song-item" id="{{ 'row-' . $song->id }}" style="background-color: {{ $key % 2 == 0 ? "#3a3939" : "#2f2f2f" }}">
                                    <audio id="{{ $song->id }}" src="{{str_replace(' ', '_', '/music/' . $song->filename) }}" onended="next()"></audio>
                                    <div class="row">
                                        <div onclick="play({{ '\'' . $song->id . '\'' }})">
                                            <div class="col-md-{{ Auth::check() ? 6 : 8 }} col-xs-12">
                                                <p class="title">{{ $song->name }}</p>
                                            </div>
                                            <div class="col-md-2 hidden-xs">
                                                <p class="length">{{ ltrim(date('h:i', strtotime($song->length)), '0') }}</p>
                                            </div>
                                            <div class="col-md-2 hidden-xs">
                                                <p class="date-added">{{ $song->created_at->toFormattedDateString() }}</p>
                                            </div>
                                        </div>
                                        @if (Auth::check())
                                            <div class="col-md-2 btns">
                                                <button class="fa-btn" data-toggle="modal" data-target="#delete-song-modal-{{ $song->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <button class="fa-btn" data-toggle="modal" data-target="#update-song-modal-{{ $song->id }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </div>
                                            @include('components.delete-song-modal', compact('song'))
                                            @include('components.update-song-modal', compact('song'))
                                        @endif
                                    </div>
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
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script type="text/javascript">
        var songs = {!! json_encode($songs->toArray()) !!};
        var played_stack = [];
        var current_song = null;
        var song_id = null;
        var playing = false;

        $(document).ready(function(){
            // Upload song modal
            $("#upload").change(function(){
                $(".upload-total").text($(this)[0].files.length + " songs selected");
            });

            $('#play-btn').click(function() {
                playing = true;

                if (current_song !== null) {
                    current_song.play();
                    played_stack = [];
                } else {
                    play({{ isset($songs->first()->id) ? $songs->first()->id : -1 }});
                }

                if ({!! json_encode(isset($songs->first()->id)) !!}) {
                    setBtn();
                }
            });

            $('#pause-btn').click(function() {
                playing = false;

                current_song.pause();

                setBtn();
            });

            $('#prev-btn').click(function() {
                played_stack.pop();

                if (played_stack.length !== 0) {
                    play(played_stack.pop());
                }
            });

            $('#next-btn').click(function() {
                next();
            });
        });

        /**
         * Play next song
         */
        function next()
        {
            if (current_song !== null) {
                play(songs[Math.floor(Math.random() * songs.length)]['id']);
            }
        }

        /**
         * Play selected song
         */
        function play(audio_id)
        {
            if (audio_id === -1) {
                return;
            }
            playing = true;

            played_stack.push(audio_id);

            if (current_song !== null) {
                current_song.pause();
            }

            $('#row-' + song_id).removeClass("playing");
            $('#row-' + audio_id).addClass("playing");

            song_id = audio_id;

            current_song = document.getElementById(audio_id);
            current_song.currentTime = 0;
            current_song.play();

            setBtn();
        }

        /**
         * Set button to play/pause
         */
        function setBtn()
        {
            if (playing) {
                $('#play-btn').css("display", "none");
                $('#pause-btn').css("display", "inline-block");
            } else {
                $('#play-btn').css("display", "inline-block");
                $('#pause-btn').css("display", "none");
            }
        }
    </script>
@endsection