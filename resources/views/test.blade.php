! function(e) {
    function t(o) {
        if (n[o]) return n[o].exports;
        var r = n[o] = {
            exports: {},
            id: o,
            loaded: !1
        };
        return e[o].call(r.exports, r, r.exports, t), r.loaded = !0, r.exports
    }
    var n = {};
    return t.m = e, t.c = n, t.p = "", t(0)
}([function(e, t, n) {
    e.exports = n(1)
}, function(e, t, n) {
    "use strict";
    var o = n(2),
        r = n(4),
        i = function() {
            function e(e) {
                var t = this,
                    n = e && e.env,
                    r = e && e.ver,
                    i = e && e.host;
                o.fetchConfig({
                    queryParams: {
                        configOption: n
                    },
                    requestTypeOptions: {
                        callbackName: "Skype.ECS.jsonpCallback"
                    }
                }, function(e) {
                    r && r.length > 0 && t.substituteConfigToVersion(SkypeWebControl.EcsConfig, r), n && (SkypeWebControl.EcsConfig.environment = n), r && (SkypeWebControl.EcsConfig.version = r), SkypeWebControl.SDK || (SkypeWebControl.SDK = {}), i && (SkypeWebControl.SDK.host = i), t.addLoader()
                }, function(e) {})
            }
            return e.prototype.addLoader = function() {
                var e = r.default.getDocument(),
                    t = e.createElement("script");
                t.type = "text/javascript", t.src = SkypeWebControl.EcsConfig.loaderUrl, e.body.appendChild(t)
            }, e.prototype.substituteConfigToVersion = function(e, t) {
                var n = /\d+.\d+.[^\D]\d+/g;
                for (var o in e)
                    if (e.hasOwnProperty(o)) {
                        var r = e[o];
                        r = r.replace(n, t), e[o] = r
                    }
            }, e.start = function(t) {
                new e(t)
            }, e
        }();
    window.SkypeWebControl = window.SkypeWebControl || {}, window.SkypeWebControl.SDKRunner = window.SkypeWebControl.SDKRunner || i
}, function(e, t, n) {
    "use strict";

    function o(e, t, n) {
        function o() {
            var t = [],
                n = e.queryParams || {};
            return e.userId && t.push("id=" + encodeURIComponent(e.userId)), e.clientId && t.push("clientId=" + encodeURIComponent(e.clientId)), Object.keys(n).sort().forEach(function(e) {
                t.push([encodeURIComponent(e), encodeURIComponent(n[e])].join("="))
            }), 0 === t.length ? "" : "?" + t.join("&")
        }

        function a(e) {
            var t = new Error(e);
            if (!n) throw t;
            n(t)
        }

        function c(t) {
            x++, r.request(t, w, l, u, e.requestTypeOptions || {})
        }

        function u(e, t) {
            if (x / W.length < b && !t) {
                if (x % W.length === 0 && !D) return void(N = !0);
                x % W.length === 0 && (D = !1, N = !1, M = setTimeout(f, C * Math.pow(C, x / W.length))), c(W[++T % W.length])
            } else y() || a("Configuration service is unreachable and no valid cached config is available: " + e.message)
        }

        function l(e) {
            if (clearTimeout(M), N = !1, !j) {
                var n = d(e);
                n && (j = !0, s(n), v(n), t(n))
            }
        }

        function s(e) {
            window.SkypeWebControl = window.SkypeWebControl || {};
            var t = JSON.stringify(e);
            SkypeWebControl.EcsConfig = JSON.parse(t)
        }

        function f() {
            clearTimeout(M), N && !j ? (N = !1, D = !1, M = setTimeout(f, C * Math.pow(S, x / W.length)), c(W[++T % W.length])) : D = !0
        }

        function d(e) {
            if ("object" == typeof e) return e;
            try {
                return JSON.parse(e)
            } catch (e) {
                return y() || a("Malformed response and no valid cached config for team is available"), null
            }
        }

        function p() {
            if (void 0 === g) {
                g = !1;
                try {
                    if (I && O && O.localStorage) {
                        var e = O.localStorage.getItem(I) || "{}";
                        O.localStorage.setItem(I, e), g = !0
                    }
                } catch (e) {}
            }
            return g
        }

        function v(e) {
            p() && O.localStorage.setItem(I, JSON.stringify(e))
        }

        function y() {
            if (!p()) return !1;
            var e;
            try {
                e = JSON.parse(O.localStorage.getItem(I))
            } catch (e) {
                return !1
            }
            return !!e && (t(e), !0)
        }
        var g, h = ["https://a.config.skype.com", "https://b.config.skype.com"],
            m = o(),
            b = 3,
            w = 7500,
            C = 500,
            S = 1.2,
            k = "skype/1.00/lwc",
            E = k + m,
            W = h.map(function(e) {
                return encodeURI(e) + "/config/v1/" + E
            }),
            I = "lwc-ecs",
            O = i.default.getWindow(),
            T = Math.floor(Math.random() * W.length),
            x = 0,
            j = !1;
        c(W[T]);
        var N, D, M = setTimeout(f, C)
    }
    var r = n(3),
        i = n(4);
    t.fetchConfig = o
}, function(e, t, n) {
    "use strict";

    function o(e, t, n, o, i) {
        function a(e) {
            clearTimeout(p), n && n(e)
        }

        function c(e) {
            clearTimeout(p), o && (o(new Error(e)), o = void 0, n = void 0)
        }

        function l() {
            c("timeout")
        }

        function f() {
            c("script.onerror invoked")
        }(t <= 0 || t >= Math.pow(2, 31) || t !== (0 | t)) && s.default.throwError(10040, "invalid timeout"), ("string" != typeof i.callbackName && void 0 !== i.callbackName || "" === i.callbackName) && s.default.throwError(10041, "if provided, jsonp callback name must be a non-empty string"), "boolean" != typeof i.async && void 0 !== i.async && s.default.throwError(10042, "if provided, async flag must be boolean");
        try {
            var d = e + (/\?/.test(e) ? "&" : "?") + "callback=" + r(a, i.callbackName);
            u(d, f, i.async)
        } catch (e) {
            return void o(e, !0)
        }
        var p = setTimeout(l, t)
    }

    function r(e, t) {
        var n = l.default.getWindow();
        return t ? a(e, t, n) : i(e, n)
    }

    function i(e, t) {
        var n;
        do n = (Math.random().toString(36) + "00000000000000000").slice(2, 12); while (n in t);
        return t[n] = e, n
    }

    function a(e, t, n) {
        var o = t.split("."),
            r = c(o.slice(0, -1), n),
            i = o.pop();
        return i in r && "function" != typeof r[i] && s.default.throwError(10060, "non-function property with supplied callback name already exists"), r[i] = e, t
    }

    function c(e, t) {
        var n = t;
        return e.forEach(function(e) {
            e in n ? n[e] && !Object.isExtensible(n[e]) && s.default.throwError(10061, "callback namespace already exists but is not an extensible type") : n[e] = {}, n = n[e]
        }), n
    }

    function u(e, t, n) {
        var o = l.default.getDocument(),
            r = o.createElement("script");
        r.src = e, r.type = "text/javascript", n ? r.async = !0 : r.defer = !0, r.onerror = t, o.getElementsByTagName("head")[0].appendChild(r)
    }
    var l = n(4),
        s = n(5);
    t.request = o
}, function(e, t) {
    "use strict";
    var n = function() {
        function e() {}
        return e.getWindow = function() {
            return window
        }, e.getDocument = function() {
            return window.document
        }, e
    }();
    Object.defineProperty(t, "__esModule", {
        value: !0
    }), t.default = n
}, function(e, t) {
    "use strict";
    var n = function() {
        function e() {}
        return e.throwError = function(e, t) {
            throw new Error(e + "")
        }, e
    }();
    Object.defineProperty(t, "__esModule", {
        value: !0
    }), t.default = n
}]);