!(function (e) {
    var t = {};
    function n(i) {
      if (t[i]) return t[i].exports;
      var r = (t[i] = { i: i, l: !1, exports: {} });
      return e[i].call(r.exports, r, r.exports, n), (r.l = !0), r.exports;
    }
    (n.m = e),
      (n.c = t),
      (n.d = function (e, t, i) {
        n.o(e, t) || Object.defineProperty(e, t, { enumerable: !0, get: i });
      }),
      (n.r = function (e) {
        "undefined" != typeof Symbol &&
          Symbol.toStringTag &&
          Object.defineProperty(e, Symbol.toStringTag, { value: "Module" }),
          Object.defineProperty(e, "__esModule", { value: !0 });
      }),
      (n.t = function (e, t) {
        if ((1 & t && (e = n(e)), 8 & t)) return e;
        if (4 & t && "object" == typeof e && e && e.__esModule) return e;
        var i = Object.create(null);
        if (
          (n.r(i),
          Object.defineProperty(i, "default", { enumerable: !0, value: e }),
          2 & t && "string" != typeof e)
        )
          for (var r in e)
            n.d(
              i,
              r,
              function (t) {
                return e[t];
              }.bind(null, r)
            );
        return i;
      }),
      (n.n = function (e) {
        var t =
          e && e.__esModule
            ? function () {
                return e.default;
              }
            : function () {
                return e;
              };
        return n.d(t, "a", t), t;
      }),
      (n.o = function (e, t) {
        return Object.prototype.hasOwnProperty.call(e, t);
      }),
      (n.p = ""),
      n((n.s = 0));
  })([
    function (e, t, n) {
      n(1), (e.exports = n(2));
    },
    function (e, t) {
      function n(e, t) {
        var n = Object.keys(e);
        return (
          Object.getOwnPropertySymbols &&
            n.push.apply(n, Object.getOwnPropertySymbols(e)),
          t &&
            (n = n.filter(function (t) {
              return Object.getOwnPropertyDescriptor(e, t).enumerable;
            })),
          n
        );
      }
      function i(e, t, n) {
        return (
          t in e
            ? Object.defineProperty(e, t, {
                value: n,
                enumerable: !0,
                configurable: !0,
                writable: !0,
              })
            : (e[t] = n),
          e
        );
      }
      function r(e, t) {
        for (var n = 0; n < t.length; n++) {
          var i = t[n];
          (i.enumerable = i.enumerable || !1),
            (i.configurable = !0),
            "value" in i && (i.writable = !0),
            Object.defineProperty(e, i.key, i);
        }
      }
      function s(e, t, n) {
        return t && r(e.prototype, t), n && r(e, n), e;
      }
      /*
       * Slinky
       * Rather sweet menus
       * @author Ali Zahid <ali.zahid@live.com>
       * @license MIT
       */ var a = (function () {
        function e(t) {
          var r =
            arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
          !(function (e, t) {
            if (!(e instanceof t))
              throw new TypeError("Cannot call a class as a function");
          })(this, e),
            (this.settings = (function (e) {
              for (var t = 1; t < arguments.length; t++) {
                var r = null != arguments[t] ? arguments[t] : {};
                t % 2
                  ? n(r, !0).forEach(function (t) {
                      i(e, t, r[t]);
                    })
                  : Object.getOwnPropertyDescriptors
                  ? Object.defineProperties(
                      e,
                      Object.getOwnPropertyDescriptors(r)
                    )
                  : n(r).forEach(function (t) {
                      Object.defineProperty(
                        e,
                        t,
                        Object.getOwnPropertyDescriptor(r, t)
                      );
                    });
              }
              return e;
            })({}, this.options, {}, r)),
            this._init(t);
        }
        return (
          s(e, [
            {
              key: "options",
              get: function () {
                return {
                  resize: !0,
                  speed: 300,
                  theme: "slinky-theme-default",
                  title: !1,
                };
              },
            },
          ]),
          s(e, [
            {
              key: "_init",
              value: function (e) {
                (this.menu = jQuery(e)),
                  (this.base = this.menu.children().first());
                var t = this.menu,
                  n = this.settings;
                t.addClass("slinky-menu").addClass(n.theme),
                  this._transition(n.speed),
                  jQuery("a + ul", t).prev().addClass("next"),
                  jQuery("li > a", t).wrapInner("<span>");
                var i = jQuery("<li>").addClass("header");
                jQuery("li > ul", t).prepend(i);
                var r = jQuery("<a>").prop("href", "#").addClass("back");
                jQuery(".header", t).prepend(r),
                  n.title &&
                    jQuery("li > ul", t).each(function (e, t) {
                      var n = jQuery(t).parent().find("a").first().text();
                      var href = jQuery(t).parent().find("a").first().attr('href');
                      if (n) {
                        var i = jQuery("<a>").addClass("title").text(n).prop("href", href);
                        jQuery("> .header", t).append(i);
                      }
                    }),
                  this._addListeners(),
                  this._jumpToInitial();
              },
            },
            {
              key: "_addListeners",
              value: function () {
                var e = this,
                  t = this.menu,
                  n = this.settings;
                jQuery("a", t).on("click", function (i) {
                  if (e._clicked + n.speed > Date.now()) return !1;
                  e._clicked = Date.now();
                  var r = jQuery(i.currentTarget);
                  (0 === r.attr("href").indexOf("#") ||
                    r.hasClass("next") ||
                    r.hasClass("back")) &&
                    i.preventDefault(),
                    r.hasClass("next")
                      ? (t.find(".active").removeClass("active"),
                        r.next().show().addClass("active"),
                        e._move(1),
                        n.resize && e._resize(r.next()))
                      : r.hasClass("back") &&
                        (e._move(-1, function () {
                          t.find(".active").removeClass("active"),
                            r
                              .parent()
                              .parent()
                              .hide()
                              .parentsUntil(t, "ul")
                              .first()
                              .addClass("active");
                        }),
                        n.resize &&
                          e._resize(r.parent().parent().parentsUntil(t, "ul")));
                });
              },
            },
            {
              key: "_jumpToInitial",
              value: function () {
                var e = this.menu,
                  t = this.settings,
                  n = e.find(".active");
                n.length > 0 && (n.removeClass("active"), this.jump(n, !1)),
                  setTimeout(function () {
                    return e.height(e.outerHeight());
                  }, t.speed);
              },
            },
            {
              key: "_move",
              value: function () {
                var e =
                    arguments.length > 0 && void 0 !== arguments[0]
                      ? arguments[0]
                      : 0,
                  t =
                    arguments.length > 1 && void 0 !== arguments[1]
                      ? arguments[1]
                      : function () {};
                if (0 !== e) {
                  var n = this.settings,
                    i = this.base,
                    r = Math.round(parseInt(i.get(0).style.left)) || 0;
                  i.css("left", "".concat(r - 100 * e, "%")),
                    "function" == typeof t && setTimeout(t, n.speed);
                }
              },
            },
            {
              key: "_resize",
              value: function (e) {
                this.menu.height(e.outerHeight());
              },
            },
            {
              key: "_transition",
              value: function () {
                var e =
                    arguments.length > 0 && void 0 !== arguments[0]
                      ? arguments[0]
                      : 300,
                  t = this.menu,
                  n = this.base;
                t.css("transition-duration", "".concat(e, "ms")),
                  n.css("transition-duration", "".concat(e, "ms"));
              },
            },
            {
              key: "jump",
              value: function (e) {
                var t =
                  !(arguments.length > 1 && void 0 !== arguments[1]) ||
                  arguments[1];
                if (e) {
                  var n = this.menu,
                    i = this.settings,
                    r = jQuery(e),
                    s = n.find(".active"),
                    a = 0;
                  s.length > 0 && (a = s.parentsUntil(n, "ul").length),
                    n.find("ul").removeClass("active").hide();
                  var o = r.parentsUntil(n, "ul");
                  o.show(),
                    r.show().addClass("active"),
                    t || this._transition(0),
                    this._move(o.length - a),
                    i.resize && this._resize(r),
                    t || this._transition(i.speed);
                }
              },
            },
            {
              key: "home",
              value: function () {
                var e =
                    !(arguments.length > 0 && void 0 !== arguments[0]) ||
                    arguments[0],
                  t = this.base,
                  n = this.menu,
                  i = this.settings;
                e || this._transition(0);
                var r = n.find(".active"),
                  s = r.parentsUntil(n, "ul");
                this._move(-s.length, function () {
                  r.removeClass("active").hide(), s.not(t).hide();
                }),
                  i.resize && this._resize(t),
                  !1 === e && this._transition(i.speed);
              },
            },
            {
              key: "destroy",
              value: function () {
                var e = this,
                  t = this.base,
                  n = this.menu;
                jQuery(".header", n).remove(),
                  jQuery("a", n).removeClass("next").off("click"),
                  n.css({ height: "", "transition-duration": "" }),
                  t.css({ left: "", "transition-duration": "" }),
                  jQuery("li > a > span", n).contents().unwrap(),
                  n.find(".active").removeClass("active"),
                  n
                    .attr("class")
                    .split(" ")
                    .forEach(function (e) {
                      0 === e.indexOf("slinky") && n.removeClass(e);
                    });
                ["settings", "menu", "base"].forEach(function (t) {
                  return delete e[t];
                });
              },
            },
          ]),
          e
        );
      })();
      jQuery.fn.slinky = function (e) {
        return new a(this, e);
      };
    },
    function (e, t, n) {},
  ]);
  //# sourceMappingURL=slinky.min.js.map
  