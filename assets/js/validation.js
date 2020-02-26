// dataSubmit = function(form) {
//   $(form).ajaxSubmit({
//     dataType: "json",
//     success: function(result) {
//       setTimeout(function() {
//         location.href = result;
//       }, 500);
//     }
//   });
// };
dataSubmit = function(form) {
  $(form).ajaxSubmit({
    dataType: "json",
    success: function(result) {
      if (result.error === true) {
        Swal.fire({
          title: result.title,
          text: result.msg,
          icon: "warning",
          showCancelButton: true,
          showConfirmButton: false,
          buttonsStyling: true
        });
      } else {
        Swal.fire({
          title: result.title,
          text: result.msg,
          icon: "success",
          showCancelButton: false,
          confirmButtonText: "OK",
          buttonsStyling: true
        }).then(function(isConfirm) {
          if (isConfirm) {
            location.href = result.url;
          }
        });
      }
    }
  });
};

$(function() {
  if ($("#formUser").length) {
    $("#formUser").validate({
      rules: {
        ad_fullname: {
          required: true
        },
        ad_email: {
          required: true,
          remote: {
            url: $("#ad_email").attr("data-url"),
            type: "post",
            data: {
              ad_email: function() {
                return $("#ad_email").val();
              }
            }
          }
        },
        position: {
          required: true
        },
        passwordA: {
          required: true,
          minlength: 8
        },
        password_confirmation: {
          required: true,
          minlength: 8,
          equalTo: "#passwordA"
        }
      },
      messages: {
        ad_fullname: {
          required: "please enter Full Name."
        },
        ad_email: {
          required: "please enter Email.",
          remote: "This Email is already."
        },
        position: {
          required: "please Select Role."
        },
        passwordA: {
          required: "please enter password.",
          minlength: "Please specify at least 8 characters."
        },
        password_confirmation: {
          required: "please enter confirm password.",
          minlength: "Please specify at least 8 characters.",
          equalTo: "Please specify the same password as the password."
        }
      },
      submitHandler: function(form) {
        dataSubmit(form);
        return false;
      }
    });
  }

  if ($("#formUser_edit").length) {
    $("#formUser_edit").validate({
      rules: {
        ad_fullname: {
          required: true
        },
        ad_email: {
          required: true,
          remote: {
            url: $("#ad_email").attr("data-url"),
            type: "post",
            data: {
              ad_email: function() {
                return $("#ad_email").val();
              }
            }
          }
        },
        position: {
          required: true
        }
      },
      messages: {
        ad_fullname: {
          required: "please enter Full Name."
        },
        ad_email: {
          required: "please enter Email.",
          remote: "This Email is already."
        },
        position: {
          required: "please Select Role."
        }
      },
      submitHandler: function(form) {
        dataSubmit(form);
        return false;
      }
    });
  }

  if ($("#formRepass").length) {
    $("#formRepass").validate({
      rules: {
        passwordA: {
          required: true,
          minlength: 8
        },
        password_confirmation: {
          required: true,
          minlength: 8,
          equalTo: "#passwordA"
        }
      },
      messages: {
        passwordA: {
          required: "please enter password.",
          minlength: "Please specify at least 8 characters."
        },
        password_confirmation: {
          required: "please enter confirm password.",
          minlength: "Please specify at least 8 characters.",
          equalTo: "Please specify the same password as the password."
        }
      },
      submitHandler: function(form) {
        dataSubmit(form);
        return false;
      }
    });
  }

  if ($("#formFaculty").length) {
    $("#formFaculty").validate({
      rules: {
        fac_name: {
          required: true,
          remote: {
            url: $("#fac_name").attr("data-url"),
            type: "post",
            data: {
              fac_name: function() {
                return $("#fac_name").val();
              }
            }
          }
        }
      },
      messages: {
        fac_name: {
          required: "please enter Faculty name.",
          remote: "This Faculty name is already."
        }
      },
      submitHandler: function(form) {
        dataSubmit(form);
        return false;
      }
    });
  }

  if ($("#formDept").length) {
    $("#formDept").validate({
      rules: {
        dept_name: {
          required: true,
          remote: {
            url: $("#dept_name").attr("data-url"),
            type: "post",
            data: {
              dept_name: function() {
                return $("#dept_name").val();
              }
            }
          }
        }
      },
      messages: {
        dept_name: {
          required: "please enter Department name.",
          remote: "This Department name is already."
        }
      },
      submitHandler: function(form) {
        dataSubmit(form);
        return false;
      }
    });
  }

  if ($("#formProduct").length) {
    $("#formProduct").validate({
      rules: {
        pdt_name: {
          required: true,
          remote: {
            url: $("#pdt_name").attr("data-url"),
            type: "post",
            data: {
              pdt_name: function() {
                return $("#pdt_name").val();
              }
            }
          }
        },
        pdt_price: {
          required: true
        }
      },
      messages: {
        pdt_name: {
          required: "please enter Product name.",
          remote: "This Product name is already."
        },
        pdt_price: {
          required: "please enter Product price."
        }
      },
      submitHandler: function(form) {
        dataSubmit(form);
        return false;
      }
    });
  }

  if ($("#formStock1").length) {
    $("#formStock1").validate({
      rules: {
        stock_text: {
          required: true,
          remote: {
            url: $("#stock_text").attr("data-url"),
            type: "post",
            data: {
              stock_text: function() {
                return $("#stock_text").val();
              }
            }
          }
        },
        stock_quantity: {
          required: true
        }
      },
      messages: {
        stock_text: {
          required: "please enter Size.",
          remote: "This Size is already."
        },
        stock_quantity: {
          required: "please enter Quantity price."
        }
      },
      submitHandler: function(form) {
        dataSubmit(form);
        return false;
      }
    });
  }

  if ($("#formStock2").length) {
    $("#formStock2").validate({
      rules: {
        stock_quantity: {
          required: true
        },
        add_stock_quantity: {
          required: true
        }
      },
      messages: {
        stock_quantity: {
          required: "please enter Quantity."
        },
        add_stock_quantity: {
          required: "please enter Quantity."
        }
      },
      submitHandler: function(form) {
        dataSubmit(form);
        return false;
      }
    });
  }

  if ($("#formPack").length) {
    $("#formPack").validate({
      rules: {
        sex_id: {
          required: true
        },
        stdtype_id: {
          required: true
        }
      },
      messages: {
        sex_id: {
          required: "please select Sex for this package."
        },
        stdtype_id: {
          required: "please select Course for this package."
        }
      },
      submitHandler: function(form) {
        dataSubmit(form);
        return false;
      }
    });
  }

  if ($("#formSetupPack").length) {
    $("#formSetupPack").validate({
      rules: {
        optgroup: {
          required: true
        },
      },
      messages: {
        optgroup: {
          required: "please select Product."
        },
      },
      submitHandler: function(form) {
        dataSubmit(form);
        return false;
      }
    });
  }

  if ($("#formStudent").length) {
    $("#formStudent").validate({
      rules: {
        stdtype_id: {
          required: true,
        },
        sex_id: {
          required: true,
        },
        std_indent: {
          required: true,
          remote: {
            url: $("#std_indent").attr("data-url"),
            type: "post",
            data: {
              std_indent: function() {
                return $("#std_indent").val();
              }
            }
          }
        },
        std_number: {
          required: true,
          remote: {
            url: $("#std_number").attr("data-url"),
            type: "post",
            data: {
              std_number: function() {
                return $("#std_number").val();
              }
            }
          }
        },
        std_title: {
          required: true,
        },
        std_fname: {
          required: true,
        },
        std_lname: {
          required: true,
        },
      },
      messages: {
        stdtype_id: {
          required: "please select Course.",
        },
        sex_id: {
          required: "please select Sex.",
        },
        std_indent: {
          required: "please enter ID Card no.",
          remote: "This ID Card is already."
        },
        std_number: {
          required: "please enter Student number.",
          remote: "This Student number is already."
        },
        std_title: {
          required: "please select Name Title.",
        },
        std_fname: {
          required: "please enter First name.",
        },
        std_lname: {
          required: "please enter Surname.",
        },
      },
      submitHandler: function(form) {
        dataSubmit(form);
        return false;
      }
    });
  }

  if ($("#formImport").length) {
    $("#formImport").validate({
      rules: {
        csv_file: {
          required: true,
        },
      },
      messages: {
        csv_file: {
          required: "please select File import.",
        },
      },
      submitHandler: function(form) {
        dataSubmit(form);
        return false;
      }
    });
  }
});
