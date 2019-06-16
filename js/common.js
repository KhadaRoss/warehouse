let strings;
let path;

let common = function () {

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
}();

let env = function () {

    return {
        /**
         * @return {string}
         */
        getWebPath: function () {
            return path;
        }
    }
}();

let request = function () {
    let requestUrl;
    let needsData;

    return {
        /**
         * @return void
         */
        init: function () {
            requestUrl = env.getWebPath() + 'api/';
        },
        /**
         * @param {string} method
         * @param {string} entity
         * @param {string} parameters
         * @param {function} callback
         */
        api: function (method, entity, parameters, callback) {
            needsData = parameters.length > 1 || method === 'POST';

            $.ajax({
                type: this.getType(),
                method: method,
                url: requestUrl + entity + this.getParameters(parameters),
                data: this.getData(parameters)
            }).done(function (data) {
                callback(JSON.parse(data))
            });
        },
        /**
         * @return {string}
         */
        getType: function () {
            return needsData ? 'POST' : 'GET';
        },
        /**
         * @param {object} parameters
         *
         * @return {object}
         */
        getData: function (parameters) {
            return needsData ? parameters : {};
        },
        /**
         * @param {object} parameters
         *
         * @return {string}
         */
        getParameters: function (parameters) {
            return needsData ? '' : '/' + parameters[(Object.keys(parameters))[0]];
        }
    }
}();

$(document).ready(function () {
    request.init();
});
