jQuery(document).ready(function() {
    $('.js-remove-property').on('click', function (e) {
        e.preventDefault();

        var $el = $(this).closest('tr');
        $(this).find('.fa-trash')
            .removeClass('fa-trash')
            .addClass('fa-spinner')
            .addClass('fa-spin');

        $.ajax({
            url: $(this).data('url'),
            method: 'DELETE'
        }).done(function () {
            $el.fadeOut();
        });
    });
});