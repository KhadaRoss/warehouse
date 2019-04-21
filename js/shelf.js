let shelf = function () {
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
        }
    }
}();

$(document).ready(function () {
    shelf.init();
});
