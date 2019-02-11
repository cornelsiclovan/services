$(document).ready(function() {
    var $serviceSelect = $('.js-service-form');
    var $subServiceTarget = $('.js-sub-service-target');
    $serviceSelect.on('change', function(e) {
        console.log($serviceSelect.val());
        console.log($serviceSelect.data('sub-service-url'))
        $.ajax({
            url: $serviceSelect.data('sub-service-url'),
            data: {
                service: $serviceSelect.val()
            },
            success: function (html) {
                if (!html) {
                    $subServiceTarget.find('select').remove();
                    $subServiceTarget.addClass('d-none');
                    return;
                }
                // Replace the current field and show
                $subServiceTarget
                    .html(html)
                    .removeClass('d-none')
            }
        });
    });
});