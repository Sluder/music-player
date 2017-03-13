@extends('layout.base')

@section('content')

    <div class="music-list">
        <div class="container">
            <ul class="list-group">
                @for ($i = 0; $i < 20; $i++)
                    <li class="list-group-item">
                        @include('components.song-item')
                    </li>
                @endfor
            </ul>
        </div>
    </div>

@endsection