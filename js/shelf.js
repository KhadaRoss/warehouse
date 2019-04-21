let shelf = function () {
    let animating = false;
    const confirmation = $('#deletePopup');
    const confirmationLayer = $('.popupBackground');

    return {
        init: function () {
            $('#deleteButton').on('click', function () {
                confirmation.removeClass('hidden');
                confirmationLayer.removeClass('hidden');
            });
            $('.popup .no, .popup .yes').on('click', function () {
                confirmation.addClass('hidden');
                confirmationLayer.addClass('hidden');

                if ($(this).hasClass('yes')) {
                    request.request('deleteShelf', {id: $('#shelf').attr('data-shelfId')}, function () {
                        $('#backButton').click();
                    })
                }
            });
            $('#shelfTools .fa').on('click', function () {
                if (animating) {
                    return;
                }

                animating = true;
                let newFieldInput = $('#shelfTools input');

                $(this).toggleClass('active');
                $(newFieldInput).fadeToggle(400, function () {
                    animating = false;
                });
            });
        }
    }
}();

$(document).ready(function () {
    shelf.init();
});
