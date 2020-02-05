// Get transactions history from API on login user.

$.ajax({
  type: "GET",
  url: "/API/?User/transactions",
  success: function(result) {
    if (result.results == null) {
      $("#history").append(
        "<tr><td class = 'text-left'>No transactions made</td></tr>"
      );
    } else {
      var id = result.session.id;
      $.each(result.results, function(index, value) {
        if (value.id == id) {
          $("#history-tbody").append(
            "<tr><td class = 'text-left'>Transaction account</td><td>" +
              value.date +
              "</td><td class = 'text-danger'>-" +
              value.from_amount +
              " " +
              value.from_currency +
              "</td></tr>"
          );
        } else if (value.id != id) {
          $("#history").append(
            "<tr><td class = 'text-left'>" +
              value.firstName +
              " " +
              value.lastName +
              "</td><td>" +
              value.date +
              "</td><td class = 'text-success'>" +
              value.to_amount +
              " " +
              value.to_currency +
              "</td></tr>"
          );
        }
      });
    }
  }
});
