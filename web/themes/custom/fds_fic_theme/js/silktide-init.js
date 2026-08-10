(function (s, i, l, k, y) {
  s[i] = s[i] || y;
  s[l] = s[l] || [];
  s[k] = function (e, p) {
    p = p || {};
    p.event = e;
    p.time = Date.now();
    s[l].push(p);
  };
  s[k]('page_load');
})(window, 'stConfig', 'stEvents', 'silktide', {});
