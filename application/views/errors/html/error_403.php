<html>

<head>
    <title>403 Error</title>
    <link rel="icon" href="<?= base_url('assets/inspinia/images/logo/icon.png'); ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?= base_url('assets/inspinia/images/logo/icon.png'); ?>" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Lato');

        * {
            position: relative;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Lato', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to bottom right, #eee, #aaa);
        }

        h1 {
            margin: 40px 0 5px;
            text-align: center;
        }

        .lock {
            border-radius: 5px;
            width: 55px;
            height: 45px;
            background-color: #333;
            animation: dip 1s;
            animation-delay: 1.5s;
        }

        .lock::before,
        .lock::after {
            content: '';
            position: absolute;
            border-left: 5px solid #333;
            height: 20px;
            width: 15px;
            left: calc(50% - 12.5px);
        }

        .lock::before {
            top: -30px;
            border: 5px solid #333;
            border-bottom-color: transparent;
            border-radius: 15px 15px 0 0;
            height: 30px;
            animation: lock 2s, spin 2s;
        }

        .lock::after {
            top: -10px;
            border-right: 5px solid transparent;
            animation: spin 2s;
        }

        @keyframes lock {
            0% {
                top: -45px;
            }

            65% {
                top: -45px;
            }

            100% {
                top: -30px;
            }
        }

        @keyframes spin {
            0% {
                transform: scaleX(-1);
                left: calc(50% - 30px);
            }

            65% {
                transform: scaleX(1);
                left: calc(50% - 12.5px);
            }
        }

        @keyframes dip {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(10px);
            }

            100% {
                transform: translateY(0px);
            }
        }
    </style>
</head>

<body>
    <div class="lock"></div>
    <div class="message">
        <h1>การเข้าถึงหน้านี้ถูกจำกัด</h1>
        <p>โปรดตรวจสอบกับผู้ดูแลเว็บไซต์หากคุณเชื่อว่านี่เป็นข้อผิดพลาด</p>
        <a href="" style="color:#c0392b"><u>
                <h4 style="text-align:center">กลับหน้าแรก</h4>
            </u></a>
    </div>
</body>
</html>