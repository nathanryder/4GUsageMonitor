<?php include("includes/connect.php") ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Data Usage</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="includes/styles.css">
  </head>
  <body>
    <?php
      $years = array();
      $months = array();
      $data = mysqli_query($con, "SHOW TABLES");
      while ($row = mysqli_fetch_assoc($data)) {
        $name = $row['Tables_in_4GUsage'];
        if ($name == "mainData" || $name == "faults")
          continue;

        $full = explode("_", $name);
        array_push($years, $full[0]);
        array_push($months, $full[1]);
      }

      include("includes/navbar.php");
    ?>

  <center>
  <div class="container" >
    <div class="col-md-6 col-sm-6" style="padding-top: 20%;">
      <div class="form-group">
        <label for="sel1">Select A Month</label>
        <select class="form-control" id="month">
          <?php
          $usedMonths = array();
          foreach ($months as $month) {
            if (in_array($month, $usedMonths))
              continue;

            $date = "01-" . $month . "-2017";
            $monthName = date('F', strtotime($date));
            echo "<option>" . $monthName . "</option>";
            array_push($usedMonths, $month);
          }
          ?>
        </select>
      </div>
    </div>

    <div class="col-md-6 col-sm-6" style="padding-top: 20%;">
      <div class="form-group">
        <label for="sel1">Select A Year</label>
        <select class="form-control" id="year">
          <?php
          $usedYears = array();
          foreach ($years as $year) {
            if (in_array($year, $usedYears))
              continue;

            echo "<option>" . $year . "</option>";
            array_push($usedYears, $year);
          }
          ?>
        </select>
      </div>
    </div>

    <div style="clear:both;">
      <br>
      <button onclick="redirect()" type="button" class="btn btn-default">Submit</button>
    </div>
  </div>
  </center>



  <div id="hidden_form_container" style="display:none;"></div>
  </body>


  <script type="text/javascript">
  function getMonthFromString(mon){
    return new Date(Date.parse(mon +" 1, 2012")).getMonth()+1
  }

  function redirect() {
    var month = document.getElementById('month').value;
    var year = document.getElementById('year').value;

    var monthNo = getMonthFromString(month);
    window.location = "showData.php?year=" + year + "&month=" + monthNo;
  }
  </script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
</html>
