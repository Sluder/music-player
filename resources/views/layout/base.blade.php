<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Music.z</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    </head>

    <body>
        <nav class="navbar navbar-fixed-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 hidden-xs">
                        <div class="navbar-header">
                            <a href="{{ route('google.login') }}">
                                <h3>Music.z</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 center">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn prev-btn" id="prev-btn">
                                    <span class="fa fa-step-backward" aria-hidden="true"></span>
                                </button>
                                <button class="btn play-btn" id="play-btn">
                                    <span class="fa fa-play" aria-hidden="true"></span>
                                </button>
                                <button class="btn pause-btn" id="pause-btn" style="display: none">
                                    <span class="fa fa-pause" aria-hidden="true"></span>
                                </button>
                                <button class="btn next-btn" id="next-btn">
                                    <span class="fa fa-step-forward" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @if (Auth::check())
                        <div class="col-md-4 hidden-xs">
                            <button class="btn upload-btn" data-toggle="modal" data-target="#upload-song-modal">
                                <span class="fa fa-plus-circle" aria-hidden="true"></span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <div class="content">
            @yield('content')
        </div>

        @if (Auth::check())
            @include('components.upload-song-modal')
        @endif

        {{-- Scripts --}}
        <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

        @yield('scripts')
    </body>
</html>