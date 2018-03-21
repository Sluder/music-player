
<div class="modal fade upload-song-modal" id="upload-song-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p class="modal-title">Upload Music</p>

                <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <label for="upload" class="btn upload">Choose</label>
                            <p class="upload-total">No songs selected</p>
                            <input name="songs[]" id="upload" class="file-upload" type="file" multiple required>
                        </div>
                        <div class="col-md-6">
                            <button class="btn upload-submit" type="submit">
                                Upload
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>