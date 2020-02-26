<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin</title>

    <link rel="icon" href="<?= base_url('assets/img/RMUTR.png'); ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?= base_url('assets/img/RMUTR.png'); ?>" type="image/x-icon">

    <link href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <style>
        @import url("https://fonts.googleapis.com/css?family=Fira+Sans");

        html,
        body {
            position: relative;
            min-height: 100vh;
            background-color: #E1E8EE;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Fira Sans", Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .form-structor {
            background-color: #222;
            border-radius: 15px;
            height: 550px;
            width: 350px;
            position: relative;
            overflow: hidden;
        }

        .form-structor::after {
            content: '';
            opacity: .8;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-repeat: no-repeat;
            background-position: left top;
            background-size: 400px;
            background-image: url('https://cdn.pixabay.com/photo/2017/10/12/22/14/background-2846206_960_720.jpg');
        }

        .login {
            position: absolute;
            top: 40%;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #fff;
            z-index: 5;
            -webkit-transition: all .3s ease;
        }

        .login::before {
            content: '';
            position: absolute;
            left: 50%;
            top: -20px;
            -webkit-transform: translate(-50%, 0);
            background-color: #fff;
            width: 200%;
            height: 250px;
            border-radius: 50%;
            z-index: 4;
            -webkit-transition: all .3s ease;
        }

        .center {
            position: absolute;
            top: calc(50% - 10%);
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            width: 65%;
            z-index: 5;
            -webkit-transition: all .3s ease;
        }

        .center .form-title {
            color: #000;
            font-size: 1.7em;
            text-align: center;
        }

        .center .form-title span {
            color: rgba(0, 0, 0, 0.4);
            opacity: 0;
            visibility: hidden;
            -webkit-transition: all .3s ease;
        }

        .form-holder {
            border-radius: 15px;
            background-color: #fff;
            border: 1px solid #eee;
            overflow: hidden;
            margin-top: 50px;
            opacity: 1;
            visibility: visible;
            -webkit-transition: all .3s ease;
        }

        .form-holder .input {
            border: 0;
            outline: none;
            box-shadow: none;
            display: block;
            height: 45px;
            line-height: 30px;
            padding: 8px 15px;
            border-bottom: 1px solid #eee;
            width: 100%;
            font-size: 12px;
        }

        .form-holder .input:last-child {
            border-bottom: 0;
        }

        .form-holder .input::-webkit-input-placeholder {
            color: rgba(0, 0, 0, 0.4);
        }

        .submit-btn {
            background-color: #6B92A4;
            color: rgba(256, 256, 256, 0.7);
            border: 0;
            border-radius: 15px;
            display: block;
            margin: 15px auto;
            padding: 15px 45px;
            width: 100%;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            opacity: 1;
            visibility: visible;
            -webkit-transition: all .3s ease;
        }

        .submit-btn:hover {
            transition: all .3s ease;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .text-danger {
            color: #a94442;
            font-size: 10px;
            text-align: center;
            margin-top: 5px;
        }

        label.error {
            display: block;
            margin-bottom: 0;
            font-size: 10px;
            text-align: right;
            color: red;
        }
    </style>

</head>

<body>
    <div class="form-structor">
        <div class="login slide-up">
            <div class="center">
                <h2 class="form-title" id="login">Log in</h2>
                <form class="m-t" role="form" method="post" action="<?= site_url('authen/authen'); ?>" id="formLogin">
                    <input type="hidden" name="formcrf" id="formcrf" value="<?= $formcrf; ?>">
                    <div class="form-holder">
                        <input type="email" class="input" name="username" id="username" placeholder="Username" required="" />
                        <input type="password" class="input" name="password" id="password" placeholder="Password" required="" style="border-top: 1px solid #eee;"/>
                    </div>
                    <label class="error" style="margin-top: 5px"><?= $msg; ?></label>
                    <button class="submit-btn" type="submit">Log in</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Mainly scripts -->
    <script src="<?= base_url('assets/bundles/libscripts.bundle.js'); ?>"></script> <!-- Lib Scripts Plugin Js -->
    <script src="<?= base_url('assets/bundles/vendorscripts.bundle.js'); ?>"></script> <!-- Lib Scripts Plugin Js -->
    <script src="<?= base_url('assets/bundles/mainscripts.bundle.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/jquery-validation/jquery.validate.js'); ?>"></script>
    <script>
        if ($("#formLogin").length) {
            $("#formLogin").validate({
                rules: {
                    username: {
                        required: true,
                    },
                    password: {
                        required: true,
                    }
                },
                messages: {
                    username: {
                        required: "please enter username.",
                    },
                    password: {
                        required: "please enter password.",
                    }
                },
                submitHandler: function() {
                    $('#formLogin').submit();
                }
            });
        }
    </script>


</body>

</html>