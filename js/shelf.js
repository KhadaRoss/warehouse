let shelf = function () {
    let animating = false;
    const shelfInput = $('#shelfTools input');
    const confirmation = $('#deletePopup');
    const confirmationLayer = $('.popupBackground');

    return {
        /**
         * @return void
         */
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
            shelfInput.keyup(function (e) {
                let name = shelfInput.val();
                
                if (e.keyCode !== 13 || !name) {
                    return;
                }

                const parameters = {
                    name: name,
                    shelfId: $('#shelf').attr('data-shelfId')
                };

                request.request('newField', parameters, function () {
                    location.reload();
                })
            });
            $('.field').on('click', function () {
                let field = $(this);

                field.siblings().each(function () {
                    shelf.closeFieldContent($(this).find('.fieldContent'));
                });

                if (!field.hasClass('hasContent')) {
                    shelf.appendFieldContent(field);
                }

                let content = field.find('.fieldContent');

                if (content.hasClass('extended')) {
                    shelf.closeFieldContent(content);
                    return;
                }

                shelf.openFieldContent(content);
            });
        },
        /**
         * @param {object} field
         */
        appendFieldContent: function (field) {
            const content = $('<div class="fieldContent hidden">content</div>');
            content.appendTo(field);
            field.addClass('hasContent');
            this.openFieldContent(content);
        },
        /**
         * @param {object} content
         */
        openFieldContent: function (content) {
            content.slideDown(400, function () {
                content.addClass('extended');
            });
        },
        /**
         * @param {object} content
         */
        closeFieldContent: function (content) {
            content.slideUp(400, function () {
                content.removeClass('extended');
            })
        }
    }
}();

$(document).ready(function () {
    shelf.init();
});
