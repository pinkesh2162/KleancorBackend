(function ($) {
  wp.customize("header_bg_color", function (value) {
    value.bind(function (to) {
      $(".site-header").css("background-color", to);
    });
  });
})(jQuery);
