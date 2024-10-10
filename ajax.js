//Objet URL et cookie rajout de propriétés
Object.defineProperties(document, {
    URL: {
        get: function() {
            var u = new URL(document.location.href);
            Object.defineProperties(u, {
                parameters: {
                    get: function() {
                        var _url = document.location.href;
                        var list = [];
                        var i = 0;
                        var dec = decodeURI(_url);
                        var searchParams = new URLSearchParams(dec.split("?")[1]);
                        for (var pair of searchParams.entries()) {
                            list[pair[0]] = pair[1];
                            list[i] = pair[1];
                            i++;
                        }
                        // Ajout de paramètres
                        list.add = function(key, value) {
                            var baseUrl = new URL(document.location.href);
                            if (baseUrl.searchParams.has(key) == false || document.location.href.split("?").length == 0) {
                                baseUrl.searchParams.append(key, encodeURI(value));
                            }
                            window.history.replaceState({}, "", baseUrl.search);
                        };
                        // Update de paramètres
                        list.update = function(key, value) {
                            var baseUrl = new URL(document.location.href);
                            baseUrl.searchParams.set(key, encodeURI(value));
                            window.history.replaceState({}, "", baseUrl.search);
                        };
                        // Suppression de paramètres
                        list.remove = function(key) {
                            if (this.length == 1) {
                                var _url = document.location.href.split("?")[0];
                                var baseUrl = new URL(_url);
                            } else {
                                var baseUrl = new URL(document.location.href);
                            }
                            baseUrl.searchParams.delete(key);
                            window.history.replaceState({}, "", baseUrl);
                        };
                        return list;
                    },
                    configurable: true
                }
            });
            return u;
        },
        configurable: true
    },
    cookies: {
        get: function() {
            var c = document.cookie;
            var t;
            var res = [];
            c = c.split(";");
            if (document.cookie != "") {
                for (var i = 0; i <= c.length - 1; i++) {
                    var t = c[i].split("=");
                    res[t[0].trim()] = t[1].trim();
                }
            }
            res.add = function(nom, valeur, jours = 365) {
                // Le nombre de jours est spécifié
                if (jours) {
                    var date = new Date();
                    // Converti le nombre de jour en millisecondes
                    date.setTime(date.getTime() + jours * 24 * 60 * 60 * 1e3);
                    var expire = "; expire=" + date.toGMTString();
                } else var expire = "";
                document.cookie = nom + "=" + valeur + expire + "; path=/";
            };
            res.update = function(nom, valeur, jours = 365) {
                if (jours) {
                    var date = new Date();
                    // Converti le nombre de jour en millisecondes
                    date.setTime(date.getTime() + jours * 24 * 60 * 60 * 1e3);
                    var expire = "; expire=" + date.toGMTString();
                } else var expire = "";
                document.cookie = nom + "=" + valeur + expire + "; path=/";
            };
            res.clear = function() {
                var cookies = document.cookie.split(";");
                for (var i = 0; i < cookies.length; i++) {
                    var cookie = cookies[i];
                    var eqPos = cookie.indexOf("=");
                    var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
                    document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
                };
            };
            res.delete = function(name) {
                document.cookie = name + '=; Max-Age=-99999999;';
            }
            return res;
        },
        configurable: true
    },
    styles: {
        get: function() {
            var sheet = {};
            if (document.querySelectorAll("style").length == 0) {
                var style = document.createElement("style");
                style.appendChild(document.createTextNode(""));
                document.head.appendChild(style);
            }
            sheet = document.styleSheets[document.styleSheets.length - 1];
            sheet.add = function(header, styles) {
                this.insertRule(header + " { " + styles + " }", this.cssRules.length);
            };
            sheet.remove = function(header) {
                var r = this.cssRules;
                for (var i = 0; i <= this.cssRules.length - 1; i++) {
                    if (r[i].selectorText == header) {
                        this.deleteRule(i);
                    }
                }
            };
            return sheet;
        },
        configurable: true
    },
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


// FONCTIONS COMMUNES

function logout()
{
    document.AJAX.sendRequest("actions/logout.php", {
    }, function(response) {
        if(response == "true")
        {
            window.location.href = "index.php";
        }
    });

}

function logout2()
{
    document.AJAX.sendRequest("../admin/actions/logout2.php", {
    }, function(response) {
        if(response == "true")
        {
            window.location.href = "../members/index.php";
        }
    });

}