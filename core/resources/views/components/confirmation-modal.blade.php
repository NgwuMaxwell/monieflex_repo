<div id="confirmationModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Confirmation Alert!')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="question"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                    <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')

<script>
    (function ($) {
        "use strict";
        $(document).on('click','.confirmationBtn', function () {
            var modal   = $('#confirmationModal');
            let data    = $(this).data();
            modal.find('.question').text(`${data.question}`);
            modal.find('form').attr('action', `${data.action}`);
            
            // Remove any existing method input
            modal.find('input[name="_method"]').remove();
            
            // Add method input based on the action URL
            let action = data.action;
            if (action.includes('/destroy/') || action.includes('/delete/') || action.includes('/reject/')) {
                modal.find('form').append('<input type="hidden" name="_method" value="DELETE">');
            } else {
                // For approve actions and others, use POST
                modal.find('form').append('<input type="hidden" name="_method" value="POST">');
            }
            
            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush
