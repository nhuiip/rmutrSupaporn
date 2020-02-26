<?php
function DateThai($strDate)
{
  $strYear = date("Y", strtotime($strDate)) + 543;
  $strMonth = date("n", strtotime($strDate));
  $strDay = date("j", strtotime($strDate));
  $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
  $strMonthThai = $strMonthCut[$strMonth];
  return "$strDay $strMonthThai " . "พ.ศ. " . "$strYear";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet" />
  <script src="<?= base_url('assets/js/PDF/jquery.js'); ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
  <script src="<?= base_url('assets/js/PDF/html2canvas.js'); ?>"></script>
  <script src="<?= base_url('assets/js/PDF/jspdf.debug.js'); ?>"></script>

  <style>
    /* body {
      width: 100%;
      margin: 0;
      padding: 0;
      background-color: #ccc;
      font-family: "Sarabun";
      font-size: 14pt;
      text-align: left;
    } */

    * {
      box-sizing: border-box;
      -moz-box-sizing: border-box;
    }
  </style>
  <script>
    var is_chrome = function() {
      return Boolean(window.chrome);
    }
    if (is_chrome) {
      window.print();
      setTimeout(function() {
        window.close();
      }, 10000);
      //give them 10 seconds to print, then close
    } else {
      window.print();
      window.close();
    }
  </script>
</head>

<body onLoad="window.print();" style="padding: 0; margin: 0">
  <div id="canvas" class="page" style="line-height: 0.5;width: 297mm;height: 210mm;padding: 5mm;background-color: #fff">
    <div class="block" style="padding: 0.3cm;float: left;width: 50%;height: 100%;border: 1px #ccc solid;">
      <small style="font-size: 6pt;float:left; float:right;">(สำหรับนักศึกษา)</small>
      <p style="text-align: center;">ใบเสร็จรับเงิน</p>
      <p style="font-size: 9pt;text-align: center;">
        วันที่
        <?= DateThai('2020-02-21'); ?>
      </p>
      <p style="font-size: 9pt;text-align: center;">
        คณะอุตสาหกรรมและเทคโนโลยี <?= $listSet[0]['set_textUname']; ?>
      </p>
      <p style="font-size: 9pt;text-align: center;">
        <?= $listSet[0]['set_textUaddress']; ?>
      </p>
      <p style="font-size: 9pt;text-align: center;"><?= $listSet[0]['set_textUcontact']; ?></p>

      <div style="width: 100%;">
        <p style="font-size: 9pt;width: 60%; float: left;">
          <strong>ชื่อ-นามสกุล (นักศึกษา)</strong> <?= $listStd[0]['std_title'] . '' . $listStd[0]['std_fname'] . '  ' . $listStd[0]['std_lname']; ?>
        </p>
        <p style="font-size: 9pt;width: 40%; float: left;text-align: right;">
          <strong>รหัสประจำตัว</strong> <?= $listStd[0]['std_number']; ?>
        </p>

        <p style="font-size: 9pt;width: 60%; float: left;margin: 0;">
          <strong>สาขา</strong> <?= $listStd[0]['dept_name']; ?>
        </p>
        <p style="font-size: 9pt;width: 40%; float: left;text-align: right;margin: 0;">
          <strong>หลักสูตร</strong> <?= $listStd[0]['stdtype_text']; ?>
        </p>

        <p style="font-size: 9pt;width: 60%; float: left;">
          <strong>สถานะ</strong> .......... ปกติ
        </p>
        <p style="font-size: 9pt;width: 100%;float: left;">
          <strong style="color: #fff;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> .......... ผ่อนผัน
          ..........................................................................
          ชำระภายใน ........../.........../...............
        </p>
        <p style="font-size: 9pt;width: 100%; float: left;">
          <strong style="color: #fff;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> ชำระเงินโดย
          <input type="checkbox" name="" id="" /> เงินสด
          <input type="checkbox" name="" id="" />
          โอนเงินเข้าบัญชี
          ....................................................................................
        </p>
      </div>

      <table style="width:100%;font-size: 8pt;text-align: left; border-top: solid 1px #ccc;border-collapse: collapse;">
        <thead>
          <tr style="padding: 10px;">
            <th style="width: 10%;border: 1px solid #ccc;padding: 10px;">ลำดับ</th>
            <th style="width: 50%;border: 1px solid #ccc;padding: 10px;">รายการ</th>
            <th style="width: 10%;border: 1px solid #ccc;padding: 10px;">ขนาด</th>
            <th style="width: 10%;border: 1px solid #ccc;padding: 10px;text-align: right;">จำนวน</th>
            <th style="width: 20%;border: 1px solid #ccc;padding: 10px;text-align: right;">ราคา</th>
          </tr>
        </thead>
        <tbody>
          <? $numrow = 1;
          foreach ($listdetail as $key => $value) { ?>
            <tr>
              <td style="border: 1px solid #ccc;padding: 10px;"><?= str_pad($numrow, 3, "0", STR_PAD_LEFT); ?></td>
              <td style="border: 1px solid #ccc;padding: 10px;"><?= $value['pdt_name']; ?></td>
              <td style="border: 1px solid #ccc;padding: 10px;"><?= $value['size']; ?></td>
              <td style="border: 1px solid #ccc;padding: 10px;text-align: right;"><?= number_format($value['quantity']); ?></td>
              <td style="border: 1px solid #ccc;padding: 10px;text-align: right;"><?= number_format($value['total']); ?></td>
            </tr>
          <? $numrow++;
          } ?>
          <tr>
            <td style="border: 1px solid #ccc;padding: 10px;"></td>
            <td style="border: 1px solid #ccc;padding: 10px;"></td>
            <td style="border: 1px solid #ccc;padding: 10px;"></td>
            <td style="border: 1px solid #ccc;padding: 5px;text-align: right;">ราคารวม</td>
            <td style="border: 1px solid #ccc;padding: 10px;text-align: right;"><?=number_format($listdetail[0]['orders_total']);?></td>
          </tr>
        </tbody>
      </table>
      <br>
      <br>
      <br>
      <br>
      <p style="font-size: 9pt;text-align: right;">ลงชื่อ ............................................................ เจ้าหน้าที่ </p>

    </div>
    <div class="block" style="padding: 0.3cm;float: left;width: 50%;height: 100%;border: 1px #ccc solid;">
      <small style="font-size: 6pt;float:right;">(สำหรับคณะ)</small>
      <p style="text-align: center;">ใบเสร็จรับเงิน</p>
      <p style="font-size: 9pt;text-align: center;">
        วันที่
        <?= DateThai('2020-02-21'); ?>
      </p>
      <p style="font-size: 9pt;text-align: center;">
        คณะอุตสาหกรรมและเทคโนโลยี <?= $listSet[0]['set_textUname']; ?>
      </p>
      <p style="font-size: 9pt;text-align: center;">
        <?= $listSet[0]['set_textUaddress']; ?>
      </p>
      <p style="font-size: 9pt;text-align: center;"><?= $listSet[0]['set_textUcontact']; ?></p>

      <div style="width: 100%;position: relative;margin-bottom: 10px;">
        <p style="font-size: 9pt;width: 60%; float: left;">
          <strong>ชื่อ-นามสกุล (นักศึกษา)</strong> <?= $listStd[0]['std_title'] . '' . $listStd[0]['std_fname'] . '  ' . $listStd[0]['std_lname']; ?>
        </p>
        <p style="font-size: 9pt;width: 40%; float: left;text-align: right;">
          <strong>รหัสประจำตัว</strong> <?= $listStd[0]['std_number']; ?>
        </p>

        <p style="font-size: 9pt;width: 60%; float: left;margin: 0;">
          <strong>สาขา</strong> <?= $listStd[0]['dept_name']; ?>
        </p>
        <p style="font-size: 9pt;width: 40%; float: left;text-align: right;margin: 0;">
          <strong>หลักสูตร</strong> <?= $listStd[0]['stdtype_text']; ?>
        </p>

        <p style="font-size: 9pt;width: 60%; float: left;">
          <strong>สถานะ</strong> .......... ปกติ
        </p>
        <p style="font-size: 9pt;width: 100%; float: left;">
          <strong style="color: #fff;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> .......... ผ่อนผัน
          ..........................................................................
          ชำระภายใน ........../.........../...............
        </p>
        <p style="font-size: 9pt;width: 100%; float: left;">
          <strong style="color: #fff;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> ชำระเงินโดย
          <input type="checkbox" name="" id="" /> เงินสด
          <input type="checkbox" name="" id="" />
          โอนเงินเข้าบัญชี
          .....................................................................................
        </p>
      </div>

      <table style="width:100%;font-size: 8pt;text-align: left; border-top: solid 1px #ccc;border-collapse: collapse;">
        <thead>
          <tr style="padding: 10px;">
            <th style="width: 10%;border: 1px solid #ccc;padding: 10px;">ลำดับ</th>
            <th style="width: 50%;border: 1px solid #ccc;padding: 10px;">รายการ</th>
            <th style="width: 10%;border: 1px solid #ccc;padding: 10px;">ขนาด</th>
            <th style="width: 10%;border: 1px solid #ccc;padding: 10px;text-align: right;">จำนวน</th>
            <th style="width: 20%;border: 1px solid #ccc;padding: 10px;text-align: right;">ราคา</th>
          </tr>
        </thead>
        <tbody>
          <? $numrow = 1;
          foreach ($listdetail as $key => $value) { ?>
            <tr>
              <td style="border: 1px solid #ccc;padding: 10px;"><?= str_pad($numrow, 3, "0", STR_PAD_LEFT); ?></td>
              <td style="border: 1px solid #ccc;padding: 10px;"><?= $value['pdt_name']; ?></td>
              <td style="border: 1px solid #ccc;padding: 10px;"><?= $value['size']; ?></td>
              <td style="border: 1px solid #ccc;padding: 10px;text-align: right;"><?= number_format($value['quantity']); ?></td>
              <td style="border: 1px solid #ccc;padding: 10px;text-align: right;"><?= number_format($value['total']); ?></td>
            </tr>
          <? $numrow++;
          } ?>
          <tr>
            <td style="border: 1px solid #ccc;padding: 10px;"></td>
            <td style="border: 1px solid #ccc;padding: 10px;"></td>
            <td style="border: 1px solid #ccc;padding: 10px;"></td>
            <td style="border: 1px solid #ccc;padding: 5px;text-align: right;">ราคารวม</td>
            <td style="border: 1px solid #ccc;padding: 10px;text-align: right;"><?=number_format($listdetail[0]['orders_total']);?></td>
          </tr>
        </tbody>
      </table>
      <br>
      <br>
      <br>
      <br>
      <p style="font-size: 9pt;">ลงชื่อ ............................................................ เจ้าหน้าที่ </p>

      <!-- <p style="font-size: 9pt;width: 200%;position: fixed;right: 100 !important;bottom: 100px;left: 600px;">ลงชื่อ ........................................................................................................................ เจ้าหน้าที่ </p> -->
    </div>
  </div>
</body>

</html>