App.Utils.renderer.publicationperiod = function(v) {
  var period = (v.start || "...") + ' <i class="uk-icon-arrow-right"></i> ' + (v.end || "...");
  return '<span class="uk-text-small uk-text-muted">' + period + "</span>";
};
