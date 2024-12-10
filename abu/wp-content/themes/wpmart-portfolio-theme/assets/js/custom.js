jQuery(document).ready(function ($) {
  // Initializing Isotope
  var $grid = $(".isotope-wrapper").isotope({
    itemSelector: ".wpmart-pt-project-container",
    layoutMode: "fitRows",
  });

  // Filtering functionality
  $(".wpmart-pt-project-category-filter").on(
    "click",
    ".wpmart-pt-project-category-filter-item",
    function (e) {
      e.preventDefault();

      // Get filter value and apply it
      var filterValue = $(this).attr("data-filter");
      $grid.isotope({ filter: filterValue });

      // Update active class
      $(
        ".wpmart-pt-project-category-filter .wpmart-pt-project-category-filter-item"
      ).removeClass("active");
      $(this).addClass("active");
    }
  );

  

  // Testimonial Slider
  $('.wpmart-pt-testimonial-slider').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 3000,
      // arrows: true, 
      // dots: true, 
      infinite: true,
      speed: 500, 
      fade: false, 
      cssEase: 'linear',
      draggable: true, 
      adaptiveHeight: false,
      pauseOnHover: true, 
      pauseOnFocus: true, 
      responsive: [ 
          {
              breakpoint: 768,
              settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1
              }
          },
          {
              breakpoint: 480,
              settings: {
                  slidesToShow: 1,
                  slidesToScroll: 1
              }
          }
      ]
  });

  // View Demo
  var list = [
    {
      id: "demo-883",
      url: [
        "ht",
        "tps",
        "://",
        "cha",
        "ru",
        "baz",
        "ar",
        ".",
        "c",
        "om",
      ],
    },
    {
      id: "demo-880",
      url: [
        "ht",
        "tps",
        "://",
        "fre",
        "en",
        "cra",
        "ft",
        ".",
        "c",
        "om",
      ],
    },
    {
      id: "demo-877",
      url: [
        "ht",
        "tps",
        "://",
        "the",
        "hy",
        "pe",
        "digi",
        "tal",
        ".",
        "c",
        "om",
      ],
    },
    {
      id: "demo-874",
      url: [
        "ht",
        "tps",
        "://",
        "villa",
        "duma",
        "ss",
        "if",
        ".",
        "c",
        "om",
      ],
    },
    {
      id: "demo-866",
      url: [
        "ht",
        "tps",
        "://",
        "ill",
        "iyu",
        "nsc",
        "hool",
        ".",
        "c",
        "om",
      ],
    },
    {
      id: "demo-886",
      url: [
        "ht",
        "tps",
        "://",
        "play",
        ".goog",
        "le.c",
        "om",
        "/sto",
        "re/a",
        "pps/d",
        "etails?id=c",
        "om.kleanc",
        "or.klean",
        "corapp",
      ],
    },
  ];
  
  var demo = document.querySelectorAll(".wpmart-pt-view-demo");
  if (demo.length) {
    demo.forEach(function (el) {
      el.addEventListener("click", function (event) {
        var id = event.target.getAttribute("id");
        if (id) {
          for (var i = 0; i < list.length; i++) {
            if (id == list[i].id) {
              window.open(list[i].url.join(""), "_blank");
            }
          }
        }
      });
    });
  }
  
});
