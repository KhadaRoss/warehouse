let strings;
let path;

let env = function () {

    return {
        getWebPath: function () {
            return path;
        }
    }
}();

let request = function () {
    const requestUrl = env.getWebPath() + 'ajax';

    return {
        /**
         * @param {string}   method
         * @param {object}   parameters
         * @param {function} callback
         */
        request: function (method, parameters, callback) {
            $.post(requestUrl, {function: method, parameters: parameters}).done(function (data) {
                callback(data);
            });
        }
    }
}();

let common = function() {

    return {
        /**
         * @param {string} jsStrings
         */
        initStrings: function (jsStrings) {
            strings = JSON.parse(jsStrings);
        },
        /**
         * @param {string} url
         */
        initPath: function (url) {
            path = url;
        }
    }
} ();

$(document).ready(function () {
});
