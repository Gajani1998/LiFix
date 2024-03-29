<?php


include_once  __DIR__ . '/../utils/classloader.php';
$admin = new classes\DS();
$data =  $admin->SystemOverview();

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
  <!-- <link rel="stylesheet" href="../css/ds/charts.css"> -->
  <link rel="stylesheet" href="../css/ds/dash.css">
  <!-- <link rel="stylesheet" href="../css/morris.css"> -->
  <link rel="stylesheet" href="../css/style.css">

  <script src="../js/jquery-3.5.1.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="../js/morris.min.js"></script>
</head>

<body>

  <?php include "../components/userfeild.php" ?>
  <?php include "./nav.html" ?>

  <div class="container">

    <h1>System Overview</h1>

    <div class="admin">
       
       
    <main class="admin__main">
        <div class="dashboard2">
            <!-- area chart -->
            <div class="dashboard__item dashboard__item--full">
                <div class="card">
                    <div class="card__header">
                        <i class="fa fa-area-chart"></i> Complaints last month
                    </div>
                    <div class="card__content">
                        <div class="card__item">
                            <canvas id="myAreaChart" width="100%" height="20"></canvas>
                        </div>
                    </div>
                </div>
            </div>
           <!-- pie -->
            <div class="dashboard__item dashboard__item--col">
                <div class="card">
                    <div class="card__header">
                        <i class="fa fa-pie-chart"></i>  Repair vs Suspicious activities
                    </div>
                    <div class="card__content">
                        <div class="card__item">
                              <canvas id="myPieChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- bar -->
           


            <div class="dashboard__item dashboard__item--col">
                <div class="card">
                    <div class="card__header">
                        <i class="fa fa-bar-chart"></i>  Current Invetory Balance
                    </div>
                    <div class="card__content">
                        <div class="card__item">
                            <canvas id="myBarChart" width="100%" height="40"></canvas>

                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="dashboard__item dashboard__item--col">
                <div class="card">
                    <div class="card__header">
                        Card
                    </div>
                    <div class="card__content">
                        <div class="card__item">

                          <div class="text-muted">Days worked</div>
                          <h3 class="text-primary">43</h3>
                          <hr>
                          <div class="text-muted">No. of repairs done</div>
                          <h3 class="text-primary"><?= $data['normcount'] ?></h3>

                          <hr>
                          <div class="text-muted">Suspicious activities</div>
                          <h3 style="color: #dc3545;"><?= $data['suscount'] ?></h3>
                        </div>
                    </div>
                </div>
            </div> -->
          
       
            <div class="dashboard__item dashboard__item--full">
                <div class="card">
                    <!-- <div class="card__header">
                        Card full width
                    </div> -->
                    <div class="card__content">
                              
                                <div class="range">
                                  <p>From</p>
                                  <input type="date" id="firstDate" class="field" value="<?=   date('Y-m-d',strtotime(date('Y-m-d')." -1 Months"))  ?>" required>
                                  <p>To</p>
                                  <input type="date" id="secondDate" class="field" value="<?= date('Y-m-d') ?>" required>
                                  <button class="btn">Generate</button>
                                </div>
                              
                    </div>
                </div>
            </div>
            <div class="dashboard__item dashboard__item--col">
                <div class="card">
                    <div class="card__header">
                      <h3>Recieved Complaints</h3> 
                    </div>
                    <div class="card__content">
                        <div class="card_item">
                            <div class="chart-column-data1">
                              
                                No data to show
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard__item dashboard__item--col">
                <div class="card">
                    <div class="card__header">
                        New LampPost Records
                    </div>
                    <div class="card__content">
                        <div class="card_item">
                        <div class="chart-column-data2">
                              
                              No data to show
                          
                          </div>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>
    </main>
 
    </div>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js'></script>
<script src='../js/ds/new.js'></script>
  <script>
    $(document).ready(function() {
      $('.btn').click(function() {

        let date1 = $("#firstDate").val();
        let date2 = $("#secondDate").val();
        console.log(date1);
        $.ajax({
          type: "POST",
          url: "./ajax/reportComp.php",
          data: {
            firstDate: date1,
            secondDate: date2
          },
          success: function(data) {
            if (data != "No data on this period") {
              $(".chart-column-data1").css({
                "display": "block"
              });
              $(".chart-column-data1").html(data);
            } else
              $(".chart-column-data1").html(data);
          }
        });

        $.ajax({
          type: "POST",
          url: "./ajax/reportlp.php",
          data: {
            firstDate: date1,
            secondDate: date2
          },
          success: function(data) {
            if (data != "No data on this period") {
              $(".chart-column-data2").css({
                "display": "block"
              });
              $(".chart-column-data2").html(data);
            } else
              $(".chart-column-data2").html(data);
          }
        });
      })
    });

 // Chart.js scripts
// -- Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';
// -- Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: [<?=$data['arealabel'] ?> ],
    datasets: [{
      label: "Sessions",
      lineTension: 0.3,
      backgroundColor: "rgba(2,117,216,0.2)",
      borderColor: "rgba(2,117,216,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 20,
      pointBorderWidth: 2,
      data: [<?=$data['areaval'] ?> ],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: <?=$data['areamax']+2 ?> ,
          maxTicksLimit: 5
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: false
    }
  }
});



// -- Bar Chart Example
var ctx = document.getElementById("myBarChart");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: [ <?=$data['barlabel'] ?> ],
    datasets: [{
      label: "Toatal",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
      data: [<?= $data['barval'] ?>],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 6
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 250,
          maxTicksLimit: 5
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});



// -- Pie Chart Example
var ctx = document.getElementById("myPieChart");
piedata =  [<?=$data['normcount'].','.$data['suscount'] ?> ];

var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ["Normal Repairs", "Suspicious Activities"],
    datasets: [{
      data: piedata,
      backgroundColor: ['#007bff', '#dc3545'],
    }],
  },
});

  </script>


</body>

</html>