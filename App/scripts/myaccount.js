// Get balance history from API on login user.

$.ajax({
  type: "GET",
  url: "/API/?User/balance",
  success: function(result) {
    $(".account-info").append(
      "<span><i>" +
        result.results[0].balance +
        "</i> " +
        result.results[0].currency +
        "</span>"
    );
  }
});
