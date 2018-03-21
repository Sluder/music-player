
<div class="modal fade update-song-modal" id="update-song-modal-{{ $song->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p class="modal-title">Update song</p>

                <form action="{{ route('song.update', ['song' => $song->id]) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="song_name" class="grey">Song Name</label>
                                {{ Form::text('song_name', $song->name, ['class' => 'form-control', 'required' => true]) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn upload-submit" type="submit">Update</button>
                            <button class="btn cancel" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>