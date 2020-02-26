<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

    <title><? if (!empty($title)) {
                echo $title;
            } ?></title>
    <!-- ico -->
    <link rel="icon" href="<?= base_url('assets/img/RMUTR.png'); ?>" type="image/x-icon">
    <!-- Custom Css -->
    <link rel="stylesheet" href="<?= base_url('assets/a-frontEnd/plugins/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/a-frontEnd/plugins/bootstrap-select/css/bootstrap-select.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/a-frontEnd/plugins/multi-select/css/multi-select.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/a-frontEnd/css/main.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/a-frontEnd/css/color_skins.css'); ?>">
    <style>
        .theme-black .menu-container .h-menu>li a {
            color: #ffffff;
        }

        .menu-container {
            top: 50px;
        }

        .btn-round.btn-simple {
            padding: 5px 20px;
        }

        .error {
            color: #c0392b;
            font-size: 12px;
        }

        .ms-container {
            width: 100% !important;
        }

        .input-group-text {

            border-radius: 0;
        }

        @media only screen and (max-width: 768px) {
            .disnone {
                display: none;
            }

            /* .ms-container .ms-selectable,
            .ms-container .ms-selection {
                width: 100% !important;
            } */
        }
        @media only screen and (max-width: 539px) {
            /* .disnone {
                display: none;
            } */

            .ms-container .ms-selectable,
            .ms-container .ms-selection {
                width: 100% !important;
            }
        }
    </style>
    <? if (!empty($css)) {
        echo $css;
    } ?>
</head>

<body class="theme-black">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img src="<?= base_url('assets/img/RMUTR.png'); ?>" width="100" height="100" alt="RMUTR"></div>
            <p>Please wait...</p>
        </div>
    </div>
    <nav class="navbar" style="background-color: #f4f7f6 !important;">
        <div class="container">
            <ul class="nav navbar-nav">
                <li class="float-right">
                    <div class="navbar-header">
                        <a href="javascript:void(0);" class="h-bars"></a>
                        <a class="navbar-brand" href="index.html"><span class="m-l-10 disnone">มหาวิทยาลัยเทคโนโลยีราชมงคลรัตนโกสินทร์</span> <img src="<?= base_url('assets/img/RMUTR.png'); ?>" width="35" alt="Alpino"></a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="menu-container" style="background-color: #c0392b !important;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="h-menu ">
                        <li class="float-right"><a href="<?= site_url('extra'); ?>">สั่งซื้อเพิ่มเติม</a></li>
                        <li class="float-right"><a href="<?= site_url('main'); ?>">หน้าแรก</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content -->
    <section class="content">
        <div class="container">
            <?= $contents; ?>
        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="<?= base_url('assets/a-frontEnd/bundles/libscripts.bundle.js'); ?>"></script> <!-- Lib Scripts Plugin Js -->
    <script src="<?= base_url('assets/a-frontEnd/bundles/vendorscripts.bundle.js'); ?>"></script> <!-- Lib Scripts Plugin Js -->
    <script src="<?= base_url('assets/plugins/jqueryForm/jquery.form.js'); ?>"></script>
    <script src="<?= base_url('assets/a-frontEnd/plugins/jquery-validation/jquery.validate.js'); ?>"></script> <!-- Jquery Validation Plugin Css -->
    <script src="<?= base_url('assets/a-frontEnd/plugins/jquery-inputmask/jquery.inputmask.bundle.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/sweetalert/sweetalert2.all.min.js'); ?>"></script>
    <script src="<?= base_url('assets/a-frontEnd/plugins/multi-select/js/jquery.multi-select.js'); ?>"></script>

    <!-- custom -->
    <? if (!empty($js)) {
        echo $js;
    } ?>
    <script src="<?= base_url('assets/a-frontEnd/bundles/mainscripts.bundle.js'); ?>"></script>
    <script>
        if ($("#optgroup").length) {
            $('#optgroup').multiSelect({
                selectableOptgroup: true
            });
        }
        if ($(".stdno").length) {
            $(".stdno").inputmask("*************", {
                placeholder: "_____________"
            });
        }
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
                        location.href = result.url;
                    }
                }
            });
        };
        if ($("#findnumber").length) {
            $("#findnumber").validate({
                rules: {
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
                },
                messages: {
                    std_number: {
                        required: "กรุณากรอกรหัสนักศึกษา",
                        remote: "ไม่พบรหัสนักศึกษาที่คุณค้นหา."
                    },
                },
                submitHandler: function(form) {
                    $("#findnumber").submit();
                }
            });
        }
        if ($("#formOders").length) {
            $("#formOders").validate({
                submitHandler: function(form) {
                    dataSubmit(form);
                    return false;
                }
            });
        }

        if ($("#formExtra").length) {
            $("#formExtra").validate({
                rules: {
                    std_number: {
                        required: true,
                    },
                },
                messages: {
                    std_number: {
                        required: "กรุณากรอกรหัสนักศึกษา",
                    },
                },
                submitHandler: function(form) {
                    dataSubmit(form);
                    return false;
                }
            });
        }

        function fncGetdata(e) {
            $.ajax({
                type: "POST",
                url: $(e).attr("data-url"),
                data: {
                    val: $(e).val()
                },
                cache: false,
                success: function(result) {
                    console.log(result);
                    if (result === 'false') {
                        var html = '<div class="alert alert-dark text-right" role="alert" style="color: #333">ไม่พบรหัสนักศึกษาที่คุณค้นหา</div>';
                        $('#getData').html(html);
                    } else {
                        var data = JSON.parse(result);
                        var html =
                            '<div class="alert alert-dark" role="alert" style="color: #333">' +
                            '<p class="m-b-0">' +
                            '<strong>สาขา: </strong> ' + data.deptname +
                            ' <strong>รหัสนักศึกษา: </strong> ' + data.stdnumber +
                            ' <strong> ชื่อเต็ม: </strong>' + data.fullname +
                            ' <strong> หลักสูตร: </strong>' + data.stdtypetext +
                            ' <strong> เพศ: </strong>' + data.sextext +
                            '</p>' +
                            '</div>';
                        $('#getData').html(html);
                        $('#std_id').val(data.stdid);
                    }
                    // location.reload();
                },
            });
        }

        function fncChangeSize(e) {
            $.ajax({
                type: "POST",
                url: $(e).attr("data-url"),
                data: {
                    val: $(e).val()
                },
                cache: false,
                success: function(response) {
                    // console.log(response);
                    // location.reload();
                },
            });
        }

        function fncChangeUnit(e) {
            $.ajax({
                type: "POST",
                url: $(e).attr("data-url"),
                data: {
                    val: $(e).val()
                },
                cache: false,
                success: function(result) {
                    var data = JSON.parse(result);
                    $('.subtotal' + $(e).attr("data-pdtid")).text(data.subtotal);
                    $('.orderTotal').text(data.total);
                    // console.log(data);
                    // console.log(result);
                    // location.reload();
                },
            });
        }
    </script>
</body>

</html>