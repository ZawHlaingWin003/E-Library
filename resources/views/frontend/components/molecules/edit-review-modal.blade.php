<div class="modal fade" id="edit-review-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center align-items-center my-3 d-none" id="edit-form-loader">
                    <div class="custom-loader section-loader"></div>
                </div>
                <form method="POST" id="update-review-form">
                    <input type="hidden" name="review-id" id="update-review-id">

                    <x-form-group label="Book Review : ">
                        <x-form-textarea name="update-content" id="update-review-content"></x-form-textarea>
                    </x-form-group>
                    <x-main-button buttonId="update-review-button" iconId="update-review-button-icon" iconName="fa-comment" loaderId="update-review-button-loader">
                        Save Changes
                    </x-main-button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
