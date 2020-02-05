$.ajax({
  type: "GET",
  url: "/API/?User/users",
  success: function(result) {
    $("#phone-number").prop("value", result.session.phone);
    $.each(result.results, function(index, value) {
      $("#receivers").append(
        "<a class='dropdown-item d-flex justify-content-between' value =" +
          value.username +
          ">" +
          value.firstName +
          " " +
          value.lastName +
          "<span>" +
          value.mobilephone +
          "</span></a>"
      );
    });
  }
});

// Add value/text to dropdown btn when user clicks a name.
$("#receivers").on("click", ".dropdown-item", function(e) {
  $("#receiverHidden").prop("value", $(this).attr("value"));
  $("#dropdownMenuReceivers").html(
    e.target.textContent.substr(0, e.target.textContent.length - 11)
  );
  $("#receiver-phone").prop(
    "value",
    e.target.textContent.substr(
      e.target.textContent.length - 11,
      e.target.textContent.length
    )
  );
});

// Add value/text to dropdown btn when user clicks a name.
$("#payments").on("click", ".dropdown-item", function(e) {
  $("#paymentsHidden").prop("value", $(this).attr("value"));
  $("#dropdownMenuPayments").html(e.target.textContent);
  if (e.target.textContent == "Swish") {
    $("#phone-container").toggleClass("hidden");
  } else {
    if (!$("#phone-container").hasClass("hidden")) {
      $("#phone-container").toggleClass("hidden");
    }
  }
});

$("#transfer-btn").on("click", function(e) {
  e.preventDefault();
  if ($(".error")) {
    $(".error").remove();
  }
  ajaxTransfer();
});

function ajaxTransfer() {
  var amount = $("#amount").val();
  var paymentMethod = $("#paymentsHidden").val();
  var receiver = $("#receiverHidden").val();
  if (paymentMethod == "") {
    $("#message").append(
      '<h6 class = "error text-danger">Payment method is required </h6>'
    );
  } else {
    $.ajax({
      type: "POST",
      url: "/API/?Transaction/" + $("#paymentsHidden").val(),
      dataType: "json",
      data: { amount: amount, method: paymentMethod, receiver: receiver },
      success: function(result) {
        if (result.info.no == 0) {
          $("#message").append(
            '<h6 class = "error text-danger">' + result.info.message + "</h6>"
          );
        } else {
          resetForm();
          $("#message").append(
            '<h6 class = "error text-success">' + result.info.message + "</h6>"
          );
        }
      }
    });
  }
}

function resetForm() {
  $("#dropdownMenuPayments").html("Select payment method");
  $("#dropdownMenuReceivers").html("Select receiver");
  $("#paymentsHidden").prop("value", "");
  $("#receiverHidden").prop("value", "");
  $("#receiver-phone").prop("value", "");
  $("#amount").val("");
  if (!$("#phone-container").hasClass("hidden")) {
    $("#phone-container").toggleClass("hidden");
  }
}
