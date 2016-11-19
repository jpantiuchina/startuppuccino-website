<?php
  
  require_once '../../../app/models/session.php';

  // Give the access to this page only to educators
  if(!$userLogged || $_SESSION['role']!="educator"){
    header("Location: ../../../");
    exit;
  }

  require '../../../app/models/db_connect.php';

?>

<!DOCTYPE html>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(
          <?php
          ?>
          [
            ['Year', 'Sales', 'Expenses'],
            ['2013',  1000,      400],
            ['2014',  1170,      460],
            ['2015',  660,       1120],
            ['2016',  1030,      540]
          ]
          <?php
          ?>
        );

        var options = {
          title: 'Company Performance',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>

    <style type="text/css">
      html,body {height: 100%;margin:0}
      #chart_div {width:95%;height:95%;margin:5%}
    </style>

    <div id="chart_div"></div>
  

  </body>
</html>
