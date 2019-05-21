let strings;

let env = function () {

    return {
        getWebPath: function () {
            return 'http://localhost/warehouse/';
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

let warehouse = function() {

    return {
        /**
         * @param jsStrings
         */
        initStrings: function (jsStrings) {
            strings = JSON.parse(jsStrings);
        }
    }
} ();

$(document).ready(function () {
});
