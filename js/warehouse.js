let menu = function () {
    const bar = $('#menu');
    const inputField = $('#menuInput, #inputLayer');

    return {
        init: function () {
            menu.initEventListeners();
        },
        initEventListeners: function () {
            $('#write, #search').on('click', function () {
                if (inputField.hasClass('animating')) {
                    return;
                }

                $(this).siblings($(this).attr('id') === 'write' ? '#search' : '#write').removeClass('active');
                $(this).toggleClass('active');
                menu.manageInputState();
            });
            inputField.find('input').on('keyup', function (e) {
                const keyCode = e.keyCode || e.which;
                if (keyCode !== 13) {
                    return;
                }

                if (input.isValid()) {
                    input.doAction();
                }
            })
        },
        showInput: function () {
            inputField.val('');
            inputField.removeClass('hidden');
            inputField.attr('placeholder', bar.find('#write.active a, #search.active a').html());
            inputField.attr('data-input', bar.find('#write.active, #search.active').attr('data-input'));
            inputField.addClass('animating');
            inputField.focus();
            inputField.animate({opacity: 1}, 400, function () {
                inputField.addClass('showMenuInput');
                inputField.removeClass('animating');
            });

        },
        hideInput: function (redirect) {
            inputField.removeClass('showMenuInput');
            inputField.addClass('animating');
            inputField.animate({opacity: 0}, 400, function () {
                inputField.addClass('hidden');
                inputField.removeClass('animating');

                if (typeof redirect !== 'undefined') {
                    window.location.href = redirect;
                }
            });
        },
        manageInputState: function () {
            if (bar.find('#write.active, #search.active').length < 1) {
                this.hideInput();
                return;
            }
            inputField.css('opacity', 0);
            this.showInput();
        },
    }
}();

let device = function () {

    return {
        isDesktop: function () {
            return (window.innerWidth >= 1200);
        },
        isTablet: function () {
            return (!this.isDesktop() && !this.isMobile());
        },
        isMobile: function () {
            return (window.innerWidth <= 576)
        }
    }
}();

let input = function () {
    const inputField = $('#menuInput');
    let value = '';

    return {
        isValid: function () {
            value = inputField.val();
            if (value.indexOf('/') > -1) {
                inputField.addClass('false');
                return false;
            }

            inputField.removeClass('false');
            return true;
        },
        doAction: function () {
            switch (inputField.attr('data-input')) {
                case 'write':
                    this.createReport();
                    break;
                case 'search':
                    this.searchReport();
                    break;
            }
        },
        createReport: function () {
            request.ajax('createReport', {value: value}, function (data) {
                menu.hideInput(env.getWebPath() + 'reports/show/' + data);
            });
        },
        searchReport: function () {
            window.location.href = env.getWebPath() + 'reports/search/' + value;
        },
    }
}();

let request = function () {

    return {
        ajax: function (action, args, callback) {
            $.ajax({
                type: 'POST',
                url: env.getWebPath() + 'ajax/handle/' + action ,
                data: {data: JSON.stringify(args)},
                success: function (data) {
                    if (typeof callback !== 'undefined') {
                        callback(data);
                    }
                }
            });
        }
    }
}();

let env = function () {

    return {
        getWebPath: function () {
            return 'http://mroepnack.localhost.dev.hh.rexx-systems.rx:8070/reports/';
        },
        getHomePage: function () {
            return this.getWebPath() + 'home';
        }
    }
}();

$(document).ready(function () {
    menu.init();
});


