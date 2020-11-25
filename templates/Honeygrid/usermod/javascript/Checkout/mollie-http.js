var MollieHttpClient = window.Mollie || {};

(function () {
    function HttpService() {
        this.get = get;
        this.post = post;
        this.put = put;

        /**
         * Performs GET ajax request.
         *
         * @param {string} url
         *
         * @return Promise
         */
        function get(url) {
            return call('GET', url, {});
        }

        /**
         * Performs POST ajax request.
         *
         * @param {string} url
         * @param {object} data
         *
         * @return Promise
         */
        function post(url, data) {
            return call('POST', url, data);
        }

        /**
         * Performs PUT http request.
         *
         *
         * @param url
         * @param data
         *
         * @return Promise
         */
        function put(url, data) {
            return call('PUT', url, data);
        }

        /**
         * Performs ajax call.
         *
         * @param {'GET' | 'POST' | 'PUT'} method
         * @param {string} url
         * @param {object} data
         *
         * @return Promise
         */
        function call(method, url, data) {
            return new Promise(function (resolve, reject) {
                let request = new XMLHttpRequest();

                request.open(method, url, true);


                request.onreadystatechange = function () {
                    if (this.readyState === 4) {
                        if (this.status >= 200 && this.status < 300) {
                            resolve(JSON.parse(this.responseText || '{}'));
                        } else {
                            reject(JSON.parse(this.responseText || '{}'));
                        }
                    }
                };

                if (['POST', 'PUT'].indexOf(method) !== -1) {
                    request.setRequestHeader("Content-Type", "application/json");
                    request.send(JSON.stringify(data));
                } else {
                    request.send();
                }
            });
        }
    }

    MollieHttpClient.http = new HttpService();
})();
