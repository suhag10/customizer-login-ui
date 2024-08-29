(function ($) {
    $(document).ready(function ($) {
        $('input[data-input-type]').on('input change', function () {
            var val = $(this).val();
            $(this).prev('.range-value').html(val);
            $(this).val(val);
        });
    })
})(jQuery);