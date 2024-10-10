
//Objet URL et cookie rajout de propriétés
Object.defineProperties(document, {
    AJAX: {
        get: function() {
            var obj;
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.withCredentials = true;
            obj = xmlHttp;
            obj.sendRequest = function(url, params, aCallback, method = "POST") {
                var parameters_list = [];
                // List paramètres
                for (var p in params)
                    if (params.hasOwnProperty(p)) {
                        parameters_list.push(encodeURIComponent(p) + "=" + encodeURIComponent(params[p]));
                    }
                if (method == "POST") {
                    this.open("POST", url, true);
                    this.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    this.send(parameters_list.join("&"));
                } else {
                    this.open("GET", url + '?' + parameters_list.join("&"), true);
                    this.send(null);
                }
                xmlHttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        aCallback(this.responseText);
                    }
                };
            };
            return obj;
        },
        configurable: true
    }
});
