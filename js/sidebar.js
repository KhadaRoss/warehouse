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
                if (env.isSmallDevice()) {
                    sidebar.handleToolClickMobile(this.id);
                } else {
                    sidebar.handleToolClick(this.id);
                }
            });
            $('#toolInput').keyup(function (e) {
                const mode = input.attr('data-mode');
                const name = input.val();

                if (e.keyCode !== 13 || typeof mode === 'undefined' || !name || !mode) {
                    return;
                }

                switch (mode) {
                    case 'search':
                        window.location.href = env.getWebPath() + 'search/' + name.trim().replace(/\s/g, "~");
                        break;
                    case 'new':
                        request.api('POST', 'shelf', {name: name}, function (data) {
                            sidebar.onNewShelf(data);
                        });
                        break;
                    default:
                        break;
                }
            });
        },

        /**
         * @param {object} data
         */
        onNewShelf: function (data) {
            const entry = $(
                '<div class="entry">' +
                '    <a id="shelf_' + data.id + '" href="' + env.getWebPath() + 'shelf/' + data.id + '" class="">' + data.name + '</a>\n' +
                '</div>'
            );

            entry.appendTo($('#menuEntries'));

            const callback = function () {
            };

            if (env.isSmallDevice()) {
                this.hideInputMobile(callback);
            }
            this.hideInput(callback);
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
                input.focus();
            });
        },
        /**
         * @param {string} mode
         */
        handleToolClickMobile: function (mode) {
            const currentMode = input.attr('data-mode') || '';

            if (currentMode === '') {
                this.showInputMobile(mode);
                return;
            }

            this.hideInputMobile(function () {
                if (currentMode === mode) {
                    return;
                }

                sidebar.showInputMobile(mode);
            });
        },
        /**
         * @param {string} mode
         */
        showInputMobile: function (mode) {
            if (animating) {
                return;
            }

            animating = true;
            const tool = $('#menuTools div#' + mode);
            tool.addClass('active');
            $('#sidebar').animate({height: 79}, 400, function () {
                animating = false;
                input.attr('data-mode', mode);
                input.attr('placeholder', tool.attr('title'));
                input.fadeIn();
                input.focus();
            });
        },
        /**
         * @param {function} callback
         */
        hideInputMobile: function (callback) {
            if (animating) {
                return;
            }

            animating = true;
            input.attr('data-mode', '');
            input.val('');
            input.fadeOut(400, function () {
                animating = false;
                $('#menuTools div').removeClass('active');
                $('#sidebar').animate({height: 35});
                callback();
            });
        },
    }
}();

$(document).ready(function () {
    sidebar.initTools();
});
