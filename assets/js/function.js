// hide
if ($(".hide").length) {
  $(".hide").hide();
}
// input date
if ($(".date").length) {
  $(".date").inputmask("yyyy-mm-dd", { placeholder: "____/__/__" });
}

// format random
function makeid(length) {
  var result = "";
  var characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  var charactersLength = characters.length;
  for (var i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}
// random password
function fncRanpass(e) {
  var random = makeid(8);
  $("#passwordA").val(random);
  $("#password_confirmation").val(random);
  $("#random").val(random);
}
// delete
function fncDelete(e) {
  Swal.fire({
    title: "Are you sure?",
    text: "You want delete this item?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonClass: "btn btn-danger",
    cancelButtonClass: "btn",
    confirmButtonText: "Delete",
    buttonsStyling: false
  }).then(result => {
    if (result.value) {
      var url = $(e).attr("data-url");
      location.href = url;
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      Swal.close();
    }
  });
}
// change status
function fncChange(e) {
  Swal.fire({
    title: "Are you sure?",
    text: "You want Update status Orders to " + $(e).attr("data-status") + " ?",
    icon: "warning",
    input: "text",
    inputPlaceholder: "Note...",
    inputValue: $(e).attr("data-note"),
    inputAttributes: {
      autocapitalize: "off"
    },
    showCancelButton: true,
    confirmButtonText: "Change",
    showLoaderOnConfirm: true
  }).then(result => {
    // console.log(result);
    if (result.value) {
      $.ajax({
        type: "POST",
        url: $(e).attr("data-url"),
        data: { note: result.value },
        cache: false,
        success: function(response) {
          Swal.fire({
            title: "Success",
            text: "Change Status success",
            icon: "success",
            showCancelButton: false,
            confirmButtonText: "OK",
            buttonsStyling: true
          }).then(function(isConfirm) {
            if (isConfirm) {
              location.reload();
            }
          });
        },
        failure: function(response) {
          location.reload();
        }
      });
    } else if (result.dismiss) {
      Swal.close();
    } else {
      Swal.fire({
        title: "Warning",
        text: "please enter Note before changing status",
        icon: "error",
        showCancelButton: true,
        showConfirmButton: false,
        buttonsStyling: true
      });
    }
  });
}
//edit EditUnit
function fncEditUnit(e) {
  Swal.fire({
    text: "Update Unit: " + $(e).attr("data-pdtname"),
    input: "number",
    inputValue: $(e).attr("data-unit"),
    inputAttributes: {
      autocapitalize: "off"
    },
    showCancelButton: true,
    confirmButtonText: "Save",
    showLoaderOnConfirm: true
  }).then(result => {
    if (result.value) {
      console.log(result);
      $.ajax({
        type: "POST",
        url: $(e).attr("data-url"),
        data: { unit: result.value },
        cache: false,
        success: function(response) {
          Swal.fire({
            title: "Success",
            text: "update Unit success",
            icon: "success",
            showCancelButton: false,
            confirmButtonText: "OK",
            buttonsStyling: true
          }).then(function(isConfirm) {
            if (isConfirm) {
              location.reload();
            }
          });
        },
        failure: function(response) {
          location.reload();
          // swal(
          //   "Internal Error",
          //   "Oops, your note was not saved.", // had a missing comma
          //   "error"
          // );
        }
      });
    }
  });
}
