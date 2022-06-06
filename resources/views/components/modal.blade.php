@props(['id'])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="modalFullScreen"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="modalFullScreen">{{ __('Confirm Order') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <div id="footer-order-confirm"></div>
            </div>
        </div>
    </div>
</div>