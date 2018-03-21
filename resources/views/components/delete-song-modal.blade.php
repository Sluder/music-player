
<div class="modal fade delete-song-modal" id="delete-song-modal-{{ $song->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p class="modal-title">Delete song?</p>

                <form action="{{ route('song.delete', ['song' => $song->id]) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn upload-submit" type="submit">Delete</button>
                            <button class="btn cancel" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>