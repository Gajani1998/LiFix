<?php

use models\ReportGenerate;

include_once  __DIR__ . '/../models/ReportGenerate.php';
include_once  __DIR__ . '/../utils/classloader.php';
$inventryModel = new models\Inventory();

$session = new classes\Session(DSFL);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Report Generate</title>
  <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
	<link rel="manifest" href="../assets/favicon/site.webmanifest">
  <script src="https://kit.fontawesome.com/2b554022ef.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/slider.css">
  <link rel="stylesheet" href="../css/ds/style.css">
  <link rel="stylesheet" href="../css/ds/report.css">
  <link rel="stylesheet" href="../css/ds/charts.css">
  <link rel="stylesheet" href="../css/morris.css">
  <script src="../js/jquery-3.5.1.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="../js/morris.min.js"></script>
</head>

<body>

  <?php include "../components/userfeild.php" ?>
  <?php include "./nav.html" ?>

  <div class="container">

    <h1>System Overview</h1>

    <div class="top-bar">
      <div class="range">
        <p>From</p>
        <input type="date" id="firstDate" class="field" required>
        <p>To</p>
        <input type="date" id="secondDate" class="field" required>
        <button class="btn">Generate</button>
      </div>
    </div>

    <div class="chart-row">

      <div class="chart-column">
        <div class="chart-title">
          <h2>Recieved Complaints</h2>
        </div>
        <div class="chart-column-data">
          <p class="chart-column-data-p">
            No data to show
          </p>
        </div>
      </div>

      <div class="chart-column-middle"></div>

      <div class="chart-column">
        <div class="chart-title">
          <h2>Current Inventory</h2>
        </div>

        <?php
        $inventry = $inventryModel->getInventory();
        $data = "";
        while ($row = mysqli_fetch_array($inventry)) {
          $data .= "{ name:'" . $row["name"] . "',total:" . $row["total"] . "},";
        }
        ?>

        <div class="chart-container">
          <div id="myfirstchart" style="height:auto; width:auto">
          </div>
        </div>
      </div>

    </div>
  </div>


  <script>
    $(document).ready(function() {
      $('.btn').click(function() {

        let date1 = $("#firstDate").val();
        let date2 = $("#secondDate").val();
        console.log(date1);
        $.ajax({
          type: "POST",
          url: "../utils/reportFetch.php",
          data: {
            firstDate: date1,
            secondDate: date2
          },
          success: function(data) {
            if (data != "No data on this period") {
              $(".chart-column-data").css({
                "display": "block"
              });
              $(".chart-column-data-p").html(data);
            } else
              $(".chart-column-data-p").html(data);
          }
        });
      })
    });

    new Morris.Bar({
      element: 'myfirstchart',
      data: [<?php echo $data; ?>],
      xkey: 'name',
      ykeys: ['total'],
      labels: ['Count']
    });
  </script>

</body>

</html>