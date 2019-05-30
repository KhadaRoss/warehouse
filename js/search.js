let search = function () {

    return {
        init: function () {
            $('.product').on('click', function () {
                let fieldId = $(this).attr('data-fieldId');
                let productId = $(this).attr('data-productId');
                let shelfId = $(this).attr('data-shelfId');
                window.location.href = env.getWebPath() + 'shelf/show/' + shelfId + '/open/' + fieldId + '/' + productId
            });
        }
    };
}();

$(document).ready(function () {
    search.init();
});
