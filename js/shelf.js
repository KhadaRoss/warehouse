let shelf = function () {
    let animating = false;
    const shelfInput = $('#shelfTools input');
    const popupBackground = $('.popupBackground');

    return {
        /**
         * @return void
         */
        init: function () {
            this.initPopupButton($('.deleteButton'));

            $(document).keyup(function (e) {
                const activePopup = $('.popup:not(.hidden)');

                if (activePopup.length < 1) {
                    return;
                }

                if (e.keyCode === 27) {
                    activePopup.find('.confirmation .no').click();
                }

                if (e.keyCode === 13) {
                    activePopup.find('.confirmation .yes').click();
                }
            });
            $('.popup .no, .popup .yes').on('click', function () {
                const method = $(this).parents('.popup').attr('id');

                shelf.togglePopup(method);

                if ($(this).hasClass('no')) {
                    return;
                }

                switch (method) {
                    case 'deleteShelf':
                        request.request(method, {id: $('#shelf').attr('data-shelfId')}, function () {
                            $('#backButton').click();
                        });
                        break;
                    case 'deleteField':
                        let id = $('.fieldSlider.extended').parents('.field').attr('data-fieldId');
                        request.request(method, {id: id}, function () {
                            location.reload();
                        });
                        break;
                    case 'productFieldAdd':
                        let data = {
                            name: $('#productName').val(),
                            quantity: $('#productQuantity').val(),
                            date: $('#productDate').val(),
                            comment: $('#productComment').val()
                        };

                        request.request(method, data, function (products) {
                        });
                        break;
                }
            });
            $('#shelfTools .fa').on('click', function () {
                if (animating) {
                    return;
                }

                animating = true;
                let newFieldInput = $('#shelfTools input');

                const addButton = $(this);
                addButton.toggleClass('active');
                if (addButton.hasClass('active')) {
                    newFieldInput.val('');
                }

                $(newFieldInput).fadeToggle(400, function () {
                    if (addButton.hasClass('active')) {
                        newFieldInput.focus();
                    }
                    animating = false;
                });
            });
            shelfInput.keyup(function (e) {
                let name = shelfInput.val();
                
                if (e.keyCode === 13 && name.length > 0) {
                    shelf.addField(name, $('#shelf').attr('data-shelfId'));
                }
            });
            $('.fieldHeadline').on('click', function () {
                let field = $(this).parent();

                if (!field.hasClass('hasContent')) {
                    shelf.appendFieldContent(field);
                    shelf.appendFieldTools(field);
                }

                let content = field.find('.fieldSlider');

                if (content.hasClass('extended')) {
                    shelf.closeFieldContent(content, function () {
                    });
                    return;
                }

                shelf.openFieldContent(content);
            });
        },
        /**
         * @param {object} button
         */
        initPopupButton: function (button) {
            button.on('click', function () {
                shelf.togglePopup($(this).attr('data-method'));
            });
        },
        /**
         * @param {string} name
         * @param {number} id
         */
        addField: function (name, id) {
            request.request('newField', {name: name, shelfId: id}, function () {
                location.reload();
            });
        },
        /**
         * @param {string} id
         */
        togglePopup: function (id) {
            let popup = $('#' + id);

            if (popup.hasClass('hidden')) {
                popup.find('input, textarea').val('');
            }

            popup.toggleClass('hidden');
            popupBackground.toggleClass('hidden');
        },
        /**
         * @param {object} field
         */
        appendFieldContent: function (field) {
            const content = $('' +
                '<div class="fieldSlider hidden">' +
                    '<div class="fieldContent">' +
                        '<div class="productButtonAdd" id="addProduct" data-method="productFieldAdd">' +
                            '<span>' + strings['NEW_PRODUCT'] + '</span>' +
                        '</div>' +
                    '</div>' +
                '</div>'
            );
            content.appendTo(field);
            this.initPopupButton($('.productButtonAdd'));
            field.addClass('hasContent');
            this.openFieldContent(content);
        },
        /**
         * @param {object} field
         */
        appendFieldTools: function (field) {
            let tools = $('<div class="fieldTools"></div>');
            let deleteField = $('<div class="fieldTool deleteButton fa fa-trash" data-method="deleteField"></div>');

            deleteField.appendTo(tools);
            tools.prependTo(field.find('.fieldSlider'));
            this.initPopupButton(deleteField);
        },
        /**
         * @param {object} content
         */
        openFieldContent: function (content) {
            if (animating) {
                return;
            }

            const openFields = $('.fieldSlider.extended');

            function open(content) {
                animating = true;
                content.slideDown(400, function () {
                    animating = false;
                    content.addClass('extended');
                });
            }

            if (openFields.length === 0) {
                open(content);
                return;
            }

            shelf.closeFieldContent(openFields, function () {
                open(content);
            });
        },
        /**
         * @param {object}   content
         * @param {function} callback
         */
        closeFieldContent: function (content, callback) {
            if (animating) {
                return;
            }

            animating = true;
            content.slideUp(400, function () {
                animating = false;
                content.removeClass('extended');
                callback();
            })
        }
    }
}();

$(document).ready(function () {
    shelf.init();
});
