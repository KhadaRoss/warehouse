let sidebar = function () {
    const input = $('#sidebar input');
    const toolbox = $('#menuTools');
    let animating = false;

    return {
        /**
         * @return {void}
         */
        initTools: function () {
            $('.inputTrigger').on('click', function () {
                sidebar.handleToolClick(this.id);
            });
            $('#toolInput').keyup(function (e) {
                const mode = input.attr('data-mode');
                const name = input.val();


                if (e.keyCode !== 13 || typeof mode === 'undefined' || !name || !mode) {
                    return;
                }

                request.request(mode + 'Shelf', {name: name}, function (data) {
                    switch (mode) {
                        case 'new':
                            sidebar.onNewShelf(data, name);
                            break;
                        default:
                            break;
                    }
                });
            });
        },

        /**
         * @param {number} id
         * @param {string} name
         */
        onNewShelf: function (id, name) {
            const entry = $(
                '<div class="entry">' +
                '    <a id="shelf_'+ id +'" href="' + env.getWebPath() + 'shelf/show/' + id + '" class="">' + name + '</a>\n' +
                '</div>'
            );

            entry.appendTo($('#menuEntries'));
            this.hideInput(function () {
            });
        },

        /**
         * @param {string} mode
         */
        handleToolClick: function (mode) {
            const currentMode = input.attr('data-mode');

            if (currentMode === '') {
                this.showInput(mode);
                return;
            }

            this.hideInput(function () {
                if (currentMode === mode) {
                    return;
                }

                sidebar.showInput(mode);
            });
        },
        /**
         * @param {function} callback
         */
        hideInput: function (callback) {
            if (animating) {
                return;
            }

            animating = true;
            input.attr('data-mode', '');
            input.val('');
            input.fadeOut(400, function () {
                animating = false;
                $('#menuTools div').removeClass('active');
                toolbox.animate({height: 33});
                callback();
            });
        },
        /**
         * @param {string} mode
         */
        showInput: function (mode) {
            if (animating) {
                return;
            }

            animating = true;
            const tool = $('#menuTools div#' + mode);
            tool.addClass('active');
            toolbox.animate({height: 67}, 400, function () {
                animating = false;
                input.attr('data-mode', mode);
                input.attr('placeholder', tool.attr('title'));
                input.fadeIn();
            });
        }
    }
}();

$(document).ready(function () {
    sidebar.initTools();
});
