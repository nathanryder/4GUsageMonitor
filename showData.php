<?php
if (!isset($_GET['year']) || !isset($_GET['month'])) {
  die("Year or month not given!");
}

include("includes/connect.php");
include("HighchartsPHP/Highchart.php");
include("HighchartsPHP/HighchartJsExpr.php");
$year = $_GET['year'];
$month = $_GET['month'];
$date = "01-" . $month . "-" . $year;
$monthName = date('F', strtotime($date));
?>

<!DOCTYPE html>
<html>
<style media="screen">
  .statheader {
    background-color: #CCCCCC;
    border: 2px solid #CCCCCC;
    border-top-right-radius: 5px;
    border-top-left-radius: 5px;
    padding: 8px;
    font-size: 18px;
  }

  .statcontainer {
    background-color: white;
    border: 2px solid #CCCCCC;
    padding: 20px;
    font-size: 35px;
  }

  .statfooter {
    background-color: #CCCCCC;
    border: 2px solid #CCCCCC;
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;
    padding: 8px;
    font-size: 18px;
  }
</style>

<?php
$days = array();
$daysUsage = array();
$amountOfDays = 0;
$uploadTotal = 0;
$downloadTotal = 0;
$totalTotal = 0;
$overUnder = 0;

$mon = 0;
$tue = 0;
$wed = 0;
$thu = 0;
$fri = 0;
$sat = 0;
$sun = 0;

$data = mysqli_query($con, "SELECT * FROM `".$year."_".$month."`");
while ($row = mysqli_fetch_assoc($data)) {
  $date = $row['day'] . "-" . $month . "-" . $year;
  $dayName = date('D', strtotime($date));
  $upload = $row['upload'];
  $download = $row['download'];
  $total = $row['total'];
  $roundedTotal = round($total/1024, 2);
  $overUnder = $overUnder+($roundedTotal-8);


  if ($dayName == "Mon")
    $mon = $mon + $total;
  else if ($dayName == "Tue")
    $tue = $tue + $total;
  else if ($dayName == "Wed")
    $wed = $wed + $total;
  else if ($dayName == "Thu")
    $thu = $thu + $total;
  else if ($dayName == "Fri")
    $fri = $fri + $total;
  else if ($dayName == "Sat")
    $sat = $sat + $total;
  else if ($dayName == "Sun")
    $sun = $sun + $total;

  $uploadTotal = $uploadTotal+$upload;
  $downloadTotal = $downloadTotal+$download;
  $totalTotal = $totalTotal+$total;
  ++$amountOfDays;
  array_push($days, $row['day']);
  array_push($daysUsage, round($total/1024,2));
}

