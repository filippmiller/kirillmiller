"use strict";

function k(t) {
    if (Array.isArray(t)) {
        for (var e = 0, r = Array(t.length); e < t.length; e++) r[e] = t[e];
        return r
    }
    return Array.from(t)
}

function t(t, e) {
    var r = 1 < arguments.length && void 0 !== e && e, e = document.querySelector(t), y = r.heightRow || 200,
        t = r.padding || !1, b = r.emptySpace || !1, S = r.border || null, n = r.getDataSizeAtr || !1,
        g = r.customSize || null, m = r.fixedHeightRows || !1, x = r.EverywhereLikeOnThisScreen || null,
        G = r.gridOptions, i = r.galleryColumns || !1, J = r.alignTheColumns || !1,
        K = r.alignTheColumnsIfTheSecondRowIsFull || !1, P = r.galleryMosaic || !1, N = function (t, e) {
            var r = 2 < arguments.length && void 0 !== arguments[2] && arguments[2], e = document.createElement(e);
            t.appendChild(e), r && h(r, e);
            return e
        }(e, "div", {className: "nicegallery-container"}), Q = x || e.clientWidth,
        C = [].concat(k(e.querySelectorAll("img"))), z = !!b && 100 * b / Q, E = !!t && 100 * t / Q, U = void 0,
        o = void 0, M = void 0, w = [];

    function a() {
        i ? (o = Y(G).items, U = Q / o, K = !!(K && C.length < 2 * o), function (t) {
            T(C);
            var e = 0, r = void 0, n = void 0, i = void 0, o = void 0, a = void 0, l = t.length, h = t[l - 1];
            M = h.heightContainer, a = h.objHeightColumn, N.style.height = M + "px";
            var u = !0, d = !1, f = void 0;
            try {
                for (var c, v = t[Symbol.iterator](); !(u = (c = v.next()).done); u = !0) {
                    var s, p = c.value;
                    if (!(e < l - 1)) break;
                    for (s in p) {
                        var y = p[s], g = 0 != y.top, m = 0 != y.left;
                        r = 100 * y.width / Q, o = 100 * y.left / Q, i = P || !J || K ? (n = 100 * y.height / M, 100 * y.top / M) : (n = 100 * y.height / w(y, a), 100 * y.top / w(y, a));
                        m = function (t, e, r, n, i, o) {
                            var a = 6 < arguments.length && void 0 !== arguments[6] && arguments[6],
                                l = 7 < arguments.length && void 0 !== arguments[7] && arguments[7], h = void 0,
                                u = void 0, d = t.parentNode;
                            u = "A" == d.tagName ? d : t, h = W(u, "div", {
                                className: "nicegallery-item",
                                css: "width: " + e + "%;\n               height:" + r + "%; \n               padding: " + o + "%; \n               position: absolute;\n               top: " + n + "%;\n               left:" + i + "%;"
                            }), a && !S && (h.style.paddingTop = z + "%");
                            l && !S && (h.style.paddingLeft = z + "%");
                            a && (h.style.borderTop = b + "px " + S);
                            l && (h.style.borderLeft = b + "px " + S);
                            return h
                        }(y.content, r, n, i, o, E, g, m);
                        N.appendChild(m)
                    }
                    e++
                }
            } catch (t) {
                d = !0, f = t
            } finally {
                try {
                    !u && v.return && v.return()
                } finally {
                    if (d) throw f
                }
            }

            function w(t, e) {
                for (var r in e) if (t.left == r) return e[r]
            }
        }(T(C))) : l(A())
    }

    function T(t) {
        var e, r, n = Y(G), i = n.screen, o = n.items, y = Q / o, h = 0, u = 0, d = void 0, f = void 0, a = void 0,
            l = {}, g = [], c = [], v = [];
        if (Q <= i) if (P) {
            var s = function (t, e, r, n, i) {
                var o = g[g.length - 1], o = 0 < g.length && o.left + o.width;
                n = 0 < g.length ? o : 0, g.push(D(t, e, r, n, i)), A = !0
            }, m = function (t) {
                z = C = 0, v.push(g), g = [], p(t)
            }, p = function (t) {
                c = v[v.length - 1], a = b(c).length, M = 0 < a, T = w(c), h += y
            }, w = function (t) {
                var e = b(t), r = 0, n = 0, i = 0, o = 0, a = 0, l = [], h = !0, u = !1, d = void 0;
                try {
                    for (var f = e[Symbol.iterator](); !(h = (v = f.next()).done); h = !0) {
                        var c = v.value, v = c.left, c = c.width;
                        0 == r ? (n = v - o, i = 0) : n = v - (i = o + a), a = c, o = v, 0 != n && l.push({
                            size: n,
                            left: i
                        }), r++
                    }
                } catch (t) {
                    u = !0, d = t
                } finally {
                    try {
                        !h && f.return && f.return()
                    } finally {
                        if (u) throw d
                    }
                }
                return Q - (i = o + a) != 0 && a <= Q - i && l.push({size: Q - i, left: i}), l
            }, b = function (t) {
                return t.filter(function (t) {
                    return t.height > t.width
                })
            }, S = void 0, x = Q, N = !0, C = 0, z = 0, E = [], M = !1, T = [], A = !1;
            t.reverse(), function t(e) {
                for (var r, n, i, o, a = e.length; a-- && (0 < e.length && 0 == a && (N = !1), 0 != e.length);) {
                    var l = e[a];
                    A = !1, f = V(l).width, d = V(l).height, S = f, C += Math.trunc(f), f = !N && x - z <= f ? x - z : f, M ? function (t, e, r, n, i, o) {
                        var a = !1, l = 0, h = Math.trunc(S), u = Math.trunc(y);
                        n = S;
                        var d = !0, f = !1, c = void 0;
                        try {
                            for (var v = t[Symbol.iterator](); !(d = (p = v.next()).done); d = !0) {
                                var s = p.value, p = Math.trunc(s.size);
                                if (n = !N && p < h && u <= p ? s.size : n, p == (h = !N && p <= h ? p : h)) {
                                    i = s.left, g.push(D(e, r, n, i, o)), t.splice(l, 1), A = a = !0;
                                    break
                                }
                                if (h < p) {
                                    i = s.left, p = s.size - n, s = s.left + n, g.push(D(e, r, n, i, o)), t.splice(l, 1, {
                                        size: p,
                                        left: s
                                    }), A = a = !0;
                                    break
                                }
                                l++
                            }
                        } catch (t) {
                            f = !0, c = t
                        } finally {
                            try {
                                !d && v.return && v.return()
                            } finally {
                                if (f) throw c
                            }
                        }
                        a || E.push(e), 0 != t.length && 0 != t[0] || m(e)
                    }(T, l, d, f, u, h) : (r = l, n = d, i = f, o = u, l = h, C <= x ? (s(r, n, i, o, l), (Math.round(C) == x || x - C < y && 0 < x - C) && m(r)) : i <= x - z ? (s(r, n, i, o, l), m(r)) : E.push(r)), z = Math.trunc(x) >= Math.trunc(C) ? C : z, A && (e.splice(a, 1), 0 < E.length && 0 < e.length && (E = [], t(e)))
                }
            }(t)
        } else {
            var L = function (t) {
                var e = !0, r = !1, n = void 0;
                try {
                    for (var i = t[Symbol.iterator](); !(e = (o = i.next()).done); e = !0) {
                        var o = o.value;
                        F[o.left], F[o.left] = o.topSum
                    }
                } catch (t) {
                    r = !0, n = t
                } finally {
                    try {
                        !e && i.return && i.return()
                    } finally {
                        if (r) throw n
                    }
                }
            }, f = y, W = 1, k = 0, F = {}, H = !0, R = !1, j = void 0;
            try {
                for (var q, B = t[Symbol.iterator](); !(H = (q = B.next()).done); H = !0) {
                    var I, O = q.value;
                    I = I = void 0, q = (I = X(q = O)).width, I = I.height, d = Number(U / q * I), o < W ? (I = function (t) {
                        L(t);
                        var e, r = [];
                        for (e in F) {
                            var n = F[e];
                            r.push({left: e, top: n})
                        }
                        return r.sort(function (t, e) {
                            return t.top - e.top
                        }), r[0]
                    }(g), u = I.left, h = I.top) : u = 0 == k ? 0 : u + f, k < o ? g.push(D(O, d, f, u, h)) : (v.push(g), (g = []).push(D(O, d, f, u, h)), k = 0), k++, W++
                }
            } catch (t) {
                R = !0, j = t
            } finally {
                try {
                    !H && B.return && B.return()
                } finally {
                    if (R) throw j
                }
            }
            L(g), l = F
        }
        return 0 < g.length && (v.push(g), c = v[v.length - 1]), P ? 0 < v.length && (0 < a && (r = c).forEach(function (t, e) {
            t.height > t.width && r.splice(e, 1, {
                content: t.content,
                height: y,
                width: t.width,
                left: t.left,
                top: t.top,
                topSum: t.top + y
            })
        }), v.push({
            heightContainer: ((e = c).sort(function (t, e) {
                return e.topSum - t.topSum
            }), e[0].topSum)
        })) : (i = function () {
            var t, e = 0, r = [];
            for (t in l) {
                var n = l[t];
                e += n, r.push(n)
            }
            return {heightContainer: !J || K ? Math.max.apply(Math, r) : e / o, objHeightColumn: l}
        }(), v.push(i)), v;

        function D(t, e, r, n, i) {
            return {content: t, height: e, width: r, left: n, top: i, topSum: i + e}
        }
    }

    function V(t) {
        var e = X(t), r = e.width, n = e.height, t = void 0, e = {}, t = Number(r / o * Q);
        return e.width = t, e.height = Number(t / r * n), e
    }

    function l(t, e) {
        var v = 1 < arguments.length && void 0 !== e && e, s = Y(G).items, p = 0;
        t.forEach(function (f, t) {
            var c = !b || 0 != t;
            f[1].forEach(function (t, e) {
                var r, n, i, o, a, l, h = !b || 0 != e, u = t[0], d = f[0],
                    l = (n = t[1], e = i = l = a = o = void 0, t = {}, l = (e = Q / 100 * (o = n / d * 100)) / n * y, i = m ? function () {
                        var t = 0, e = 0, r = !0, n = !1, i = void 0;
                        try {
                            for (var o, a = A()[Symbol.iterator](); !(r = (o = a.next()).done); r = !0) {
                                var l = o.value, h = !0, u = !1, d = void 0;
                                try {
                                    for (var f = l[1][Symbol.iterator](); !(h = (c = f.next()).done); h = !0) {
                                        var c = c.value;
                                        t += function (t, e) {
                                            return Q / 100 * (t / e * 100) / t * y
                                        }(c[1], l[0]), e++
                                    }
                                } catch (t) {
                                    u = !0, d = t
                                } finally {
                                    try {
                                        !h && f.return && f.return()
                                    } finally {
                                        if (u) throw d
                                    }
                                }
                            }
                        } catch (t) {
                            n = !0, i = t
                        } finally {
                            try {
                                !r && a.return && a.return()
                            } finally {
                                if (n) throw i
                            }
                        }
                        return t / e
                    }() : l, a = 100 * i / e, t.w = Number(o.toFixed(7)), t.h = Number(a.toFixed(7)), t), i = l.w,
                    e = l.h;
                g && (i = 100 / s, e = 100 * g.h), v ? (o = i, a = e, t = (l = w[t = p]).firstElementChild.firstElementChild, l.style.width = o + "%", t.style.paddingBottom = a + "%") : (r = function (t, e, r, n, i, o) {
                    var a = void 0, l = void 0, h = void 0, u = void 0, d = t.parentNode;
                    l = "A" == d.tagName ? d : t, u = W(l, "div", {
                        className: "wrapper-content",
                        css: "padding-bottom: " + r + "%;"
                    }), h = W(u, "div", {className: "nicegallery-wrapper"}), a = W(h, "div", {
                        className: "nicegallery-item",
                        css: "width:" + e + "%; padding: " + n + "%;"
                    }), t.style.position = "absolute", i && !S && (a.style.paddingTop = z + "%");
                    o && !S && (a.style.paddingLeft = z + "%");
                    i && (a.style.borderTop = b + "px " + S);
                    o && (a.style.borderLeft = b + "px " + S);
                    return a
                }(u, i, e, E, c, h), N.appendChild(r), w.push(r)), p++
            })
        })
    }

    function A() {
        var e = 0, t = 1, r = Y(G), n = r.screen || 568, i = r.items || 2, o = i, a = void 0, l = [], h = [], u = [];
        if (Q <= n && null === x) {
            var d = !0, f = !1, c = void 0;
            try {
                for (var v = C[Symbol.iterator](); !(d = (s = v.next()).done); d = !0) {
                    var s = s.value, a = L(s);
                    e += a, t <= o ? b(s) : (S(s), o += i), t++
                }
            } catch (t) {
                f = !0, c = t
            } finally {
                try {
                    !d && v.return && v.return()
                } finally {
                    if (f) throw c
                }
            }
        } else {
            var p = !0, y = !1, g = void 0;
            try {
                for (var m = C[Symbol.iterator](); !(p = (w = m.next()).done); p = !0) {
                    var w = w.value;
                    a = L(w), ((e += a) <= Q + 50 ? b : S)(w)
                }
            } catch (t) {
                y = !0, g = t
            } finally {
                try {
                    !p && m.return && m.return()
                } finally {
                    if (y) throw g
                }
            }
        }
        return u.push([l.pop(), h]), 1 < u.length && (((n = (r = u[u.length - 1])[0]) <= Q / 2 || 1 == r[1].length) && (l = u.pop(), u[u.length - 1][0] = u[u.length - 1][0] + n, (n = u[u.length - 1][1]).push.apply(n, k(l[1])))), u;

        function b(t) {
            h.push([t, a]), l.push(e)
        }

        function S(t) {
            e = 0, e += L(t), u.push([l.pop(), h]), (h = []).push([t, a]), l.push(e)
        }
    }

    function L(t) {
        var e = X(t), t = e.width, e = e.height, t = Number(y / e * t);
        return Number(t.toFixed(5))
    }

    function X(t) {
        var e = {};
        return null === g || i ? (n ? (e.width = t.dataset.width, e.height = t.dataset.height) : (e.width = t.naturalWidth, e.height = t.naturalHeight), P && (e.width >= 1.7 * e.height ? (e.width = 2, e.height = 1) : 1.2 * e.width <= e.height ? (e.width = 1, e.height = 2) : (e.width = 1, e.height = 1))) : (e.width = g.w, e.height = g.h), e
    }

    function Y(t) {
        if (t) {
            t.sort(function (t, e) {
                return t.screen - e.screen
            });
            var e = !0, r = !1, n = void 0;
            try {
                for (var i = t[Symbol.iterator](); !(e = (o = i.next()).done); e = !0) {
                    var o = o.value;
                    if (window.innerWidth <= o.screen) return o
                }
            } catch (t) {
                r = !0, n = t
            } finally {
                try {
                    !e && i.return && i.return()
                } finally {
                    if (r) throw n
                }
            }
        }
        return !1
    }

    function W(t, e, r, n) {
        r = 2 < arguments.length && void 0 !== r && r, n = !(3 < arguments.length && void 0 !== n) || n, e = document.createElement(e);
        return t.parentNode.insertBefore(e, t), n && e.appendChild(t), r && h(r, e), e
    }

    function h(t, e) {
        for (var r in t) e[r] = t[r], "css" == r && (e.style.cssText = t[r])
    }

    a(), i ? window.addEventListener("resize", function (t) {
        var e, r, n;
        N.style.height = (e = Q, r = M, ((n = n || N.clientWidth) < Q || Q < n ? n / e * r : Q == n ? r : void 0) + "px")
    }) : window.addEventListener("resize", function (t) {
        var e = Y(G);
        e.screen, e.items;
        N.clientWidth <= Q && l(A(), !0)
    })
}
//
// if ("undefined" != typeof options) {
//     var e = !0, r = !1, n = void 0;
//     try {
//         for (var i = options[Symbol.iterator](); !(e = (o = i.next()).done); e = !0) {
//             var o = o.value;
//             console.log(o), t("#" + o.id, o)
//         }
//     } catch (t) {
//         r = !0, n = t
//     } finally {
//         try {
//             !e && i.return && i.return()
//         } finally {
//             if (r) throw n
//         }
//     }
// }