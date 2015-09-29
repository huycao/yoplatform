(window, document, window.jQuery), function (e, t, o) {
    o(function () {
        function t() {
            var e = o(this), t = e.data();
            t && (t.triggerInView ? (i.scroll(function () {
                n(e, t)
            }), n(e, t)) : a(e, t))
        }

        function n(e, t) {
            var n = -20;
            !e.hasClass(r) && o.Utils.isInView(e, {topoffset: n}) && a(e, t)
        }

        function a(e, t) {
            e.ClassyLoader(t).addClass(r)
        }

        var i = o(e), r = "js-is-in-view";
        o("[data-classyloader]").each(t)
    })
}(window, document, window.jQuery), function (e, t, o) {
    o(function () {
        var e = new n, a = o("[data-search-open]");
        a.on("click", function (e) {
            e.stopPropagation()
        }).on("click", e.toggle);
        var i = o("[data-search-dismiss]"), r = '.navbar-form input[type="text"]';
        o(r).on("click", function (e) {
            e.stopPropagation()
        }).on("keyup", function (t) {
            27 == t.keyCode && e.dismiss()
        }), o(t).on("click", e.dismiss), i.on("click", function (e) {
            e.stopPropagation()
        }).on("click", e.dismiss)
    });
    var n = function () {
        var e = "form.navbar-form";
        return {
            toggle: function () {
                var t = o(e);
                t.toggleClass("open");
                var n = t.hasClass("open");
                t.find("input")[n ? "focus" : "blur"]()
            }, dismiss: function () {
                o(e).removeClass("open").find('input[type="text"]').blur().val("")
            }
        }
    }
}(window, document, window.jQuery), function (e, t, o) {
    "use strict";
    function n(t) {
        var o = t.data("message"), n = t.data("options");
        o || e.error("Notify: No message specified"), e.notify(o, n || {})
    }

    {
        var a = "[data-notify]";
        e(o)
    }
    e(function () {
        e(a).each(function () {
            var t = e(this), o = t.data("onload");
            void 0 !== o && setTimeout(function () {
                n(t)
            }, 800), t.on("click", function (e) {
                e.preventDefault(), n(t)
            })
        })
    })
}(jQuery, window, document), function (e, t, o) {
    o(function () {
        if ("undefined" != typeof Rickshaw) {
            for (var e = [[], [], []], o = new Rickshaw.Fixtures.RandomData(150), n = 0; 150 > n; n++)o.addData(e);
            var a = [{color: "#c05020", data: e[0], name: "New York"}, {
                color: "#30c020",
                data: e[1],
                name: "London"
            }, {
                color: "#6060c0",
                data: e[2],
                name: "Tokyo"
            }], i = new Rickshaw.Graph({element: t.querySelector("#rickshaw1"), series: a, renderer: "area"});
            i.render();
            var r = new Rickshaw.Graph({
                element: t.querySelector("#rickshaw2"),
                renderer: "area",
                stroke: !0,
                series: [{
                    data: [{x: 0, y: 40}, {x: 1, y: 49}, {x: 2, y: 38}, {x: 3, y: 30}, {x: 4, y: 32}],
                    color: "#f05050"
                }, {
                    data: [{x: 0, y: 40}, {x: 1, y: 49}, {x: 2, y: 38}, {x: 3, y: 30}, {x: 4, y: 32}],
                    color: "#fad732"
                }]
            });
            r.render();
            var l = new Rickshaw.Graph({
                element: t.querySelector("#rickshaw3"),
                renderer: "line",
                series: [{
                    data: [{x: 0, y: 40}, {x: 1, y: 49}, {x: 2, y: 38}, {x: 3, y: 30}, {x: 4, y: 32}],
                    color: "#7266ba"
                }, {
                    data: [{x: 0, y: 20}, {x: 1, y: 24}, {x: 2, y: 19}, {x: 3, y: 15}, {x: 4, y: 16}],
                    color: "#23b7e5"
                }]
            });
            l.render();
            var s = new Rickshaw.Graph({
                element: t.querySelector("#rickshaw4"),
                renderer: "bar",
                series: [{
                    data: [{x: 0, y: 40}, {x: 1, y: 49}, {x: 2, y: 38}, {x: 3, y: 30}, {x: 4, y: 32}],
                    color: "#fad732"
                }, {
                    data: [{x: 0, y: 20}, {x: 1, y: 24}, {x: 2, y: 19}, {x: 3, y: 15}, {x: 4, y: 16}],
                    color: "#ff902b"
                }]
            });
            s.render()
        }
    })
}(window, document, window.jQuery), function (e, t, o) {
    function n() {
        var e = o("<div/>", {"class": "dropdown-backdrop"});
        e.insertAfter(".aside").on("click mouseenter", function () {
            r()
        })
    }

    function a(e) {
        e.siblings("li").removeClass("open").end().toggleClass("open")
    }

    function i(e) {
        r();
        var t = e.children("ul");
        if (!t.length)return o();
        if (e.hasClass("open"))return a(e), o();
        var n = o(".aside"), i = o(".aside-inner"), l = parseInt(i.css("padding-top"), 0) + parseInt(n.css("padding-top"), 0), s = t.clone().appendTo(n);
        a(e);
        var d = e.position().top + l - p.scrollTop(), f = u.height();
        return s.addClass("nav-floating").css({
            position: c() ? "fixed" : "absolute",
            top: d,
            bottom: s.outerHeight(!0) + d > f ? 0 : "auto"
        }), s.on("mouseleave", function () {
            a(e), s.remove()
        }), s
    }

    function r() {
        o(".sidebar-subnav.nav-floating").remove(), o(".dropdown-backdrop").remove(), o(".sidebar li.open").removeClass("open")
    }

    function l() {
        return f.hasClass("touch")
    }

    function s() {
        return h.hasClass("aside-collapsed")
    }

    function c() {
        return h.hasClass("layout-fixed")
    }

    function d() {
        return h.hasClass("aside-hover")
    }

    var u, f, h, p, g;
    o(function () {
        u = o(e), f = o("html"), h = o("body"), p = o(".sidebar"), g = "";
        var t = p.find(".collapse");
        t.on("show.bs.collapse", function (e) {
            e.stopPropagation(), 0 === o(this).parents(".collapse").length && t.filter(".in").collapse("hide")
        });
        var a = o(".sidebar .active").parents("li");
        d() || a.addClass("active").children(".collapse").collapse("show"), p.find("li > a + ul").on("show.bs.collapse", function (e) {
            d() && e.preventDefault()
        });
        var r = l() ? "click" : "mouseenter", c = o();
        p.on(r, ".nav > li", function () {
            (s() || d()) && (c.trigger("mouseleave"), c = i(o(this)), n())
        });
        var m = p.data("sidebarAnyclickClose");
        "undefined" != typeof m && o(".wrapper").on("click.sidebar", function (e) {
            if (h.hasClass("aside-toggled")) {
                var t = o(e.target);
                t.parents(".aside").length || t.is("#user-block-toggle") || t.parent().is("#user-block-toggle") || h.removeClass("aside-toggled")
            }
        })
    })
}(window, document, window.jQuery), function (e, t, o, n) {
    o(function () {
        var t = o("body");
        toggle = new StateToggler, o("[data-toggle-state]").on("click", function (a) {
            a.stopPropagation();
            var i = o(this), r = i.data("toggleState"), l = i.attr("data-no-persist") !== n;
            r && (t.hasClass(r) ? (t.removeClass(r), l || toggle.removeState(r)) : (t.addClass(r), l || toggle.addState(r))), o(e).resize()
        })
    }), e.StateToggler = function () {
        var e = "jq-toggleState", t = {
            hasWord: function (e, t) {
                return new RegExp("(^|\\s)" + t + "(\\s|$)").test(e)
            }, addWord: function (e, t) {
                return this.hasWord(e, t) ? void 0 : e + (e ? " " : "") + t
            }, removeWord: function (e, t) {
                return this.hasWord(e, t) ? e.replace(new RegExp("(^|\\s)*" + t + "(\\s|$)*", "g"), "") : void 0
            }
        };
        return {
            addState: function (n) {
                var a = o.localStorage.get(e);
                a = a ? t.addWord(a, n) : n, o.localStorage.set(e, a)
            }, removeState: function (n) {
                var a = o.localStorage.get(e);
                a && (a = t.removeWord(a, n), o.localStorage.set(e, a))
            }, restoreState: function (t) {
                var n = o.localStorage.get(e);
                n && t.addClass(n)
            }
        }
    }
}(window, document, window.jQuery), function (e, t, o) {
    o(function () {
        var e = [];
        if (o(".tour-step").each(function () {
                var t = o(this).data();
                t.element = "#" + this.id, e.push(t)
            }), e.length) {
            var t = new Tour({
                backdrop: !0, onShown: function () {
                    o(".wrapper > section").css({position: "static"})
                }, onHide: function () {
                    o(".wrapper > section").css({position: ""})
                }, steps: e
            });
            t.init(), o("#start-tour").on("click", function () {
                t.restart()
            })
        }
    })
}(window, document, window.jQuery), function (e, t, o) {
    "use strict";
    var n = e("html"), a = e(t);
    e.support.transition = function () {
        var e = function () {
            var e, t = o.body || o.documentElement, n = {
                WebkitTransition: "webkitTransitionEnd",
                MozTransition: "transitionend",
                OTransition: "oTransitionEnd otransitionend",
                transition: "transitionend"
            };
            for (e in n)if (void 0 !== t.style[e])return n[e]
        }();
        return e && {end: e}
    }(), e.support.animation = function () {
        var e = function () {
            var e, t = o.body || o.documentElement, n = {
                WebkitAnimation: "webkitAnimationEnd",
                MozAnimation: "animationend",
                OAnimation: "oAnimationEnd oanimationend",
                animation: "animationend"
            };
            for (e in n)if (void 0 !== t.style[e])return n[e]
        }();
        return e && {end: e}
    }(), e.support.requestAnimationFrame = t.requestAnimationFrame || t.webkitRequestAnimationFrame || t.mozRequestAnimationFrame || t.msRequestAnimationFrame || t.oRequestAnimationFrame || function (e) {
            t.setTimeout(e, 1e3 / 60)
        }, e.support.touch = "ontouchstart"in t && navigator.userAgent.toLowerCase().match(/mobile|tablet/) || t.DocumentTouch && document instanceof t.DocumentTouch || t.navigator.msPointerEnabled && t.navigator.msMaxTouchPoints > 0 || t.navigator.pointerEnabled && t.navigator.maxTouchPoints > 0 || !1, e.support.mutationobserver = t.MutationObserver || t.WebKitMutationObserver || t.MozMutationObserver || null, e.Utils = {}, e.Utils.debounce = function (e, t, o) {
        var n;
        return function () {
            var a = this, i = arguments, r = function () {
                n = null, o || e.apply(a, i)
            }, l = o && !n;
            clearTimeout(n), n = setTimeout(r, t), l && e.apply(a, i)
        }
    }, e.Utils.removeCssRules = function (e) {
        var t, o, n, a, i, r, l, s, c, d;
        e && setTimeout(function () {
            try {
                for (d = document.styleSheets, a = 0, l = d.length; l > a; a++) {
                    for (n = d[a], o = [], n.cssRules = n.cssRules, t = i = 0, s = n.cssRules.length; s > i; t = ++i)n.cssRules[t].type === CSSRule.STYLE_RULE && e.test(n.cssRules[t].selectorText) && o.unshift(t);
                    for (r = 0, c = o.length; c > r; r++)n.deleteRule(o[r])
                }
            } catch (u) {
            }
        }, 0)
    }, e.Utils.isInView = function (t, o) {
        var n = e(t);
        if (!n.is(":visible"))return !1;
        var i = a.scrollLeft(), r = a.scrollTop(), l = n.offset(), s = l.left, c = l.top;
        return o = e.extend({
            topoffset: 0,
            leftoffset: 0
        }, o), c + n.height() >= r && c - o.topoffset <= r + a.height() && s + n.width() >= i && s - o.leftoffset <= i + a.width() ? !0 : !1
    }, e.Utils.options = function (t) {
        if (e.isPlainObject(t))return t;
        var o = t ? t.indexOf("{") : -1, n = {};
        if (-1 != o)try {
            n = new Function("", "var json = " + t.substr(o) + "; return JSON.parse(JSON.stringify(json));")()
        } catch (a) {
        }
        return n
    }, e.Utils.events = {}, e.Utils.events.click = e.support.touch ? "tap" : "click", e.langdirection = "rtl" == n.attr("dir") ? "right" : "left", e(function () {
        if (e.support.mutationobserver) {
            var t = new e.support.mutationobserver(e.Utils.debounce(function () {
                e(o).trigger("domready")
            }, 300));
            t.observe(document.body, {childList: !0, subtree: !0})
        }
    }), n.addClass(e.support.touch ? "touch" : "no-touch")
}(jQuery, window, document), function (e, t, o) {
    o(function () {
    })
}(window, document, window.jQuery);