?>

  <head>
    <meta charset="utf-8">
    <title>Data usage for <?php echo $monthName; ?></title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script></head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="includes/styles.css">
  <body>
    <?php include("includes/navbar.php") ?>
    <style media="screen">
      .clear {
        clear:both;
      }
    </style>

    <br>
    <div class="container">

      <center>
        <div class="col-md-6">
          <div class="stat" style="width:60%; text-align:center;">
            <div class="statheader">Average Usage Per Day (GB)</div>
            <div class="statcontainer">
               <?php echo round(($totalTotal/$amountOfDays)/1024, 2); ?>
            </div>
          </div>
        </div>

        <div class="col-md-6">
      		<div class="stat" style="width:60%; text-align:center;">
      			<div class="statheader">Total Estimated Usage (GB)</div>
      			<div class="statcontainer">
      				<?php
              $total = $totalTotal/1024;
              $average = ($totalTotal/$amountOfDays)/1024;

              $dayNo = $days[sizeof($days)-1];
              $daysTaken = $dayNo % 22;
              $daysLeft = date('t') - $daysTaken;

              $daysLastMonth = (date("t", mktime(0,0,0, date("n") - 1)) % 22);
              $totalBillableDaysLeft = ($daysLastMonth + 22)-($daysTaken+$daysLastMonth);

              $estimated = ($totalBillableDaysLeft*$average)+$total;
              echo round($estimated, 2);
              ?>
      			</div>
      		</div>
        </div>
      </center>

    <div class="col-md-7" style="clear:both;">
      <br><br>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Date</th>
            <th>Day</th>
            <th>Upload (MB)</th>
            <th>Download (MB)</th>
            <th>Total (GB)</th>
            <th>Over/Under (GB)</th>
           </tr>
         </thead>
         <tbody
           <?php

           $data = mysqli_query($con, "SELECT * FROM `".$year."_".$month."`");
           while ($row = mysqli_fetch_assoc($data)) {
             if ($row['day'] <= 22) {
               if ($month == 12) {
                 $month = 1;
               } else {
                 $month--;
               }
             }

             $date = $row['day'] . "-" . $month . "-" . $year;
             $dayName = date('D', strtotime($date));
             $upload = $row['upload'];
             $download = $row['download'];
             $total = $row['total'];
             $roundedTotal = round($total/1024, 2);

             echo "<tr>";
             echo "<td>" . $row['day'] . "</td>";
             echo "<td>" . $dayName . "</td>";
             echo "<td>" . round($upload, 2) . "</td>";
             echo "<td>" . round($download, 2) . "</td>";
             echo "<td>" . $roundedTotal . "</td>";
             echo "<td>" . ($roundedTotal-8) . "</td>";
             echo "</tr>";
           }
           echo "<tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>" . $overUnder . "</td>
           </tr>
           <tr>
             <td><b>Totals</b></td>
             <td></td>
             <td>" . round($uploadTotal, 2) . "</td>
             <td>" . round($downloadTotal, 2) . "</td>
             <td>" . round($totalTotal/1024, 2) . "</td>
             <td></td>
             <td></td>
           </tr>
           <tr>
             <td><b>Averages</b></td>
             <td></td>
             <td>" . round($uploadTotal/$amountOfDays, 2) . "</td>
             <td>" . round($downloadTotal/$amountOfDays, 2) . "</td>
             <td>" . round(($totalTotal/$amountOfDays)/1024, 2) . "</td>
             <td></td>
             <td></td>
           </tr>";
           ?>
         </tbody>
       </table>
    </div>
    <div class="col-md-1">
    </div>

    <div class="col-md-5">
      <br><br>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Day</th>
            <th><center>Total Usage (GB)</center></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Monday</td>
            <td><center><?php echo round($mon/1024, 2); ?></center></td>
          </tr>
          <tr>
            <td>Tuesday</td>
            <td><center><?php echo round($tue/1024, 2); ?></center></td>
          </tr>
          <tr>
            <td>Wednesday</td>
            <td><center><?php echo round($wed/1024, 2); ?></center></td>
          </tr>
          <tr>
            <td>Thursday</td>
            <td><center><?php echo round($thu/1024, 2); ?></center></td>
          </tr>
          <tr>
            <td>Friday</td>
            <td><center><?php echo round($fri/1024, 2); ?></center></td>
          </tr>
          <tr>
            <td>Saturday</td>
            <td><center><?php echo round($sat/1024, 2); ?></center></td>
          </tr>
          <tr>
            <td>Sunday</td>
            <td><center><?php echo round($sun/1024, 2); ?></center></td>
          </tr>
        </tbody>
      </table>
      <div class="clear">

        <!-- Pie chart -->
        <?php
        $total = round($mon+$tue+$wed+$thu+$fri+$sat+$sun, 2);
        $monPerc = round($mon/$total, 2);
        $tuePerc = round($tue/$total, 2);
        $wedPerc = round($wed/$total, 2);
        $thuPerc = round($thu/$total, 2);
        $friPerc = round($fri/$total, 2);
        $satPerc = round($sat/$total, 2);
        $sunPerc = round($sun/$total, 2);

        $chart = new Highchart();
        $chart->chart->renderTo = "piechart";
        $chart->chart->plotBackgroundColor = null;
        $chart->chart->plotBorderWidth = null;
        $chart->chart->plotShadow = false;
        $chart->title->text = "Day Usage";

        $chart->tooltip->formatter = new HighchartJsExpr(
            "function() {
            return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %'; }");

        $test = 10;
        $chart->plotOptions->pie->allowPointSelect = 1;
        $chart->plotOptions->pie->cursor = "pointer";
        $chart->plotOptions->pie->dataLabels->enabled = false;
        $chart->plotOptions->pie->showInLegend = 1;
        $chart->series[] = array(
            'type' => "pie",
            'name' => "Days",
            'data' => array(
                array(
                    "Monday",
                    $monPerc
                ),
                array(
                    'Tuesday',
                    $tuePerc
                ),
                array(
                    "Wednesday",
                    $wedPerc
                ),
                array(
                    "Thursday",
                    $thuPerc
                ),
                array(
                    "Friday",
                    $friPerc
                ),
                array(
                    "Saturday",
                    $satPerc
                ),
                array(
                    "Sunday",
                    $sunPerc
                )
            )
        );

        $chart->printScripts();
        ?>
        <div id="piechart"></div>
        <script type="text/javascript"><?php echo $chart->render("chart1"); ?></script>
      </div>
    </div>

    <div class="clear">
      <?php
      $chart = new Highchart();

      $chart->chart = array(
          'renderTo' => 'linechart',
          'type' => 'line'
      );
      $chart->title = array(
          'text' => 'Usage per day'
      );
      $chart->xAxis->categories = $days;
      $chart->yAxis->title->text = 'Amount (GB)';
      $chart->tooltip->enabled = false;
      $chart->tooltip->formatter = new HighchartJsExpr(
          "function() {
              return '<b>' + this.series.name + '</b><br/>' +
                  this.x + ': ' + this.y + 'Â°C';
          }");

      $chart->plotOptions->line->dataLabels->enabled = true;
      $chart->plotOptions->line->enableMouseTracking = true;
      $chart->series[] = array(
          'name' => 'Data',
          'data' => $daysUsage
      );
      ?>
      <div id="linechart"></div>
      <script type="text/javascript"><?php echo $chart->render("chart2"); ?></script>
      </div>
  </div>

  </body>
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
</html>
