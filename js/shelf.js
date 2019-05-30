let shelf = function () {
    let animating = false;
    let extendedFieldId;
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

                if ($(this).hasClass('no')) {
                    shelf.togglePopup(method, true);
                    return;
                }

                let closePopup = true;

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
                    case 'productFieldUpdate':
                        $(this).parents('.popup').find('input, textarea').each(function () {
                            let currentField = $(this);
                            currentField.removeClass('empty');
                            if (currentField.val().trim() === '') {
                                closePopup = false;
                                currentField.addClass('empty');
                            }
                        });

                        if (!closePopup) {
                            break;
                        }

                        let data = {
                            fieldId: extendedFieldId,
                            name: (method === 'productFieldAdd' ? $('#productName').val() : $('#productNameUpdate').val()),
                            quantity: (method === 'productFieldAdd' ? $('#productQuantity').val() : $('#productQuantityUpdate').val()),
                            date: (method === 'productFieldAdd' ? $('#productDate').val() : $('#productDateUpdate').val()),
                            comment: (method === 'productFieldAdd' ? $('#productComment').val() : $('#productCommentUpdate').val())
                        };

                        if (method === 'productFieldUpdate') {
                            data.id = $(this).parents('.popup').find('.headline').attr('data-productId');
                        }

                        request.request(method, data, function (productId) {
                            shelf.loadProducts(
                                $('.field[data-fieldId="' + extendedFieldId + '"]').find('.fieldContent'),
                                productId
                            );
                        });
                        break;
                }

                if (closePopup) {
                    shelf.togglePopup(method,  true);
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
                extendedFieldId = field.attr('data-fieldid');

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

                shelf.openFieldContent(content, undefined);
            });
        },
        /**
         * @param {object} button
         */
        initPopupButton: function (button) {
            button.on('click', function () {
                shelf.togglePopup($(this).attr('data-method'), true);
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
         * @param {boolean} clearInputs
         */
        togglePopup: function (id, clearInputs) {
            let popup = $('#' + id);

            if (popup.hasClass('hidden') && clearInputs) {
                popup.find('input, textarea').val('').removeClass('empty');
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
            this.loadProducts(content.find('.fieldContent'), undefined);
        },
        /**
         * @param {object} content
         * @param {int} scrollToProductId
         */
        loadProducts: function (content, scrollToProductId) {
            request.request('getProductsByFieldId', {id: extendedFieldId}, function (products) {
                content.find('.product').remove();
                $(JSON.parse(products)).each(function () {
                    $('<div class="product" data-productid="' + this.id + '">' + this.name + ' (' + this.quantity + ')<div class="fa fa-trash deleteProduct"></div></div>').appendTo(content);
                });

                shelf.initProductEventHandlers();
                shelf.openFieldContent(content.parents('.fieldSlider'), scrollToProductId)
            });
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
         * @param {int} scrollToProductId
         */
        openFieldContent: function (content, scrollToProductId) {
            if (animating || (content.hasClass('extended') && typeof scrollToProductId === 'undefined')) {
                return;
            }

            let scrollToElement = undefined;

            if (typeof scrollToProductId !== 'undefined') {
                scrollToElement = $('.product[data-productid="' + scrollToProductId + '"]');
            }

            if (content.hasClass('extended') && typeof scrollToElement !== 'undefined') {
                this.scrollElementIntoView(scrollToElement);
                return;
            }

            const openFields = $('.fieldSlider.extended');

            function open(content) {
                animating = true;
                content.slideDown(400, function () {
                    animating = false;
                    content.addClass('extended');
                    if (typeof scrollToProductId !== 'undefined') {
                        shelf.scrollElementIntoView(scrollToElement);
                    }
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
         * @param {object} scrollToElement
         */
        scrollElementIntoView: function (scrollToElement) {
            $([document.documentElement, document.body]).animate({
                scrollTop: scrollToElement.offset().top - 200
            }, 1000, function () {
                scrollToElement.addClass('highlight');
                setTimeout(function () {
                    scrollToElement.removeClass('highlight');
                }, 2000);
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
        },
        /**
         * @return void
         */
        initProductEventHandlers: function () {
            $('.product:not(.popup)').on('click', function (e) {
                if ($(e.target).hasClass('deleteProduct')) {
                    request.request('deleteProduct', {id: $(this).attr('data-productId'), fieldId: extendedFieldId}, function (product) {
                        shelf.loadProducts($('.field[data-fieldId="' + extendedFieldId + '"]').find('.fieldContent'), undefined);
                    });
                } else {
                    request.request('getProductInformation', {id: $(this).attr('data-productId')}, function (product) {
                        shelf.fillProductPopup(JSON.parse(product));
                    });
                }
            });
        },
        /**
         * @param {object} product
         */
        fillProductPopup: function (product) {
            let popup = $('#productFieldUpdate');

            popup.find('.headline').attr('data-productid', product.id);
            popup.find('#productNameUpdate').val(product.name);
            popup.find('#productQuantityUpdate').val(product.quantity);
            popup.find('#productDateUpdate').val(product.date);
            popup.find('#productCommentUpdate').val(product.comment);

            this.togglePopup('productFieldUpdate', false);
        }
    };
}();

$(document).ready(function () {
    shelf.init();
});
