jQuery(document).ready(function ($) {
  $(".delete-event-button").on("click", function (e) {
    e.preventDefault();

    var eventId = $(this).data("id");

    if (confirm("Are you sure you want to delete this event?")) {
      $.ajax({
        type: "POST",
        url: ajax_object.ajax_url,
        data: {
          action: "delete_event",
          event_id: eventId,
          nonce: ajax_object.nonce,
        },
        success: function (response) {
          if (response.success) {
            alert("Event deleted successfully!");
            location.reload();
          } else {
            alert("Error: " + response.data);
          }
        },
        error: function () {
          alert("AJAX error. Please try again.");
        },
      });
    }
  });
});
