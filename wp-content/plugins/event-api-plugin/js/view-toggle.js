jQuery(document).ready(function ($) {
  $(".toggle-button").on("click", function () {
    var view = $(this).data("view");
    $(".event-list").removeClass("grid list").addClass(view);
    $(".toggle-button").removeClass("active");
    $(this).addClass("active");

    localStorage.setItem("eventView", view);
  });

  var storedView = localStorage.getItem("eventView");
  if (storedView) {
    $(".event-list").removeClass("grid list").addClass(storedView);
    $(".toggle-button").removeClass("active");
    $('.toggle-button[data-view="' + storedView + '"]').addClass("active");
  }

  $("#category-filter").on("change", function () {
    var selectedCategory = $(this).val();
    var currentUrl = window.location.href.split("?")[0];
    var newUrl = "";

    if (selectedCategory) {
      newUrl = currentUrl + "?category=" + selectedCategory;
    } else {
      newUrl = currentUrl;
    }
    window.location.href = newUrl;
  });
});
